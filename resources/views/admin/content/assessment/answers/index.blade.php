@extends('admin/layouts/contentLayoutMaster')

@section('title', __('assessment.Questions'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('page-style')
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection
@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">


                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('assessment.Questions') }}</h4>
                        </div>
                        <div class="dt-action-buttons text-end">
                            <div class="dt-buttons d-inline-flex">


                                <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#addNewAnswer">
                                    {{ __('assessment.AnswerCreate') }}
                                </button>


                            </div>
                        </div>
                    </div>
                    <!--Search Form -->
                    <div class="card-body mt-2">

                        {{ __('assessment.Question') }}: <span class="text-warning">{{ $question->question }}</span>
                    </div>

                </div>
                <hr class="my-0" />
                <div class="card-datatable">
                    <table class="dt-advanced-server-search table text-center">
                        <thead>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('assessment.Question') }}</th>
                                <th>{{ __('assessment.Answer') }}</th>
                                <th>{{ __('assessment.SubmitRisk') }}</th>
                                <th>{{ __('assessment.FailControl') }}</th>
                                <th>{{ __('assessment.MaturityControl') }}</th>
                                <th>{{ __('assessment.Actions') }}</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        </div>
    </section>

    <div class="modal fade" id="addNewAnswer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{--                    <h5 class="modal-title" id="modalFullTitle">{{__('locale.AddNewAnswer')}}</h5> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <section class="modern-vertical-wizard">
                        <form action="{{ route('admin.answers.store', $question->id) }}" id="addNewAnswerForm"
                            method="post">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                            <div class="bs-stepper vertical wizard-modern modern-vertical-wizard-example">
                                <div class="bs-stepper-header">
                                    <div class="step" data-target="#answer" role="tab" id="answer-toggle">
                                        <button type="button" class="step-trigger">
                                            <span class="bs-stepper-box">
                                                <i data-feather="check-square" class="font-medium-3"></i>
                                            </span>
                                            <span class="bs-stepper-label">
                                                <span class="bs-stepper-title">{{ __('assessment.AnswerDetails') }}</span>
                                                <span class="bs-stepper-subtitle">{{ __('assessment.AddAnswer') }}</span>
                                            </span>
                                        </button>
                                    </div>
                                    @if ($question->question_logic)
                                        <div class="step" data-target="#question_logic" role="tab"
                                            id="question_logic_toggle">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-box">
                                                    <i data-feather="alert-triangle" class="font-medium-3"></i>
                                                </span>
                                                <span class="bs-stepper-label">
                                                    <span
                                                        class="bs-stepper-title">{{ __('assessment.QuestionLogic') }}</span>
                                                    <span
                                                        class="bs-stepper-subtitle">{{ __('assessment.AddQuestionLogic') }}</span>
                                                </span>
                                            </button>
                                        </div>
                                    @endif
                                    @if ($question->risk_assessment)
                                        <div class="step" data-target="#risk_assessment" role="tab"
                                            id="risk_assessment_toggle">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-box">
                                                    <i data-feather="alert-triangle" class="font-medium-3"></i>
                                                </span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">{{ __('assessment.Risk') }}</span>
                                                    <span
                                                        class="bs-stepper-subtitle">{{ __('assessment.SubmitRisk') }}</span>
                                                </span>
                                            </button>
                                        </div>
                                    @endif
                                    @if ($question->compliance_assessment)
                                        <div class="step" data-target="#compliance_assessment" role="tab"
                                            id="compliance_assessment_toggle">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-box">
                                                    <i data-feather="alert-triangle" class="font-medium-3"></i>
                                                </span>
                                                <span class="bs-stepper-label">
                                                    <span
                                                        class="bs-stepper-title">{{ __('assessment.ComplianceAssessment') }}</span>
                                                    {{--                                            <span class="bs-stepper-subtitle">{{__('locale.AddComplianceAssessment')}}</span> --}}
                                                </span>
                                            </button>
                                        </div>
                                    @endif
                                    @if ($question->maturity_assessment)
                                        <div class="step" data-target="#maturity_assessment" role="tab"
                                            id="maturity_assessment_toggle">
                                            <button type="button" class="step-trigger">
                                                <span class="bs-stepper-box">
                                                    <i data-feather="alert-triangle" class="font-medium-3"></i>
                                                </span>
                                                <span class="bs-stepper-label">
                                                    <span
                                                        class="bs-stepper-title">{{ __('assessment.MaturityAssessment') }}</span>
                                                    {{--                                        <span class="bs-stepper-subtitle">{{__('locale.AddMaturityAssessment')}}</span> --}}
                                                </span>
                                            </button>
                                        </div>
                                    @endif

                                </div>

                                <div class="bs-stepper-content">
                                    <div id="answer" class="content" role="tabpanel" aria-labelledby="answer-toggle">
                                        <div class="content-header">
                                            <h5 class="mb-0">{{ __('assessment.AnswerDetails') }}</h5>
                                            <small class="text-muted">{{ __('assessment.AddAnswer') }}</small>
                                        </div>

                                        <div class="row">
                                            <div class="mb-1 col-md-12">
                                                <label class="form-label">{{ __('assessment.Answer') }}</label>
                                                <div class="create_answer"></div>
                                                <span class="error-answer error"></span>
                                            </div>
                                            <div class="mt-5"></div>

                                        </div>
                                    </div>

                                    @if ($question->question_logic)
                                        <div id="question_logic" class="content" role="tabpanel"
                                            aria-labelledby="question_logic_toggle">
                                            <div class="content-header">
                                                <h5 class="mb-0">{{ __('assessment.QuestionLogic') }}</h5>
                                                <small>{{ __('assessment.AddQuestionLogic') }}</small>
                                            </div>

                                            <div class="row">
                                                <div class="mb-1 col-md-12">
                                                    <label class="form-label"
                                                        for="assessment_id">{{ __('assessment.Assessment') }}</label>
                                                    <select name="sub_question_assessment_id" class="form-control select2"
                                                        id="assessment_id">
                                                        <option value=" ">----</option>
                                                        @foreach ($data['assessments'] as $assessment)
                                                            <option value="{{ $assessment->id }}">{{ $assessment->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                {{--  data-assessment_id="{{$sub_question->assessments->first()->id}}"   --}}

                                                <div class="mb-1 col-md-12">
                                                    <div class="mb-2">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm select-all-btn">{{ __('locale.SelectAll') }}</button>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm unselect-all-btn">{{ __('locale.UnSelectAll') }}</button>
                                                    </div>
                                                    <label class="form-label"
                                                        for="sub_questions">{{ __('assessment.AssessmentSubQuestion') }}</label>
                                                    <span class="text-success sub_questions_count">0 Selected</span>
                                                    <select name="sub_questions[]" class="form-control select2" multiple
                                                        id="sub_questions">
                                                        @foreach ($data['questions'] as $sub_question)
                                                            <option value="{{ $sub_question->id }}">
                                                                {{ $sub_question->question }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                    @if ($question->risk_assessment)
                                        <div id="risk_assessment" class="content" role="tabpanel"
                                            aria-labelledby="risk_assessment_toggle">
                                            <div class="content-header">
                                                <h5 class="mb-0">{{ __('assessment.RiskAssessment') }}</h5>
                                                <small>{{ __('assessment.SubmitRisk') }}</small>
                                            </div>

                                            <div class="row">
                                                <div class="mb-1 col-md-12">
                                                    <label class="form-label"
                                                        for="submit_risk">{{ __('assessment.SubmitRisk') }}</label>
                                                    <input type="checkbox" id="submit_risk" name="submit_risk"
                                                        value="true">
                                                </div>
                                                <div class="mb-1 col-md-12 risk_details d-none">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label
                                                                for="risk_subject">{{ __('assessment.Subject') }}</label>
                                                            <input type="text" class="form-control"
                                                                name="risk_subject" id="risk_subject">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label
                                                                for="assessment_scoring_id">{{ __('assessment.RiskScoringMethod') }}</label>
                                                            <select name="risk_scoring_method_id"
                                                                id="assessment_scoring_id" class="form-control select2">
                                                                @foreach ($data['riskScoringMethods'] as $method)
                                                                    <option value="{{ $method->id }}">
                                                                        {{ $method->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label
                                                                for="current_likelihood_id">{{ __('assessment.CurrentLikelihood') }}</label>
                                                            <select name="likelihood_id" id="current_likelihood_id"
                                                                class="form-control select2">
                                                                @foreach ($data['likelihoods'] as $likelihood)
                                                                    <option value="{{ $likelihood->id }}">
                                                                        {{ $likelihood->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label
                                                                for="impact_id">{{ __('assessment.CurrentImpact') }}</label>
                                                            <select name="impact_id" id="impact_id"
                                                                class="form-control select2">
                                                                @foreach ($data['impacts'] as $impact)
                                                                    <option value="{{ $impact->id }}">
                                                                        {{ $impact->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <label for="owner_id">{{ __('assessment.Owner') }}</label>
                                                            <select name="owner_id" id="owner_id"
                                                                class="form-control select2">
                                                                @foreach ($data['enabledUsers'] as $user)
                                                                    <option value="{{ $user->id }}">
                                                                        {{ $user->username }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <label
                                                                for="affected_assets">{{ __('assessment.AffectedAssets') }}</label>
                                                            <select name="assets_ids[]" id="affected_assets"
                                                                class="form-control select2" multiple>
                                                                @if (count($data['assetGroups']))
                                                                    <optgroup label="{{ __('assessment.AssetGroups') }}">
                                                                        @foreach ($data['assetGroups'] as $assetGroup)
                                                                            <option value="{{ $assetGroup->id }}_group">
                                                                                {{ $assetGroup->name }}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif
                                                                <optgroup
                                                                    label="{{ __('assessment.Standards') }} {{ __('assessment.Assets') }}">
                                                                    @foreach ($data['assets'] as $asset)
                                                                        <option value="{{ $asset->id }}_asset">
                                                                            {{ $asset->name }}</option>
                                                                    @endforeach
                                                                </optgroup>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <label for="tags">{{ __('assessment.Tags') }}</label>
                                                            <select name="tags_ids[]" id="tags"
                                                                class="form-control select2" multiple>
                                                                @foreach ($data['tags'] as $tag)
                                                                    <option value="{{ $tag->id }}">
                                                                        {{ $tag->tag }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <label
                                                                for="migrationControls">{{ __('assessment.Controls') }}</label>
                                                            <select name="framework_controls_ids" id="migrationControls"
                                                                class="form-control select2">
                                                                @foreach ($data['migration_controls'] as $control)
                                                                    <option value="{{ $control->id }}">
                                                                        {{ $control->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                    @if ($question->compliance_assessment)
                                        <div id="compliance_assessment" class="content" role="tabpanel"
                                            aria-labelledby="compliance_assessment_toggle">
                                            <div class="content-header">
                                                <h5 class="mb-0">{{ __('assessment.ComplianceAssessment') }}</h5>
                                                {{--                                                <small>{{__('locale.AddComplianceAssessment')}}</small> --}}
                                            </div>

                                            <div class="row">
                                                <div class="mb-1 col-md-6 form-group">
                                                    <label class="form-label" for="fail_control">
                                                        {{ __('assessment.FailControl') }} </label>
                                                    <input type="checkbox" class="" name="fail_control"
                                                        value="true" id="fail_control">

                                                </div>

                                            </div>

                                        </div>
                                    @endif
                                    @if ($question->maturity_assessment)
                                        <div id="maturity_assessment" class="content" role="tabpanel"
                                            aria-labelledby="maturity_assessment_toggle">
                                            <div class="content-header">
                                                <h5 class="mb-0">{{ __('assessment.MaturityAssessment') }}</h5>
                                                {{--                                                <small>{{__('locale.AddMaturityAssessment')}}</small> --}}
                                            </div>

                                            <div class="row">
                                                <div class="mb-1 col-md-6">
                                                    <label class="form-label"
                                                        for="vertical-modern-google">{{ __('assessment.ControlMaturity') }}</label>
                                                    <select name="maturity_control_id" id="control_maturity"
                                                        class="select2 form-control">
                                                        <option value=" ">---</option>
                                                        @foreach ($data['maturity_controls'] as $control)
                                                            <option value="{{ $control->id }}">{{ $control->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary"
                                    data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('locale.SaveAnswer') }}</button>
                            </div>
                        </form>
                    </section>


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
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    @include('admin.content.partials._helperJs')

    {{-- quill --}}
    <script>
        var quill = new Quill('.create_answer', {

            theme: 'snow'
        });
    </script>
    {{-- answers datatable --}}
    <script>
        let datatable_url = '{{ route('admin.answers.list', $question->id) }}'
        var answers_datatable = $('.dt-advanced-server-search').DataTable({
            lengthChange: true,
            processing: false,
            serverSide: true,
            ajax: {
                url: datatable_url,
                data: function(d) {
                    d.answer = $('input[name="filter_answer"]').val();
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
                    name: 'DT_RowIndex',
                    data: "DT_RowIndex",
                    searchable: false,
                    sortable: false,
                    orderable: false
                },
                {
                    name: 'question.question',
                    data: "question.question",
                    orderable: false,
                    sortable: false
                },
                {
                    name: 'answer',
                    data: "answer",
                    render: function(d) {
                        var template = document.createElement('div');
                        template.innerHTML = d;
                        return template.innerText || template.textContent || "";

                    }
                },
                {
                    name: 'submit_risk',
                    data: "submit_risk",
                    searchable: false,
                    render: function(d) {
                        var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                        if (d) {
                            icon = '<i class="fa fa-check text-success"></i>';
                        }
                        return icon;
                    }
                },
                {
                    name: 'fail_control',
                    data: "fail_control",
                    searchable: false,
                    render: function(d) {
                        var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                        if (d) {
                            icon = '<i class="fa fa-check text-success"></i>';
                        }
                        return icon;
                    }
                },

                {
                    name: 'maturity_control.name',
                    data: "maturity_control",
                    sortable: false,
                    orderable: false,
                    searchable: true,
                    render: function(d) {
                        var icon = '<i class="fa fa-close fa-sm text-danger"></i>';
                        if (d) {
                            icon = '<span class="text-success">' + d.name + '</span>';
                        }
                        return icon;
                    }

                },


                {
                    name: 'actions',
                    data: "actions",
                    searchable: false,
                    sortable: false,
                    orderable: false
                },
            ],
            columnDefs: [{}]
        });
        $('input[name="filter_answer"]').on('input', function() {
            answers_datatable.page(answers_datatable.page.info().page).draw('page');
        })
    </script>
    {{-- reset modal form --}}
    <script>
        function resetModalForm() {
            $('.modal form').find('form').trigger('reset');
            $('.modal form').find('select option:selected').prop('selected', false);
            $('.modal form').find('select').trigger('change');
            $('.modal form').find('input:checkbox:checked').prop('checked', false);
            $('.modal form').attr('id', 'addNewAnswerForm').removeAttr('data-url');
            $('.modal input[name="risk_subject"]').val('');
            quill.setText('');
            $('.risk_details').not('.d-none') ? $('.risk_details').addClass('d-none') : '';
            $('.step:first').find('button.step-trigger').trigger('click');
            $('.modal form').find('.error').empty();

        }

        $('.modal').on('hide.bs.modal', function() {
            resetModalForm();
        })
    </script>
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
                    $('#sub_questions').empty();
                    $.each(response, function(index, option) {
                        $('#sub_questions').append('<option value="' + option.id + '">' + option
                            .question + ' </option>');;
                    });
                },
                error: function(xhr) {

                }
            });

        });
        $(".select-all-btn").click(function() {
            $("#sub_questions").find("option").prop("selected", true);
            $("#sub_questions").trigger("change");
        });

        $(".unselect-all-btn").click(function() {
            $("#sub_questions").find("option").prop("selected", false);
            $("#sub_questions").trigger("change");
        });


        /* var that = $(this);
             $('#sub_questions option').each(function() {
                 if ($(this).data('assessment_id') == that.val()) {
                     $(this).prop('selected', true)
                 } else {
                     $(this).prop('selected', false)
                 }
             });
             $('#sub_questions').parents('div').find('.sub_questions_count').text($('#sub_questions option:selected')
                 .length + ' Selected');
             $('#sub_questions').trigger('change'); */

        $('#sub_questions').on('change', function() {
            $(this).parents('div').find('.sub_questions_count').text($('#sub_questions option:selected').length +
                ' Selected');
        })
    </script>

    {{-- actions on table --}}
    <script>
        {{-- Add new Record --}}
        $('#addNewAnswerForm').on('submit', function(e) {
            e.preventDefault();
            if ($(this).is('#EditAnswerForm')) {
                return;
            }
            var url = $(this).attr('action');
            var data = new FormData(this);
            if (quill.getLength() == 1) {
                $('.error-answer').empty().append('Answer is Required').css('display', 'inline-block');
                makeAlert('error', "Answer Is Required", "{{ __('locale.Error') }}");
                return;
            }
            var answer = $('.create_answer .ql-editor').html();
            data.append('answer', answer);
            data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                type: "POST",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[namee="csrf-token"]').attr('content')
                },
                processData: false,
                cache: false,
                contentType: false,
                success: function(response) {
                    answers_datatable.page(answers_datatable.page.info().page).draw('page');
                    Swal.fire({
                        title: "{{ __('Locale.Success') }}",
                        text: "{{ __('assessment.Answer Added successfully , Do you Want To Add  Another Answer ?') }}",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: "{{ __('Locale.Yes') }}",
                        cancelButtonText: "{{ __('Locale.No') }}",
                        customClass: {
                            confirmButton: 'btn btn-relief-success ms-1',
                            cancelButton: 'btn btn-outline-danger ms-1'
                        },
                        buttonsStyling: false
                    }).then(function(result) {
                        if (result.value) {
                            resetModalForm();
                        } else {
                            $('.modal').modal('hide');
                        }
                    });


                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON[0], "{{ __('locale.Error') }}");
                }
            })
        });
        /* @Click on Edit Button*/
        $(document).on('click', '.edit_answer_btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var url = $(this).data('url');

            $.ajax({
                type: "GET",
                url,
                success: function(answer) {
                    var form = $('.modal form');
                    $('.create_answer .ql-editor ').html(answer.answer);


                    if (answer.fail_control) {
                        $('input[name="fail_control"]').prop('checked', true);
                    }
                    if (answer.maturity_control_id) {
                        $('#control_maturity option[value="' + answer.maturity_control_id + '"]').prop(
                            'selected', true);
                        $('#control_maturity').trigger('change');
                    }
                    if (answer.sub_question_assessment_id) {
                        $('#assessment_id option[value="' + answer.sub_question_assessment_id + '"]')
                            .prop('selected', true);
                        $('#assessment_id').trigger('change.select2');
                    }
                    if (answer.sub_questions && answer.sub_questions.length > 0) {
                        var sub_questions = answer.sub_questions;
                        $.each(sub_questions, function(index, question) {
                            $('#sub_questions option[value="' + question.pivot.question_id +
                                '"]').prop('selected', true);
                        });
                        $('#sub_questions').trigger('change');
                    }

                    if (answer.submit_risk) {
                        $('#submit_risk').trigger('click');
                        $('#risk_subject').val(answer.risk_subject);
                        $('#assessment_scoring_id option[value="' + answer.risk_scoring_method_id +
                            '"]').prop('selected', true);
                        $('#current_likelihood_id option[value="' + answer.likelihood_id + '"]').prop(
                            'selected', true);
                        $('#impact_id option[value="' + answer.impact_id + '"]').prop('selected', true);
                        $('#owner_id option[value="' + answer.owner_id + '"]').prop('selected', true);
                        var assets_ids = JSON.parse(answer.assets_ids),
                            tags_ids = JSON.parse(answer.tags_ids),
                            framework_controls_ids = answer.framework_controls_ids;

                        $.each(assets_ids, function(index, asset_id) {
                            $('#affected_assets option[value="' + asset_id + '"]').prop(
                                'selected', true);
                        });
                        $.each(tags_ids, function(index, tag_id) {
                            $('#tags option[value="' + tag_id + '"]').prop('selected', true);
                        });

                        $('#migrationControls option[value="' + framework_controls_ids + '"]').prop(
                            'selected', true);

                        $('#assessment_scoring_id , #current_likelihood_id , #impact_id ,#owner_id, #affected_assets,#tags ,#migrationControls')
                            .trigger('change');
                    }

                    var edit_answer_form_url =
                        '{{ route('admin.answers.update', ['question' => $question->id, 'answer' => ':answer_id']) }}';
                    edit_answer_form_url = edit_answer_form_url.replace(':answer_id', answer.id);
                    form.attr('id', 'EditAnswerForm');
                    form.attr('data-url', edit_answer_form_url);
                    form.attr('action', edit_answer_form_url);

                },
                error: function(xhr) {

                }
            }).then(() => {
                $('#addNewAnswer').modal('show')
            })
        });
        /*on Update Answer*/
        $(document).on('submit', '#EditAnswerForm', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var url = $(this).attr('action');
            var data = new FormData(this);
            var answer = $('.create_answer .ql-editor').html();
            data.append('_method', 'put');
            data.append('answer', answer);
            $.ajax({
                type: "POST",
                data: data,
                url: url,
                processData: false,
                cache: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(response) {
                    answers_datatable.page(answers_datatable.page.info().page).draw('page');
                    $('.modal').modal('hide');
                    makeAlert('success', response, 'Success')
                },
                error: function(xhr) {

                }
            })
        });
        {{-- On Delete Record --}}
        $(document).on('click', '.delete_answer_btn', function(e) {

            e.preventDefault();
            var url = $(this).data('url');

            deleteRecord(url, callback);

            function callback(response) {
                makeAlert('success', response, "{{ __('locale.Success') }}");
                answers_datatable.page(answers_datatable.page.info().page).draw('page');

            };
        });
    </script>
    <script>
        /*on check/uncheck submit risk*/
        $('#submit_risk').on('click', function() {
            if ($(this).is(':checked')) {
                $('.risk_details').removeClass('d-none');
            } else {
                $('.risk_details').addClass('d-none');
            }
        });
    </script>
@endsection
