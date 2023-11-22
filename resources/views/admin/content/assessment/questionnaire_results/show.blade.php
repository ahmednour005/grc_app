@extends('admin.layouts.contentLayoutMaster')
@section('title', __('assessment.QuestionnaireResults'))

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

    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection
@section('content')
    <div class="col-xl-12 col-lg-12">
        @if ($questionnaireAnswers->status == 'complete' && $questionnaireAnswers->approved_status == null)
        @if (auth()->user()->hasPermission('assessmentResult.assessmentResult'))
            <a href="{{ route('admin.questionnaire-results.changeStatus', ['id' => $questionnaireAnswers->id, 'status' => 'yes']) }}"
                class="btn btn-success">Approve</a>
            <a href="{{ route('admin.questionnaire-results.changeStatus', ['id' => $questionnaireAnswers->id, 'status' => 'no']) }}"
                class="btn btn-danger">Reject</a>
                @endif
                @endif


        <div class="card">


            <div class="card-header">
                <h4 class="card-title">
                    {{ @$questionnaireAnswers->questionnaire ? $questionnaireAnswers->questionnaire->name : '' }} </h4>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab-fill" data-bs-toggle="tab" href="#Answers" role="tab"
                            aria-controls="home-fill"
                            aria-selected="true">{{ __('assessment.QuestionnaireResponses') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab-fill" data-bs-toggle="tab" href="#Assessment-Risk"
                            role="tab" aria-controls="profile-fill"
                            aria-selected="false">{{ __('assessment.RiskAssessment') }}</a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content pt-1">
                    <div class="tab-pane active" id="Answers" role="tabpanel" aria-labelledby="home-tab-fill">
                        {{-- Questions and Answers --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="d-inline">{{ __('assessment.AssetName') }}</label>
                                    <select name="asset_id" readonly disabled required class="form-control select2"
                                        id="">
                                        <option value="">{{ @$questionnaireAnswers->asset->name }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <br>

                        @foreach ($questionnaire->assessment->questions as $index => $question)
                            <div class="form-group">
                                <label for="">
                                    <b class="badge badge-light-warning " style="font-size: 15px">{{ ++$index }}</b>
                                    <span class="" style="font-size: 15px; font-weight: bold">
                                        {{ $question->question }}</span>
                                </label>
                            </div>



                            @if ($question->answer_type == 1)

                                @php
                                    $value = '';
                                    $comment = '';
                                    $file = '';
                                @endphp

                                @foreach ($question->answers as $answer)
                                    @php

                                        foreach ($questionnaireAnswers->results as $result) {
                                            if ($result->answer_type == 1 && $result->question_id == $question->id) {
                                                $value = $result->answer_id;
                                                $comment = $result->comment;
                                                $file = $result->file;
                                            }
                                        }
                                    @endphp

                                    <input type="radio" {{ $answer->id == @$value ? 'checked' : '' }} disabled readonly
                                        name="questions[{{ $index }}][answers]" value="{{ $answer->id }}"
                                        id="answer_{{ $answer->id }}">
                                    <label for="answer_{{ $answer->id }}">{!! trim($answer->answer) !!}</label>
                                    <br>
                                @endforeach

                                @if (@$comment != '')
                                    <label for="" class="d-inline-block" style="font-weight: bold">
                                        {{ __('assessment.Comment:') }} </label>
                                    <strong>{{ @$comment }}</strong>
                                    <br>
                                @endif
                                @isset($file)
                                    <a download="{{ $question->question }}question_file" target="_blank"
                                        href="{{ asset($file) }}">view file</a>
                                @endif
                                <br>
                            @elseif($question->answer_type == 2)
                                @php
                                    $value = [];
                                    $comment = '';
                                    $file = '';
                                @endphp

                                @foreach ($question->answers as $answer)
                                    @php
                                        foreach ($questionnaireAnswers->results as $result) {
                                            if ($result->answer_type == 2 && $result->question_id == $question->id) {
                                                $value = explode(',', $result->answer);
                                                $comment = $result->comment;
                                                $file = $result->file;
                                            }
                                        }
                                    @endphp

                                    <input type="checkbox" readonly disabled
                                        {{ in_array($answer->id, $value ?? []) ? 'checked' : '' }}
                                        name="questions[{{ $index }}][answers][]" value="{{ $answer->id }}"
                                        id="answer_{{ $answer->id }}">
                                    <label for="answer_{{ $answer->id }}">{!! trim($answer->answer) !!}</label>
                                    <br>
                                @endforeach

                                @if (@$comment != '')
                                    <label for="" class="d-inline-block" style="font-weight: bold">
                                        {{ __('assessment.Comment:') }}</label>
                                    <strong>{{ @$comment }}</strong>
                                    <br>
                                @endif


                                @isset($file)
                                    <a download="{{ $question->question }}question_file" target="_blank"
                                        href="{{ asset($file) }}">{{ __('assessment.viewFile') }}</a>
                                @endif
                                <br>
                            @else
                                @php
                                    $value = '';
                                    $comment = '';
                                    $file = '';
                                @endphp


                                @php

                                    foreach ($questionnaireAnswers->results as $result) {
                                        if ($result->answer_type == 3 && $result->question_id == $question->id) {
                                            $value = $result->answer ?? '';
                                            $comment = $result->comment ?? '';
                                            $file = $result->file;
                                        }
                                    }
                                @endphp



                                <textarea disabled name="questions[{{ $index }}][answers]" cols="70" rows="2">
                                    {!! @$value !!}
                                </textarea>
                                <br>
                                @if ($comment != '')
                                    <label for="" class="d-inline-block" style="font-weight: bold">
                                        {{ __('assessment.Comment:') }} </label>
                                    <strong>{{ @$comment != null }}</strong>
                                    <br>
                                @endif

                                @if ($file && !empty($file))
                                    <a download="{{ $question->question }}question_file" target="_blank"
                                        href="{{ asset($file) }}">{{ __('assessment.viewFile') }}</a>
                                @endif

                                @endif
                                @endforeach
                            </div>
                            <div class="tab-pane" id="Assessment-Risk" role="tabpanel" aria-labelledby="profile-tab-fill">
                                <section id="accordion">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title"></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-text"></p>
                                                        <div class="accordion" id="accordionExample">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingOne">
                                                                    @if (auth()->user()->hasPermission('assessmentResult.assessmentResult'))
                                                                    <button class="accordion-button" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionOne"
                                                                        aria-expanded="true" aria-controls="accordionOne">
                                                                        {{ __('assessment.Analysis') }}
                                                                    </button>
                                                                    @endif
                                                                </h2>
                                                                <div id="accordionOne" class="accordion-collapse collapse show"
                                                                    aria-labelledby="headingOne"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        <table class="table table-striped table-bordered">

                                                                            <td></td>
                                                                            <td>{{ __('assessment.TotalNumber') }}</td>
                                                                            {{-- <td>Cumulative Score</td>
                                                                     <td>Average Score</td> --}}


                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>{{ __('assessment.AllRisks') }}</td>
                                                                                    <td>{{ $questionnaire->risks->count() }}</td>
                                                                                    {{-- <td></td>
                                                                        <td></td> --}}
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>{{ __('assessment.AddedRisks') }}</td>
                                                                                    <td>{{ $questionnaire->AddedRisks->count() }}
                                                                                    </td>
                                                                                    {{-- <td></td>
                                                                         <td></td> --}}
                                                                                </tr>

                                                                                <tr>
                                                                                    <td>{{ __('assessment.PendingRisks') }}</td>
                                                                                    <td>{{ $questionnaire->pendingRisks->count() }}
                                                                                    </td>
                                                                                    {{--  <td></td>
                                                                          <td></td> --}}
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>{{ __('assessment.RejectedRisks') }}</td>
                                                                                    <td>{{ $questionnaire->rejectedRisks->count() }}
                                                                                    </td>
                                                                                    {{-- <td></td>
                                                                         <td></td> --}}
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion-item">
                                                                @if (auth()->user()->hasPermission('assessmentResult.assessmentResult'))
                                                                <h2 class="accordion-header" id="headingTwo">
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionTwo"
                                                                        aria-expanded="false" aria-controls="accordionTwo">
                                                                        {{ __('assessment.PendingRisks') }}
                                                                    </button>
                                                                    @endif
                                                                </h2>
                                                                <div id="accordionTwo" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingTwo"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">

                                                                        <div class="row">

                                                                            @forelse($questionnaire->pendingRisks as $p_risk)
                                                                                <div class="col-md-6">
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <form
                                                                                                action="{{ route('admin.questionnaire-results.changeRiskStatus', $p_risk->id) }}"
                                                                                                id="" method="post">
                                                                                                @csrf
                                                                                                <input type="hidden"
                                                                                                    name="action_type"
                                                                                                    value="add_risk">
                                                                                                <input type="hidden"
                                                                                                    name="questionnaire_risk_id"
                                                                                                    value="{{ $p_risk->id }}">

                                                                                                <div
                                                                                                    class=" vertical wizard-modern modern-vertical-wizard-example">
                                                                                                    <div
                                                                                                        class="bs-stepper-content">
                                                                                                        <div id="risk_assessment"
                                                                                                            class="content"
                                                                                                            role="tabpanel"
                                                                                                            aria-labelledby="risk_assessment_toggle">
                                                                                                            <div class="row">

                                                                                                                <div
                                                                                                                    class="mb-1 col-md-12 risk_details">
                                                                                                                    <div
                                                                                                                        class="row">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="risk_subject">{{ __('assessment.Subject') }}</label>
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                value="{{ $p_risk->risk_subject }}"
                                                                                                                                class="form-control"
                                                                                                                                name="risk_subject">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-4">
                                                                                                                            <label
                                                                                                                                for="assessment_scoring_id">{{ __('assessment.RiskScoringMethod') }}</label>
                                                                                                                            <select
                                                                                                                                name="risk_scoring_method_id"
                                                                                                                                class="form-control select2">
                                                                                                                                @foreach ($data['riskScoringMethods'] as $method)
                                                                                                                                    <option
                                                                                                                                        value="{{ $method->id }}"
                                                                                                                                        {{ $p_risk->risk_scoring_method_id == $method->id ? 'selected' : '' }}>
                                                                                                                                        {{ $method->name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                        <div
                                                                                                                            class="col-md-4">
                                                                                                                            <label
                                                                                                                                for="current_likelihood_id">{{ __('assessment.CurrentLikelihood') }}</label>
                                                                                                                            <select
                                                                                                                                name="likelihood_id"
                                                                                                                                class="form-control select2">
                                                                                                                                @foreach ($data['likelihoods'] as $likelihood)
                                                                                                                                    <option
                                                                                                                                        value="{{ $likelihood->id }}"
                                                                                                                                        {{ $p_risk->likelihood_id == $likelihood->id ? 'selected' : '' }}>
                                                                                                                                        {{ $likelihood->name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                        <div
                                                                                                                            class="col-md-4">
                                                                                                                            <label
                                                                                                                                for="impact_id">{{ __('assessment.CurrentImpact') }}</label>
                                                                                                                            <select
                                                                                                                                name="impact_id"
                                                                                                                                class="form-control select2">
                                                                                                                                @foreach ($data['impacts'] as $impact)
                                                                                                                                    <option
                                                                                                                                        value="{{ $impact->id }}"
                                                                                                                                        {{ $p_risk->impact_id == $impact->id ? 'selected' : '' }}>
                                                                                                                                        {{ $impact->name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="owner_id">{{ __('assessment.Owner') }}</label>
                                                                                                                            <select
                                                                                                                                name="owner_id"
                                                                                                                                class="form-control select2">
                                                                                                                                @foreach ($data['enabledUsers'] as $user)
                                                                                                                                    <option
                                                                                                                                        value="{{ $user->id }}"
                                                                                                                                        {{ $p_risk->owner_id == $user->id ? 'selected' : '' }}>
                                                                                                                                        {{ $user->username }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="affected_assets">{{ __('assessment.AffectedAssets') }}</label>

                                                                                                                            <select
                                                                                                                                name="assets_ids[]"
                                                                                                                                class="form-control select2"
                                                                                                                                multiple>
                                                                                                                                @if (count($data['assetGroups']))
                                                                                                                                    <optgroup
                                                                                                                                        label="{{ __('assessment.AssetGroups') }}">

                                                                                                                                        @foreach ($data['assetGroups'] as $assetGroup)
                                                                                                                                            <option
                                                                                                                                                value="{{ $assetGroup->id }}_group"
                                                                                                                                                {{ in_array($assetGroup->id . '_group', json_decode($p_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                                {{ $assetGroup->name }}
                                                                                                                                            </option>
                                                                                                                                        @endforeach
                                                                                                                                    </optgroup>
                                                                                                                                @endif
                                                                                                                                <optgroup
                                                                                                                                    label="{{ __('assessment.Standards') }} {{ __('assessment.Assets') }}">
                                                                                                                                    @foreach ($data['assets'] as $asset)
                                                                                                                                        <option
                                                                                                                                            value="{{ $asset->id }}_asset"
                                                                                                                                            {{ in_array($asset->id . '_asset', json_decode($p_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                            {{ $asset->name }}
                                                                                                                                        </option>
                                                                                                                                    @endforeach
                                                                                                                                </optgroup>

                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="tags">{{ __('locale.Tags') }}</label>
                                                                                                                            <select
                                                                                                                                name="tags_ids[]"
                                                                                                                                class="form-control select2"
                                                                                                                                multiple>
                                                                                                                                @foreach ($data['tags'] as $tag)
                                                                                                                                    <option
                                                                                                                                        value="{{ $tag->id }}"
                                                                                                                                        {{ in_array($tag->id, json_decode($p_risk->tags_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                        {{ $tag->tag }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>


                                                                                                                    <div
                                                                                                                        class="row mt-2">
                                                                                                                        <div
                                                                                                                            class="col-md-12">
                                                                                                                            <label
                                                                                                                                for="migrationControls">{{ __('locale.Controls') }}</label>
                                                                                                                            <select
                                                                                                                                name="framework_controls_ids"
                                                                                                                                class="form-control select2">
                                                                                                                                @foreach ($data['migration_controls'] as $control)
                                                                                                                                    <option
                                                                                                                                        value="{{ $control->id }}"
                                                                                                                                        {{ $control->id == $p_risk->framework_controls_ids ? 'selected' : '' }}>
                                                                                                                                        {{ $control->name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>


                                                                                                    </div>

                                                                                                </div>
                                                                                                @if ($questionnaireAnswers->status == 'complete' && $questionnaireAnswers->approved_status == null)
                                                                                                    @if (auth()->user()->hasPermission('assessmentResult.assessmentResult'))
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button"
                                                                                                                class="btn btn-label-secondary btn-danger reject_risk"
                                                                                                                data-bs-dismiss="modal">Reject
                                                                                                                Risk</button>
                                                                                                            <button type="submit"
                                                                                                                class="btn btn-primary add_risk">{{ __('assessment.AddRisk') }}</button>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                @endif

                                                                                            </form>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            @empty
                                                                                {{ __('assessment.NoRisksFound') }}
                                                                            @endforelse


                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingThree">
                                                                    @if (auth()->user()->hasPermission('assessmentResult.assessmentResult'))
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionThree"
                                                                        aria-expanded="false" aria-controls="accordionThree">
                                                                        {{ __('assessment.AddedRisks') }}
                                                                    </button>
                                                                    @endif
                                                                </h2>
                                                                <div id="accordionThree" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingThree"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">


                                                                        @forelse($questionnaire->AddedRisks as $a_risk)
                                                                            <div class="col-md-6">
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <form action="" id=""
                                                                                            method="post">
                                                                                            @csrf

                                                                                            <div
                                                                                                class=" vertical wizard-modern modern-vertical-wizard-example">
                                                                                                <div class="bs-stepper-content">
                                                                                                    <div id="risk_assessment"
                                                                                                        class="content"
                                                                                                        role="tabpanel"
                                                                                                        aria-labelledby="risk_assessment_toggle">
                                                                                                        <div class="row">

                                                                                                            <div
                                                                                                                class="mb-1 col-md-12 risk_details">
                                                                                                                <div
                                                                                                                    class="row">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="risk_subject">{{ __('locale.Subject') }}</label>
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            value="{{ $a_risk->risk_subject }}"
                                                                                                                            class="form-control"
                                                                                                                            name="risk_subject">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="assessment_scoring_id">{{ __('assessment.RiskScoringMethod') }}</label>
                                                                                                                        <select
                                                                                                                            name="risk_scoring_method_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['riskScoringMethods'] as $method)
                                                                                                                                <option
                                                                                                                                    value="{{ $method->id }}"
                                                                                                                                    {{ $a_risk->risk_scoring_method_id == $method->id ? 'selected' : '' }}>
                                                                                                                                    {{ $method->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="current_likelihood_id">{{ __('assessment.CurrentLikelihood') }}</label>
                                                                                                                        <select
                                                                                                                            name="likelihood_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['likelihoods'] as $likelihood)
                                                                                                                                <option
                                                                                                                                    value="{{ $likelihood->id }}"
                                                                                                                                    {{ $a_risk->likelihood_id == $likelihood->id ? 'selected' : '' }}>
                                                                                                                                    {{ $likelihood->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="impact_id">{{ __('assessment.CurrentImpact') }}</label>
                                                                                                                        <select
                                                                                                                            name="impact_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['impacts'] as $impact)
                                                                                                                                <option
                                                                                                                                    value="{{ $impact->id }}"
                                                                                                                                    {{ $a_risk->impact_id == $impact->id ? 'selected' : '' }}>
                                                                                                                                    {{ $impact->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="owner_id">{{ __('assessment.Owner') }}</label>
                                                                                                                        <select
                                                                                                                            name="owner_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['enabledUsers'] as $user)
                                                                                                                                <option
                                                                                                                                    value="{{ $user->id }}"
                                                                                                                                    {{ $a_risk->owner_id == $user->id ? 'selected' : '' }}>
                                                                                                                                    {{ $user->username }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="affected_assets">{{ __('assessment.AffectedAssets') }}</label>

                                                                                                                        <select
                                                                                                                            name="assets_ids[]"
                                                                                                                            class="form-control select2"
                                                                                                                            multiple>
                                                                                                                            @if (count($data['assetGroups']))
                                                                                                                                <optgroup
                                                                                                                                    label="{{ __('assessment.AssetGroups') }}">
                                                                                                                                    @foreach ($data['assetGroups'] as $assetGroup)
                                                                                                                                        <option
                                                                                                                                            value="{{ $assetGroup->id }}_group"
                                                                                                                                            {{ in_array($assetGroup->id . '_group', json_decode($a_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                            {{ $assetGroup->name }}
                                                                                                                                        </option>
                                                                                                                                    @endforeach
                                                                                                                                </optgroup>
                                                                                                                            @endif
                                                                                                                            <optgroup
                                                                                                                                label="{{ __('assessment.Standards') }} {{ __('assessment.Assets') }}">
                                                                                                                                @foreach ($data['assets'] as $asset)
                                                                                                                                    <option
                                                                                                                                        value="{{ $asset->id }}_asset"
                                                                                                                                        {{ in_array($asset->id . '_asset', json_decode($a_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                        {{ $asset->name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </optgroup>

                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="tags">{{ __('locale.Tags') }}</label>
                                                                                                                        <select
                                                                                                                            name="tags_ids[]"
                                                                                                                            class="form-control select2"
                                                                                                                            multiple>
                                                                                                                            @foreach ($data['tags'] as $tag)
                                                                                                                                <option
                                                                                                                                    value="{{ $tag->id }}"
                                                                                                                                    {{ in_array($tag->id, json_decode($a_risk->tags_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                    {{ $tag->tag }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>


                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="migrationControls">{{ __('locale.Controls') }}</label>
                                                                                                                        <select
                                                                                                                            name="framework_controls_ids"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['migration_controls'] as $control)
                                                                                                                                <option
                                                                                                                                    value="{{ $control->id }}"
                                                                                                                                    {{ $control->id == $a_risk->framework_controls_ids ? 'selected' : '' }}>
                                                                                                                                    {{ $control->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                    </div>


                                                                                                </div>

                                                                                            </div>

                                                                                        </form>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        @empty
                                                                            {{ __('assessment.NoRisksFound') }}
                                                                        @endforelse

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingFour">
                                                                    @if (auth()->user()->hasPermission('assessmentResult.assessmentResult'))
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionFour"
                                                                        aria-expanded="false" aria-controls="accordionFour">
                                                                        {{ __('assessment.RejectedRisks') }}
                                                                    </button>
                                                                    @endif
                                                                </h2>
                                                                <div id="accordionFour" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingFour"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">

                                                                        @forelse($questionnaire->rejectedRisks as $r_risk)
                                                                            <div class="col-md-6">
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <form action="" id=""
                                                                                            method="post">
                                                                                            @csrf

                                                                                            <div
                                                                                                class=" vertical wizard-modern modern-vertical-wizard-example">
                                                                                                <div class="bs-stepper-content">
                                                                                                    <div id="risk_assessment"
                                                                                                        class="content"
                                                                                                        role="tabpanel"
                                                                                                        aria-labelledby="risk_assessment_toggle">
                                                                                                        <div class="row">

                                                                                                            <div
                                                                                                                class="mb-1 col-md-12 risk_details">
                                                                                                                <div
                                                                                                                    class="row">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="risk_subject">{{ __('assessment.Subject') }}</label>
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            value="{{ $r_risk->risk_subject }}"
                                                                                                                            class="form-control"
                                                                                                                            name="risk_subject">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="assessment_scoring_id">{{ __('assessment.RiskScoringMethod') }}</label>
                                                                                                                        <select
                                                                                                                            name="risk_scoring_method_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['riskScoringMethods'] as $method)
                                                                                                                                <option
                                                                                                                                    value="{{ $method->id }}"
                                                                                                                                    {{ $r_risk->risk_scoring_method_id == $method->id ? 'selected' : '' }}>
                                                                                                                                    {{ $method->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="current_likelihood_id">{{ __('assessment.CurrentLikelihood') }}</label>
                                                                                                                        <select
                                                                                                                            name="likelihood_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['likelihoods'] as $likelihood)
                                                                                                                                <option
                                                                                                                                    value="{{ $likelihood->id }}"
                                                                                                                                    {{ $r_risk->likelihood_id == $likelihood->id ? 'selected' : '' }}>
                                                                                                                                    {{ $likelihood->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="col-md-4">
                                                                                                                        <label
                                                                                                                            for="impact_id">{{ __('assessment.CurrentImpact') }}</label>
                                                                                                                        <select
                                                                                                                            name="impact_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['impacts'] as $impact)
                                                                                                                                <option
                                                                                                                                    value="{{ $impact->id }}"
                                                                                                                                    {{ $r_risk->impact_id == $impact->id ? 'selected' : '' }}>
                                                                                                                                    {{ $impact->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="owner_id">{{ __('assessment.Owner') }}</label>
                                                                                                                        <select
                                                                                                                            name="owner_id"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['enabledUsers'] as $user)
                                                                                                                                <option
                                                                                                                                    value="{{ $user->id }}"
                                                                                                                                    {{ $r_risk->owner_id == $user->id ? 'selected' : '' }}>
                                                                                                                                    {{ $user->username }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="affected_assets">{{ __('assessment.AffectedAssets') }}</label>

                                                                                                                        <select
                                                                                                                            name="assets_ids[]"
                                                                                                                            class="form-control select2"
                                                                                                                            multiple>
                                                                                                                            @if (count($data['assetGroups']))
                                                                                                                                <optgroup
                                                                                                                                    label="{{ __('locale.AssetGroups') }}">
                                                                                                                                    @foreach ($data['assetGroups'] as $assetGroup)
                                                                                                                                        <option
                                                                                                                                            value="{{ $assetGroup->id }}_group"
                                                                                                                                            {{ in_array($assetGroup->id . '_group', json_decode($r_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                            {{ $assetGroup->name }}
                                                                                                                                        </option>
                                                                                                                                    @endforeach
                                                                                                                                </optgroup>
                                                                                                                            @endif
                                                                                                                            <optgroup
                                                                                                                                label="{{ __('assessment.Standards') }} {{ __('assessment.Assets') }}">
                                                                                                                                @foreach ($data['assets'] as $asset)
                                                                                                                                    <option
                                                                                                                                        value="{{ $asset->id }}_asset"
                                                                                                                                        {{ in_array($asset->id . '_asset', json_decode($r_risk->assets_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                        {{ $asset->name }}
                                                                                                                                    </option>
                                                                                                                                @endforeach
                                                                                                                            </optgroup>

                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="tags">{{ __('locale.Tags') }}</label>
                                                                                                                        <select
                                                                                                                            name="tags_ids[]"
                                                                                                                            class="form-control select2"
                                                                                                                            multiple>
                                                                                                                            @foreach ($data['tags'] as $tag)
                                                                                                                                <option
                                                                                                                                    value="{{ $tag->id }}"
                                                                                                                                    {{ in_array($tag->id, json_decode($r_risk->tags_ids, true) ?? []) ? 'selected' : '' }}>
                                                                                                                                    {{ $tag->tag }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>


                                                                                                                <div
                                                                                                                    class="row mt-2">
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <label
                                                                                                                            for="migrationControls">{{ __('locale.Controls') }}</label>
                                                                                                                        <select
                                                                                                                            name="framework_controls_ids"
                                                                                                                            class="form-control select2">
                                                                                                                            @foreach ($data['migration_controls'] as $control)
                                                                                                                                <option
                                                                                                                                    value="{{ $control->id }}"
                                                                                                                                    {{ $control->id == $r_risk->framework_controls_ids ? 'selected' : '' }}>
                                                                                                                                    {{ $control->name }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                    </div>


                                                                                                </div>

                                                                                            </div>

                                                                                        </form>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        @empty
                                                                            {{ __('assessment.NoRisksFound') }}
                                                                        @endforelse
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingFive">
                                                                    @if (auth()->user()->hasPermission('assessmentResult.assessmentResult'))
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionFive"
                                                                        aria-expanded="false" aria-controls="accordionFive">
                                                                        {{ __('assessment.ComplianceAssessment') }}
                                                                    </button>
                                                                    @endif
                                                                </h2>

                                                                <div id="accordionFive" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingFive"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        {{--  <h2>Associated Frameworks</h2>
                                                                  @foreach ($questionnaire->assessment->questions as $index => $question)

                                                                      @if ($question->answer_type == 1)
                                                                          <div style="font-weight: bold">{{@$question->control->Frameworks?$question->control->Frameworks->first()->name:""}}</div>
                                                                      @endif
                                                                  @endforeach --}}
                                                                        <h2>Associated Controls</h2>
                                                                        <table class="table  table-bordered">

                                                                            <thead>
                                                                                <th>{{ __('assessment.AssociatedFrameworks') }}
                                                                                </th>
                                                                                <th>{{ __('assessment.Control') }}</th>
                                                                                <th>{{ __('locale.Status') }}</th>
                                                                            </thead>
                                                                            <tbody>

                                                                                @foreach ($questionnaireAnswers->results as $result)
                                                                                    @if ($result->answer_type == 1)
                                                                                        @if ($result->Answer)
                                                                                            @if ($result->question->control)
                                                                                                <tr>
                                                                                                    <td
                                                                                                        style="background-color: {{ @$result->Answer->fail_control == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer ? $result->Answer->question->control->Frameworks->first()->name : '' }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        style="background-color: {{ @$result->Answer->fail_control == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer->question->control->short_name }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        style="background-color: {{ @$result->Answer->fail_control == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer->fail_control ? 'Fail' : 'Pass' }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif

                                                                                @endforeach


                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingSix">
                                                                    @if (auth()->user()->hasPermission('assessmentResult.assessmentResult'))
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#accordionSix"
                                                                        aria-expanded="false" aria-controls="headingSix">
                                                                        {{ __('assessment.MaturityAssessment') }}
                                                                    </button>
                                                                    @endif
                                                                </h2>

                                                                <div id="accordionSix" class="accordion-collapse collapse"
                                                                    aria-labelledby="headingFive"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        {{--  <h2>Associated Frameworks</h2>
                                                                  @foreach ($questionnaire->assessment->questions as $index => $question)

                                                                      @if ($question->answer_type == 1)
                                                                          <div style="font-weight: bold">{{@$question->control->Frameworks?$question->control->Frameworks->first()->name:""}}</div>
                                                                      @endif
                                                                  @endforeach --}}
                                                                        {{--  <h2>Associated Controls</h2> --}}
                                                                        <table class="table  table-bordered">

                                                                            <thead>
                                                                                <th>{{ __('assessment.AssociatedFrameworks') }}
                                                                                </th>
                                                                                <th>{{ __('assessment.CurrentControlMaturity') }}
                                                                                </th>
                                                                                <th>{{ __('assessment.DesiredControlMaturity') }}
                                                                                </th>
                                                                            </thead>
                                                                            <tbody>


                                                                                @foreach ($questionnaireAnswers->results as $result)
                                                                                    @if ($result->answer_type == 1 && $result->question->maturity_assessment == 1)
                                                                                        @if ($result->Answer)
                                                                                            @if ($result->question->control)
                                                                                                <tr>

                                                                                                    <td
                                                                                                        style="background-color: {{ ($result->Answer ? $result->Answer->fail_control : '') == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer ? ($result->Answer->question->control ? $result->Answer->question->control->Frameworks->first()->name : '') : '' }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        style="background-color: {{ ($result->Answer ? $result->Answer->fail_control : '') == 1 ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->Answer ? ($result->Answer->maturity_control ? $result->Answer->maturity_control->name : '') : '' }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        style="background-color: {{ ($result->question->control->maturities[0] ? $result->question->control->maturities[0]->name : '') != ($result->Answer ? ($result->Answer->maturity_control ? $result->Answer->maturity_control->name : '') : '') ? '#d9c3c3' : '#7dc9a6' }} ">
                                                                                                        {{ @$result->question->control->maturities[0] ? @$result->question->control->maturities[0]->name : '' }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif

                                                                                @endforeach


                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endsection
        @section('vendor-script')
            <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>

            <script>
                $('.select2').select2();

                $('.add_risk').on('click', function(e) {
                    e.preventDefault();
                    $('input[name="action_type"]').val('add_risk');
                    $(this).parents('form').submit();
                });
                $('.reject_risk').on('click', function(e) {
                    e.preventDefault();
                    $('input[name="action_type"]').val('reject_risk');
                    $(this).parents('form').submit();
                })
            </script>

        @endsection
