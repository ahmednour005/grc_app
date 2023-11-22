@extends('admin/layouts/contentLayoutMaster')

@section('title', __('assessment.Assessments'))
@section('vendor-style')
    <!-- vendor css files -->

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-todo.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
@endsection


@section('page-style')
    <!-- Page css files -->

    <style>
        html .navbar-floating.footer-static .app-content .content-area-wrapper,
        html .navbar-floating.footer-static .app-content .kanban-wrapper {
            height: auto !important;
        }

        #view_type_sorting {
            font-family: "FontAwesome";
            font-size: 14px;
        }

        #view_type_sorting::before {
            vertical-align: middle;
        }

        .tab button:hover {
            background-color: #bee9f7;
        }

        .tab button.active {
            background-color: #6398a8;
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

        .gov_check {
            padding: 0.786rem 0.7rem;
            line-height: 1;
            font-weight: 500;
            font-size: 1.2rem;
        }

        .gov_err {

            color: red;
        }

        .frame .card-title {
            display: inline-block;
            color: #000;
            font-size: 1rem !important;
        }

        .frame .card-desc {
            display: inline-block;
            color: #6e6c6c;
        }

        .card-body .btn {
            margin-right: 5px;

        }

        .card-body form {
            margin-bottom: 0;

        }

        .todo-application .content-area-wrapper .content-right .todo-task-list-wrapper .todo-task-list li:not(:first-child) {
            border-top: 0 !important;
        }

        .todo-application .content-area-wrapper .content-right .todo-task-list-wrapper .todo-task-list .pagination li {
            padding: 0;
        }

        .card2 {
            padding: 0.893rem 2rem;
            margin-top: 25px;
        }

        .tab button {
            margin: 0;
        }

        .form-select {
            display: inline-block;
        }

        .dataTables_filter {
            float: right !important;
        }

        .dataTables_filter input {
            display: inline-block !important;
            width: auto !important;
        }

        .multiple-select2 {
            z-index: 99999999;
        }

        #privacy2 {
            display: none
        }

        #approval_date2 {
            display: none
        }

        #reviewer {
            display: none
        }
    </style>
@endsection
@section('content-sidebar')

    <div class="sidebar-content todo-sidebar">
        <div class="todo-app-menu pt-2">

            <div id="paginated_data">
                @include('admin.content.assessment.paginated_data')
            </div>

        </div>
    </div>
    {{-- assessments modals --}}
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-assessment-modal">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <form id="add_assessment" class="add_assessment todo-modal needs-validation" novalidate method="POST"
                    action="{{ route('admin.assessment.store') }}">
                    @csrf

                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('assessment.AddNewTemplate') }}</h5>
                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                            <span class="todo-item-favorite cursor-pointer me-75">
                                <i data-feather="star" class="font-medium-2"></i>
                            </span>
                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                <input type="text" name="name" class=" form-control" placeholder="Name" required />
                                <span class="error error-name"></span>
                            </div>
                        </div>
                        <div class="my-1">
                            <button type="submit" class="btn btn-primary add-todo-item me-1">
                                {{ __('locale.Add') }}
                            </button>
                            <button type="button" class="btn btn-outline-secondary add-todo-item" data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit-assessment-modal">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <form id="edit_assessment" class="edit_assessment todo-modal needs-validation" novalidate method="POST"
                    action="">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('locale.UpdateAssessment') }}</h5>
                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                            <span class="todo-item-favorite cursor-pointer me-75">
                                <i data-feather="star" class="font-medium-2"></i>
                            </span>
                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                <input type="text" name="name" class=" form-control" placeholder="Name" required />
                                <span class="error error-name"></span>
                            </div>
                        </div>
                        <div class="my-1">
                            <button type="submit" class="btn btn-primary   add-todo-item me-1">
                                {{ __('locale.Update') }}
                            </button>
                            <button type="button" class="btn btn-outline-secondary add-todo-item "
                                data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- qeustions modals --}}
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-question-modal">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <form id="add_questions" class="add_questions todo-modal needs-validation" novalidate method="POST"
                    action="{{ route('admin.questions.store') }}">
                    @csrf

                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('locale.AddNewQuestion') }}</h5>
                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                            <span class="todo-item-favorite cursor-pointer me-75">
                                <i data-feather="star" class="font-medium-2"></i>
                            </span>
                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">
                            <div class="mb-1">
                                <label for="question" class="form-label">{{ __('locale.Question') }}</label>
                                <div {{-- id="question" --}} class="border-bottom-0 question"></div>
                                <div class="d-flex justify-content-end question-toolbar border-top-0">
                                    <span class="ql-formats me-0">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        {{--                                        <button class="ql-align"></button> --}}
                                        <button class="ql-link"></button>
                                    </span>
                                </div>
                                <span class="error error-question"></span>
                            </div>
                            <div class="mb-1 controls" {{-- id="controls" --}}>
                                <label for="controls">{{ __('locale.Controls') }}</label>
                                <select name="control_id" class="form-control select2 controls">
                                    <option value="">{{ __('locale.Choose') }}</option>
                                    @foreach ($controls as $control)
                                        <option value="{{ $control->id }}">{{ $control->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mb-1">
                                <label for="answer_type">{{ __('assessment.AnswerType') }}</label>
                                <select name="answer_type" {{-- id="answer_type" --}} class="form-control select2 answer_type">
                                    <option value="1">{{ __('assessment.Multiple Choice ( single-select )') }}
                                    </option>
                                    <option value="2">{{ __('assessment.Multiple Choice ( multiple-select )') }}
                                    </option>
                                    <option value="3">{{ __('assessment.FillInTheBlank') }}</option>
                                </select>
                            </div>

                            <div class="options">
                                <div class="mb-1 file_attachment ">
                                    <label data-toggle="tooltip" title="Enable file uploads for this question."
                                        for="file_attachment">{{ __('assessment.FileAttachment') }}
                                    </label>
                                    <input type="checkbox" id="file_attachment" name="file_attachment" value="1">
                                </div>
                                <div class="mb-1 question_logic">
                                    <label data-toggle="tooltip"
                                        title="Enable ability to ask another question
                                            based on the answer to this question."
                                        for="QuestionLogic">{{ __('assessment.QuestionLogic') }}
                                    </label>
                                    <input type="checkbox" id="QuestionLogic" name="question_logic" value="1">
                                </div>
                                <div class="mb-1 risk_assessment">
                                    <label data-toggle="tooltip"
                                        title=" Enable creation of risks based on the answer to this question."
                                        for="RiskAssessment">{{ __('assessment.RiskAssessment') }}
                                    </label>
                                    <input type="checkbox" id="RiskAssessment" name="risk_assessment" value="1">
                                </div>
                                <div class="mb-1 compliance_assessment">
                                    <label data-toggle="tooltip"
                                        title="Enable tracking of the pass/fail status
                                     against the mapped controls."
                                        for="ComplianceAssessment">{{ __('assessment.ComplianceAssessment') }}
                                    </label>
                                    <input type="checkbox" id="ComplianceAssessment" name="compliance_assessment"
                                        value="1">
                                </div>
                                <div class="mb-1 maturity_assessment">
                                    <label data-toggle="tooltip"
                                        title="Enable tracking of the current control maturity level
                                            against our desired maturity level."
                                        for="MaturityAssessment">{{ __('assessment.MaturityAssessment') }}
                                    </label>
                                    <input type="checkbox" id="MaturityAssessment" name="maturity_assessment"
                                        value="1">
                                </div>
                            </div>
                        </div>
                        <div class="my-1">
                            <button type="submit" class="btn btn-primary add-todo-item me-1">
                                {{ __('locale.Add') }}
                            </button>
                            <button type="button" class="btn btn-outline-secondary add-todo-item "
                                data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit-question-modal">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <form id="edit_question_form" class="edit_question_form todo-modal needs-validation" novalidate
                    method="POST" action="{{ route('admin.questions.update', ':id') }}">
                    @csrf
                    @method('put')
                    <input type="hidden" name="question_id">
                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('locale.UpdateQuestion') }}</h5>
                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                            <span class="todo-item-favorite cursor-pointer me-75">
                                <i data-feather="star" class="font-medium-2"></i>
                            </span>
                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">
                            <div class="mb-1">
                                <label for="edit_question" class="form-label">{{ __('locale.Question') }}</label>
                                <div {{-- id="edit_question" --}} class="border-bottom-0 edit_question"></div>
                                <div class="d-flex justify-content-end edit_question-toolbar border-top-0">
                                    <span class="ql-formats me-0">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        {{--                                        <button class="ql-align"></button> --}}
                                        <button class="ql-link"></button>
                                    </span>
                                </div>
                                <span class="error error-question"></span>
                            </div>
                            <div class="mb-1 controls" {{-- id="controls" --}}>
                                <label for="controls">{{ __('locale.Controls') }}</label>
                                <select name="control_id" class="form-control select2 controls">
                                    <option value="">{{ __('locale.Choose') }}</option>
                                    @foreach ($controls as $control)
                                        <option value="{{ $control->id }}">{{ $control->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mb-1">
                                <label for="answer_type">{{ __('assessment.AnswerType') }}</label>
                                <select name="answer_type" id="answer_type" class="form-control select2 answer_type">
                                    <option value="1">{{ __('assessment.Multiple Choice ( single-select )') }}
                                    </option>
                                    <option value="2">{{ __('assessment.Multiple Choice ( multiple-select )') }}
                                    </option>
                                    <option value="3">{{ __('assessment.FillInTheBlank') }}</option>
                                </select>
                            </div>

                            <div class="options">
                                <div class="mb-1 file_attachment ">
                                    <label data-toggle="tooltip" title="Enable file uploads for this question."
                                        for="edit_file_attachment">{{ __('assessment.FileAttachment') }}
                                    </label>
                                    <input type="checkbox" id="edit_file_attachment" name="file_attachment"
                                        value="1">
                                </div>
                                <div class="mb-1 question_logic">
                                    <label data-toggle="tooltip"
                                        title="Enable ability to ask another question based
                                            on the answer to this question."
                                        for="edit_QuestionLogic">{{ __('assessment.QuestionLogic') }}
                                    </label>
                                    <input type="checkbox" id="edit_QuestionLogic" name="question_logic" value="1">
                                </div>
                                <div class="mb-1 risk_assessment">
                                    <label data-toggle="tooltip"
                                        title=" Enable creation of risks based on
                                     the answer to this question."
                                        for="edit_RiskAssessment">{{ __('assessment.RiskAssessment') }}
                                    </label>
                                    <input type="checkbox" id="edit_RiskAssessment" name="risk_assessment"
                                        value="1">
                                </div>
                                <div class="mb-1 compliance_assessment">
                                    <label data-toggle="tooltip"
                                        title="Enable tracking of the pass/fail status against the mapped controls."
                                        for="edit_ComplianceAssessment">{{ __('assessment.ComplianceAssessment') }}
                                    </label>
                                    <input type="checkbox" id="edit_ComplianceAssessment" name="compliance_assessment"
                                        value="1">
                                </div>
                                <div class="mb-1 maturity_assessment">
                                    <label data-toggle="tooltip"
                                        title="Enable tracking of the
                                     current control maturity level
                                     against our desired maturity level."
                                        for="edit_MaturityAssessment">{{ __('assessment.MaturityAssessment') }}
                                    </label>
                                    <input type="checkbox" id="edit_MaturityAssessment" name="maturity_assessment"
                                        value="1">
                                </div>
                            </div>
                        </div>
                        <div class="my-1">
                            <button type="submit" class="btn btn-primary   add-todo-item me-1">
                                {{ __('locale.Update') }}
                            </button>
                            <button type="button" class="btn btn-outline-secondary add-todo-item "
                                data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- import questions --}}
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="import-questions-modal">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <form id="import_questions" class="import_questions todo-modal needs-validation" novalidate
                    method="POST" action="{{ route('admin.questions.importQuestions') }}">
                    @csrf

                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('assessment.QuestionsBank') }}</h5>
                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                            <span class="todo-item-favorite cursor-pointer me-75">
                                <i data-feather="star" class="font-medium-2"></i>
                            </span>
                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">
                            <div class="mb-1">
                                <label for="assessment_id" class="form-label">{{ __('locale.Assessment') }}</label>
                                <select name="assessment_id" id="assessment_id" class="form-control select2">
                                    <option value="">---</option>
                                    @foreach ($all_assessments as $assessment)
                                        <option value="{{ $assessment->id }}">{{ $assessment->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-name"></span>
                            </div>

                            <div class="mb-1">
                                {{--  data-assessment_id="{{ @$question->assessments->first()->id }}"  --}}
                                <div class="mb-2">
                                    <button type="button"
                                        class="btn btn-primary btn-sm select-all-btn">{{ __('locale.SelectAll') }}</button>
                                    <button type="button"
                                        class="btn btn-primary btn-sm unselect-all-btn">{{ __('locale.UnSelectAll') }}</button>
                                </div>
                                <label for="assessments_questions"
                                    class="form-label">{{ __('locale.Questions') }}</label>
                                <select name="question_ids[]" id="assessments_questions" class="form-control select2"
                                    multiple>
                                    @foreach ($questions as $question)
                                        <option value="{{ $question->id }}">
                                            {{ $question->question }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-name"></span>
                            </div>
                        </div>
                        <div class="my-1">
                            <button type="submit" class="btn btn-primary add-todo-item me-1">
                                {{ __('locale.Import') }}
                            </button>
                            <button type="button" class="btn btn-outline-secondary add-todo-item"
                                data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="body-content-overlay"></div>

    <div class="todo-app-list {{ @$assessments->first() ? 'd-block' : 'd-none' }}">
        <!-- control List starts -->
        <div class="todo-task-list-wrapper list-group">
            <div class="app-fixed-search d-flex align-items-center justify-content-end p-2">
                @if (auth()->user()->hasPermission('templateAssessment.create'))
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#new-assessment-modal">
                        {{ __('assessment.AddNewTemplate') }}
                    </button>
                    {{-- <a style="margin:7px 25px 0px 25px ;" href="{{ route('admin.assessment.notificationsSettingsassessments') }}" class="dt-button btn btn-primary mx-2"
            target="_self">
            {{ __('locale.NotificationsSettings') }}
        </a> --}}
                @endif
            </div>

            <ul class="todo-task-list media-list" id="todo-task-list">
                <li class="todo-item">
                    <div id="firstTab{{ $assessments->first()->id ?? '' }}" class="tabcontent">
                        <!-- Dark Tables start -->
                        <div class="row" id="dark-table">
                            <div class="col-12">

                                <div class="card2 p-0 m-0">
                                    <div class="card m-0">
                                        <div class="card-body">
                                            <div class="frame">
                                                <h4 class="card-title"> {{ __('locale.Name') }} : </h4>
                                                <h5 class="card-desc AssessmentName">
                                                    {{ $assessments->first()->name ?? '' }}
                                                </h5>
                                            </div>

                                            <!-- <a href="#" class="card-link">Another link</a> -->
                                            @if (auth()->user()->hasPermission('templateAssessment.edit'))
                                                <button type="button"
                                                    class="
                                                card-link
                                                btn btn-outline-primary btn-sm
                                                 updateItem"
                                                    data-id="{{ $assessments->first()->id ?? '' }}"
                                                    data-name="{{ $assessments->first()->name ?? '' }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit-modal{{ $assessments->first()->id ?? '' }}">
                                                    {{ __('locale.Edit') }}
                                                </button>
                                            @endif
                                            @if (auth()->user()->hasPermission('templateAssessment.delete'))
                                                <button class="card-link btn btn-outline-danger btn-sm m-0 deleteItem"
                                                    data-id="{{ $assessments->first()->id ?? '' }}">
                                                    {{ __('locale.Delete') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </li>
                <li class="todo-item">
                    <section id="advanced-search-datatable">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">

                                    <div class="card-header border-bottom p-1">
                                        <div class="head-label">
                                            <h4 class="card-title">{{ __('locale.Questions') }}</h4>
                                        </div>
                                        @if (auth()->user()->hasPermission('templateAssessment.create'))
                                            <div class="dt-action-buttons text-end">
                                                <div class="dt-buttons d-inline-flex">

                                                    <button type="button"
                                                        class="dt-button  btn btn-primary  me-2 AddQuesBtn"
                                                        data-bs-toggle="modal" data-bs-target="#new-question-modal">
                                                        {{ __('assessment.AddNewQuestion') }}
                                                    </button>

                                                    <button type="button"
                                                        class="dt-button  btn btn-primary  me-2 ImportQuestionsBTn"
                                                        data-bs-toggle="modal" data-bs-target="#import-questions-modal">
                                                        {{ __('assessment.QuestionsBank') }}
                                                    </button>
                                                    <a href="{{ route('admin.questions.notificationsSettingsQuestions') }}"
                                                        class="dt-button btn btn-primary me-2" target="_self">
                                                        {{ __('locale.NotificationsSettings') }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!--Search Form -->

                                    <hr class="my-0" />
                                    <div class="card-datatable table-responsive mx-1 ">

                                        <table class="table QuestionTable text-center">
                                            <thead>
                                                <tr>
                                                    <th class="all">{{ __('locale.#') }}</th>
                                                    <th class="all">{{ __('assessment.FileAttachment') }}</th>
                                                    <th class="all">{{ __('assessment.QuestionLogic') }}</th>
                                                    <th class="all">{{ __('assessment.RiskAssessment') }}</th>
                                                    <th class="all">{{ __('assessment.ComplianceAssessment') }}</th>
                                                    <th class="all">{{ __('assessment.MaturityAssessment') }}</th>
                                                    <th class="all">{{ __('assessment.HaveAnswers') }}</th>
                                                    <th class="all">{{ __('assessment.AnswerType') }}</th>
                                                    <th class="all">{{ __('assessment.Question') }}</th>

                                                    <th class="all">{{ __('assessment.Actions') }}</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </li>


            </ul>
            <div class="no-results">
                <h5>No Items Found</h5>
            </div>
        </div>

    </div>
@endsection




@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script> --}}
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dragula.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
@endsection

@section('page-script')

    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

    <script>
        let _assessment_id = '{{ $assessments->first()->id ?? '' }}';
        let _assessment_name = '{{ $assessments->first()->name ?? '' }}';
        let _sideNavBtn = '';
        let _page = 1;

        let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
        let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
        let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
        let swal_success = "{{ __('locale.Success') }}";

        $(document).on('click', '.sideNavBtn', function() {
            _sideNavBtn = $(this);
            _sideNavBtn.addClass('active').siblings().removeClass('active');
            _assessment_id = $(this).attr('id');
            _assessment_name = $(this).data('name');
            $('.AssessmentName').text(_assessment_name);
            $('.updateItem').attr('data-bs-target', '#edit-modal' + _assessment_id + '');
            $('.deleteItem').attr('data-id', _assessment_id);
            table.draw();

        });

        // edit assessment
        $('.updateItem').on('click', function() {
            let form = $('#edit-assessment-modal form');
            let url = "{{ route('admin.assessment.update', ':id') }}";
            url = url.replace(':id', _assessment_id);
            form.find($('input[name="name"]')).val(_assessment_name);
            form.attr('action', url);
            form.find('input[name="id"]').val(_assessment_id);
            $('#edit-assessment-modal').modal('show');

        });

        $(document).on('click', '.pagination.custom  a', function(e) {
            // get paginated assessments
            e.preventDefault();
            let url = $(this).data('url');
            _page = url.split('page=')[1];
            fetchData(_page);

        });

        function fetchData(page) {
            let url = '{{ route('admin.assessment.ajax.paginated_data', ':page') }}';
            url = url.replace(':page', 'page=' + page);
            $.ajax({
                type: "Get",
                url: url,
                success: function(response) {
                    $('#paginated_data').html(response);
                    $('.sideNavBtn:first').trigger('click');

                },
                error: function(xhr) {
                    console.log(xhr)
                }
            })
        }
    </script>

    {{-- on submit add assessment form --}}
    <script>
        $('#add_assessment').on('submit', function(event) {
            event.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');
            $.ajax({
                processData: false,
                contentType: false,
                cache: false,
                type: "POST",
                url: url,
                data: data,
                success: function(response) {
                    makeAlert('success', '@lang('assessment.Assessment Added Successfully')', 'Success');
                    $('#new-assessment-modal').modal('hide');
                    fetchData(_page);
                    formReset();
                    $('.todo-app-list').removeClass('d-none');
                },
                error: function(xhr) {
                    if (xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            let input = $(`input[name="${key}"]`);
                            input.addClass('is-invalid');
                            $('.error-' + key).text(value)
                        })
                    }

                }
            })
        });
        // edit form
        $('#edit_assessment').on('submit', function(event) {
            event.preventDefault();
            let url = $(this).attr('action'),
                data = new FormData(this);
            data.append('_method', 'put');
            $.ajax({
                processData: false,
                cache: false,
                contentType: false,
                type: "post",
                url: url,
                data: data,
                headers: {
                    'x-csrf-token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    makeAlert('success', '@lang('assessment.Assessment Updated Successfully')', 'Success');
                    $('#edit-assessment-modal').modal('hide');
                    fetchData(_page);
                    formReset();
                },
                error: function(xhr) {
                    if (xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            let input = $(`input[name="${key}"]`);
                            input.addClass('is-invalid');
                            $('.error-' + key).text(value)
                        })
                    }
                }

            })

        });

        $('.deleteItem').on('click', function() {
            let url = '{{ route('admin.assessment.destroy', ':id') }}';
            url = url.replace(':id', _assessment_id);

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
                        type: "DELETE",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            makeAlert('success', '@lang('assessment.Assessment Deleted Successfully')', 'Success');
                            if ($('.sideNavBtn').length === 1) {
                                $('.todo-app-list').addClass('d-none');
                            }
                            fetchData(_page);

                        }
                    })
                }
            });

        })
    </script>

    <script>
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false
            });
        };

        function formReset() {
            $('.modal form').trigger('reset');
            if (quill.getLength() > 1) {
                quill.setText('')
            }
            $('.modal form select').trigger('change');
            $('.modal form div.d-none').removeClass('d-none');
        }

        $('.modal').on('hidden.bs.modal', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('.error').empty();

            formReset();
        })
    </script>

    {{-- questions --}}

    <script>
        const datatable_url = '{{ route('admin.questions.list') }}';
    </script>
    {{--  <script src="{{ asset('ajax-files/assessments/assessments/questions.js') }}"></script>  --}}
    <script>
        let table = $('.QuestionTable').DataTable({
            lengthChange: true,
            processing: false,
            serverSide: true,
            ajax: {
                url: datatable_url,
                data: function(d) {
                    d.assessment_id = _assessment_id
                }
            },
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
                    name: "DT_RowIndex",
                    data: "DT_RowIndex",
                    searchable: false,
                    orderable: false
                },


                {
                    name: "file_attachment",
                    data: "file_attachment",
                    searchable: true,
                    orderable: false,
                    render: function(d) {
                        var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                        if (d) {
                            icon = '<i class="fa fa-check text-success"></i>';
                        }
                        return icon;
                    }
                },
                {
                    name: "question_logic",
                    data: "question_logic",
                    render: function(d) {
                        var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                        if (d) {
                            icon = '<i class="fa fa-check text-success"></i>';
                        }
                        return icon;
                    }
                },
                {
                    name: "risk_assessment",
                    data: "risk_assessment",
                    searchable: true,
                    orderable: false,
                    render: function(d) {
                        var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                        if (d) {
                            icon = '<i class="fa fa-check text-success"></i>';
                        }
                        return icon;
                    }
                },
                {
                    name: "compliance_assessment",
                    data: "compliance_assessment",
                    searchable: true,
                    orderable: false,
                    render: function(d) {
                        var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                        if (d) {
                            icon = '<i class="fa fa-check text-success"></i>';
                        }
                        return icon;
                    }
                },

                {
                    name: "maturity_assessment",
                    data: "maturity_assessment",
                    searchable: true,
                    orderable: false,
                    render: function(d) {
                        var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                        if (d) {
                            icon = '<i class="fa fa-check text-success"></i>';
                        }
                        return icon;
                    }
                },

                {
                    name: "answers_count",
                    data: "answers_count",
                    searchable: true,
                    orderable: false,
                    render: function(d) {

                        var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                        if (d > 0) {
                            icon = '<i class="fa fa-check text-success"></i>';
                        }
                        return icon;
                    }
                },
                {
                    name: "answer_type",
                    data: "answer_type",
                    searchable: false,
                    sortable: false,
                    orderable: false,
                },

                {
                    name: "question",
                    data: "question",
                    render: function(data) {

                        if (data.length > 100) {
                            data = data.slice(0, 100) + ' ...?';
                        }

                        return data;
                    }
                },


                {
                    name: "actions",
                    data: "actions"
                }
            ],
            columnDefs: [

                {
                    targets: -1,
                    width: "30%"
                },
                {
                    targets: -2,
                    width: "50%"
                }
            ],


        });

        var quill = new Quill('.question,.edit_question', {
            modules: {
                toolbar: '.question-toolbar'
            },
            theme: 'snow'
        });

        var edit_quill = new Quill('.edit_question', {
            modules: {
                toolbar: '.edit_question-toolbar'
            },
            theme: 'snow'
        });


        $('.answer_type').on('change', function() {
            var answer_type = $(this).val();
            // $('.options .mb-1 input[type="checkbox"]').prop('checked', false);
            if (answer_type == 1) {
                $('.controls , .options .mb-1').removeClass('d-none');
            } else if (answer_type == 2) {
                $('.controls').val('').trigger('change');
                $('#ComplianceAssessment, #MaturityAssessment').prop('checked', false);
                $('.options .mb-1:is(.file_attachment,.question_logic,.risk_assessment)').removeClass('d-none');
                $('.controls ,.options .mb-1:not(.file_attachment,.question_logic,.risk_assessment)').addClass(
                    'd-none');

            } else if (answer_type == 3) {
                $('.controls').val('').trigger('change');
                $('#ComplianceAssessment, #MaturityAssessment').prop('checked', false);
                $(".controls ,.options .mb-1:not(.file_attachment)").addClass('d-none');
            }
        });

        /*add new question*/
        $('#add_questions').on('submit', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            //var question = $('#question .ql-editor').html(); // includes html  tags
            var question = quill.getText();
            var data = new FormData(this);
            data.append('question', question);
            data.append('assessment_id', _assessment_id);
            if (quill.getLength() == 1) {
                $('.error-question').empty().append('Question is Required').css('display', 'inline-block');
                return 0;
            }
            $.ajax({
                processData: false,
                contentType: false,
                cache: false,
                type: "post",
                data: data,
                url: url,
                success: function(response) {
                    makeAlert('success', response);
                    // $('.sideNavBtn.active').trigger('click');

                    table.page(table.page.info().page).draw('page');

                    $('#new-question-modal').modal('hide');
                },
                error: function(xhr) {
                    if (xhr.responseJSON.message) {
                        makeAlert('error', xhr.responseJSON.message);
                    }
                }
            });

        });

        /*edit question*/
        $(document).on('click', '.edit_question_btn', function(e) {
            e.preventDefault();
            // 1- get question data using ajax call
            let url = $(this).data('url');

            $.ajax({
                type: "GET",
                url: url,
                success: function(question) {

                    // 2- render data into form
                    var question_edit_form = $('#edit_question_form');
                    question_edit_form.find('input[name="question_id"]').val(question.id);
                    edit_quill.setText(question.question);
                    var controls = $('#edit_question_form select[name="control_id"] option');
                    /* var questions_control = question.control;*/

                    $('#edit_question_form select[name="control_id"] option[value="' + question
                        .control_id + '"]').prop('selected', true);
                    $('#edit_question_form select[name="control_id"]').trigger('change');

                    var answer_types = $('#edit_question_form select[name="answer_type"] option');
                    answer_types.each(function(key, option) {
                        if (question.answer_type == option.value) {
                            $(option).prop('selected', true);
                        }
                    });
                    $('#edit_question_form select[name="answer_type"]').trigger('change');

                    $(question_edit_form).find('select[name="answer_type"]').trigger('change');
                    $(question_edit_form).find('input[name="file_attachment"]').prop('checked', !!
                        question.file_attachment);
                    $(question_edit_form).find('input[name="question_logic"]').prop('checked', !!
                        question.question_logic);
                    $(question_edit_form).find('input[name="risk_assessment"]').prop('checked', !!
                        question.risk_assessment);
                    $(question_edit_form).find('input[name="compliance_assessment"]').prop('checked', !!
                        question.compliance_assessment);
                    $(question_edit_form).find('input[name="maturity_assessment"]').prop('checked', !!
                        question.maturity_assessment);

                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message);

                }
            }).then(function() {
                // 3- open edit modal
                $('#edit-question-modal').modal('show')
            })
        });

        /* on submit edit_question_form*/

        $('#edit_question_form').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this);
            var question = edit_quill.getText();
            data.append('question', question);

            data.append('assessment_id', _assessment_id);
            if (edit_quill.getLength() == 1) {
                $('.error-question').empty().append('Question is Required').css('display', 'inline-block');
                return 0;
            }
            var question_id = $(this).find('input[name="question_id"]').val();
            var url = $(this).attr('action');
            url = url.replace(':id', question_id);
            $.ajax({
                processData: false,
                contentType: false,
                cache: false,
                type: "Post",
                data: data,
                url: url,
                success: function(response) {
                    makeAlert('success', response);
                    // $('.sideNavBtn.active').trigger('click');
                    table.page(table.page.info().page).draw('page');
                    $('#edit-question-modal').modal('hide');
                },
                error: function(xhr) {
                    if (xhr.responseJSON.message) {
                        makeAlert('error', xhr.responseJSON.message);
                    }
                }
            })


        });

        // delete question
        $(document).on('click', '.delete_question_btn', function(e) {
            e.preventDefault();
            var url = $(this).data('url');

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
                        type: "DELETE",
                        url: url,
                        data: {
                            assessment_id: _assessment_id
                        },
                        headers: {
                            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            var message = response.message;
                            makeAlert('success', message, swal_success);
                            // $('.sideNavBtn.active').trigger('click');
                            table.page(table.page.info().page).draw('page');
                        },
                        error: function(xhr) {

                        }
                    })
                }
            });


        })
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    {{-- import questions from assessemt --}}
    <script>
        var assesment_edit = null;
        $('#assessment_id').on('change', function(e) {
            assessment_id = $(this).val();
            url = "{{ route('admin.questions.fetch_questions_from_assessment') }}";
            $.ajax({
                type: "GET",
                url,
                data: {
                    assessment_id: assessment_id
                },
                success: function(response) {
                    $('#assessments_questions').empty();
                    $.each(response, function(index, option) {
                        $('#assessments_questions').append('<option value="' + option.id +
                            '">' + option
                            .question + ' </option>');;
                    });
                },
                error: function(xhr) {

                }
            });

        });
        $(".select-all-btn").click(function() {
            $("#assessments_questions").find("option").prop("selected", true);
            $("#assessments_questions").trigger("change");
        });

        $(".unselect-all-btn").click(function() {
            $("#assessments_questions").find("option").prop("selected", false);
            $("#assessments_questions").trigger("change");
        });

        {{--  $('#assessment_id').on('change', function () {
            var assessment_id = $(this).val();
            $('#c option').prop('selected', false);
            $('#assessments_questions option[data-assessment_id="' + assessment_id + '"]').prop('selected', true);
            //  $('#assessments_questions').trigger('change');
        });  --}}
        $('#import_questions').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');
            data.append('assessment_id', _assessment_id);
            if ($('#assessments_questions').val().length === 0) {
                makeAlert('error', 'Please Select At Least one Question !');
                return;
            }

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                processData: false,
                cache: false,
                contentType: false,
                success: function(response) {
                    formReset();
                    $('.modal').modal('hide');
                    table.draw();
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message);
                }
            })
        })
    </script>
@endsection
