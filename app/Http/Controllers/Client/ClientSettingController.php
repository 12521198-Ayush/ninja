<?php
namespace App\Http\Controllers\Client;
use Exception;
use App\Models\Timezone;
use App\Rules\AppIdRule;
use Illuminate\Http\Request;
use App\Rules\PhoneNumberIdRule;
use App\Http\Controllers\Controller;
use App\Rules\BusinessAccountIdRule;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\ClientRepository;
use App\Repositories\CountryRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Client\ClientSettingRepository;
use App\Http\Requests\Admin\ClientUpdateRequest;
class ClientSettingController extends Controller
{
    protected $repo;

    protected $client;

    protected $country;

    public function __construct(ClientSettingRepository $repo, ClientRepository $client, CountryRepository $country)
    {
        $this->repo    = $repo;
        $this->client  = $client;
        $this->country = $country;
    }

    public function whatsAppSettings(Request $request)
    {
        $embeddedSignupView = 'addon:EmbeddedSignup::index';
        $whatsappSettingsView = 'backend.client.setting.whatsApp';

        if (addon_is_activated('embedded_signup') && setting('is_embedded_signup_active')==1) {
            return view($embeddedSignupView);
        }

        return view($whatsappSettingsView);
    }
    

    public function whatsAppSettingUpdate(Request $request)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false, 
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        $clientId = auth()->user()->client->id;
        $request->validate([
            'access_token' => ['required', 'string'],
            'phone_number_id' => ['required', 'string', new PhoneNumberIdRule($clientId)],
            'business_account_id' => ['required', 'string', new BusinessAccountIdRule($clientId)],
            // 'app_id' => ['required', 'string', new AppIdRule($clientId)],
            'app_id' => ['required', 'string'],
        ], [
            'access_token.required' => __('access_token_is_required'),
            'access_token.string' => __('access_token_must_be_string'),
            'phone_number_id.required' => __('phone_number_id_is_required'),
            'phone_number_id.string' => __('phone_number_id_must_be_string'),
            'business_account_id.required' => __('business_account_id_is_required'),
            'business_account_id.string' => __('business_account_id_must_be_string'),
            'app_id.required' => __('app_id_is_required'),
            'app_id.string' => __('app_id_must_be_string'),
        ]);
        return $this->repo->whatsAppSettingUpdate($request);
    }

    public function whatsAppsync(Request $request)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        return $this->repo->whatsAppsync($request);
    }

    public function removeWhatsAppToken(Request $request, $id)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        return $this->repo->removeWhatsAppToken($request, $id);
    }

    // Telegram Setting
    public function telegramSettings(Request $request)
    {
        return view('backend.client.setting.telegram');
    }

    public function telegramUpdate(Request $request)
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));
            return back();
        }
        $request->validate([
            'access_token' => 'required',
        ]);
        $result = $this->repo->telegramUpdate($request);
        if ($result->status) {
            return redirect()->route($result->redirect_to)->with($result->redirect_class, $result->message);
        }

        return back()->with($result->redirect_class, $result->message);
    }

    public function removeTelegramToken(Request $request, $id)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        return $this->repo->removeTelegramToken($request, $id);
    }

    
    public function telegramSettingsync($id)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        return $this->repo->telegramSettingsync($id);
    }


    public function billingDetails(Request $request)
    {
        $data = [
            'client' => $this->client->find(auth()->user()->client_id),
        ];

        return view('backend.client.setting.billing_details', $data);
    }

    public function storeBillingDetails(Request $request, $id)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];
            return response()->json($data);
        }
        try {
            $this->repo->billingDetailsupdate($request, $id);
            Toastr::success(__('update_successful'));

            return back();
        } catch (Exception $e) {
            Toastr::error(__('something_went_wrong_please_try_again'));

            return back();
        }
    }

    public function generalSettings(Request $request)
    {
        $id   = auth()->user()->client_id;
        $data = [
            'client'     => $this->client->find($id),
            'countries'  => $this->country->all(),
            'time_zones' => Timezone::all(),
        ];

        return view('backend.client.setting.general', $data);
    }


    public function api(Request $request)
    {
        return view('backend.client.setting.api');
    }

    public function update_api(Request $request)
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));

            return back();
        }

        $result = $this->repo->update($request);
        if ($result->status) {
            return redirect()->route($result->redirect_to)->with($result->redirect_class, $result->message);
        }

        return back()->with($result->redirect_class, $result->message);
    }

    public function updateGeneralSettings(ClientUpdateRequest $request, $id)
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));
            return back();
        }
        try {
            $this->client->update($request->all(), $id);
            Toastr::success(__('update_successful'));

            return redirect()->route('client.general.settings');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            if (config('app.debug')) {
                dd($e->getMessage());
            }
            return back()->withInput();
        }
    }

    public function aiWriterSetting()
    {
        return view('backend.client.setting.ai_writer_setting');
    }

    public function AIReplyStatus(Request $request)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|boolean',
        ]);
        return $this->client->AIReplyStatus($request);
    }

    // Webhook Settings
    public function webhookSettings()
    {
        $client = auth()->user()->client;
        return view('backend.client.setting.webhook', compact('client'));
    }

    public function webhookSettingsUpdate(Request $request)
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));
            return back();
        }

        $request->validate([
            'webhook_url' => 'nullable|url|max:500',
            'webhook_secret' => 'nullable|string|max:255',
        ], [
            'webhook_url.url' => __('Please enter a valid URL'),
            'webhook_url.max' => __('Webhook URL must not exceed 500 characters'),
        ]);

        try {
            $client = auth()->user()->client;
            $client->webhook_url = $request->webhook_url;
            $client->webhook_enabled = $request->has('webhook_enabled') ? 1 : 0;
            $client->webhook_secret = $request->webhook_secret;
            $client->save();

            Toastr::success(__('Webhook settings updated successfully'));
            return redirect()->route('client.webhook.settings');
        } catch (\Exception $e) {
            Toastr::error(__('something_went_wrong_please_try_again'));
            if (config('app.debug')) {
                dd($e->getMessage());
            }
            return back()->withInput();
        }
    }

    public function webhookSettingsTest(Request $request)
    {
        $request->validate([
            'webhook_url' => 'required|url',
        ]);

        try {
            $testPayload = [
                'event' => 'test',
                'timestamp' => now()->toIso8601String(),
                'client_id' => auth()->user()->client->id,
                'message' => 'This is a test webhook from WhatsApp Ninja',
                'data' => [
                    'message_id' => 'test_' . uniqid(),
                    'from' => '+919876543210',
                    'contact_name' => 'Test Contact',
                    'type' => 'text',
                    'text' => 'This is a test message',
                    'timestamp' => time(),
                ]
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'X-Webhook-Event' => 'test',
                'X-Client-Id' => (string) auth()->user()->client->id,
            ];

            // Add signature if secret is provided
            if ($request->webhook_secret) {
                $signature = hash_hmac('sha256', json_encode($testPayload), $request->webhook_secret);
                $headers['X-Webhook-Signature'] = 'sha256=' . $signature;
            }

            $client = new \GuzzleHttp\Client(['timeout' => 10]);
            $response = $client->post($request->webhook_url, [
                'json' => $testPayload,
                'headers' => $headers,
                'http_errors' => false,
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode >= 200 && $statusCode < 300) {
                return response()->json([
                    'success' => true,
                    'message' => __('Webhook test successful! Response code: ') . $statusCode
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('Webhook returned status code: ') . $statusCode
                ]);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Could not connect to webhook URL. Please check the URL and try again.')
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Webhook test failed: ') . $e->getMessage()
            ], 500);
        }
    }

}
