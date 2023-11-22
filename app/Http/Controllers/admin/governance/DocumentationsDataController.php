<?php

namespace App\Http\Controllers\admin\governance;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ControlDesiredMaturity;
use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\DocumentTypes;
use App\Models\Framework;
use App\Models\FrameworkControl;
use App\Models\Privacy;
use App\Models\Team;
use App\Models\User;
use App\Models\Action;
use Symfony\Component\HttpFoundation\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Events\CateogryDeleted;

use Session;

class DocumentationsDataController extends Controller
{
    public function index()
    {
        //Documents
        $breadcrumbs = [[
            'link' => route('admin.dashboard'),
            'name' => __('locale.Dashboard')
        ], [
            'link' => "javascript:void(0)",
            'name' => __('locale.Governance')
        ], ['name' => __('locale.Documentation')]];
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        $documents = \App\Models\Document::all();
        $frameworks = Framework::with('FrameworkControls:id,short_name,control_number')->get();
        // $owners=ControlOwner::all();
        if (isDepartmentManager()) {
            $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
            $owners = User::where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
        } else {
            $departmentManagersIds = Department::pluck('manager_id')->toArray();
            $owners = User::whereIn('id', $departmentManagersIds)->get();
        }

        $desiredMaturities = ControlDesiredMaturity::all();
        $testers = User::all();
        $teams = Team::all();
        $controls = FrameworkControl::all();
        $categoryList = DocumentTypes::with('documents')->orderBy('id', 'asc')->take(1)->get();

        Session::put('doc_current_id_dtb', $categoryList[0]->id ?? null);

        $category2 = DocumentTypes::orderBy('id', 'asc')->paginate(5);

        $status = DocumentStatus::all();
        $privacies = Privacy::all();

        $activeDocumentType = request()->query('doc_type');

        if (!DocumentTypes::where('id', $activeDocumentType)->exists())
            $activeDocumentType = null;

        if (!$activeDocumentType) {
            $activeDocumentType = $category2[0]->id ?? null;
        }
        $checkCount = DocumentTypes::count();

        return view('admin.content.governance.category', ['pageConfigs' => $pageConfigs], compact(
            'breadcrumbs',
            'controls',
            'testers',
            'teams',
            'documents',
            'frameworks',
            'owners',
            'desiredMaturities',
            'categoryList',
            'status',
            'privacies',
            'category2',
            'activeDocumentType',
            'checkCount'
        ));
    }

    public function NexDocPage(Request $request)
    {
        $sidebarCategory = DocumentTypes::skip(5 * ($request->page - 1))
            ->take(5)->get();
        $data = '';
        $checkCount = $sidebarCategory->count();
        foreach ($sidebarCategory as $item) {
            $data .= "<button class='list-group-item list-group-item-action tablinks sideNavBtn' id='item$item->id'  style=' display: flex'>
                        <span class=' fa  $item->icon '
                              style=' padding: 0 6px;  font-size: 20px;  color: #0097a7; '></span>

                        <div class='mb-1'>

                           " . $item->name . "
                               </div>
                    </button>";
        }
        $lastPage = DocumentTypes::count();
        $lastPage = $lastPage > 0 ? $lastPage / 5 : 0;
        return [$data, round($lastPage), $checkCount];
    }

    public function PrevDocPage(Request $request)
    {
        $sidebarCategory = DocumentTypes::skip(5 * ($request->page - 1))
            ->take(5)->get();
        $data = '';
        foreach ($sidebarCategory as $item) {
            $data .= "<button class='list-group-item list-group-item-action tablinks sideNavBtn' id='item$item->id'  style=' display: flex'>
                        <span class=' fa  $item->icon '
                              style=' padding: 0 6px;  font-size: 20px;  color: #0097a7; '></span>

                        <div class='mb-1'>

                           " . $item->name . "
                               </div>
                    </button>";
        }
        $lastPage = Framework::select('id', 'name', 'icon')->count();
        $lastPage = $lastPage > 0 ? $lastPage / 5 : 0;
        return [$data, round($lastPage)];
    }

    public function docDetails(Request $request)
    {
        $id = (int)substr($request->id, 4);

        $doc = DocumentTypes::find($id);

        //Put Doc id To Be used on Datatables
        Session::put('doc_current_id_dtb', $id);

        $editUrl = route('admin.governance.category.update', $id);

        $addDocUrl = route('admin.governance.document.store', $id);

        $iconsArray = Helper::getIcons();
        $IconsSelect = "";
        foreach ($iconsArray as $icon) {
            if ($icon['key'] == $doc->icon) {
                $IconsSelect .= "   <option selected value='" . $icon['key'] . "'> " . $icon['value'] . "</option>";
            } else {
                $IconsSelect .= "   <option  value='" . $icon['key'] . "'> " . $icon['value'] . "</option>";
            }
        }

        $docName = $doc->name;

        return [$doc->name, $editUrl, $addDocUrl, $docName, $IconsSelect];
    }

    public function deleteDoc(Request $request)
    {
        $doc = DocumentTypes::find($request->id);

        if ($doc) {
            $doc->delete();
        }
        event(new CateogryDeleted($doc));

    }

    /**
     * Return a listing of the resource after some manipulation depending on current user
     * if is admin all data returned
     * else returned data will depending on vulnerability creator or current user team.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetList(Request $request)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['document_name'],
            'relationships' => [],
            'other_global_filters' => ['creation_date'],
        ];
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            // 'assets:name',
            // 'teams:name'
        ];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */


        $conditions = [];
        if (!auth()->user()->hasPermission('document.all')) {
            if (isDepartmentManager()) {
                $departmentId = (Department::where('manager_id', auth()->id())->first())->id;
                $departmentMembers =  User::with('teams')->where('department_id', $departmentId)->orWhere('id', auth()->id())->get();
                $departmentMembersIds =  $departmentMembers->pluck('id')->toArray();
                $departmentTeams = [];
                foreach ($departmentMembers as $departmentMember) {
                    $departmentTeams = array_merge($departmentTeams, $departmentMember->teams->pluck('id')->toArray());
                }
                $ownedDocumentsIds =  Document::whereIn('document_owner', $departmentMembersIds)->pluck('id')->toarray();
                $reviewedDocumentsIds =  Document::whereIn('document_reviewer', $departmentMembersIds)->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toarray();
                if(!empty($departmentTeams)){
                    $teamsDocumentsIds = Document::where(function ($query) use ($departmentTeams) {
                        foreach ($departmentTeams as $teamId) {
                            $query->orWhereRaw("FIND_IN_SET($teamId, team_ids)");
                        }
                    })->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toArray();
                } else {
                    $teamsDocumentsIds = [];
                }
                $stakesDocumentsIds = Document::where(function ($query) use ($departmentMembersIds) {
                    foreach ($departmentMembersIds as $memberId) {
                        $query->orWhereRaw("FIND_IN_SET($memberId, additional_stakeholders)");
                    }
                })->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toArray();
            } else {
                $loggedUserTeams = User::with('teams')->find(auth()->id())->teams->pluck('id')->toArray();
                $ownedDocumentsIds =  Document::where('document_owner', auth()->id())->pluck('id')->toarray();
                $reviewedDocumentsIds =  Document::where('document_reviewer', auth()->id())->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toarray();
                if (!empty($loggedUserTeams)) {
                $teamsDocumentsIds = Document::where(function ($query) use ($loggedUserTeams) {
                    foreach ($loggedUserTeams as $teamId) {
                        $query->orWhereRaw("FIND_IN_SET($teamId, team_ids)");
                    }
                })->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toArray();
                } else {
                    $teamsDocumentsIds = [];
                }

                $loggedUserId = auth()->id();
                $stakesDocumentsIds = Document::where(function ($query) use ($loggedUserId) {
                        $query->orWhereRaw("FIND_IN_SET($loggedUserId, additional_stakeholders)");
                    })->where('privacy', 1)->whereIn('document_status', [2, 3])->pluck('id')->toArray();
            }
            $publicDocuments = Document::where('privacy', 2)->where('document_status', 3)->pluck('id')->toarray();
            $documentsIds = array_unique(array_merge($ownedDocumentsIds, $reviewedDocumentsIds, $stakesDocumentsIds, $teamsDocumentsIds));
            $conditions = [
                'where' => [
                    'document_type' => session('doc_current_id_dtb'),
                ],
                'whereIn' => [
                    'id' => $documentsIds,
                ],
            ];
        }else {
            $conditions = [
                'where' => [
                    'document_type' => session('doc_current_id_dtb'),
                ]
            ];
        }
        $relationshipsWithColumns = [
            // 'relationshipName:column1,column2,....'
            // 'assets:name',
            // 'teams:name'
        ];

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
        Document::class,
        $dataTableDetails,
        $customFilterFields,
        $conditions
        );

        $mainTableColumns = getTableColumnsSelect(
            'documents',
            [
                'id',
                'document_type',
                'privacy',
                'document_name',
                'parent',
                'document_status',
                'file_id',
                'creation_date',
                'last_review_date',
                'review_frequency',
                'next_review_date',
                'approval_date',
                'control_ids',
                'framework_ids',
                'document_owner',
                'document_reviewer',
                'created_by',
                'additional_stakeholders',
                'approver',
                'team_ids'
            ]
        );


         // Getting records with apply global search */
         $documents = getDatatableFilterRecords(
            Document::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns,
            $conditions
        );

        // Custom vulnerabilities response data as needs
        $data_arr = [];
        foreach ($documents as $document) {

            $frames = Framework::whereIn('id', explode(',', $document->framework_ids))->get();
            $frames_txt = '';
            foreach ($frames as $frame) {
                $frames_txt .= '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' .
                    $frame->name . '</span>';
            }
            $framework_name =  $frames_txt;

            $frames = FrameworkControl::whereIn('id', explode(',', $document->control_ids))->get();
            $frames_txt = '';
            foreach ($frames as $frame) {
                $frames_txt .= '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' .
                    $frame->short_name . '</span>';
            }
            $controls = $frames_txt;

            $statuses = [];
            $statuses[1] = "Draft";
            $statuses[2] = "InReview";
            $statuses[3] = "Approved";
            $status = $statuses[$document->document_status];

            $currentUserId = auth()->id();
            $returnedString = '';

            $returnedString .= '<a  href="javascript:;" onclick="showDocument(' . $document->id . ')"
            class="item-edit dropdown-item ">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye me-50 font-small-4"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>' . __('locale.View') . '</a>';
            if (auth()->user()->hasPermission('document.download'))
                $returnedString .= '<span class="tem-edit dropdown-item supporting_documentation"
            data-document-id="' . $document->id . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>'. __('locale.download') .'</span>';

            if ($currentUserId == $document->document_owner)
                $returnedString .= '<a  href="javascript:;" onclick="editDocument(' . $document->id . ')" class="item-edit dropdown-item "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>'. __('locale.Edit') .'</a>';
            if ($currentUserId == $document->document_owner)
                $returnedString .= '<a  href="javascript:;" onclick="deleteDocument(' . $document->id . ')" class="dropdown-item  btn-flat-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-50 font-small-4"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>'. __('locale.Delete') .'</a>';
            if ($returnedString == '') {
                $returnedString = '------';
                // return $returnedString;
            } else
                $returnedString = '<div class="d-inline-flex">
            <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4" style="height: 20px !important;
            width: 40px !important;">
            <circle cx="12" cy="12" r="1"></circle>
            <circle cx="12" cy="5" r="1"></circle>
            <circle cx="12" cy="19" r="1"></circle>
        </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-end">'
                    . $returnedString .
                    '</div>
            </div>';

            $data_arr[] = array(
                'id' =>  $document->id,
                'document_name' => $document->document_name,
                'framework_name' => $framework_name,
                'control' => $controls,
                'status' => $status,
                'approval_date' => $document->approval_date,
                'creation_date' => $document->creation_date,
                'actions' => $returnedString
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(intval($dataTableDetails['draw']), $totalRecords, $totalRecordswithFilter, $data_arr);

        return response()->json($response, 200);
    }

    public function DocTable(Request $request)
    {

        if (request()->ajax()) {
            $currentUserId = auth()->id();
            return DataTables::of(Document::where('document_type', session('doc_current_id_dtb'))->where(function ($query)  use ($currentUserId) {
                // $this->getUserHaveAbilityToViewDocument($query, $currentUserId);
                $query->where('document_owner', '=', $currentUserId)
                    ->orWhere('created_by', '=', $currentUserId);
            })
                ->select('*'))

                ->addColumn('responsive_id', function ($item) {
                    return $item->id;
                })
                ->addColumn('framework_name', function ($item) {
                    $frames = Framework::whereIn('id', explode(',', $item->framework_ids))->get();
                    $frames_txt = '';
                    foreach ($frames as $frame) {
                        $frames_txt .= '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' .
                            $frame->name . '</span>';
                    }
                    return $frames_txt;
                })
                ->addColumn('control', function ($item) {
                    $frames = FrameworkControl::whereIn('id', explode(',', $item->control_ids))->get();
                    $frames_txt = '';
                    foreach ($frames as $frame) {
                        $frames_txt .= '<span class="badge rounded-pill badge-light-primary" style="margin: 4px">' .
                            $frame->short_name . '</span>';
                    }
                    return $frames_txt;
                })
                ->editColumn('status', function ($item) {
                    $statuses = [];
                    $statuses[1] = "Draft";
                    $statuses[2] = "InReview";
                    $statuses[3] = "Approved";
                    return $statuses[$item->document_status];
                })
                ->addColumn('actions', function ($item) {
                    $currentUserId = auth()->id();
                    $returnedString = '';

                    $returnedString .= '<a  href="javascript:;" onclick="showDocument(' . $item->id . ')"
                  class="item-edit dropdown-item ">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye me-50 font-small-4"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>View</a>';
                    if (auth()->user()->hasPermission('document.download'))
                        $returnedString .= '<span class="tem-edit dropdown-item supporting_documentation"
                    data-document-id="' . $item->id . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>download</span>';

                    if ($currentUserId == $item->document_owner)
                        $returnedString .= '<a  href="javascript:;" onclick="editDocument(' . $item->id . ')" class="item-edit dropdown-item "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>Edit</a>';
                    if ($currentUserId == $item->document_owner)
                        $returnedString .= '<a  href="javascript:;" onclick="deleteDocument(' . $item->id . ')" class="dropdown-item  btn-flat-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-50 font-small-4"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>Delete</a>';
                    if ($returnedString == '') {
                        $returnedString = '------';
                        return $returnedString;
                    } else
                        return '<div class="d-inline-flex">
                    <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
                    :
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">'
                            . $returnedString .
                            '</div>
                    </div>';
                })
                ->rawColumns(['responsive_id', 'framework_name', 'control', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    protected function getUserHaveAbilityToViewDocument($document, $currentUserId)
    {
        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($document->document_status == 3 /*Approved*/ && $document->privacy == 2 /*public*/) {
            return true;
        } else if (($document->document_status == 2 /*InReview*/) || ($document->document_privacy == 3 /*Approved*/ && $document->privacy == 1 /*private*/)) {
            if (
                $currentUserId == $document->document_reviewer // current user is reviewer
            ) {
                return true;
            }

            // Get users from stockholders
            $additionalStakeholders = explode(',', $document->additional_stakeholders);

            if (in_array($currentUserId, $additionalStakeholders)) {
                return true;
            }
            unset($additionalStakeholders);

            // Get users from team
            $usersInTeams = [];
            $teams = Team::with('users:id')->whereIn('id', explode(',', $document->team_ids))->get();
            foreach ($teams as $team) {
                foreach ($team->users as $user) {
                    array_push($usersInTeams, $user->id);
                }
            }
            unset($teams);
            if (in_array($currentUserId, $usersInTeams)) {
                return true;
            }

            return false;
        }
    }

}
