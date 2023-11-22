@extends('admin/layouts/contentLayoutMaster')

@section('title', __('governance.Define Controls'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    {{--
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection


<style>
    .gov_btn {
        border-color: #0097a7 !important;
        background-color: #0097a7 !important;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_check {
        padding: 0.786rem 0.7rem;
        line-height: 1;
        font-weight: 500;
        font-size: 1.2rem;
    }

    .gov_err {

        color: red;
    }

    .gov_btn {
        border-color: #0097a7;
        background-color: #0097a7;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_edit {
        border-color: #5388B4 !important;
        background-color: #5388B4 !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_map {
        border-color: #6c757d !important;
        background-color: #6c757d !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_delete {
        border-color: red !important;
        background-color: red !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }
</style>
@section('content')


    <!-- Advanced Search -->
    <section id="advanced-search-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('governance.Controls') }}</h4>
                        </div>
                        <div class="dt-action-buttons text-end">
                            <div class="dt-buttons d-inline-flex">
                                @if (auth()->user()->hasPermission('control.create'))
                                    <button class="dt-button  btn btn-primary  me-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#add_control">
                                        {{ __('locale.Add') }} {{ __('governance.Control') }}
                                    </button>
                                    <a href="{{ route('admin.governance.notificationsSettingscontrol') }}"
                                        class="dt-button btn btn-primary me-2" target="_self">
                                        {{ __('locale.NotificationsSettings') }}
                                    </a>
                                @endif
                                @if (auth()->user()->hasPermission('audits.create'))
                                    <button class="dt-button  btn btn-info  me-2" type="button"
                                        onclick="CreateAuditSellectAll()">
                                        {{ __('locale.Initiate Audits') }}
                                    </button>
                                @endif

                                <!-- Import and export container -->
                                <x-export-import name=" {{ __('governance.Control') }}"
                                    createPermissionKey='control.create' exportPermissionKey='control.export'
                                    exportRouteKey='admin.governance.control.ajax.export'
                                    importRouteKey='admin.governance.control.import' />
                                <!--/ Import and export container -->
                            </div>
                        </div>
                    </div>
                    <!--Search Form -->
                    <div class="card-body mt-2">
                        <form class="dt_adv_search" method="POST">
                            <div class="row g-1 mb-md-1">
                                <!-- Name -->
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('Name') }}</label>
                                    <input class="form-control dt-input " name="filter_short_name" data-column="2"
                                        data-column-index="1" type="text">
                                </div>

                                <!-- framework -->
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('governance.Framework') }}</label>
                                    <select class="form-control dt-input dt-select select2 " name="filter_Frameworks"
                                        id="framework" data-column="4" data-column-index="3">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($frameworks as $framework)
                                            <option value="{{ $framework['name'] }}" data-id="{{ $framework['id'] }}">
                                                {{ $framework['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!--  families -->
                                <div class="col-md-4 family-container">
                                    <label class="form-label">{{ __('governance.Domain') }}</label>
                                    <select class="form-control dt-input dt-select select2 domain_select_filter"
                                        no_datatable_draw="true" name="filter_family_name" data-column="5"
                                        data-column-index="4">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($families as $family)
                                            <option value="{{ $family->name }}"
                                                data-families="{{ json_encode($family->families) }}">{{ $family->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- sub families --}}
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('governance.sub_domain') }}</label>
                                    <select class="form-control dt-input dt-select select2" name="filter_family_with_parent"
                                        data-column="6" data-column-index="5">
                                        <option value="" selected>{{ __('locale.select-option') }}</option>

                                    </select>
                                </div>
                            </div>

                        </form>
                    </div>
                    <hr class="my-0" />
                    <div class="card-datatable table-responsive">
                        <table class="dt-advanced-server-search table">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('locale.Select') }}</th>
                                    <th class="all">{{ __('locale.Name') }}</th>
                                    <th class="all">{{ __('locale.Description') }}</th>
                                    <th class="all">{{ __('governance.Framework') }}</th>
                                    <th class="all">{{ __('governance.Domain') }}</th>
                                    <th class="all">{{ __('governance.sub_domain') }}</th>
                                    <th class="all">{{ __('locale.Actions') }}</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all"></th>
                                    <th class="all">{{ __('locale.Name') }}</th>
                                    <th class="all">{{ __('locale.Description') }}</th>
                                    <th class="all">{{ __('governance.Framework') }}</th>
                                    <th class="all">{{ __('governance.Domain') }}</th>
                                    <th class="all">{{ __('governance.sub_domain') }}</th>
                                    <th class="all">{{ __('locale.Actions') }}</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- // add control modal -->
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="add_control">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <form id="form-add_control" class="form-add_control todo-modal" novalidate method="POST"
                    action="{{ route('admin.governance.control.store2') }}">
                    @csrf

                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('locale.Add') }} {{ __('governance.Control') }}</h5>
                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                            <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                    class="font-medium-2"></i></span>
                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                <input type="text" name="name" class=" form-control" placeholder="" required />
                                <span class="error error-name "></span>

                            </div>

                            <div class="mb-1">
                                <label for="desc" class="form-label">{{ __('locale.Description') }}</label>
                                <textarea class="form-control" name="description"></textarea>
                                <span class="error error-description"></span>

                            </div>
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('governance.ControlNumber') }}</label>
                                <input type="text" name="number" class=" form-control" placeholder="" />
                                <span class="error error-number "></span>

                            </div>

                            <!--  long_name -->
                            <div class="mb-1">
                                <label class="form-label" for="long_name">{{ __('governance.ControlLongName') }}</label>
                                <input class="form-control" type="text" name="long_name">
                            </div>

                            <!--  framework -->
                            <div class="mb-1 framework-container">
                                <label class="form-label">{{ __('governance.Framework') }}</label>
                                <select class="select2 form-select  add-control-framework-select" name="framework"
                                    required>
                                    <option value="" disabled selected>{{ __('locale.select-option') }}</option>
                                    @foreach ($frameworks as $framework)
                                        <option value="{{ $framework['id'] }}"
                                            data-domains="{{ json_encode($framework['domains']) }}"
                                            data-controls="{{ json_encode($framework['controls']) }}">
                                            {{ $framework['name'] }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-framework"></span>
                            </div>

                            <!--  families -->
                            <div class="mb-1 family-container">
                                <label class="form-label" for="family">{{ __('governance.Domain') }}</label>

                                <select class="select2 form-select domain_select" name="family" required>
                                    <option value="" disabled selected>{{ __('locale.select-option') }}</option>
                                </select>
                                <span class="error error-family"></span>
                            </div>

                            {{-- sub families --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('governance.sub_domain') }}</label>

                                <select class="select2 form-select" name="sub_family" required>
                                    <option value="" disabled selected>{{ __('locale.select-option') }}</option>
                                </select>
                                <span class="error error-sub_family"></span>
                            </div>

                            {{-- Parent control --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('governance.ParentControlFramework') }}</label>
                                <select class="select2 form-select" name="parent_id">
                                    <option value="" selected>{{ __('locale.select-option') }}</option>
                                </select>
                                <span class="error error-parent_id"></span>
                            </div>

                            <!--  mitigation_guidance -->
                            <div class="mb-1">
                                <label class="form-label"
                                    for="mitigation_percent">{{ __('governance.mitigationpercent') }} </label>
                                <input class="form-control" type="text" name="mitigation_percent">
                            </div>

                            <!--  supplemental_guidance -->
                            <div class="mb-1">
                                <label class="form-label" for="supplemental_guidance">
                                    {{ __('governance.supplementalGuidance') }} </label>
                                <input class="form-control" type="text" name="supplemental_guidance">
                            </div>

                            <div class="mb-1">
                                <label class="form-label" for="priority"> {{ __('governance.ControlPriority') }} </label>

                                <select class="select2 form-select" id="task-assigned" name="priority">
                                    <option value="">
                                        {{ __('governance.selectpriority') }}
                                    </option>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}">
                                            {{ $priority->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-1">
                                <label class="form-label" for="phase">{{ __('governance.ControlPhase') }} </label>

                                <select class="select2 form-select" id="task-assigned" name="phase">
                                    <option value="">
                                        {{ __('governance.selectphase') }}
                                    </option>
                                    @foreach ($phases as $phase)
                                        <option value="{{ $phase->id }}">
                                            {{ $phase->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-1">
                                <label class="form-label" for="type">{{ __('governance.ControlType') }} </label>

                                <select class="select2 form-select" id="task-assigned" name="type">
                                    <option value="">
                                        {{ __('governance.selectType') }}
                                    </option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-1">
                                <label class="form-label" for="maturity"> {{ __('governance.ControlMaturity') }} </label>

                                <select class="select2 form-select" id="task-assigned" name="maturity">
                                    <option value="">
                                        {{ __('governance.selectmaturity') }}
                                    </option>
                                    @foreach ($maturities as $maturity)
                                        <option value="{{ $maturity->id }}">
                                            {{ $maturity->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-1">
                                <label class="form-label" for="class"> {{ __('governance.ControlClass') }} </label>

                                <select class="select2 form-select" id="task-assigned" name="class">
                                    <option value="">
                                        {{ __('governance.selectClass') }}
                                    </option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-1">

                                <label class="form-label" for="desired_maturity">
                                    {{ __('governance.ControlDesiredMaturity') }} </label>
                                <select class="select2 form-select" id="task-assigned" name="desired_maturity">
                                    <option value=""> {{ __('governance.selectDesiredMaturity') }} </option>
                                    @foreach ($desiredMaturities as $desiredMaturity)
                                        <option value="{{ $desiredMaturity->id }}"> {{ $desiredMaturity->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <!-- //Control Status -->
                            {{-- <div class="mb-1">
                            <label class="form-label ">Control Status</label>
                            <select class="select2 form-select" name="control_status">
                                <option value="Not Applicable"> {{ __('locale.Not Applicable') }}</option>
                                <option value="Not Implemented"> {{ __('locale.Not Implemented') }}</option>
                                <option value="Partially Implemented"> {{ __('locale.Partially Implemented') }}</option>
                                <option value="Implemented"> {{ __('locale.Implemented') }}</option>
                            </select>
                            <span class="error error-control_status"></span>
                        </div> --}}

                            <!-- //owner -->
                            <div class="mb-1">

                                <label class="form-label" for="owner"> {{ __('governance.ControlOwner') }} </label>
                                <select class="select2 form-select" id="task-assigned" name="owner">
                                    <option value="">{{ __('governance.selectOwner') }} </option>
                                    @foreach ($owners as $owner)
                                        <option value="{{ $owner->id }}"> {{ $owner->name }} </option>
                                    @endforeach

                                </select>
                            </div>



                            <!-- //add test start-->

                            <div class="mb-1">
                                <label class="form-label " for="select2-basic1">{{ __('locale.Tester') }}</label>
                                <select class="select2 form-select" name="tester">
                                    <option value="" disabled selected>{{ __('locale.select-option') }}</option>
                                    @foreach ($testers as $tester)
                                        <option value="{{ $tester->id }}">{{ $tester->name }}</option>
                                    @endforeach

                                </select>
                                <span class="error error-tester "></span>
                            </div>

                            {{-- <div class="mb-1">
                                <label class="form-label"
                                    for="basic-icon-default-post">{{ __('locale.TestName') }}</label>
                                <input type="text" name="test_name" id="basic-icon-default-post"
                                    class="form-control dt-post" aria-label="Web Developer" required />
                                <span class="error error-test_name "></span>
                            </div> --}}

                            <!-- <div class="mb-1">
                                                                                                                                        <label class="form-label" for="additional_stakeholders"> AdditionalStakeholders </label>
                                                                                                                                        <select name="additional_stakeholders[]" class="form-select multiple-select2" id="additional_stakeholders" multiple="multiple">
                                                                                                                                          <option value=""> select-option </option>
                                                                                                                                           @foreach ($testers as $tester)
    <option value="{{ $tester->id }}">{{ $tester->name }}</option>
    @endforeach

                                                                                                                                        </select>
                                                                                                                                        <span class="error error-additional_stakeholders" ></span>
                                                                                                                                      </div>
                                                                                                                                      <div class="mb-1">
                                                                                                                                        <label class="form-label" for="teams">  Teams </label>
                                                                                                                                        <select name="teams[]" class="form-select multiple-select2" id="teams" multiple="multiple">
                                                                                                                                          <option value="" >select teams </option>
                                                                                                                                           @foreach ($teams as $team)
    <option value="{{ $team->id }}">{{ $team->name }}</option>
    @endforeach
                                                                                                                                        </select>
                                                                                                                                        <span class="error error-teams " ></span>
                                                                                                                                      </div> -->
                            <div class="mb-1">
                                <label class="form-label" for="normalMultiSelect1">{{ __('locale.TestFrequency') }}
                                    ({{ __('locale.days') }})</label>
                                <input name="test_frequency" type="number" min="0" class="form-control " />
                                <span class="error error-test_frequency "></span>
                            </div>
                            {{--
                            <div class=" mb-1">
                                <label class="form-label" for="fp-default"> {{ __('locale.LastTestDate') }}</label>
                                <input type="text" data-i="0" name="last_date" placeholder="YYYY-MM-DD "
                                    class="form-control js-datepicker">

                            </div> --}}
                            <div class="mb-1">
                                <label class="form-label"
                                    for="exampleFormControlTextarea1">{{ __('locale.TestSteps') }}</label>
                                <textarea class="form-control" name="test_steps" id="exampleFormControlTextarea1" rows="3"></textarea>
                                <span class="error error-test_steps "></span>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="normalMultiSelect1"> {{ __('locale.ApproximateTime') }}
                                    ({{ __('locale.minutes') }})</label>
                                <input name="approximate_time" type="number" min="0"
                                    id="basic-icon-default-post" class="form-control dt-post"
                                    aria-label="Web Developer" />
                                <span class="error error-approximate_time "></span>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="exampleFormControlTextarea1">
                                    {{ __('locale.ExpectedResults') }}</label>
                                <textarea class="form-control" name="expected_results" id="exampleFormControlTextarea1" rows="3"></textarea>
                                <span class="error error-expected_results"></span>
                            </div>

                            <!--add test end -->

                        </div>
                        <div class="my-1">
                            <button type="submit" class="btn btn-primary   add-todo-item me-1">Add</button>
                            <button type="button" class="btn btn-outline-secondary add-todo-item "
                                data-bs-dismiss="modal">
                                Cancel
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- // edit control modal -->
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit_contModal" role="dialog">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">


                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('governance.UpdateControl') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                class="font-medium-2"></i></span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>

                <form id="update_form" class="todo-modal needs-validation" novalidate method="POST"
                    action="{{ route('admin.governance.control.update') }}">
                    @csrf

                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3" id="form-modal-edit">

                    </div>


                </form>


            </div>
        </div>
    </div>

    <!-- // map control modal -->

    <div class="modal modal-slide-in sidebar-todo-modal fade" id="empModal" role="dialog">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">


                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('governance.Mapping') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                class="font-medium-2"></i></span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>

                <!-- <h3> Mapped Control Frameworks </h3> -->
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3" id="form-modal-map">


                </div>




            </div>
        </div>
    </div>

    <!-- // List Objectives Modal -->

    <div class="modal modal-slide-in sidebar-todo-modal fade" id="objectiveModal" role="dialog">
        <div class="modal-dialog sidebar-lg" style="width:700px">
            <div class="modal-content p-0">


                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('governance.Objectives') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>

                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div>
                        <h3 style="display: inline-block">{{ __('governance.Control') }} :</h3>
                        <h3 style="display: inline-block" id="controlName"></h3>

                    </div>
                    <br>
                    <div id="objectivesList">

                    </div>
                    <br>
                    @if (auth()->user()->hasPermission('control.add_objectives'))
                        <div class="text-center">
                            <button class="btn btn-success"
                                id="addObjective">{{ __('governance.AddObjective') }}</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- // Add Objective Modal -->

    <div class="modal fade" tabindex="-1" aria-hidden="true" id="addObjectiveModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 px-md-5 pb-3">
                    <div class="text-center mb-4">
                        <h1 class="role-title">{{ __('governance.AddObjective') }}</h1>
                    </div>
                    <!-- Evidence form -->
                    <form class="row addObjectiveToControlForm" onsubmit="return false" enctype="multipart/form-data">
                        <input type="hidden" name="control_id">
                        <input type="hidden" name="objective_adding_type" value="existing">
                        @csrf
                        <div class="col-12 objective_id_container">
                            {{-- objective id --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('governance.Objective') }}</label>
                                <a href="javascript:;"
                                    onclick="showAddNewObjectiveInputs()">{{ __('governance.AddNewObjective') }}?</a>
                                <select class="select2 form-select" name="objective_id">
                                    <option value="" selected>{{ __('locale.select-option') }}</option>
                                </select>
                                <span class="error error-objective_id"></span>
                                <span class="error error-control_id"></span>
                            </div>
                        </div>
                        <div class="col-12  objective_name_container" style="display: none;">
                            {{-- objective Name --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('governance.ObjectiveName') }}</label>
                                <a onclick="showSelectExistingObjectiveInputs()"
                                    href="javascript:;">{{ __('locale.SelectExistingObjective') }}?</a>
                                <input type="text" class="form-control" name="objective_name" />
                                <span class="error error-objective_name"></span>
                                <span class="error error-control_id"></span>
                            </div>
                        </div>
                        <div class="col-12 objective_description_container" style="display: none;">
                            {{-- objective Descriotion --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('governance.ObjectiveDescription') }}</label>
                                <textarea name="objective_description" class="form-control"></textarea>
                                <span class="error error-objective_description"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            {{-- Responsible Type --}}
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('governance.ResponsibleType') }}</label>
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="responsible_type"
                                            id="user" value="user" checked />
                                        <label class="form-check-label" for="user">{{ __('locale.User') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="responsible_type"
                                            id="manager" value="manager" />
                                        <label class="form-check-label"
                                            for="manager">{{ __('locale.DepartmentManager') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="responsible_type"
                                            id="team" value="team" />
                                        <label class="form-check-label" for="team">{{ __('locale.Team') }}</label>
                                    </div>
                                </div>
                                <span class="error error-responsible_type"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            {{-- Responsible --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('locale.Responsible') }}
                                    <small>({{ __('governance.ControlOwnerWillBeResponsibleIfYouDidntSelectOne') }})</small></label>
                                <select class="select2 form-select" name="responsible_id">
                                    <option value="" selected>{{ __('locale.select-option') }}</option>
                                </select>
                                <span class="error error-responsible_id"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            {{-- Responsible --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('locale.DueDate') }}</label>
                                <input name="due_date" class="form-control flatpickr-date-time-compliance"
                                    placeholder="YYYY-MM-DD" />
                                <span class="error error-due_date"></span>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-2">
                            <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}</button>
                        </div>
                    </form>
                    <!--/ Evidence form -->
                </div>
            </div>
        </div>
    </div>
    <!-- // Change Responsible Modal -->

    <div class="modal fade" tabindex="-1" aria-hidden="true" id="changeResponsibleModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 px-md-5 pb-3">
                    <div class="text-center mb-4">
                        <h1 class="role-title">{{ __('locale.ChangeResponsible') }}</h1>
                    </div>
                    <!-- Evidence form -->
                    <form class="row changeResponsibleForm" onsubmit="return false" enctype="multipart/form-data">
                        <input type="hidden" name="control_control_objective_id">
                        @csrf
                        <div class="col-12">
                            {{-- Responsible --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('locale.Responsible') }}</label>
                                <select class="select2 form-select" name="responsible_member_id">
                                    <option value="" selected>{{ __('locale.select-option') }}</option>
                                </select>
                                <span class="error error-responsible_member_id"></span>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-2">
                            <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}</button>
                        </div>
                    </form>
                    <!--/ Evidence form -->
                </div>
            </div>
        </div>
    </div>

    <!-- // Add Evidence Modal -->

    <div class="modal fade" tabindex="-1" aria-hidden="true" id="addEvidenceModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 px-md-5 pb-3">
                    <div class="text-center mb-4">
                        <h1 class="role-title">{{ __('governance.AddEvidence') }}</h1>
                    </div>
                    <!-- Evidence form -->
                    <form class="row addEvidenceToObjectiveForm" onsubmit="return false" enctype="multipart/form-data">
                        <input type="hidden" name="control_control_objective_id">
                        @csrf
                        <div class="col-12">
                            {{-- Evidence Description --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('governance.EvidenceDescription') }}</label>
                                <input class="form-control" type="text" name="evidence_description">
                                <span class="error error-evidence_description"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            {{-- File Attachment --}}
                            <div class="mb-1">
                                <label class="form-label">{{ __('governance.EvidenceFile') }}</label>
                                <input type="file" name="evidence_file" class="form-control dt-post"
                                    aria-label="{{ __('locale.file') }}" />
                                <span class="error error-evidence_file "></span>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-2">
                            <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}</button>
                        </div>
                    </form>
                    <!--/ Evidence form -->
                </div>
            </div>
        </div>
    </div>

    <!-- // List Evidences Modal -->

    <div class="modal modal-slide-in sidebar-todo-modal fade" id="evidencesModal" role="dialog">
        <div class="modal-dialog sidebar-lg" style="width:700px">
            <div class="modal-content p-0">


                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('locale.Evidences') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>

                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div>
                        <h3 style="display: inline-block">{{ __('governance.Control') }} :</h3>
                        <h3 style="display: inline-block" id="evidenceControlName"> </h3>
                        <h3 style="display: inline-block"> / {{ __('governance.Objective') }} :</h3>
                        <h3 style="display: inline-block" id="evidenceObjectiveName"></h3>

                    </div>
                    <br>
                    <div id="evidencesList">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- // Edit Evidence Modal -->

    <div class="modal fade" tabindex="-1" aria-hidden="true" id="editEvidenceModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 px-md-5 pb-3">
                    <div class="text-center mb-4">
                        <h1 class="role-title">{{ __('governance.EditEvidence') }}</h1>
                    </div>
                    <!-- Evidence form -->
                    <form class="row editEvidenceForm" onsubmit="return false" enctype="multipart/form-data">
                        @csrf
                        <input class="form-control" type="hidden" name="evidence_id">
                        <div class="col-12">
                            {{-- Evidence Description --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('governance.EvidenceDescription') }}</label>
                                <input type="text" class="form-control" name="edited_evidence_description">
                                <span class="error error-edited_evidence_description"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            {{-- File Attachment --}}
                            <div class="mb-1">
                                <label class="form-label">{{ __('governance.EvidenceFile') }}</label>

                                <input type="file" name="edited_evidence_file" class="form-control dt-post"
                                    aria-label="{{ __('locale.file') }}" />
                                <span class="error error-edited_evidence_file "></span>
                            </div>
                            <div class="mb-1 last_uploaded_file_container" style="display: hidden;">
                                <label class="form-label">{{ __('locale.LastUploadedFile') }}</label>
                                <a class="badge bg-secondary last_uploaded_file cursor-pointer text-light"></a>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-2">
                            <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}</button>
                        </div>
                    </form>
                    <!--/ Evidence form -->
                </div>
            </div>
        </div>
    </div>
    <!-- // View Evidence Modal -->

    <div class="modal fade" tabindex="-1" aria-hidden="true" id="viewEvidenceModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 px-md-5 pb-3">
                    <div class="text-center mb-4">
                        <h1 class="role-title">{{ __('locale.ViewEvidence') }}</h1>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{-- Evidence Description --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('governance.EvidenceDescription') }}</label>
                                <input class="form-control view_evidence_description" disabled>
                            </div>
                        </div>
                        <div class="col-12 view_evidence_file_container">
                            {{-- File Attachment --}}
                            <div class="mb-1">
                                <label class="form-label">{{ __('governance.EvidenceFile') }}</label>
                                <a class="badge bg-secondary view_evidence_file cursor-pointer text-light"></a>
                            </div>
                        </div>

                        <div class="col-12">
                            {{-- Evidence Description --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('locale.CreatedBy') }}</label>
                                <input class="form-control view_evidence_created_by" disabled>

                            </div>
                        </div>
                        <div class="col-12">
                            {{-- Evidence Description --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('locale.CreatedAt') }} </label>
                                <input class="form-control view_evidence_created_at" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="https://amsul.ca/pickadate.js/vendor/pickadate/lib/picker.js"></script>
    <script src="https://amsul.ca/pickadate.js/vendor/pickadate/lib/picker.date.js"></script>

@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script>
        var permission = [],
            lang = []
        URLs = [];
        URLs['ajax_list'] = "{{ route('admin.governance.ajax.get-list-control') }}";
        permission['edit'] = {{ auth()->user()->hasPermission('control.update')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('control.delete')? 1: 0 }};
        permission['audits.create'] = {{ auth()->user()->hasPermission('audits.create')? 1: 0 }};
        permission['list_objectives'] = {{ auth()->user()->hasPermission('control.list_objectives')? 1: 0 }};

        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.department')]) }}";
        lang['Edit'] = "{{ __('locale.Edit') }}";
        lang['Objective'] = "{{ __('governance.Objective') }}";
        lang['Mapping'] = "{{ __('governance.Mapping') }}";
        lang['Delete'] = "{{ __('locale.Delete') }}";
        lang['Audit'] = "{{ __('governance.Audit') }}";


        // edit control
        function editControl(data) {

            var url = "{{ route('admin.governance.ajax.edit_control', '') }}" + "/" + data;

            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    $('.dtr-bs-modal').modal('hide');
                    $('#edit_contModal').modal('show');
                    $('#form-modal-edit').html(response);
                    $('#form-modal-edit').find('.select2').select2();

                }

            });
        };
        // mapping


        function deleteControl(data) {
            var url = "{{ route('admin.governance.control.destroy', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('.dtr-bs-modal').modal('hide');
                        redrawDatatable();
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }


        function mapControl(data) {


            var url = "{{ route('admin.governance.ajax.get-list_control-map', '') }}" + "/" + data;

            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {

                    $('#empModal').modal('show');
                    $('#form-modal-map').html(response);

                }
            });

        }

        function showControlObjectives(data) {
            var url = "{{ route('admin.governance.control.ajax.objective.get', '') }}" + "/" + data;

            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    control = response.control;
                    objectives = response.objectives;
                    $('#objectivesList').empty();
                    $('#controlName').html(control.short_name)
                    $('#addObjective').attr('onClick', 'showAddObjectiveForm(' + control.id + ');')
                    if (objectives.length) {
                        publishTableWithObjectives(objectives)
                    } else {
                        html = '<h4 style="text-align:center; color:red">No Objectives Yet<h4>'
                        $('#objectivesList').html(html);
                    }
                    $('#objectiveModal').modal('show');
                }
            });

        }

        function showChangeResponsibleForm(controlControlObjectiveId) {
            var url = "{{ route('admin.governance.control.ajax.objective.getDepartmentMembers', '') }}" + "/" +
                controlControlObjectiveId;
            $('[name="control_control_objective_id"]').val(controlControlObjectiveId)
            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {

                    members = response;
                    if (members.length) {
                        var membersOptions =
                            '<option value="" selected>{{ __('locale.select-option') }}</option>';
                        $.each(members, function(index, member) {
                            membersOptions += '<option value="' + member.id + '">' + member
                                .name + '</option>'
                        });
                        $('[name="responsible_member_id"]').html(membersOptions);

                    }
                    $('#changeResponsibleModal').modal('show');
                }
            });
        }

        $('.changeResponsibleForm').submit(function(e) {
            e.preventDefault();
            $('.error').empty();
            var url = "{{ route('admin.governance.control.ajax.objective.updateObjectiveResponsible') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: $('.changeResponsibleForm').serialize(),
                success: function(data) {
                    if (data.status) {
                        objectives = data.data;
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        publishTableWithObjectives(objectives);
                        $('#changeResponsibleModal').modal('hide');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }


            });

        });

        function showAddObjectiveForm(control_id) {

            showSelectExistingObjectiveInputs();
            var url = "{{ route('admin.governance.control.ajax.objective.getAll', '') }}" + "/" + control_id;
            $('[name="control_id"]').val(control_id);
            $("input[name='responsible_type'][value='user']").prop("checked", true);
            $("input[name='due_date']").val('');

            $('.error').empty();
            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {

                    objectives = response.objectives;
                    users = response.users;
                    if (objectives.length) {
                        var objectivesOptions =
                            '<option value="" selected>{{ __('locale.select-option') }}</option>';
                        $.each(objectives, function(index, objective) {
                            objectivesOptions += '<option value="' + objective.id + '"' + (objective
                                    .disabled ? 'disabled' : '') + '>' + objective
                                .name + '</option>'
                        });
                        $('[name="objective_id"]').html(objectivesOptions);

                    }
                    if (users.length) {
                        var usersOptions =
                            '<option value="" selected>{{ __('locale.select-option') }}</option>';
                        $.each(users, function(index, user) {
                            usersOptions += '<option value="' + user.id + '">' + user
                                .name + '</option>'
                        });
                        $('[name="responsible_id"]').html(usersOptions);

                    }
                    $('#addObjectiveModal').modal('show');
                }
            });
        }

        $('.addObjectiveToControlForm').submit(function(e) {
            e.preventDefault();
            $('.error').empty();
            var url = "{{ route('admin.governance.control.ajax.objective.addObjectiveToControl') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: $('.addObjectiveToControlForm').serialize(),
                success: function(data) {
                    if (data.status) {
                        objectives = data.data;
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        publishTableWithObjectives(objectives);
                        $('#addObjectiveModal').modal('hide');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }


            });

        });


        function showAddEvidenceForm(controlControlObjectiveId) {
            $('[name="control_control_objective_id"]').val(controlControlObjectiveId);
            $('#addEvidenceModal').modal('show');
        }

        $('.addEvidenceToObjectiveForm').submit(function(e) {
            var formData = new FormData(document.querySelector('.addEvidenceToObjectiveForm'));
            e.preventDefault();
            $('.error').empty();
            var url = "{{ route('admin.governance.control.ajax.objective.storeEvidence') }}";
            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#addEvidenceModal').modal('hide');
                        $('[name="control_control_objective_id"]').val('');
                        $('[name="evidence_description"]').val('');
                        $('[name="evidence_file"]').val('');

                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }


            });

        });

        function showEvidencesList(objectiveControlId) {
            var url = "{{ route('admin.governance.control.ajax.objective.getEvidences', '') }}" + "/" +
                objectiveControlId;

            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    controlName = response.control_name;
                    objectiveName = response.objective_name;
                    evidences = response.evidences;
                    canEditEvidences = response.can_edit_evidences
                    $('#evidencesList').empty();
                    $('#evidenceControlName').html(controlName)
                    $('#evidenceObjectiveName').html(objectiveName)
                    if (evidences.length) {
                        publishTableWithEvidences(evidences, canEditEvidences)
                    } else {
                        html = '<h4 style="text-align:center; color:red">No Evidences Yet<h4>'
                        $('#evidencesList').html(html);
                    }
                    $('#evidencesModal').modal('show');
                }
            });



        }

        function showEvidenceData(evidenceId) {
            var url = "{{ route('admin.governance.control.ajax.objective.getEvidence', '') }}" + "/" +
                evidenceId;

            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    evidence = response
                    const date = new Date(evidence.created_at);
                    // convert to local timezone
                    date.setTime(date.getTime() + date.getTimezoneOffset() * 60 * 1000);

                    // format date
                    const dateFormatted = date.toISOString().split('T')[0];
                    $('.view_evidence_description').val(evidence.description);
                    $('.view_evidence_created_by').val(evidence.created_by);
                    $('.view_evidence_created_at').val(dateFormatted);
                    if (evidence.file_name) {
                        $('.view_evidence_file').html(evidence.file_name);
                        $('.view_evidence_file').attr('onclick', 'downloadEvidenceFile(' + evidence.id + ')');
                        $('.view_evidence_file_container').show();
                    } else {
                        $('.view_evidence_file').html('');
                        $('.view_evidence_file').attr('onclick', '');
                        $('.view_evidence_file_container').hide();

                    }
                    $('#viewEvidenceModal').modal('show');
                }
            });
        }

        function showEditEvidenceForm(evidenceId) {
            var url = "{{ route('admin.governance.control.ajax.objective.getEvidence', '') }}" + "/" +
                evidenceId;

            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    evidence = response
                    $('[name="evidence_id"]').val(evidence.id);
                    $('[name="edited_evidence_description"]').val(evidence.description)
                    if (evidence.file_name) {
                        $('a.last_uploaded_file').html(evidence.file_name);
                        $('a.last_uploaded_file').attr('onclick', 'downloadEvidenceFile(' + evidence.id + ')');
                        $('.last_uploaded_file_container').show();
                    } else {
                        $('a.last_uploaded_file').html('');
                        $('a.last_uploaded_file').attr('onclick', '');
                        $('.last_uploaded_file_container').hide();

                    }
                    $('#editEvidenceModal').modal('show');
                }
            });
        }

        $('.editEvidenceForm').submit(function(e) {
            var formData = new FormData(document.querySelector('.editEvidenceForm'));
            e.preventDefault();

            $('.error').empty();
            var url = "{{ route('admin.governance.control.ajax.objective.updateEvidence') }}";
            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#editEvidenceModal').modal('hide');
                        $('[name="edited_evidence_description"]').val('');
                        $('[name="edited_evidence_file"]').val('');

                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }


            });

        });

        function downloadEvidenceFile(evidenceId) {
            var url = "{{ route('admin.governance.control.ajax.objective.downloadEvidenceFile', '') }}" + "/" +
                evidenceId;
            var link = document.createElement("a");
            link.href = url;
            link.style.display = "none";
            document.body.appendChild(link);

            link.click();

            // Cleanup
            document.body.removeChild(link);
        }
    </script>

    <script>
        function publishTableWithObjectives(objectives) {
            table = ''
            table += "<table width=100% class='table' >";
            table += "<tbody><tr> ";
            table += "<th>#</th> ";
            table += "<th>Objectives</th> ";
            table += "<th>Responsible</th> ";
            table += "<th>Due Date</th> ";
            table += "<th style='width:18%;'>actions</th> ";
            table += "</tr>";
            $.each(objectives, function(index, objective) {
                console.log(objective);
                listEvidencesButton =
                    '<a href="javascript:;" class="item-list" title="List Evidences" onclick="showEvidencesList(' +
                    objective.pivot.id + ')">' +
                    feather.icons["list"].toSvg({
                        class: "me-1 font-small-4",
                    }) +
                    "</a>";
                if (objective.canAddEvidence) {
                    addEvidenceButton =
                        '<a  href="javascript:;" class="item-edit" title="Add Evidence" onClick="showAddEvidenceForm(' +
                        objective.pivot.id + ')">' +
                        feather.icons["plus"].toSvg({
                            class: "me-1 font-small-4",
                        }) +
                        "</a>";
                } else {
                    addEvidenceButton = '';
                }
                if (objective.manager) {
                    changeResponsibleButton =
                        '<a  href="javascript:;" class="item-edit" title="Change Responsible" onClick="showChangeResponsibleForm(' +
                        objective.pivot.id + ')">' +
                        feather.icons["edit"].toSvg({
                            class: " font-small-4",
                        }) +
                        "</a>";
                } else {
                    changeResponsibleButton = '';
                }
                canDeleteObjective = {{ auth()->user()->hasPermission('control.add_objectives')? 1: 0 }};
                console.log(canDeleteObjective)
                if(canDeleteObjective){
                    deleteObjectiveButton =
                    '<a  href="javascript:;" class="item-edit "title=Delete Evidence" onClick="ShowModalDeleteObjective(' +
                    objective.pivot.id + ')">' +
                    feather.icons["trash-2"].toSvg({
                            class: "me-50 font-small-4",
                        }) +
                        "</a>";      
                    } else {
                        deleteObjectiveButton = '';
                    }

                row = '<tr><td>' + (index + 1) + '</td><td>' + objective.name +
                    '</td><td>' + objective.responsible +
                    '</td><td>' + objective.due_date +
                    '</td><td>' + listEvidencesButton + addEvidenceButton + changeResponsibleButton + deleteObjectiveButton +'</td></tr>';
                table += row;
            });
            $('#objectivesList').html(table);
        }


        function publishTableWithEvidences(evidences, canEditEvidences = false) {
            table = ''
            table += "<table width=100% class='table' >";
            table += "<tbody><tr> ";
            table += "<th>#</th> ";
            table += "<th>Created By</th> ";
            table += "<th>Created At</th> ";
            table += "<th>actions</th> ";
            table += "</tr>";
            $.each(evidences, function(index, evidence) {
                showEvidencesButton =
                    '<a href="javascript:;" class="item-list " title="Show Evidence" onclick="showEvidenceData(' +
                    evidence.id + ')">' +
                    feather.icons["eye"].toSvg({
                        class: "me-1 font-small-4",
                    }) +
                    "</a>";
                if (canEditEvidences) {
                    editEvidenceButton =
                        '<a  href="javascript:;" class="item-edit "title="Edit Evidence" onClick="showEditEvidenceForm(' +
                        evidence.id + ')">' +
                        feather.icons["edit"].toSvg({
                            class: "me-50 font-small-4",
                        }) +
                        "</a>";
                } else {
                    editEvidenceButton = '';
                }

                if (canEditEvidences) {
                    deleteEvidenceButton =
                        '<a  href="javascript:;" class="item-edit "title=Delete Evidence" onClick="ShowModalDeleteEvidence(' +
                        evidence.id + ')">' +
                        feather.icons["trash-2"].toSvg({
                            class: "me-50 font-small-4",
                        }) +
                        "</a>";
                } else {
                    deleteEvidenceButton = '';
                }
                const date = new Date(evidence.created_at);

                // convert to local timezone
                date.setTime(date.getTime() + date.getTimezoneOffset() * 60 * 1000);

                // format date
                const dateFormatted = date.toISOString().split('T')[0];

                row = '<tr><td>' + (index + 1) + '</td><td>' + evidence.created_by +
                    '</td><td>' + dateFormatted +
                    '</td><td>' + showEvidencesButton + editEvidenceButton + deleteEvidenceButton + '</td></tr>';
                table += row;
            });
            $('#evidencesList').html(table);
        }

        function showAddNewObjectiveInputs() {
            $('.objective_name_container, .objective_description_container').show();
            $('.objective_id_container').hide();
            $('[name="objective_id"]').val('');
            $('[name="objective_adding_type"]').val('new');

        }

        function showSelectExistingObjectiveInputs() {
            $('.objective_id_container').show();
            $('.objective_name_container, .objective_description_container').hide();
            $('[name="objective_name"], [name="objective_description"]').val('');
            $('[name="objective_adding_type"]').val('existing');
        }


        $('[name="responsible_type"]').change(function(e) {
            var url = "{{ route('admin.governance.control.ajax.objective.getResponsibles') }}"
            var responsibleType = $('[name="responsible_type"]:checked').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Retrieve CSRF token from meta tag

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    responsible_type: responsibleType,
                    _token: csrfToken,
                },
                success: function(response) {
                    var responsibles = response;
                        var responsiblesOptions =
                            '<option value="" selected>{{ __('locale.select-option') }}</option>';
                        $.each(responsibles, function(index, responsible) {
                            responsiblesOptions += '<option value="' + responsible.id + '">' +
                                responsible
                                .name + '</option>'
                        });
                        $('[name="responsible_id"]').html(responsiblesOptions);

                },


            });

        });
    </script>
    <script>
        function formReset() {
            var form = $('.form-add_control')[0];
            form.reset();

            // Reset select elements to their default option
            $('.form-add_control select').each(function() {
                $(this).val($(this).find('option:first').val()); // Reset to the first option
            });
        }
        $('.form-add_control').submit(function(e) {
            e.preventDefault();
            $('.error').empty();
            $.ajax({
                url: $('.form-add_control').attr('action'),
                type: 'POST',
                data: $('.form-add_control').serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        redrawDatatable();
                        // Close the form after success
                        $('.form-add_control').closest('.modal').modal(
                        'hide'); // Assuming your form is within a modal
                        formReset();

                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }


            });

        });



        $('#update_form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $('#update_form').attr('action'),
                type: 'POST',
                data: $('#update_form').serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('.dtr-bs-modal').modal('hide');
                        redrawDatatable();
                        $('#update_form').closest('.modal').modal(
                        'hide'); // Assuming your form is within a modal

                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }
            });

        });


        function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }

        // status [warning, success, error]
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }

        $('.multiple-select2').select2();

        function CreateAuditSellectAll() {
            var groupTestIds = $('input[name="audits[]"]:checked');
            if (groupTestIds.length <= 0) {
                makeAlert('error', "{{ __('governance.PleaseSelectOneTestAtLeast') }}", ' Error!');
            } else {
                var groupTestIdsString = '';
                groupTestIds.each(function() {
                    if ($(this).is(':checked')) {
                        groupTestIdsString = $(this).val() + ',' + groupTestIdsString;
                    }
                });
                showModalCreateAudit(groupTestIdsString);
            }
        }


        function showModalCreateAudit(id) {
            $('.dtr-bs-modal').modal('hide');
            Swal.fire({
                title: "{{ __('governance.InitiateAudit') }}",
                text: "{{ __('governance.YouWillConfrimInitiateAudit') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.Confrim') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {

                if (result.value) {
                    CreateAuditTest(id);
                    Swal.fire({
                        icon: "{{ __('locale.Success') }}",
                        title: "{{ __('governance.InitiateAudit') }} ",
                        text: "{{ __('governance.InitiateAuditSuccessfully') }}",
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                }
            });
        }

        // create  Audit for list of tests
        function CreateAuditTest(id) {

            let url = "{{ route('admin.governance.audit.store') }}";

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(data) {
                    //
                }
            });
        }



        // $(document).ready(function() {


        //     'use strict'

        //     // Fetch all the forms we want to apply custom Bootstrap validation styles to
        //     var forms = document.querySelectorAll('form')
        //     // Loop over them and prevent submission
        //     Array.prototype.slice.call(forms)
        //         .forEach(function(form) {
        //             form.addEventListener('submit', function(event) {
        //                 if (!form.checkValidity()) {
        //                     event.preventDefault()
        //                     event.stopPropagation()
        //                 } else if (form.checkValidity() == true) {
        //                     // makeAlert('success', "created successfuly", "{{ __('locale.Success') }}");
        //                     // location.reload();

        //                     // stop form submit only for demo
        //                     // event.preventDefault();
        //                 }

        //                 form.classList.add('was-validated')


        //             }, false)
        //         })
        // });

        // Load subdomains of domain
        $(document).on('change', '.domain_select', function() {
            const subDomains = $(this).find('option:selected').data('families');
            const subDomainSelect = $(this).parents('.family-container').next().find('select');
            subDomainSelect.find('option:not(:first)').remove();
            if (subDomains)
                subDomains.forEach(subDomains => {
                    subDomainSelect.append(
                        `<option value="${subDomains.id}">${subDomains.name}</option>`
                    );
                });
            subDomainSelect.find('option').attr('selected', false);
            subDomainSelect.find('option:first').attr('selected', true);
        });

        $(document).on('change', '.add-control-framework-select', function() {
            const domains = $(this).find('option:selected').data('domains');
            const controls = $(this).find('option:selected').data('controls');
            const domainSelect = $(this).parents('.framework-container').next().find('select');
            const subDomainSelect = $(this).parents('.framework-container').next().next().find('select');
            const parentControlsSelect = $(this).parents('.framework-container').next().next().next().find(
                'select');

            // Add domains
            domainSelect.find('option:not(:first)').remove();
            if (domains)
                domains.forEach(domain => {
                    domainSelect.append(
                        `<option data-families='${JSON.stringify(domain.sub_domains)}' value="${domain.id}">${domain.name}</option>`
                    );
                });
            domainSelect.find('option').attr('selected', false);
            domainSelect.find('option:first').attr('selected', true);
            subDomainSelect.find('option:not(:first)').remove();
            subDomainSelect.find('option:first').attr('selected', true);

            // Add parent controls
            parentControlsSelect.find('option:not(:first)').remove();
            parentControlsSelect.find('option:first').attr('selected', true);
            if (controls)
                controls.forEach(control => {
                    parentControlsSelect.append(
                        `<option value="${control.id}">${control.name}</option>`
                    );
                });

            // Enable domain and sub-domain selects
            $('[name="family"]').prop('disabled', false);
            $('[name="sub_family"]').prop('disabled', false);
        })

        // Load subdomains of domain
        $(document).on('change', '.domain_select_filter', function() {
            const subDomains = $(this).find('option:selected').data('families');
            const subDomainSelect = $(this).parents('.family-container').next().find('select');
            subDomainSelect.find('option:not(:first)').remove();
            subDomainSelect.val('');
            subDomainSelect.trigger('change');
            subDomainSelect.find('option:first').attr('selected', true)
            if (subDomains)
                subDomains.forEach(subDomains => {
                    subDomainSelect.append(
                        `<option value="${subDomains.name}">${subDomains.name}</option>`
                    );
                });
        });

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            //datepicker start

            var $input = $('.js-datepicker').pickadate({
                format: 'yyyy-mm-dd',
                firstDay: 1,
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true,
                editable: true
            });

            var picker = {};


            // $('button').on('click', function(e) {
            //     e.stopPropagation();
            //     picker[$(e.target).data('i')].open();
            // });

            //datepicker end
        });

        $(document).on('change', '[name="parent_id"]', function() {
            if ($(this).val()) {
                $('[name="family"]').val('').trigger('change').prop('disabled', true);
                $('[name="sub_family"]').val('').trigger('change').prop('disabled', true);
            } else {
                $('[name="family"]').prop('disabled', false);
                $('[name="sub_family"]').prop('disabled', false);
            }
        });
    </script>

    <script>
        function DeleteObjective(id) {
            let url = "{{ route('admin.governance.control.ajax.objective.deleteObjective', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        objectives = data.objectives;
                    $('#objectivesList').empty();
                    if (objectives.length) {
                        publishTableWithObjectives(objectives)
                    } else {
                        html = '<h4 style="text-align:center; color:red">No Objectives Yet<h4>'
                        $('#objectivesList').html(html);
                    }
                        $('.dtr-bs-modal').modal('hide');
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }

        // Show delete alert modal
        function ShowModalDeleteObjective(id) {
            $('.dtr-bs-modal').modal('hide');
            Swal.fire({
                title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                text: '@lang('locale.YouWontBeAbleToRevertThis')',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    DeleteObjective(id);
                }
            });
        }

        function DeleteEvidence(id) {
            let url = "{{ route('admin.governance.control.ajax.objective.deleteEvidence', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        evidences = data.evidences;
                    canEditEvidences = data.can_edit_evidences
                    $('#evidencesList').empty();
                    if (evidences.length) {
                        publishTableWithEvidences(evidences, canEditEvidences)
                    } else {
                        html = '<h4 style="text-align:center; color:red">No Evidences Yet<h4>'
                        $('#evidencesList').html(html);
                    }
                        $('.dtr-bs-modal').modal('hide');
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }

        // Show delete alert modal
        function ShowModalDeleteEvidence(id) {
            $('.dtr-bs-modal').modal('hide');
            Swal.fire({
                title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                text: '@lang('locale.YouWontBeAbleToRevertThis')',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    DeleteEvidence(id);
                }
            });
        }
    </script>

    <script src="{{ asset('ajax-files/governance/controls/index.js') }}"></script>

@endsection
