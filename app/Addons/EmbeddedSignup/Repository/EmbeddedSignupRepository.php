<?php

namespace App\Addons\EmbeddedSignup\Repository;
use App\Models\Client;
use App\Enums\TypeEnum;
use App\Models\Template;
use App\Traits\ImageTrait;
use App\Traits\RepoResponse;
use App\Models\ClientSetting;
use App\Traits\TemplateTrait;
use Illuminate\Support\Facades\DB;
use App\Models\ClientSettingDetail;
use Illuminate\Support\Facades\Auth;
use App\Services\MetaService;

class EmbeddedSignupRepository
{
    use ImageTrait, RepoResponse, TemplateTrait;
    private $FACEBOOK_BASE_URL = 'https://graph.facebook.com';
    private $API_VERSION = 'v20.0';
    private $model;
    private $template;
    private $client;
    private $client_id;
    private $client_secret;
    private $access_token;
    private $phone_number_id;
    private $app_id;
    private $business_account_id; //Assigned-WABA-ID
    private $metaService;
    private $clientSettingDetail;

    public function __construct(
        ClientSetting $model,
        Template $template,
        Client $client,
        ClientSettingDetail $clientSettingDetail,
        MetaService $metaService
    ) {
        $this->metaService = $metaService;
        $this->model = $model;
        $this->clientSettingDetail = $clientSettingDetail;
        $this->template = $template;
        $this->client = $client;
        $this->client_id = setting('meta_app_id');
        $this->client_secret = setting('meta_app_secret');
    }

    public function find($id)
    {
        return $this->model->withPermission()->find($id);
    }

    public function store($request)
    {
        if (isDemoMode()) {
            return $this->formatResponse(false, __('this_function_is_disabled_in_demo_server'), 'client.whatsapp.embedded-signup', []);
        }
        // DB::beginTransaction();   
        try {
            $client = Auth::user()->client;
            if (!$client) {
                return $this->formatResponse(false, __('client_not_found_for_the_authenticated_user'), 'client.whatsapp.embedded-signup', []);
            }
            $this->access_token = $this->getAccessClient($request);
            $this->phone_number_id = $request->phone_number_id;
            $this->business_account_id = $request->business_account_id;
            if (!$this->access_token) {
                return $this->formatResponse(false, __('failed_to_retrieve_access_token'), 'client.whatsapp.embedded-signup', []);
            }
            $validationResponse = $this->validateAccessToken();
            if ($validationResponse['success'] === false) {
                return $this->formatResponse(false, $validationResponse['message'], 'client.whatsapp.embedded-signup', []);
            }
            $data = $this->extractTokenData($validationResponse['data']);
            $clientSetting = $this->model->firstOrNew(
                [
                    // 'phone_number_id' => $data['phone_number_id'],
                    'client_id' => $client->id,
                    'phone_number_id' => $data['phone_number_id']
                ]
            );
            $clientSetting->fill($data)->save();
            $this->createPhoneAndBusinessProfile($this->business_account_id, $clientSetting);
       
            $callbackUri =  route('whatsapp.webhook', @$client->webhook_verify_token);
            $verifyToken = @$client->webhook_verify_token;
            $callbackURL = $this->metaService->overrideCallbackURL($data['business_account_id'], $callbackUri, $verifyToken, $clientSetting);

            $this->syncTemplate($clientSetting);

            $results = view('addon:EmbeddedSignup::partials.business_profile_card')->render();
            // DB::commit();
            return $this->formatResponse(true, __('whatsapp_successfully_connected'), 'client.whatsapp.embedded-signup', $results);
        } catch (\Throwable $e) {
            logError('Store error: ', $e);
            // DB::rollback();
            return $this->formatResponse(false,$e->getMessage() , 'client.whatsapp.embedded-signup', []);
        }
    }

    private function createPhoneAndBusinessProfile($businessAccountId, $clientSetting)
    {
        try {
            $phoneNumbers = $this->metaService->getPhoneNumbers($businessAccountId, $clientSetting);
            if ($phoneNumbers['success'] == true && isset($phoneNumbers['data'])) {
                $results = $phoneNumbers['data']->data ?? [];
                foreach ($results as $result) {
                    $phoneNumberStatus = $this->metaService->getPhoneNumberStatus($result->id ?? null, $clientSetting);
                    $accountReviewStatus = $this->metaService->getAccountReviewStatus($businessAccountId ?? null, $clientSetting);
                    $registerNumber = $this->metaService->registerNumber($clientSetting->phone_number_id, $clientSetting);
                    $businessProfile = $this->metaService->getBusinessProfileDetails($result->id ?? null, $clientSetting);
                    $subscribeApps = $this->metaService->subscribeApps($this->business_account_id,$clientSetting);
                    $businessAccount = $this->metaService->getBusinessAccount($businessAccountId ?? null, $clientSetting);
                    $this->clientSettingDetail->updateOrCreate(
                        [
                            'client_setting_id' => $clientSetting->id,
                            'phone_number_id' => $result->id ?? null
                        ],
                        [
                            'verified_name' => $result->verified_name ?? null,
                            'display_phone_number' => $result->display_phone_number ?? null,
                            'phone_number_id' => $result->id ?? null,
                            'quality_rating' => $result->quality_rating ?? null,
                            'account_review_status' => $accountReviewStatus['data'] ?? null,
                            'number_status' => $phoneNumberStatus->data->status ?? null,
                            'code_verification_status' => $phoneNumberStatus->data->code_verification_status ?? $result->code_verification_status ?? null,
                            'certificate' => $result->certificate ?? null,
                            'new_certificate' => $result->new_certificate ?? null,
                            'messaging_limit_tier' => $result->messaging_limit_tier ?? null,
                            'profile_info' => [
                                // 'business_account_name' => $businessAccount['data']->name ?? null,
                                'webhook_configuration' => $result->webhook_configuration->application ?? null,
                                'message_template_namespace' => $accountReviewStatus['data']->message_template_namespace ?? null,
                                'address' => $businessProfile['data']->data[0]->address ?? null,
                                'email' => $businessProfile['data']->data[0]->email ?? null,
                                'description' => $businessProfile['data']->data[0]->description ?? null,
                                'vertical' => $businessProfile['data']->data[0]->vertical ?? null,
                                'about' => $businessProfile['data']->data[0]->about ?? null,
                                'websites' => json_encode($businessProfile['data']->data[0]->websites ?? []),
                                'profile_picture_url' => $businessProfile['data']->data[0]->profile_picture_url ?? null,
                            ]
                        ]
                    );
                }
                if (isset($businessAccount['data'])) {
                    $clientSetting->business_account_name = $businessAccount['data']->name ?? $clientSetting->business_account_name;
                    $clientSetting->update();
                }
            }
        } catch (\Throwable $e) {
            logError('Store error: ', $e);
            // return $this->formatResponse(false,$e->getMessage() , 'client.whatsapp.embedded-signup', []);
            return false;
        }
        return true;
    }


    public function getAccessClient($request)
    {
        $code = $request->code;
        if (!$code || !$this->client_id || !$this->client_secret) {
            return null;
        }
        $url = "{$this->FACEBOOK_BASE_URL}/{$this->API_VERSION}/oauth/access_token?client_id={$this->client_id}&client_secret={$this->client_secret}&code={$code}";
        $response = curlRequest($url, null, 'GET');
        return $response->access_token ?? null;
    }

    public function validateAccessToken()
    {
        $appAccessToken = setting('meta_app_id') . '|' . setting('meta_app_secret');
    
        $url = "{$this->FACEBOOK_BASE_URL}/debug_token"
            . "?input_token={$this->access_token}"
            . "&access_token={$appAccessToken}";
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($ch);
        $responseData = json_decode($response, true);
    
        if (isset($responseData['error'])) {
            return [
                'success' => false,
                'message' => $responseData['error']['message'],
            ];
        }  
    
        if (!isset($responseData['data']['is_valid']) || !$responseData['data']['is_valid']) {
            return [
                'success' => false,
                'message' => __('access_token_is_not_valid'),
            ];
        }  
    
        return [
            'success' => true,
            'data' => $responseData['data'],
        ];
    }

    // public function validateAccessToken()
    // {
    //     $url = "{$this->FACEBOOK_BASE_URL}/debug_token?input_token={$this->access_token}&access_token={$this->access_token}";
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     $response = curl_exec($ch);
    //     $responseData = json_decode($response, true);
    //     if (isset($responseData['error'])) {
    //         return [
    //             'success' => false,
    //             'message' => $responseData['error']['message'], // Use a single dollar sign here
    //         ];
    //     }  
    //     if (!isset($responseData['data']['is_valid']) || !$responseData['data']['is_valid']) {
    //         return [
    //             'success' => false,
    //             'message' => __('access_token_is_not_valid'),
    //         ];
    //     }  
    //     return [
    //         'success' => true,
    //         'data' => $responseData['data'],
    //     ];
    // }

    public function extractTokenData($responseData)
    {
        return [ 
            'access_token' => $this->access_token,
            'phone_number_id' => $this->phone_number_id,
            'business_account_id' => $this->business_account_id,
            'app_id' => $responseData['app_id'] ?? $this->app_id,
            'is_connected' => true,
            'token_verified' => true,
            'scopes' => $responseData['scopes'],
            'granular_scopes' => $responseData['granular_scopes'] ?? null,
            'data_access_expires_at' => $this->timestampToDateTime($responseData['data_access_expires_at']),
            'expires_at' => $this->timestampToDateTime($responseData['expires_at']),
            'fb_user_id' => $responseData['user_id'] ?? null,
            'name' => $responseData['application'] ?? null,
        ];
    }

    public function timestampToDateTime($timestamp)
    {
        return $timestamp ? (new \DateTime())->setTimestamp($timestamp) : null;
    }

    public function statusUpdate($id)
    {
        if (isDemoMode()) {
            return $this->formatResponse(false, __('this_function_is_disabled_in_demo_server'), 'client.whatsapp.embedded-signup', []);
        }
        try {
            $setting         = $this->model->find($id);
            $setting->status = $setting->status == 1 ? 0 : 1;
            $setting->save();
            return $this->formatResponse(true, __('updated_successfully'), 'client.whatsapp.embedded-signup', $setting);
        } catch (\Throwable $th) {
            return $this->formatResponse(false, $th->getMessage(), 'client.whatsapp.embedded-signup', []);
        }
    }

    public function sync()
    { 
        if (isDemoMode()) {
            return $this->formatResponse(false, __('this_function_is_disabled_in_demo_server'), 'client.whatsapp.embedded-signup', []);
        }
        DB::beginTransaction();
        try {
            $clientSetting = Auth::user()->client->whatsappSetting;
            if (!$clientSetting) {
                return $this->formatResponse(false, __('whatsapp_setting_not_found'), 'client.whatsapp.embedded-signup', []);
            }
            $this->access_token = $clientSetting->access_token;
            $this->phone_number_id = $clientSetting->phone_number_id;
            $this->business_account_id = $clientSetting->business_account_id;
            if (!$this->access_token) {
                return $this->formatResponse(false, __('failed_to_retrieve_access_token'), 'client.whatsapp.embedded-signup', []);
            }
            $validationResponse = $this->validateAccessToken();
            if ($validationResponse['success'] === false) {
                return $this->formatResponse(false, $validationResponse['message'], 'client.whatsapp.embedded-signup', []);
            }
            $data = $this->extractTokenData($validationResponse['data']);
            $clientSetting->fill($data)->save();

            // $this->createPhoneAndBusinessProfile($this->business_account_id, $clientSetting);
            $phoneNumbers = $this->metaService->getPhoneNumbers($clientSetting->business_account_id, $clientSetting);
            // Log::info('$phoneNumbers : ', [$phoneNumbers['data']]);
            // Log::info('$phoneNumbers : ', [$phoneNumbers['data']->data[0]]);
            $phoneNumberStatus = $this->metaService->getPhoneNumberStatus($clientSetting->phone_number_id ?? null, $clientSetting);
            $accountReviewStatus = $this->metaService->getAccountReviewStatus($clientSetting->business_account_id ?? null, $clientSetting);
            $businessProfile = $this->metaService->getBusinessProfileDetails($clientSetting->phone_number_id ?? null, $clientSetting);
            // $businessAccount = $this->metaService->getBusinessAccount($clientSetting->business_account_id ?? null, $clientSetting);
            $this->clientSettingDetail->updateOrCreate(
                [
                    'client_setting_id' => $clientSetting->id,
                    'phone_number_id' => $clientSetting->phone_number_id ?? null
                ],
                [
                    'verified_name' => $phoneNumbers['data']->data[0]->verified_name ?? null,
                    'display_phone_number' => $phoneNumbers['data']->data[0]->display_phone_number ?? null,
                    'phone_number_id' => $clientSetting->phone_number_id ?? null,
                    'quality_rating' => $phoneNumbers['data']->data[0]->quality_rating ?? null,
                    'account_review_status' => $accountReviewStatus['data'] ?? null,
                    'number_status' => $phoneNumberStatus->data->status ?? null,
                    'code_verification_status' => $phoneNumberStatus->data->code_verification_status ?? $phoneNumbers['data']->data[0]->code_verification_status ?? null,
                    'certificate' => $phoneNumbers['data']->data[0]->certificate ?? null,
                    'new_certificate' => $phoneNumbers['data']->data[0]->new_certificate ?? null,
                    'messaging_limit_tier' => $phoneNumbers['data']->data[0]->messaging_limit_tier ?? null,
                    'profile_info' => [
                        // 'business_account_name' => $businessAccount['data']->name ?? null,
                        'webhook_configuration' => $phoneNumbers['data']->data[0]->webhook_configuration->application ?? null,
                        'message_template_namespace' => $accountReviewStatus['data']->message_template_namespace ?? null,
                        'address' => $businessProfile['data']->data[0]->address ?? null,
                        'email' => $businessProfile['data']->data[0]->email ?? null,
                        'description' => $businessProfile['data']->data[0]->description ?? null,
                        'vertical' => $businessProfile['data']->data[0]->vertical ?? null,
                        'about' => $businessProfile['data']->data[0]->about ?? null,
                        'websites' => json_encode($businessProfile['data']->data[0]->websites ?? []),
                        'profile_picture_url' => $businessProfile['data']->data[0]->profile_picture_url ?? null,
                    ]
                ]
            );
            $this->syncTemplate($clientSetting);
            DB::commit();
            return $this->formatResponse(true, __('whatsapp_settings_synced_successfully'), 'client.whatsapp.embedded-signup', []);
        } catch (\Throwable $e) {
            dd($e->getMessage());
            DB::rollback();
            logError('Sync error: ', $e);
            return $this->formatResponse(false, $e->getMessage(), 'client.whatsapp.embedded-signup', []);
        }
    }

    public function delete($request, $id)
    {
        if (isDemoMode()) {
            return $this->formatResponse(false, __('this_function_is_disabled_in_demo_server'), 'client.whatsapp.embedded-signup', []);
        }
        DB::beginTransaction();
        try {
            $clientSetting = $this->model->where('type', TypeEnum::WHATSAPP)
                ->withPermission()
                ->where('id', $id)
                ->firstOrFail();
            // $this->metaService->deRegister($clientSetting->phone_number_id, $clientSetting);
            $this->metaService->unSubscribeApps($clientSetting->business_account_id, $clientSetting);
            $clientSetting->delete();
            $this->template->where('client_id', Auth::user()->client->id)->where('client_setting_id', $clientSetting->id)->delete();
            // $this->client->where('id', Auth::user()->client->id)->update([
            //     'webhook_verify_token' => Str::random(40)
            // ]);
            DB::commit();
            return $this->formatResponse(true, __('deleted_successfully'), 'client.whatsapp.embedded-signup', []);
        } catch (\Throwable $e) {
            DB::rollback();
            if (config('app.debug')) {
                dd($e->getMessage());
            }
            logError('WhatsApp Setting Remove: ', $e);
            return $this->formatResponse(false, __('an_unexpected_error_occurred_please_try_again_later.'), 'client.whatsapp.embedded-signup', []);
        }
    }

    public function getBusinessProfileDetails($id)
    {
        try {
            $clientSetting = $this->model->findOrFail($id);
            $profile_info = $this->metaService->getBusinessProfileDetails($clientSetting->phone_number_id, $clientSetting);
            if($profile_info['success']==false){
                return $this->formatResponse(false, $profile_info['message'], '', []);
            }
            $profileData = isset($profile_info['data']->data[0]) ? $profile_info['data']->data[0] : null;
            $data = [
                'row' => $clientSetting,
                'profile_info' => $profileData,
            ];
            $results = view('addon:EmbeddedSignup::partials.__update_profile_modal_body', $data)->render();
            return $this->formatResponse(true, '', '', $results);
        } catch (\Throwable $e) {
            return $this->formatResponse(false, __('data_not_found'), '', []);
        }
    }

    public function updateBusinessProfile($request, $id)
    {
        try {
            $clientSetting = $this->model->findOrFail($id);
            $businessProfile = $this->metaService->updateBusinessProfile($clientSetting->phone_number_id, $clientSetting->access_token, $request);
            if($businessProfile['success']==true){
                $profile_info = $this->metaService->getBusinessProfileDetails($clientSetting->phone_number_id, $clientSetting);
                $clientSettingDetail = $this->clientSettingDetail->where('phone_number_id', $clientSetting->phone_number_id)->firstOrFail();
                $existingProfileInfo = $clientSettingDetail->profile_info;
                $profile_info = [
                    'business_account_name' => $existingProfileInfo['business_account_name'] ?? null,
                    'webhook_configuration' => $existingProfileInfo['webhook_configuration'] ?? null,
                    'message_template_namespace' => $existingProfileInfo['message_template_namespace'] ?? null,
                    'address' => $profile_info['data']->data[0]->address ?? $existingProfileInfo['address'],
                    'email' => $profile_info['data']->data[0]->email ?? $existingProfileInfo['email'],
                    'description' => $profile_info['data']->data[0]->description ?? $existingProfileInfo['description'],
                    'vertical' => $profile_info['data']->data[0]->vertical ?? $existingProfileInfo['vertical'],
                    'about' => $profile_info['data']->data[0]->about ?? $existingProfileInfo['about'],
                    'websites' => isset($profile_info['data']->data[0]->websites) ? json_encode($profile_info['data']->data[0]->websites) : $existingProfileInfo['websites'],
                    'profile_picture_url' => $profile_info['data']->data[0]->profile_picture_url ?? $existingProfileInfo['profile_picture_url'],
                ];
                $clientSettingDetail->profile_info = json_encode($profile_info);
                $clientSettingDetail->update();
                            }
            return $this->formatResponse(true, __('updated_successfully'), route('client.whatsapp.embedded-signup'), $clientSetting);
        } catch (\Throwable $e) {
            logError('update Business Profile: ', $e);
            return $this->formatResponse(false, __('an_unexpected_error_occurred_please_try_again_later.'), '', []);
        }
    }
}
