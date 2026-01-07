<?php
namespace App\Http\Controllers\Client;
use App\Enums\TypeEnum;
use App\Models\Timezone;
use Illuminate\Http\Request;
use App\Services\TemplateService;
use App\Services\WhatsAppService;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\DataTables\Client\MessageDataTable;
use App\Exports\CampaignLogsExport;
use App\Models\Contact;
use App\Models\ContactsList;
use App\Models\ContactRelationList;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Services\WhatsAppNewContactsService;
use App\Http\Requests\Client\CampaignsRequest;
use App\Repositories\Client\ContactRepository;
use App\Repositories\Client\SegmentRepository;
use App\Services\WhatsAppTotalContactsService;
use App\Repositories\Client\CampaignRepository;
use App\Repositories\Client\TemplateRepository;
use App\Repositories\Client\WaCampaignRepository;
use App\Repositories\Client\ContactListRepository;
use App\Http\Requests\Client\ResendCampaignRequest;
use App\DataTables\Client\WhatsAppCampaignDataTable;

class WhatsappCampaignController extends Controller
{
    protected $repo;

    protected $templateRepo;

    protected $contactListsRepo;

    protected $ContactsRepo;

    protected $segmentsRepo;

    protected $campaignsRepo;
    
    protected $whatsappService;

    public function __construct(
        WaCampaignRepository $repo,
        TemplateRepository $templateRepo,
        ContactListRepository $contactListsRepo,
        ContactRepository $ContactsRepo,
        SegmentRepository $segmentsRepo,
        CampaignRepository $campaignsRepo,
        WhatsAppService $whatsappService

    ) {
        $this->repo             = $repo;
        $this->templateRepo     = $templateRepo;
        $this->contactListsRepo = $contactListsRepo;
        $this->ContactsRepo     = $ContactsRepo;
        $this->segmentsRepo     = $segmentsRepo;
        $this->campaignsRepo    = $campaignsRepo;
        $this->whatsappService = $whatsappService;

    }

    public function index(Request $request, WhatsAppCampaignDataTable $dataTable)
    {
        $data = [
            'templates' => $this->templateRepo->combo(),
            'segments'  => $this->segmentsRepo->combo(),
            'lists'     => $this->contactListsRepo->combo(),
        ];

        return $dataTable->render('backend.client.whatsapp.campaigns.index', $data);
    }

    public function create()
    {
        $data = [
            'templates'     => $this->templateRepo->combo(),
            'segments'      => $this->segmentsRepo->combo(),
            'contact_lists' => $this->contactListsRepo->combo(),
            'time_zones'    => Timezone::all(),

        ];

        return view('backend.client.whatsapp.campaigns.create', $data);

    }

    public function store(CampaignsRequest $request): \Illuminate\Http\RedirectResponse
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));
            return back();
        }
        $result = $this->repo->store($request);
        if ($result->status) {
            return redirect()->route($result->redirect_to)->with($result->redirect_class, $result->message);
        }
        return back()->with($result->redirect_class, $result->message);
    }

    public function storeContactTemplate(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));
            return back();
        }
        $result = $this->repo->ContactTemplateStore($request);
        if ($result->status) {
            return redirect()->route('client.chat.index', ['contact' => $request->contact_id])->with($result->redirect_class, $result->message);
        }

        return back()->with($result->redirect_class, $result->message);
    }

    public function overview(Request $request)
    {

        $modifiedRequest = new Request(array_merge($request->all(), ['type' => TypeEnum::WHATSAPP->value]));
        $totalContacts   = Auth::user()->client->contacts()->where('type', TypeEnum::WHATSAPP->value)->count();
        $activeContacts  = Auth::user()->client->contacts()->where('type', TypeEnum::WHATSAPP->value)->active()->count();

        if ($totalContacts > 0) {
            $activePercentage = ($activeContacts / $totalContacts) * 100;
        } else {
            $activePercentage = 0;
        }

        $data            = [
            'charts'             => [
                'total_contacts' => app(WhatsAppTotalContactsService::class)->execute($request),
                'new_contacts'   => app(WhatsAppNewContactsService::class)->execute($request),
            ],
            'allContact'         => $totalContacts,
            'blacklistCount'     => $this->ContactsRepo->blockContacts($modifiedRequest)->count(),
            'readRatePercentage' => $this->ContactsRepo->readRatePercentage($modifiedRequest),
            'activePercentage'   => $activePercentage,
        ];
        return view('backend.client.whatsapp.overview.index', $data);
    }

    public function campaignCountContact(Request $request)
    {

    return $this->repo->campaignCountContact($request);
    }

    public function statusUpdate(Request $request, $id)
    {
        return $this->repo->statusUpdate($request, $id);
    }

    public function view(MessageDataTable $dataTable, $id)
    {
        try {
            $campaign = $this->repo->find($id);

            $data     = [
                'campaign' => $campaign,
            ];

            return $dataTable->with('id', $id)->render('backend.client.whatsapp.campaigns.view', $data);
        } catch (\Exception $e) {
            Toastr::error('something_went_wrong_please_try_again');

            return back();
        }
    }

    //Resend Campaign
    public function resend(ResendCampaignRequest $request): \Illuminate\Http\RedirectResponse
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));
            return back();
        }
        $result = $this->repo->resend($request);
        if ($result->status) {
            return redirect()->route($result->redirect_to)->with($result->redirect_class, $result->message);
        }
        return back()->with($result->redirect_class, $result->message);
    }

    public function sendTemplate(Request $request)
    {
        try {
            $data =[];
            $template  = $this->templateRepo->find($request->template_id);
            $data = app(TemplateService::class)->execute($template);
            $data['contact_id'] = $request->contact_id;
            return view('backend.client.whatsapp.campaigns.contact_template', $data);
        } catch (\Exception $e) {
            Toastr::error('something_went_wrong_please_try_again');
            if (config('app.debug')) {
                dd($e->getMessage());            
            }
            return back();
        }
    }

    public function exportLogs(Request $request, $id)
    {
        try {
            $campaign = $this->repo->find($id);
            $status = $request->get('status', null);
            $filename = 'campaign_logs_' . str_replace(' ', '_', $campaign->campaign_name) . '_' . now()->format('YmdHis') . '.xlsx';

            return Excel::download(new CampaignLogsExport($id, $status), $filename);
        } catch (\Exception $e) {
            Toastr::error('something_went_wrong_please_try_again');
            return back();
        }
    }

    public function quickContactGroup(Request $request)
    {
        if (isDemoMode()) {
            return response()->json([
                'success' => false,
                'message' => __('this_function_is_disabled_in_demo_server')
            ]);
        }

        DB::beginTransaction();
        try {
            $clientId = Auth::user()->client_id;

            // Validate group name
            $request->validate([
                'group_name' => 'required|string|max:255',
            ]);

            // Create the contact group
            $contactGroup = ContactsList::create([
                'name' => $request->group_name,
                'status' => 1,
                'client_id' => $clientId,
            ]);

            $contactsCreated = 0;
            $contactsLinked = 0;
            $phoneNumbers = [];

            // Handle pasted phone numbers
            if ($request->has('phone_numbers') && !empty($request->phone_numbers)) {
                $rawNumbers = $request->phone_numbers;
                // Split by newlines, commas, or spaces
                $numbers = preg_split('/[\n,\s]+/', $rawNumbers);
                $phoneNumbers = array_filter(array_map('trim', $numbers));
            }

            // Handle CSV file upload
            if ($request->hasFile('csv_file')) {
                $file = $request->file('csv_file');
                $extension = $file->getClientOriginalExtension();

                if (!in_array($extension, ['csv', 'xlsx'])) {
                    throw new \Exception(__('file_type_not_supported'));
                }

                $content = file_get_contents($file->getRealPath());
                $lines = preg_split('/[\r\n]+/', $content);
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line)) continue;
                    
                    // Handle CSV with multiple columns (take first column as phone)
                    $columns = str_getcsv($line);
                    if (!empty($columns[0])) {
                        $phone = trim($columns[0]);
                        // Skip header row if it looks like text
                        if (!preg_match('/[a-zA-Z]{3,}/', $phone) || preg_match('/^\+?[0-9]+$/', $phone)) {
                            if (preg_match('/^\+?[0-9]+$/', $phone)) {
                                $phoneNumbers[] = $phone;
                            }
                        }
                    }
                }
            }

            // Process phone numbers
            foreach ($phoneNumbers as $phone) {
                $phone = preg_replace('/[^0-9+]/', '', $phone);
                
                if (empty($phone) || strlen($phone) < 7) {
                    continue;
                }

                // Check if contact already exists for this client
                $existingContact = Contact::where('phone', $phone)
                    ->where('client_id', $clientId)
                    ->first();

                if ($existingContact) {
                    // Link existing contact to the new group
                    $existingRelation = ContactRelationList::where('contact_id', $existingContact->id)
                        ->where('contact_list_id', $contactGroup->id)
                        ->first();
                    
                    if (!$existingRelation) {
                        ContactRelationList::create([
                            'contact_id' => $existingContact->id,
                            'contact_list_id' => $contactGroup->id,
                        ]);
                        $contactsLinked++;
                    }
                } else {
                    // Create new contact
                    $contact = Contact::create([
                        'phone' => $phone,
                        'name' => $phone,
                        'client_id' => $clientId,
                        'status' => 1,
                        'type' => TypeEnum::WHATSAPP->value,
                    ]);

                    // Link to the group
                    ContactRelationList::create([
                        'contact_id' => $contact->id,
                        'contact_list_id' => $contactGroup->id,
                    ]);
                    $contactsCreated++;
                }
            }

            DB::commit();

            $message = __('Contact group created successfully.');
            if ($contactsCreated > 0 || $contactsLinked > 0) {
                $message .= ' ' . $contactsCreated . ' ' . __('new contacts created') . ', ' . $contactsLinked . ' ' . __('existing contacts linked') . '.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'group_id' => $contactGroup->id,
                'group_name' => $contactGroup->name,
                'contacts_created' => $contactsCreated,
                'contacts_linked' => $contactsLinked,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (config('app.debug')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return response()->json([
                'success' => false,
                'message' => __('something_went_wrong_please_try_again')
            ], 500);
        }
    }
}
