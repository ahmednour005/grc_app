@extends('admin.layouts.contentLayoutMaster')
@section('title', __('survey.Survey'))
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

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />


@endsection

@section('content')

    {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> --}}
    {{-- @endif                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('survey.Survey') }}</h4>
                        </div>
                        <div class="dt-action-buttons text-end">
                            <div class="dt-buttons d-inline-flex">
                                @if (auth()->user()->hasPermission('control.create'))
                                    <button class="dt-button  btn btn-primary  me-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#add_survey">
                                        {{ __('locale.AddNewSurvey') }}
                                    </button>
                                @endif


                            </div>
                        </div> --}}
    {{-- </div> --}}
    <!-- Advanced Search -->
    <section id="advanced-search-datatable">
        <div class="class="card-datatable"">
            <div class="col-12">
                <div class="card">


                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                        </div>
                        @if (auth()->user()->hasPermission('awareness-survey.create'))
                            <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                    <button type="button" class="dt-button  btn btn-primary  me-2 AddQuesBtn"
                                    data-bs-toggle="modal" data-bs-target="#add_survey">
                                    {{ __('survey.AddaNewawarenesssurvey') }}
                                </button>
                                    <a href="{{ route('admin.awarness_survey.notificationsSettingsawareness') }}"
                                        class="dt-button btn btn-primary me-2" target="_self">
                                        {{ __('locale.NotificationsSettings') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!--Search Form -->
                    <div class="card-body mt-2">
                        <form id="searchForm" class="dt_adv_search" method="POST">
                            <div class="row g-1 mb-md-1">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Title') }}:</label>
                                    <input class="form-control dt-input" data-column="1" data-column-index="1"
                                        type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Description') }}:</label>
                                    <input class="form-control dt-input" data-column="2" data-column-index="2"
                                        type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Status') }}:</label>
                                    <select class="form-control dt-input dt-select select2" name="filter_status"
                                        id="team" data-column="3" data-column-index="3">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-datatable table-responsive ">
                    <table class="dt-advanced-server-search table" id="dataTableREfresh">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>

                                <th class="all">{{ __('locale.Title') }}</th>
                                <th class="all">{{ __('locale.Description') }}</th>
                                <th class="all">{{ __('locale.Status') }}</th>
                                <th class="all">{{ __('locale.CreatedDate') }}</th>
                                <th class="all">{{ __('locale.Actions') }}</th>


                            </tr>
                        </thead>
                        {{-- fetch data --}}
                        <tbody>

                            @foreach ($survey as $survey)
                                <tr>
                                </tr>
                                {{-- update survey --}}

                                <div class="modal modal-slide-in sidebar-todo-modal fade"
                                    id="update_survey{{ $survey->id }}">
                                    <div class="modal-dialog sidebar-lg" style="width: 350px;">
                                        <div class="modal-content p-0 " id="update_survey_con{{ $survey->id }}">

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th class="all">{{ __('locale.Title') }}</th>
                                <th class="all">{{ __('locale.Description') }}</th>
                                <th class="all">{{ __('locale.Status') }}</th>
                                <th class="all">{{ __('locale.CreatedDate') }}</th>
                                <th class="all">{{ __('locale.Actions') }}</th>

                            </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
        </div>

        <!-- Add Exam Modal -->
        <div class="modal fade" id="add-security-awareness-exam" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('survey.AddTheSurvey') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <!-- Question repeater -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="add-security-awareness-exam-form"
                                        action="{{ route('admin.awarness_survey.SurveyQuestion.store') }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="survey_id" class="form-control" />

                                        <div class="invoice-repeater">
                                            <div data-repeater-list="questions">
                                                <div data-repeater-item>
                                                    <div class="row d-flex align-items-end">
                                                        <!-- content -->
                                                        <div class="bs-stepper-content shadow-none" multiple="multiple">
                                                            <div class="content" role="tabpanel"
                                                                aria-labelledby="create-app-details-trigger">
                                                                <h5 class="question-number"
                                                                    data-title="{{ __('survey.Question') }}">
                                                                    {{ __('survey.Question') }}
                                                                </h5>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="mb-1">
                                                                            <textarea class="form-control" rows="2" name="question"></textarea>
                                                                            <span
                                                                                class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Question')]) }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>

                                                                </div>

                                                                <div class="mb-1">
                                                                    <label
                                                                        for="answer_type">{{ __('survey.AnswerType') }}</label>
                                                                    <select id="answer-type" name="answer_type"
                                                                        class="form-control answer_type">
                                                                        <option value="1">{{ __('survey.Multiple Choice ( single-select )') }}</option>
                                                                        <option value="2">{{ __('survey.Multiple Choice ( multiple-select )') }}</option>
                                                                    </select>
                                                                    <span
                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Question')]) }}</span>
                                                                </div>


                                                                <h5 class="mt-2 pt-1"
                                                                    data-title="{{ __('survey.Question') }} (question_number) {{ __('survey.options') }} ">
                                                                    {{ __('survey.options') }}
                                                                </h5>
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionA"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionA') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1" style="width: 95%">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionA')]) }}"
                                                                                        name="option_A" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionA')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionB"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionB') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1"
                                                                                    style="width: 95%; cursor: text;">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionB')]) }}"
                                                                                        name="option_B" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionB')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionC"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionC') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1"
                                                                                    style="width: 95%; cursor: text;">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionC')]) }}"
                                                                                        name="option_C" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionC')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionD"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionD') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1"
                                                                                    style="width: 95%; cursor: text;">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionD')]) }}"
                                                                                        name="option_D" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionD')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="list-group-item border-0 px-0">
                                                                        <label for="Q1-OptionE"
                                                                            class="d-flex cursor-pointer">
                                                                            <span
                                                                                class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionE') }}</span>
                                                                            <span
                                                                                class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                <span class="me-1"
                                                                                    style="width: 95%; cursor: text;">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionE')]) }}"
                                                                                        name="option_E" />
                                                                                    <span
                                                                                        class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionE')]) }}</span>
                                                                                </span>

                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                                <span
                                                                    class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Answer')]) }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 col-12 mb-50">
                                                            <div class="mb-1">
                                                                <button class="btn btn-outline-danger text-nowrap px-1"
                                                                    data-repeater-delete type="button">
                                                                    <i data-feather="x" class="me-25"></i>
                                                                    <span>{{ __('locale.Delete') }}</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-icon btn-primary" data-repeater-create
                                                        type="button">
                                                        <i data-feather="plus" class="me-25"></i>
                                                        <span>{{ __('survey.AddQuestion') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Question repeater -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary"
                            data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                        <button type="submit" class="btn btn-primary"
                            form="add-security-awareness-exam-form">{{ __('locale.Add') }}</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- add survey --}}
        <div class="modal modal-slide-in sidebar-todo-modal fade" id="add_survey">
            <div class="modal-dialog sidebar-lg" style="width: 350px;">
                <div class="modal-content p-0">
                    <form id="form-add_control" class="form-add_control todo-modal needs-validation" novalidate
                        method="POST" action="{{ route('admin.awarness_survey.surveyManagement.store') }}">
                        @csrf
                        <div class="modal-header align-items-center mb-1">
                            <h5 class="modal-title">{{ __('survey.AddNewSurvey') }}</h5>
                            <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                        class="font-medium-2"></i></span>
                                <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                            </div>
                        </div>
                        <input type="hidden" name="created_by">
                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                            <div class="action-tags">
                                <div class="mb-1">
                                    <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                    <input type="text" name="name" class=" form-control" placeholder=""
                                        required />
                                    <span class="error error-name "></span>

                                </div>
                                {{-- AdditionalStakeholders --}}
                                <div class="mb-1">
                                    <label class="form-label ">{{ __('locale.AdditionalStakeholders') }}</label>
                                    <select name="additional_stakeholder[]" class="form-select select2"
                                        multiple="multiple">
                                        @foreach ($enabledUsers as $additionalStakeholder)
                                            <option value="{{ $additionalStakeholder->id }}">
                                                {{ $additionalStakeholder->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-additional_stakeholder"></span>
                                </div>
                                {{-- Owner --}}
                                <div class="mb-1">
                                    <label class="form-label ">{{ __('locale.Owner') }}</label>
                                    <select class="select2 form-select" name="owner_id">
                                        <option value="" selected>{{ __('locale.select-option') }}</option>
                                        @foreach ($enabledUsers as $owner)
                                            <option value="{{ $owner->id }}"
                                                data-manager="{{ json_encode($owner->manager) }}">{{ $owner->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error error-owner_id"></span>
                                </div>
                                {{-- Team --}}
                                <div class="mb-1">
                                    <label class="form-label ">{{ __('locale.Team') }}</label>
                                    <select name="team[]" class="form-select select2" multiple="multiple">
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-team"></span>
                                </div>
                                {{-- LastReview --}}
                                {{-- Last Review --}}
                                <div class=" mb-1">
                                    <label class="form-label" for="fp-default">{{ __('locale.LastReview') }}</label>
                                    <input name="last_review_date" class="form-control flatpickr-date-time-compliance"
                                        placeholder="YYYY-MM-DD" />
                                    <span class="error error-last_review_date "></span>
                                </div>
                                <div class="mb-1">
                                    <label for="">{{ __('locale.ReviewFrequency') }}
                                        ({{ __('locale.days') }})</label>
                                    <input type="number" min="0" name="review_frequency" id="review_frequency"
                                        value="0" class="form-control">
                                    <span class="error error-review_frequency"></span>
                                </div>

                                <div class="mb-1">
                                    <label for="">{{ __('locale.NextReviewDate') }}</label>
                                    <input type="text" name="next_review_date" placeholder="YYYY-MM-DD "
                                        id="next_review" class="form-control" readonly>
                                    <span class="error error-next_review_date"></span>
                                </div>
                                {{-- check_status --}}

                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.Status') }}:</label>
                                    <select class="form-control dt-input dt-select2 select2" name="filter_status"
                                        id="team" data-column="3" data-column-index="2"
                                        onchange="changeStatus(this.value)">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-filter_status"></span>
                                </div>




                                {{-- reviwer_Person --}}
                                <div class="mb-1" id="reviewer">
                                    <label class="form-label ">{{ __('locale.Reviewer') }}</label>
                                    <select name="reviewer[]" class="form-select select2" multiple="multiple">
                                        @foreach ($enabledUsers as $additionalStakeholder)
                                            <option value="{{ $additionalStakeholder->id }}">
                                                {{ $additionalStakeholder->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-reviewer"></span>
                                </div>

                                {{-- Approval Date --}}
                                <div class="mb-1" id="approval_date_update">
                                    <label for="">{{ __('locale.ApprovalDate') }}</label>
                                    <input type="text" data-i="0" name="approval_date" placeholder="YYYY-MM-DD "
                                        class="form-control flatpickr-date-time-compliance" placeholder="YYYY-MM-DD" />
                                    <span class="error error-approval_date"></span>
                                </div>
                                {{-- privacy --}}
                                <div class="mb-1" id="privacy">
                                    <label for="">{{ __('locale.Privacy') }}</label>
                                    <div class="parent_documents_container">
                                        <select name="privacy" class="form-select select2 ">
                                            <option value="" disabled>{{ __('locale.select-option') }}</option>
                                            @foreach ($privacies as $priv)
                                                <option value="{{ $priv->id }}">{{ $priv->title }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-privacy"></span>
                                    </div>
                                </div>

                                {{-- description --}}

                                <div class="mb-1">
                                    <label for="">{{ __('locale.Description') }}</label>
                                    <textarea class="form-control" name="description"></textarea>
                                    <span class="error error-description  "></span>

                                </div>
                            </div>

                            <div class="mb-1">
                                <label for="all_questions_mandatory">{{ __('survey.all_questions_mandatory') }}</label>
                                <input type="checkbox" id="all_questions_mandatory" checked
                                    name="all_questions_mandatory">
                                    <span class="error error-all_questions_mandatory  "></span>

                            </div>

                            <div class="question_logic d-none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="percentage_checkbox">{{ __('survey.percentage') }}</label>
                                        <input type="checkbox" id="percentage_checkbox" value="1" class="checkbox"
                                            name="answer_percentage">
                                            <span class="error error-answer_percentage  "></span>

                                    </div>
                                    <div class="col-md-5 d-none percentage_number_div">

                                        <input type="number" class="form-control d-block" name="percentage_number"
                                            placeholder="Percentage Number">
                                            <span class="error error-percentage_number  "></span>

                                    </div>


                                </div>

                                {{-- <div class="row">

                                    <div class="col-md-6">
                                        <label for="specific_questions">{{ __('locale.specific_questions') }}</label>
                                        <input type="checkbox" id="specific_questions" value="1" class="checkbox"
                                            name="specific_mandatory_questions">
                                    </div>
                                    <div class="col-md-12 specific_question_div d-none">
                                        <select name="questions[]" id="questions" class="form-select select2 "multiple="multiple">
                                            <option value="" disabled>{{ __('locale.select-option') }}</option>
                                            @foreach ($questions as $question)
                                                <option value="{{ $question->id }}">{{ $question->question }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div> --}}

                            </div>

                        </div>

                        <div class="footer mt-2">
                            <button class="btn btn-primary btn-sm" style="margin-left: 10px;"
                                type="submit">{{ __('locale.Save') }}</button>
                        </div>
                </div>

                </form>
            </div>
        </div>
        </div>

    </section>
@endsection
@section('vendor-script')

    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>ad
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
    <script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            @foreach ($enabledUsers as $additionalStakeholder)
                @if ($additionalStakeholder->id != auth()->user()->id)
                    $('#row-{{ $additionalStakeholder->id }}')
                        .remove(); // Assuming you have a unique identifier for each row
                @endif
            @endforeach
        });
    </script>

    {{--  to get survey id to question modal  --}}
    <script>
        function OpenAddQuestionsForm(surveyId) {
            $('[name="survey_id"]').val(surveyId);
            $('#add-security-awareness-exam').modal('show');
        }
    </script>
    {{-- fetch data --}}
    <script>
        function getRecord(id) {
            var url = "{{ route('admin.awarness_survey.editmodal', '') }}" + "/" + id;
            $.ajax({
                url: url,
                success: function(data) {
                    if (data.success == true) {
                        // Update the modal ID selector to use the correct ID
                        $('#update_survey' + id).modal('toggle');
                        $('#update_survey' + id).modal('show');
                        $('#update_survey_con' + id).html(data.html);
                    }
                }
            });
        }
    </script>
    {{-- reset form --}}
    <script>
        let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
        let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
        let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
        let swal_success = "{{ __('locale.Success') }}";
        let swal_error = "{{ __('locale.Error') }}";


        $('.select2').select2();

        function resetForm() {
            $('#add_questionnaire form').trigger('reset');
            $('.select2').trigger('change');
        }

        $('#add_questionnaire').on('hidden.bs.modal', function() {
            resetForm();
        });
        $('#all_questions_mandatory').on('change', function() {
            if (!$(this).is(':checked')) {
                $('.question_logic').removeClass('d-none');
            } else {
                $('.question_logic').addClass('d-none');
                $('.question_logic').find('input:checkbox').prop('checked', false);
                $('.question_logic').find('input[name="percentage_number"]').val('');
                $('#questions option:selected').prop('selected', false).trigger('change');
                $('.specific_question_div , .percentage_number_div').addClass('d-none');
            }
        });


        $('#specific_questions').on('change', function() {
            if ($(this).is(":checked")) {
                $('.specific_question_div').removeClass('d-none');
                $('#percentage_checkbox').prop('checked', false).trigger('change')

            } else {
                $('.specific_question_div').addClass('d-none');
                $('#questions option:selected').prop('selected', false).trigger('change');
                if ($('#percentage_checkbox:checked').length == 0) {
                    $('#all_questions_mandatory').prop('checked', true).trigger('change');
                }
            }
        });

        $('#percentage_checkbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('.percentage_number_div').removeClass('d-none');
                $('#specific_questions').prop('checked', false).trigger('change');

            } else {

                $('input[name="percentage_number"]').val('');
                $('.percentage_number_div').addClass('d-none');
                if ($('#specific_questions:checked').length == 0) {
                    $('#all_questions_mandatory').prop('checked', true).trigger('change');
                }
            }
        });

        $('#assessment_id').on('change', function() {
            $('#questions').empty();
            let questions = $(this).find('option:selected').data('questions');
            var options = '';
            $.each(questions, function(key, val) {
                options += '<option value="' + val.id + '">' + val.question + '</option>';
            });
            $('#questions').append(options);
        });


        function formReset() {
            $('.modal form').trigger('reset');
            $('.modal form select').trigger('change');
            $('#question').addClass('d-none')

        }

        $('.modal').on('hidden.bs.modal', function() {
            $('.question_logic').addClass('d-none');
            $('.is-invalid').removeClass('is-invalid');
            $('#question').addClass('d-none');
            $('.update_questionnaire_modal').removeClass('update_questionnaire_modal');
        });

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }
        var update_url;
    </script>
    {{-- delete row --}}
    <script>
        function deletesurvey(id) {
            var id = id;

            Swal.fire({
                title: swal_title,
                text: swal_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: swal_confirmButtonText,
                cancelButtonText: swal_cancelButtonText,
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.awarness_survey.awarness-survey.surveyDelete', '') }}" +
                            "/" + id,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status) {
                                makeAlert('success', '@lang('survey.Survey Deleted successfully')', 'Success');
                                var oTable = $('#dataTableREfresh').DataTable();
                                oTable.ajax.reload();
                            } else {
                                makeAlert('success', '@lang('survey.An error occurred while deleting the survey it has questions and answers')', 'Success');
                            }
                        },
                        error: function() {
                            makeAlert('success', '@lang('survey.Survey Deleted successfully')', 'Success');
                            var oTable = $('#dataTableREfresh').DataTable();
                            oTable.ajax.reload();
                        }
                    })
                }
            });
        }

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    </script>
    <script>
        {{-- send email to contacts --}}

        function sendMail(id) {

            var id = id;
            Swal.fire({
                title: "{{ __('assessment.Are You Sure You Want Send Email ?') }}",
                text: swal_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.Yes') }}",
                cancelButtonText: swal_cancelButtonText,
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.awarness_survey.awarness-survey.sendMail', '') }}" + "/" +
                            id,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            makeAlert('success', '@lang('survey.Survey Send Successfully')', 'Success');

                        },

                        error: function(response) {
                            makeAlert('error', response.responseText, 'Error')
                        }
                    })
                }
            });


        }

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    </script>


    {{-- to select multichoice --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    {{-- change the next date review  --}}
    <script>
        /* Start change dates event */
        $("[name='last_review_date']").change(function() {
            const that = this;
            var last_review = $(this).val();
            var days = $(this).parent().parent().find("[name='review_frequency']").val();

            if (days != 0) {
                var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last_review;

                $.ajax({
                    url: url,
                    success: function(response) {
                        $(that).parent().parent().find("[name='next_review_date']").val(response);
                    }
                });

            } else {
                $(that).parent().parent().find("[name='next_review_date']").val(last_review);

            }
        });

        $("[name='review_frequency']").change(function() {
            const that = this;
            var days = $(this).val();
            var last = $(this).parent().parent().find("[name='last_review_date']").val();
            var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last;

            $.ajax({
                url: url,
                success: function(response) {
                    $(that).parent().parent().find("[name='next_review_date']").val(response);

                }
            });
        });

        $("[name='review_frequency']").trigger('change');
        /* End change dates event */
    </script>
    {{-- lbarary of date time --}}
    <script>
        dateTimePickr = $('.flatpickr-date-time-compliance');
        // Date & TIme
        if (dateTimePickr.length) {
            dateTimePickr.flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
            });
        }
    </script>
    {{-- to use the repeater form --}}
    <script>
        $(function() {
            'use strict';

            // form repeater jquery
            $('.invoice-repeater, .repeater-default').repeater({
                show: function() {
                    $(this).slideDown();
                    // Feather Icons
                    if (feather) {
                        feather.replace({
                            width: 14,
                            height: 14
                        });
                    }
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                }
            });
        });
    </script>
    {{-- to hide or view the input in model of survey  --}}
    <script>
        $('#approval_date_update').val('').hide();
        $('#privacy').val('').hide();
        $('#reviewer').val('').hide();

        function changeStatus(status) {
            if (status == 2) {
                $('#approval_date_update').val('').hide();
                $('#privacy').val('').hide();
                $('#reviewer').show();
            } else if (status == 3) {

                $('#approval_date_update').show();
                $('#privacy').show();
                $('#reviewer').val('').hide();

            } else {
                $('#approval_date_update').val('').hide();
                $('#privacy').val('').hide();
                $('#reviewer').val('').hide();
            }
        }
    </script>
    {{-- submit of question survey --}}

    <script>
        $('#add-security-awareness-exam-form').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');

            $.ajax({
                type: "post",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.is-invalid').removeClass('is-invalid');
                },
                success: function(response) {
                    window.location.reload(true);
                    formReset();
                    $('.modal').modal('hide');
                    makeAlert('success', '@lang('survey.Questions of survey added successfully')', 'Success');
                    // Reload the page after successful insert

                },
                error: function(xhr) {
                    $.each(xhr.responseJSON.errors, function(key, val) {
                        switch (key) {
                            case "contacts":
                                key = 'contacts[]'
                                break;
                            case "questions":
                                key = 'questions[]'
                                break;
                        }

                        makeAlert('error', val);
                        let input = $('input[name="' + key + '"] , textarea[name="' + key +
                            '"] , select[name="' + key + '"]')
                        input.addClass('is-invalid');
                    })
                }
            })
        });

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false
            });
        };
    </script>
    <script>
        {{-- send link to contacts --}}

        function sendoutside(id) {
            var link = "{{ route('admin.awarness_survey.Examoutside', '') }}" + "/" + id;

            Swal.fire({
                title: "{{ __('survey.Are You Sure To Send Survey Outside cyberMode ?') }}",
                 icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.Yes') }}",
                cancelButtonText: swal_cancelButtonText,
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    // Create a temporary input element
                    var tempInput = document.createElement("input");
                    // Set the value of the input element to the link
                    tempInput.value = link;
                    // Append the input element to the document
                    document.body.appendChild(tempInput);
                    // Select the text inside the input element
                    tempInput.select();
                    tempInput.setSelectionRange(0, 99999); // For mobile devices
                    // Execute the copy command
                    document.execCommand("copy");
                    // Remove the temporary input element from the document
                    document.body.removeChild(tempInput);
                    // Show success message
                    makeAlert('success', '@lang('survey.Link copied successfully')', 'Success');
                } else {
                    // Show error message
                    makeAlert('error', 'Failed to copy link to clipboard', 'Error');
                }
            });
        }

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    </script>

    {{-- submit of survey --}}
    <script>
        $('#add_survey form').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');

            $.ajax({
                type: "post",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.is-invalid').removeClass('is-invalid');
                },
                success: function(response) {
                    formReset();
                    $('.modal').modal('hide');
                    makeAlert('success', 'Survey added successfully', 'Success');
                    location.reload(); // Reload the page immediately
                },
                error: function(xhr) {
                    $.each(xhr.responseJSON.errors, function(key, val) {
                        switch (key) {
                            case "contacts":
                                key = 'contacts[]'
                                break;
                            case "questions":
                                key = 'questions[]'
                                break;
                        }

                        makeAlert('error', val);
                        let input = $('input[name="' + key + '"] , textarea[name="' + key +
                            '"] , select[name="' + key + '"]')
                        input.addClass('is-invalid');
                    })
                }
            })
        });

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false
            });
        };
    </script>
    {{-- filter data --}}
    <script>
        function filterColumn(i, val) {

            $('.dt-advanced-search').DataTable().column(i).search(val, false, true).draw();

        }

        function createDatatable(JsonList) {

            var isRtl = $('html').attr('data-textdirection') === 'rtl';

            var dt_ajax_table = $('.datatables-ajax'),
                dt_filter_table = $('.dt-column-search'),
                dt_adv_filter_table = $('.dt-advanced-search'),
                dt_responsive_table = $('.dt-responsive'),
                assetPath = '../../../app-assets/';

            if ($('body').attr('data-framework') === 'laravel') {
                assetPath = $('body').attr('data-asset-path');
            }

            // filter function after input keyup
            $('input.dt-input').on('keyup', function() {
                filterColumn($(this).attr('data-column'), $(this).val());
            });

            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass('form-control-sm');
        }
    </script>

    {{-- fetch data yajra --}}
    <script type="text/javascript">
        $(function() {

            var table = $('#dataTableREfresh').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('admin.awarness_survey.GetDataSurvey', ':id') }}",
                language: {
                "sProcessing": "{{ __('locale.Processing') }}",
                "sSearch": "{{ __('locale.Search') }}",
                "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                "sInfo": "{{ __('locale.info') }}",
                "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
                "sInfoPostFix": "",
                "sSearchPlaceholder": "",
                "sZeroRecords": "{{ __('locale.emptyTable') }}",
                "sEmptyTable": "{{ __('locale.NoDataAvailable') }}",
                "oPaginate": {
                    "sFirst": "",
                    "sPrevious": "{{ __('locale.Previous') }}",
                    "sNext": "{{ __('locale.NextStep') }}",
                    "sLast": ""
                },
                "oAria": {
                    "sSortAscending": "{{ __('locale.sortAscending') }}",
                    "sSortDescending": "{{ __('locale.sortDescending') }}"
                }
            },
                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            return '<span class="badge rounded-pill badge-light-primary">' + data +
                                '</span>';
                        }
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'filter_status',
                        name: 'filter_status',
                        render: function(data, type, row) {
                            // Replace the number with the corresponding word
                            if (row.filter_status === 1) {
                                return '<span class="badge rounded-pill badge-light-danger">{{ __('locale.Draft') }}</span>';
                            } else if (row.filter_status === 2) {
                                return '<span class="badge rounded-pill badge-light-warning">{{ __('locale.InReview') }}</span>';
                            } else if (row.filter_status === 3 && row.privacy === 1) {
                                return '<span class="badge rounded-pill badge-light-success">{{ __('locale.Approved') }}  {{ __('locale.(Private)') }}</span>';
                            } else if (row.filter_status === 3 && row.privacy === 2) {
                                return '<span class="badge rounded-pill badge-light-success">{{ __('locale.Approved') }}  {{ __('locale.(Public)') }}</span>';
                            }
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            var date = new Date(data);
                            var formattedDate = date.toISOString().replace('T', ' ').substring(0,
                                16);
                            return formattedDate;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            var authenticatedUserId = <?php echo auth()->user()->id; ?>;
                            var additionalStakeholders = row.additional_stakeholder ? row
                                .additional_stakeholder.split(',') : [];
                            var team = row.team ? row.team.split(',') : [];
                            var userRoleId = {{ auth()->user()->role_id }};


                            if (row.privacy == 2 && row.owner_id == authenticatedUserId) {
                                return `
                                <div class="d-inline-flex">
                    <a class="pe-1 dropdown-toggle hide-arrow text-primary " data-bs-toggle="dropdown" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
                    </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1453px, -1324px);" data-popper-placement="top-end" data-popper-reference-hidden="">
                    <a href="javascript:;" class="item-edit dropdown-item " onclick="getRecord(${row.id})" data-id="${row.id}" data-bs-target="#edit_survey${row.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>{{ __('locale.Edit') }}
                    </a>
                    <a href="javascript:;" onclick="sendMail(${row.id})" data-bs-target="#edit_survey${row.id}" class=" dropdown-item ">
                        <svg style ="margin-right: 5px;"xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                    <path d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480V396.4c0-4 1.5-7.8 4.2-10.7L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4"/>
                    </svg>{{ __('survey.SendMail') }}</a>
                    <a href="javascript:;" onclick="sendoutside(${row.id})"   data-bs-target="#edit_survey${row.id}" class=" dropdown-item ">
                        <svg style ="margin-right: 5px;"xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                    <path d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480V396.4c0-4 1.5-7.8 4.2-10.7L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4"/>
                    </svg>{{ __('survey.GenerateLink') }}</a>
                    <a href="javascript:;" onclick="OpenAddQuestionsForm(${row.id})" class=" dropdown-item btn-flat-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list me-50 font-small-4"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>{{ __('survey.AddQuestion') }}</a>
                    <a href="{{ url('admin/awarness-survey/Question') }}/${row.id}" class="dropdown-item  btn-flat-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-merge font-small-4"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M6 21V9a9 9 0 0 0 9 9"></path>
                    </svg>{{ __('survey.ViewQuestions') }}</a>
                    <a href="javascript:;" onclick="deletesurvey(${row.id})" data-toggle="tooltip" data-original-title="Delete" class="dropdown-item  btn-flat-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-50 font-small-4"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>{{ __('locale.Delete') }}</a>
                    </div>
                    </div>
    `;
                            } else if (row.owner_id == authenticatedUserId) {
                                return `
            <div class="d-inline-flex">
            <a class="pe-1 dropdown-toggle hide-arrow text-primary " data-bs-toggle="dropdown" aria-expanded="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
            </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1453px, -1324px);" data-popper-placement="top-end" data-popper-reference-hidden="">
            <a href="javascript:;" class="item-edit dropdown-item " onclick="getRecord(${row.id})" data-id="${row.id}" data-bs-target="#edit_survey${row.id}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>{{ __('locale.Edit') }}
            </a>

            <a href="javascript:;" onclick="OpenAddQuestionsForm(${row.id})" class=" dropdown-item btn-flat-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list me-50 font-small-4"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>{{ __('survey.AddQuestion') }}</a>
            <a href="{{ url('admin/awarness-survey/Question') }}/${row.id}" class="dropdown-item  btn-flat-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-merge font-small-4"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M6 21V9a9 9 0 0 0 9 9"></path>
            </svg>{{ __('survey.ViewQuestions') }}</a>
            <a href="javascript:;" onclick="deletesurvey(${row.id})" data-toggle="tooltip" data-original-title="Delete" class="dropdown-item  btn-flat-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-50 font-small-4"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>{{ __('locale.Delete') }}</a>
            </div>
            </div>
    `;
                            } else if (row.reviewer && row.reviewer.split(',').includes(
                                    authenticatedUserId.toString())) {
                                return `
            <div class="d-inline-flex">
            <a class="pe-1 dropdown-toggle hide-arrow text-primary " data-bs-toggle="dropdown" aria-expanded="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
            </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1453px, -1324px);" data-popper-placement="top-end" data-popper-reference-hidden="">
            <a href="javascript:;" class="item-edit dropdown-item " onclick="getRecord(${row.id})" data-id="${row.id}"  data-bs-target="#edit_survey${row.id}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>{{ __('locale.Edit') }}
            </a>
            <a href="{{ url('admin/awarness-survey/Question') }}/${row.id}" class="dropdown-item  btn-flat-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-merge font-small-4"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M6 21V9a9 9 0 0 0 9 9"></path>
            </svg>{{ __('survey.ViewQuestions') }}</a>
            </div>
            </div>
    `;
                            } else if (row.reviewer && row.additional_stakeholder &&
                                row.reviewer.split(',').includes(authenticatedUserId.toString()) &&
                                row.additional_stakeholder.split(',').includes(authenticatedUserId
                                    .toString())) {
                                return `
            <div class="d-inline-flex">
            <a class="pe-1 dropdown-toggle hide-arrow text-primary " data-bs-toggle="dropdown" aria-expanded="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
            </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1453px, -1324px);" data-popper-placement="top-end" data-popper-reference-hidden="">
            <a href="javascript:;" class="item-edit dropdown-item " onclick="getRecord(${row.id})" data-id="${row.id}" data-bs-target="#edit_survey${row.id}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>{{ __('locale.Edit') }}
            </a>
            <a href="{{ url('admin/awarness-survey/Question') }}/${row.id}" class="dropdown-item  btn-flat-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-merge font-small-4"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M6 21V9a9 9 0 0 0 9 9"></path>
            </svg>{{ __('survey.ViewQuestions') }}</a>
            </div>
            </div>
    `;
                            } else if (row.additional_stakeholder && row.additional_stakeholder
                                .split(',').includes(authenticatedUserId.toString())) {
                                return `
            <div class="d-inline-flex">
            <a class="pe-1 dropdown-toggle hide-arrow text-primary " data-bs-toggle="dropdown" aria-expanded="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
            </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1453px, -1324px);" data-popper-placement="top-end" data-popper-reference-hidden="">
            <a href="javascript:;" class=" dropdown-item " onclick="getRecord(${row.id})" data-id="${row.id}" data-bs-target="#edit_survey${row.id}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>{{ __('locale.View') }}
            </a>
            </div>
            </div>
    `;
                            } else if (row.team && row.team.split(',') && userRoleId === 2) {
                                return `
                                @if (auth()->user()->hasPermission('awareness-survey.list'))
                    <div class="d-inline-flex">
                    <a class="pe-1 dropdown-toggle hide-arrow text-primary " data-bs-toggle="dropdown" aria-expanded="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
                    </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1453px, -1324px);" data-popper-placement="top-end" data-popper-reference-hidden="">
                    <a href="{{ url('admin/awarness-survey/GetExam') }}/${row.id}" class="dropdown-item  btn-flat-success" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50 font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>{{ __('survey.SurveyQ') }}
                    </a>
                    <a onclick="getRecord(${row.id})" data-id="${row.id}"data-bs-target="#edit_survey${row.id}" class="dropdown-item" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-merge font-small-4"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M6 21V9a9 9 0 0 0 9 9"></path>
                    </svg>{{ __('locale.Details') }}</a>
                    </div>
                    </div>
                                 @endif
        `;
                            } else {
                                return `<i style="color: #0097a7;font-size: 15px;margin-right: 16px;"class="fas fa-lock"></i>
`;
                            }
                        }
                    },
                ],
                drawCallback: function() {
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    api.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = startIndex + i + 1;
                    });
                }
            });
            // search box
            $('.dt-input').on('keyup', function() {
                table
                    .columns($(this).data('column'))
                    .search(this.value)
                    .draw();
            });
            // filter by status
            $('.dt-select').on('change', function() {
                var value = $(this).val();
                table
                    .columns($(this).data('column'))
                    .search(value ? '^' + value + '$' : '', true, false)
                    .draw();
            });
        });
    </script>
@endsection
