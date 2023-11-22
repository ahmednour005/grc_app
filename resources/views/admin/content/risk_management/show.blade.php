@extends('admin/layouts/contentLayoutMaster')

@section('title', __('risk.ViewRisk'))
@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<style>
    @media (max-width: 576px) {
        .text-sm-only-center {
            text-align: center
        }
    }

    .text-label {
        font-size: 1.1rem;
        font-weight: 900;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    #impact-detail-btn svg,
    #likelihood-detail-btn svg,
    .delete_supporting_documentation svg {
        width: 25px;
        height: 25px;
    }

    .highcharts-credits {
        display: none;
    }

</style>
@endsection
@section('content')
<!-- main risk data start -->
<div class="row">
    <div class="col-12">
        <div class="card risk-session">
            <div class="card-body row mx-0">
                <div class="col-12 col-md-6 col-lg-3 row mx-0 px-0 justify-content-evenly align-items-center" style="font-size: 1.2rem">
                    {{-- InherentRisk --}}
                    <div class="text-black col-5 row mx-0 px-0 py-2 justify-content-center align-items-center text-center" style="font-weight: 900; background-color: {{ $data['calculated_risk_data']['color'] }}; height:130px">
                        <p class="m-0 p-0">{{ __('risk.InherentRisk') }}</p>
                        <p class="m-0 p-0" style="font-size: 2rem" id="inherent_risk_score">
                            {{ $data['calculated_risk'] }}</p>
                        <p class="m-0 p-0">{{ $data['calculated_risk_data']['name'] }}</p>
                    </div>
                    {{-- ResidualRisk --}}
                    <div class="text-black col-5 row mx-0 px-0 py-2 justify-content-center align-items-center text-center" style="font-weight: 900; background-color: {{ $data['residual_risk_data']['color'] }}; height:130px">
                        <p class="m-0 p-0">{{ __('risk.ResidualRisk') }}</p>
                        <p class="m-0 p-0" style="font-size: 2rem" id="residual_risk_score">
                            {{ $data['residual_risk'] }}</p>
                        <p class="m-0 p-0">{{ $data['residual_risk_data']['name'] }}</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-9 text-sm-only-center">
                    <div class="row justify-content-between px-0 text-left">
                        {{-- status --}}
                        <div class="col-12 col-md-6 col-lg-4 row mx-0 px-0">
<div class="col-12 col-md-6 mt-1 mt-md-0 px-0"><label>{{ __('locale.ID') }} #: <span class="display-6">{{ __($data['id']
                                        + 1000) }}</span></label>
                            </div>
<div class="col-12 col-md-6 my-1 my-md-0 px-0"><label>{{ __('locale.Status') }}: <span class="display-6">{{
                                        __($data['status']) }}</span></label></div>
                        </div>
                        {{-- Actions --}}
                        <div class="col-12 col-md-6 col-lg-4 row mx-0 px-0">
                            <div class="">
                                <select class="form-control dt-input dt-select select20 " id="risk-actions" data-column="3" data-column-index="2" data-id="{{ $data['id'] }}">
                                    <option disabled hidden selected value="">{{ __('locale.Actions') }}</option>
                                    @if($data['status'] == 'Closed')
                                    <option value="ReopenRisk">{{ __('risk.ReopenRisk') }}</option>
                                    @else
                                    @if (auth()->user()->hasPermission('riskmanagement.AbleToCloseRisks'))
                                        <option value="CloseRisk">{{ __('risk.CloseRisk') }}</option>
                                    @endif
                                    @endif
                                    @if (auth()->user()->hasPermission('riskmanagement.update'))
                                    <option value="EditRisk">{{ __('risk.EditRisk') }}</option>
                                    @endif
                                    <option value="PlanAMitigation">{{ __('risk.PlanAMitigation') }}</option>
                                    @if (auth()->user()->hasPermission('perform_reviews.create'))
                                    <option value="PerformAReview">{{ __('risk.PerformAReview') }}</option>
                                    @endif
                                    <option value="ChangeStatus">{{ __('locale.ChangeStatus') }}</option>
                                    @if (auth()->user()->hasPermission('riskmanagement.AbleToCommentRiskManagement'))
                                    <option value="AddAComment">{{ __('risk.AddAComment') }}</option>
                                    @endif
                                    <option value="ResetMitigations">{{ __('risk.ResetMitigations') }}</option>
                                    @if (auth()->user()->hasPermission('perform_reviews.create'))
                                    <option value="ResetReviews">{{ __('risk.ResetReviews') }}</option>
                                    @endif
                                    {{-- <option value="PrintableView">{{ __('locale.PrintableView') }}</option> --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- Subject --}}
                    <div class="row justify-content-between px-0">
                        <div id="static-subject" class="px-0"><label>{{ __('locale.Subject') }} :
                                <span class="display-6" id="subject-text">{{ $data['subject'] }}</span>
                                @if (auth()->user()->hasPermission('riskmanagement.update'))
                                <span id="edit-subject" class="display-6" style="cursor: pointer"><i data-feather="edit" style="width: 24px; height: 24px;margin-right: 5px;margin-left: 5px;"></i></span>
                                @endif
                            </label></div>
                        @if (auth()->user()->hasPermission('riskmanagement.update'))
                            <form id="edit-subject-form" method="post" action="/" class="px-0">
                                @csrf
                                <div class="col-12 row mx-0 px-0 align-content-center d-none" id="edit-subject-container">
                                    <div class="col-12 col-lg-8 mx-0 px-0 mb-1 row">
                                        <label class="col-12 col-md-2 col-form-label">{{ __('locale.Subject') }}</label>
                                        <div class="col-12 col-md-10">
                                            <input type="text" class="form-control" value="{{ $data['subject'] }}" data-value="{{ $data['subject'] }}" name="subject">
                                            <span class="error error-subject"></span>
                                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 text-center">
                                        <button id="cancel-edit-subject" class="button btn btn-danger" type="button">{{ __('locale.Cancel') }}</button>
                                        <button id="submit-edit-subject" class="button btn btn-success" type="button">{{ __('locale.Submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- RiskScoringDetails start -->
            <section>
                <div class="row mx-0">
                    <div class="col-sm-12">
                        <div class="card mb-1">
                            <div class="card-header py-0">
                                <div class="head-label">
                                    <button id="RiskScoringDetailsBtn" class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" data-bs-target="#RiskScoringDetails" aria-expanded="false" aria-controls="RiskScoringDetails" data-showtext="{{ __('risk.ShowRiskScoringDetails') }}" data-hidetext=" {{ __('risk.HideRiskScoringDetails') }}" data-showstatus="0">
                                        {{ __('risk.ShowRiskScoringDetails') }}
                                    </button>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <div class="collapse" id="RiskScoringDetails">
                                    <div class="row mx-0">
                                        <h3 class="my-1 p-0 col-12 col-md-6">
                                            {{ __('locale.' . $data['risk_scoring']['name'] . 'RiskScoring') }}</h3>
                                        @if (auth()->user()->hasPermission('riskmanagement.update'))
                                            <div class="col-12 col-md-6" style="text-align: right">
                                                <button id="UpdateClassicScoreShowBtn" type="button" class="btn btn-secondary me-1">
                                                    {{ __('locale.UpdateClassicScore') }}</button>
                                        @endif
                                        </div>
                                        <p class="card-text mt-1">
                                            <span class="d-block mb-1"><label class="text-label">{{ __('risk.Impact') }}</label> :
                                                [{{ $data['impact']['id'] }}] {{ $data['impact']['name'] }}</span>
                                            <span class="d-block"><label class="text-label">{{ __('risk.Likelihood') }}</label> :
                                                [{{ $data['likelihood']['id'] }}]
                                                {{ $data['likelihood']['name'] }}</span>
                                        </p>
                                        <h3 class="my-1 p-0 col-12 col-md-6">
                                            @if (get_setting('risk_model') == 1)
                                            {{ __('locale.RISKClassicExp1') . ' x ( 10 / 35 ) = ' . $data['calculated_risk'] }}
                                            @elseif (get_setting('risk_model') == 2)
                                            {{ __('locale.RISKClassicExp2') . ' x ( 10 / 30 ) = ' . $data['calculated_risk'] }}
                                            @elseif (get_setting('risk_model') == 3)
                                            {{ __('locale.RISKClassicExp3') . ' x ( 10 / 25 ) = ' . $data['calculated_risk'] }}
                                            @elseif (get_setting('risk_model') == 4)
                                            {{ __('locale.RISKClassicExp4') . ' x ( 10 / 30 ) = ' . $data['calculated_risk'] }}
                                            @elseif (get_setting('risk_model') == 5)
                                            {{ __('locale.RISKClassicExp5') . ' x ( 10 / 35 ) = ' . $data['calculated_risk'] }}
                                            @endif
                                        </h3>
                                    </div>
                                    @if (auth()->user()->hasPermission('riskmanagement.update'))                                        
                                        <form class="row px-0" id="edit-risk-scoring-form" method="post" action="/" style="display: none">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                                            <div class="row mx-0">
                                                <div class="col-12 col-md-6 mb-1">
                                                    {{-- Current Likelihood --}}
                                                    <div class="mb-1 row">
                                                        <div class="col-11">
                                                            <label class="form-label ">{{ __('risk.CurrentLikelihood') }}</label>
                                                            <select class="select2 form-select d-inline" name="current_likelihood_id">
                                                                <option value="" disabled hidden selected>
                                                                    {{ __('locale.select-option') }}</option>
                                                                @foreach ($riskLikelihoods as $riskLikelihood)
                                                                <option value="{{ $riskLikelihood->id }}" {{ $data['likelihood']['id'] == $riskLikelihood->id ? 'selected' : '' }}>
                                                                    {{ $riskLikelihood->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div id="likelihood-detail-btn" class="col-1 cursor-pointer" style="margin-top: 2.2rem !important;">
                                                            <i data-feather='info' class="text-danger"></i>
                                                        </div>
                                                        <span class="error error-current_likelihood_id"></span>
                                                    </div>
                                                    {{-- Current Impact --}}
                                                    <div class="mb-1 row">
                                                        <div class="col-11">

                                                            <label class="form-label ">{{ __('risk.CurrentImpact') }}</label>
                                                            <select class="select2 form-select" name="current_impact_id">
                                                                <option value="" disabled hidden selected>
                                                                    {{ __('locale.select-option') }}</option>
                                                                @foreach ($impacts as $impact)
                                                                <option value="{{ $impact->id }}" {{ $data['impact']['id'] == $impact->id ? 'selected' : '' }}>
                                                                    {{ $impact->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div id="impact-detail-btn" class="col-1 cursor-pointer" style="margin-top: 2.2rem !important;">
                                                            <i data-feather='info' class="text-danger"></i>
                                                        </div>
                                                        <span class="error error-current_impact_id"></span>
                                                    </div>
                                                    <button id="update-edit-risk-scoring" type="button" class="btn btn-success me-1">{{ __('locale.Update') }}</button>
                                                    <button id="cancel-edit-risk-scoring" class="button btn btn-danger" type="button">{{ __('locale.Cancel') }}</button>
                                                </div>
                                                <div class="col-12 col-md-6 mb-1">
                                                    <div id="impact-detail" style="display: none">
                                                        <p class="card-text mt-1"><b>{{ $impacts[0]['name'] ?? '' }}</b>
                                                            No impact on service, no impact on reputation, complaint
                                                            unlikely, or litigation risk remote.</p>
                                                        <hr>
                                                        <p class="card-text mt-1"><b>{{ $impacts[1]['name'] ?? '' }}</b>
                                                            Slight impact on service, slight impact on reputation, complaint
                                                            possible, or litigation possible.</p>
                                                        <hr>
                                                        <p class="card-text mt-1"><b>{{ $impacts[2]['name'] ?? '' }}</b>
                                                            Some service disruption, potential for adverse publicity
                                                            (avoidable with careful handling), complaint probable, or
                                                            litigation probably.</p>
                                                        <hr>
                                                        <p class="card-text mt-1"><b>{{ $impacts[3]['name'] ?? '' }}</b>
                                                            Service disrupted, adverse publicity not avoidable (local
                                                            media), complaint probably, or litigation probable.</p>
                                                        <hr>
                                                        <p class="card-text mt-1"><b>{{ $impacts[4]['name'] ?? '' }}</b>
                                                            Service interrupted for significant time, major adverse
                                                            publicity not avoidable (national media), major litigation
                                                            expected, resignation of senior management and board, or loss of
                                                            benficiary confidence.</p>
                                                    </div>
                                                    <div id="likelihood-detail" style="display: none">
                                                        <p class="card-text mt-1"><b>
                                                                {{ $riskLikelihoods[0]['name'] ?? '' }} </b> May only
                                                            occur in exceptional circumstances.</p>
                                                        <hr>
                                                        <p class="card-text mt-1"> <b>
                                                                {{ $riskLikelihoods[1]['name'] ?? '' }} </b> Expected to
                                                            occur in a few circumstances.</p>
                                                        <hr>
                                                        <p class="card-text mt-1"><b>
                                                                {{ $riskLikelihoods[2]['name'] ?? '' }} </b> Expected to
                                                            occur in some circumstances.</p>
                                                        <hr>
                                                        <p class="card-text mt-1"><b>
                                                                {{ $riskLikelihoods[3]['name'] ?? '' }} </b> Expected to
                                                            occur in many circumstances.</p>
                                                        <hr>
                                                        <p class="card-text mt-1"><b>
                                                                {{ $riskLikelihoods[4]['name'] ?? '' }} </b> Expected to
                                                            occur frequently and in most circumstances.</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    @endif                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- RiskScoringDetails end -->

            <!-- RiskScoreOverTime start -->
            <section>
                <div class="row mx-0">
                    <div class="col-sm-12">
                        <div class="card mb-1">
                            <div class="card-header py-1">
                                <div class="head-label">
                                    <button id="RiskScoreOverTimeBtn" class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" data-bs-target="#RiskScoreOverTime" aria-expanded="false" aria-controls="RiskScoreOverTime" data-showtext="{{ __('risk.ShowRiskScoreOverTime') }}" data-hidetext=" {{ __('risk.HideRiskScoreOverTime') }}" data-showstatus="0" data-riskId="{{ $data['id'] }}">
                                        {{ __('risk.ShowRiskScoreOverTime') }}
                                    </button>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <div class="collapse" id="RiskScoreOverTime">

                                </div>
                                <input type="hidden" id="_RiskScoringHistory" value="{{ __('risk.RiskScoringHistory') }}">
                                <input type="hidden" id="_RiskScore" value="{{ __('risk.InherentRisk') }}">
                                <input type="hidden" id="_ResidualRiskScore" value="{{ __('risk.ResidualRisk') }}">
                                <input type="hidden" id="_DateAndTime" value="{{ __('locale.DateAndTime') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- RiskScoreOverTime end -->
        </div>
    </div>
</div>
<!-- main risk data End -->

<!-- Basic tabs start -->
<section id="basic-tabs-components" class="main-containers">
    <div class="row match-height">
        <!-- Basic Tabs starts -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        {{-- Details --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" aria-controls="details" role="tab" aria-selected="true">{{ __('locale.Details') }}</a>
                        </li>
                        {{-- Mitigation --}}
                        <li class="nav-item">
                            <a class="nav-link" id="mitigation-tab" data-bs-toggle="tab" href="#mitigation" aria-controls="mitigation" role="tab" aria-selected="false">{{ __('risk.Mitigation') }}</a>
                        </li>
                        {{-- Review --}}
                        <li class="nav-item">
                            <a class="nav-link" id="review-tab" data-bs-toggle="tab" href="#review" aria-controls="review" role="tab" aria-selected="false">{{ __('locale.Review') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        {{-- Details tab --}}
                        <div class="tab-pane active" id="details" aria-labelledby="details-tab" role="tabpanel">
                            <div class="row" id="static-details">
                                <div class="col-12">
                                    {{-- Risk Mapping --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.RiskMapping') }}</label> :
                                        @foreach ($data['riskCatalogs'] as $riskCatalog)
                                        <span class="badge bg-secondary">{{ $riskCatalog['name'] }}</span>
                                        @endforeach
                                    </div>
                                    {{-- Threat Mapping --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.ThreatMapping') }}</label> :
                                        @foreach ($data['threatCatalogs'] as $threatCatalog)
                                        <span class="badge bg-secondary">{{ $threatCatalog['name'] }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{-- Submission date --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.SubmissionDate') }}</label> :
                                        {{ format_date($data['submission_date'], 'N/A') }}
                                    </div>
                                    {{-- Category --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.Category') }}</label> :
                                        {{ $data['category']['name'] ?? '' }}
                                    </div>
                                    {{-- Site Location --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.SiteLocation') }}</label> :
                                        @foreach ($data['locations'] as $location)
                                        <span class="badge bg-secondary">{{ $location['name'] }}</span>
                                        @endforeach
                                    </div>
                                    {{-- External Reference Id --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.ExternalReferenceId') }}</label>
                                        : {{ $data['reference_id'] }}
                                    </div>
                                    {{-- Control Regulation --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.ControlRegulation') }}</label>
                                        :
                                        {{ $data['framework']['name'] ?? '' }}
                                    </div>
                                    {{-- Control Number --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.ControlNumber') }}</label> :
                                        @if (isset($data['control']))
                                        <b>({{ $data['control']['id'] ?? '' }})</b>
                                        {{ $data['control']['short_name'] ?? '' }}
                                        @endif
                                    </div>
                                    {{-- Affected Assets --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.AffectedAssets') }}</label> :
                                        <p class="mx-2">{{ __('risk.AssetGroups') }} :
                                            @foreach ($data['assetGroups'] as $asset)
                                            <span class="badge bg-secondary">{{ $asset['name'] }}</span>
                                            @endforeach
                                        </p>
                                        <p class="mx-2">{{ __('locale.Standards') }}
                                            {{ __('locale.Assets') }} :
                                            @foreach ($data['assets'] as $asset)
                                            <span class="badge bg-secondary">{{ $asset['name'] }}</span>
                                            @endforeach
                                        </p>
                                    </div>

                                    {{-- Technology --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.Technology') }}</label> :
                                        @foreach ($data['technologies'] as $technology)
                                        <span class="badge bg-secondary">{{ $technology['name'] }}</span>
                                        @endforeach
                                    </div>
                                    {{-- Team --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.Team') }}</label> :
                                        @foreach ($data['teams'] as $team)
                                        <span class="badge bg-secondary">{{ $team['name'] }}</span>
                                        @endforeach
                                    </div>
                                    {{-- AdditionalStakeholders --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.AdditionalStakeholders') }}</label>
                                        :
                                        @foreach ($data['additional_stakeholders'] as $additionalStakeholder)
                                        <span class="badge bg-secondary">{{ $additionalStakeholder['name'] }}</span>
                                        @endforeach
                                    </div>
                                    {{-- Owner --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.Owner') }}</label> :
                                        {{ $data['owner']['name'] ?? '' }}
                                    </div>
                                    {{-- OwnersManager --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.OwnersManager') }}</label> :
                                        {{ $data['owner_manager']['name'] ?? '' }}
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{-- Submitted By --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.SubmittedBy') }}</label> :
                                        {{ $data['submitted_by']['name'] ?? '' }}
                                    </div>
                                    {{-- Risk Source --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.RiskSource') }}</label> :
                                        {{ $data['source']['name'] ?? '' }}
                                    </div>
                                    {{-- Risk Scoring Method --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.RiskScoringMethod') }}</label>
                                        :
                                        {{ $data['risk_scoring']['name'] ?? '' }}
                                    </div>
                                    {{-- Current Likelihood --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.CurrentLikelihood') }}</label>
                                        :
                                        {{ $data['likelihood']['name'] ?? '' }}
                                    </div>
                                    {{-- Current Impact --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.CurrentImpact') }}</label> :
                                        {{ $data['impact']['name'] ?? '' }}
                                    </div>
                                    {{-- Risk Assessment --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.RiskAssessment') }}</label> :
                                        <div style="max-height: 100px;   overflow: auto;">
                                            {{ $data['assessment'] }}
                                        </div>
                                    </div>
                                    {{-- Additional Notes --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.AdditionalNotes') }}</label> :
                                        <div style="max-height: 100px;   overflow: auto;">
                                            {{ $data['notes'] }}
                                        </div>
                                    </div>
                                    {{-- Supporting Documentation --}}
                                    <div class="mb-1 supporting_documentation_container">
                                        <label class="text-label">{{ __('risk.SupportingDocumentation') }}</label>
                                        :
                                        @forelse($data['files'] ?? [] as $file)
                                        <span class="badge bg-secondary supporting_documentation cursor-pointer" style="margin-bottom: 5px" data-id="{{ $file['id'] }}" data-risk-id="{{ $data['id'] }}">{{ $file['name'] }}</span>
                                        @empty
                                        <span class="mx-2 text-danger">{{ __('locale.NONE') }}</span>
                                        @endforelse
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('riskmanagement.update'))                                    
                                <div class="col-12">
                                    <div class="row m-0 justify-content-center">
                                        <button id="edit-details" type="button" class="btn btn-secondary col-12 col-md-6">
                                            {{ __('locale.EditDetails') }}</button>
                                    </div>
                                </div>
                                @endif                                        
                            </div>
                            @if (auth()->user()->hasPermission('riskmanagement.update'))                                
                            <form class="row d-none px-0" id="edit-details-form" method="post" action="{{ route('admin.risk_management.ajax.update') }}">
                                @csrf
                                @method('put')
                                <input type="hidden" name="id" value="{{ $data['id'] }}">
                                <div class="col-12">
                                    {{-- Risk Mapping --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.RiskMapping') }}</label>
                                        <select name="risk_catalog_mapping_id[]" class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($riskGroupings as $riskGrouping)
                                            <optgroup label="{{ $riskGrouping->name }}">
                                                @foreach ($riskGrouping->RiskCatalogs as $riskCatalog)
                                                <option value="{{ $riskCatalog->id }}" {{ $data['risk_catalog_mapping'] == $riskCatalog->id ? 'selected' : '' }}>
                                                    {{ $riskCatalog->number . ' - ' . $riskCatalog->name }}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                        <span class="error error-risk_catalog_mapping_id"></span>
                                    </div>
                                    {{-- Threat Mapping --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.ThreatMapping') }}</label>
                                        <select name="threat_catalog_mapping_id[]" class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($threatGroupings as $threatGrouping)
                                            <optgroup label="{{ $threatGrouping->name }}">
                                                @foreach ($threatGrouping->ThreatCatalogs as $ThreatCatalog)
                                                <option value="{{ $ThreatCatalog->id }}" {{ $data['threat_catalog_mapping'] == $ThreatCatalog->id ? 'selected' : '' }}>
                                                    {{ $ThreatCatalog->number . ' - ' . $ThreatCatalog->name }}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                        <span class="error error-threat_catalog_mapping_id"></span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    {{-- Submission date --}}
                                    <div class=" mb-1">
                                        <label class="form-label">
                                            {{ __('locale.SubmissionDate') }}</label>
                                        <input name="submission_date" class="form-control flatpickr-date-time-compliance" value="{{ format_date($data['submission_date'], 'N/A') }}" />
                                        <span class="error error-submission_date "></span>
                                    </div>
                                    {{-- Category --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.Category') }}</label>
                                        <select class="select2 form-select" name="category_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $data['category_id'] == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-category_id"></span>
                                    </div>
                                    {{-- Site Location --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.SiteLocation') }}</label>
                                        <select class="form-select multiple-select2" name="location_id[]" multiple="multiple">
                                            @foreach ($locations as $location)
                                            <option value="{{ $location->id }}" {{ in_array($location->id, $data['location_ids']) ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-location_id"></span>
                                    </div>
                                    {{-- External Reference Id --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.ExternalReferenceId') }}</label>
                                        <input type="text" name="reference_id" class="form-control dt-post" aria-label="{{ __('locale.ExternalReferenceId') }}" value="{{ $data['reference_id'] }}" />
                                        <span class="error error-reference_id "></span>
                                    </div>
                                    {{-- Control Regulation --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.ControlRegulation') }}</label>
                                        <select class="select2 form-select" name="framework_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($frameworks as $framework)
                                            <option value="{{ $framework->id }}" data-controls="{{ json_encode($framework->FrameworkControls) }}" {{ $data['regulation'] == $framework->id ? 'selected' : '' }}>
                                                {{ $framework->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-framework_id"></span>
                                    </div>
                                    {{-- Control Number --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.ControlNumber') }}</label>

                                        <select class="select2 form-select" name="control_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($data['framework_controls'] as $frameworkControl)
                                            <option value="{{ $frameworkControl['id'] }}" {{ $data['control_id'] == $frameworkControl['id'] ? 'selected' : '' }}>
                                                {{ $frameworkControl['short_name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-control_id"></span>
                                    </div>
                                    {{-- Affected Assets --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.AffectedAssets') }}</label>
                                        <select name="affected_asset_id[]" class="form-select multiple-select2" multiple="multiple">
                                            @if (count($assetGroups))
                                            <optgroup label="{{ __('risk.AssetGroups') }}">
                                                @foreach ($assetGroups as $assetGroup)
                                                <option value="{{ $assetGroup->id }}_group" {{ in_array($assetGroup->id, $data['assetGroup_ids']) ? 'selected' : '' }}>
                                                    {{ $assetGroup->name }}</option>
                                                @endforeach
                                            </optgroup>
                                            @endif
                                            <optgroup label="{{ __('locale.Standards') }} {{ __('locale.Assets') }}">
                                                @foreach ($assets as $asset)
                                                <option value="{{ $asset->id }}_asset" {{ in_array($asset->id, $data['asset_ids']) ? 'selected' : '' }}>
                                                    {{ $asset->name }}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <span class="error error-affected_asset_id"></span>
                                    </div>
                                    {{-- Technology --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.Technology') }}</label>
                                        <select name="technology_id[]" class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($technologies as $technology)
                                            <option value="{{ $technology->id }}" {{ in_array($technology->id, $data['technology_ids']) ? 'selected' : '' }}>
                                                {{ $technology->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-technology_id"></span>
                                    </div>
                                    {{-- Team --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.Team') }}</label>
                                        <select name="team_id[]" class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($teams as $team)
                                            <option value="{{ $team->id }}" {{ in_array($team->id, $data['team_ids']) ? 'selected' : '' }}>
                                                {{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-team_id"></span>
                                    </div>
                                    {{-- AdditionalStakeholders --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.AdditionalStakeholders') }}</label>
                                        <select name="additional_stakeholder_id[]" class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($enabledUsers as $additionalStakeholder)
                                            <option value="{{ $additionalStakeholder->id }}" {{ in_array($additionalStakeholder->id, $data['additionalStakeholder_ids']) ? 'selected' : '' }}>
                                                {{ $additionalStakeholder->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-additional_stakeholder_id"></span>
                                    </div>
                                    {{-- Owner --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.Owner') }}</label>
                                        <select class="select2 form-select" name="owner_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($owners as $owner)
                                            <option value="{{ $owner->id }}" data-manager="{{ json_encode($owner->manager) }}" {{ $data['owner_id'] == $owner['id'] ? 'selected' : '' }}>
                                                {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-owner_id"></span>
                                    </div>
                                    {{-- OwnersManager --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('locale.OwnersManager') }}</label>
                                        <select class="select2 form-select" name="owner_manager_id" data-ownerSelected={{ $data['manager_id'] ? 1 : 0 }}>
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}</option>
                                        </select>
                                        <span class="error error-owners_manager_id"></span>
                                    </div>

                                </div>

                                <div class="col-12 col-md-6">
                                    {{-- Risk Source --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.RiskSource') }}</label>
                                        <select class="select2 form-select" name="risk_source_id">
                                            <option value="" selected>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($riskSources as $riskSource)
                                            <option value="{{ $riskSource->id }}" {{ $data['source_id'] == $riskSource->id ? 'selected' : '' }}>
                                                {{ $riskSource->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-risk_source_id"></span>
                                    </div>
                                    {{-- Risk Scoring Method --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.RiskScoringMethod') }}</label>
                                        <select class="select2 form-select" name="risk_scoring_method_id">
                                            <option value="" selected disabled hidden>
                                                {{ __('locale.select-option') }}
                                            </option>
                                            @foreach ($riskScoringMethods as $riskScoringMethod)
                                            <option value="{{ $riskScoringMethod->id }}" {{ $data['risk_scoring']['id'] == $riskScoringMethod->id ? 'selected' : '' }}>
                                                {{ $riskScoringMethod->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-risk_scoring_method_id"></span>
                                    </div>
                                    {{-- Current Likelihood --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.CurrentLikelihood') }}</label>
                                        <select class="select2 form-select" name="current_likelihood_id">
                                            <option value="" disabled hidden selected>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($riskLikelihoods as $riskLikelihood)
                                            <option value="{{ $riskLikelihood->id }}" {{ $data['likelihood']['id'] == $riskLikelihood->id ? 'selected' : '' }}>
                                                {{ $riskLikelihood->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-current_likelihood_id"></span>
                                    </div>
                                    {{-- Current Impact --}}
                                    <div class="mb-1">
                                        <label class="form-label ">{{ __('risk.CurrentImpact') }}</label>
                                        <select class="select2 form-select" name="current_impact_id">
                                            <option value="" disabled hidden selected>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($impacts as $impact)
                                            <option value="{{ $impact->id }}" {{ $data['impact']['id'] == $impact->id ? 'selected' : '' }}>
                                                {{ $impact->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-current_impact_id"></span>
                                    </div>
                                    {{-- Risk Assessment --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('risk.RiskAssessment') }}</label>
                                        <textarea class="form-control" name="risk_assessment" rows="3">{{ $data['assessment'] }}</textarea>
                                        <span class="error error-risk_assessment "></span>
                                    </div>
                                    {{-- Additional Notes --}}
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.AdditionalNotes') }}</label>
                                        <textarea class="form-control" name="additional_notes" rows="3">{{ $data['notes'] }}</textarea>
                                        <span class="error error-additional_notes "></span>
                                    </div>
                                    {{-- Supporting Documentation --}}
                                    <div class="mb-1 supporting_documentation_container">
                                        <label class="text-label">{{ __('risk.SupportingDocumentation') }}</label>
                                        :
                                        <input type="file" multiple name="supporting_documentation[]" class="form-control dt-post" aria-label="{{ __('risk.SupportingDocumentation') }}" />
                                        <span class="error error-supporting_documentation "></span>
                                        @forelse($data['files'] ?? [] as $file)
                                        <div>
                                            <span class="badge bg-secondary supporting_documentation cursor-pointer" data-id="{{ $file['id'] }}" data-risk-id="{{ $data['id'] }}">{{ $file['name'] }}</span>
                                            <span class="text-danger delete_supporting_documentation cursor-pointer" data-id="{{ $file['id'] }}" data-risk-id="{{ $data['id'] }}"><i data-feather="x"></i></span>
                                        </div>
                                        @empty
                                        <span class="mx-2 text-danger">{{ __('locale.NONE') }}</span>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-12">
                                    {{-- Tags --}}
                                    <div class="mb-1">
                                        <label class="form-label"> {{ __('risk.Tags') }}</label>
                                        <select name="tags[]" class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}" {{ in_array($tag->id, $data['tag_ids']) ? 'selected' : '' }}>
                                                {{ $tag->tag }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-tags "></span>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-2">
                                    <button id="submit-edit-details" type="button" class="btn btn-primary me-1">
                                        {{ __('locale.SaveDetails') }}</button>
                                    <button id="cancel-edit-details" type="reset" class="btn btn-danger">
                                        {{ __('locale.Cancel') }}</button>
                                </div>

                            </form>
                            @endif                                    
                        </div>

                        {{-- Mitigation tab --}}
                        <div class="tab-pane" id="mitigation" aria-labelledby="mitigation-tab" role="tabpanel">
                            <div class="row" id="static-mitigation">
                                <div class="col-12 col-md-6">
                                    {{-- Mitigation Date --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationDate') }}</label> :
                                        {{ format_date($data['mitigation']['mitigation_date'], 'N/A') }}
                                    </div>
                                    {{-- Mitigation Planning Date --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationPlanning') }}</label>
                                        :
                                        {{ $data['mitigation']['planning_date'] ?? '' }}
                                    </div>
                                    {{-- Planning Strategy --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.PlanningStrategy') }}</label> :
                                        {{ $data['mitigation']['planning_strategy'] ?? '' }}
                                    </div>
                                    {{-- Mitigation Effort --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationEffort') }}</label> :
                                        {{ $data['mitigation']['mitigation_effort'] ?? '' }}
                                    </div>
                                    {{-- MitigationCost --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationCost') }}</label> :
                                        {{ $data['mitigation']['mitigation_cost'] ?? '' }}
                                    </div>
                                    {{-- Mitigation Owner --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationOwner') }}</label> :
                                        {{ $data['mitigation']['mitigation_owner'] ?? '' }}
                                    </div>
                                    {{-- Mitigation Team --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationTeam') }}</label> :
                                        @foreach ($data['mitigation']['mitigation_team'] as $team)
                                        <span class="badge bg-secondary">{{ $team['name'] }}</span>
                                        @endforeach
                                    </div>
                                    {{-- Mitigation Percent --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationPercent') }}</label>
                                        :
                                        {{ (isset($data['mitigation']['mitigation_percent']) && $data['mitigation']['mitigation_percent'] >= 0 && $data['mitigation']['mitigation_percent'] <= 100 ? $data['mitigation']['mitigation_percent'] : 0) . ' %' }}
                                    </div>
                                    {{-- Accept Mitigation --}}
                                    @if (auth()->user()->hasPermission('plan_mitigation.accept'))                                        
                                    <div class="mb-1">
                                        <div class="card mb-0">
                                            <div class="card-body p-0">
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($data['mitigation']['accepted_mitigations'] as $accepted_mitigation)
                                                    <li class="list-group-item">
                                                        {{ __('risk.MitigationAcceptedByUserOnTime', ['name' => $accepted_mitigation['name'], 'date' => $accepted_mitigation['date'], 'time' => $accepted_mitigation['time']]) }}
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @if ($data['mitigation']['mitigation_id'])
                                            @if ($data['mitigation']['user_accepted_mitigations'])
                                            <button id="accept-mitigation" type="button" class="btn btn-danger me-1 acceptOrRejectStatus" data-value='0' data-id="{{ $data['id'] }}">
                                                {{ __('risk.RejectMitigation') }}</button>
                                            @else
                                            <button id="reject-mitigation" type="button" class="btn btn-success me-1 acceptOrRejectStatus" data-value='1' data-id="{{ $data['id'] }}">
                                                {{ __('risk.AcceptMitigation') }}</button>
                                            @endif
                                        @endif
                                    </div>
                                    @endif                                    
                                </div>
                                <div class="col-12 col-md-6">
                                    {{-- Current Solution --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.CurrentSolution') }}</label> :
                                        <div style="max-height: 100px;   overflow: auto;">
                                            {{ $data['mitigation']['current_solution'] ?? '' }}
                                        </div>
                                    </div>
                                    {{-- Security Requirements --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.SecurityRequirements') }}</label>
                                        :
                                        <div style="max-height: 100px;   overflow: auto;">
                                            {{ $data['mitigation']['security_requirements'] ?? '' }}
                                        </div>
                                    </div>
                                    {{-- Security Recommendations --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.SecurityRecommendations') }}</label>
                                        :
                                        <div style="max-height: 100px;   overflow: auto;">
                                            {{ $data['mitigation']['security_recommendations'] ?? '' }}
                                        </div>
                                    </div>
                                    {{-- Supporting Documentation --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.SupportingDocumentation') }}</label>
                                        :
                                        @forelse($data['mitigation']['files'] ?? [] as $files)
                                        <span class="badge bg-secondary">{{ $files['name'] }}</span>
                                        @empty
                                        <span class="mx-2 text-danger">{{ __('locale.NONE') }}</span>
                                        @endforelse

                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('plan_mitigation.create'))                                
                                <div class="col-12">
                                    <div class="row m-0 justify-content-center">
                                        <button id="edit-mitigation" type="button" class="btn btn-secondary col-12 col-md-6">
                                            {{ __('locale.EditMitigation') }}</button>
                                    </div>
                                </div>
                                @endif                                    
                            </div>
                            @if (auth()->user()->hasPermission('plan_mitigation.create'))                                
                            <form class="row d-none px-0" id="edit-mitigation-form" method="post" action="/">
                                @csrf
                                <input type="hidden" name="risk_id" value="{{ $data['id'] }}">
                                <div class="col-12 col-md-6">
                                    {{-- Mitigation Date --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationDate') }}</label>
                                    </div>
                                    {{-- Mitigation Planning Date --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationPlanning') }}</label>
                                        <input name="planned_mitigation_date" class="form-control flatpickr-date-time-compliance" value="{{ format_date($data['mitigation']['planning_date'], '') }}" />
                                        <span class="error error-planned_mitigation_date "></span>
                                    </div>
                                    {{-- Planning Strategy --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.PlanningStrategy') }}</label>
                                        <select class="select2 form-select" name="planning_strategy">
                                            <option value="">
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($planningStrategies as $planningStrategy)
                                            <option value="{{ $planningStrategy->id }}" {{ $data['mitigation']['planning_strategy_id'] ?? '' == $planningStrategy->id ? 'selected' : '' }}>
                                                {{ $planningStrategy->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-planning_strategy"></span>
                                    </div>
                                    {{-- Mitigation Effort --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationEffort') }}</label>
                                        <select class="select2 form-select" name="mitigation_effort">
                                            <option value="">
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($mitigationEfforts as $mitigationEffort)
                                            <option value="{{ $mitigationEffort->id }}" {{ $data['mitigation']['mitigation_effort_id'] ?? '' == $mitigationEffort->id ? 'selected' : '' }}>
                                                {{ $mitigationEffort->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_effort"></span>
                                    </div>
                                    {{-- MitigationCost --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationCost') }}</label><select class="select2 form-select" name="mitigation_cost">
                                            <option value="">
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($mitigationCosts as $mitigationCost)
                                            <option value="{{ $mitigationCost->id }}" {{ $data['mitigation']['mitigation_cost_id'] ?? '' == $mitigationCost->id ? 'selected' : '' }}>
                                                {{ $mitigationCost->name }}
                                                @php
                                                $valuation_level_name = '';
                                                if (!empty($mitigationCost->valuation_level_name)) {
                                                $valuation_level_name = ' (' . $mitigationCost->valuation_level_name . ')';
                                                }

                                                if ($mitigationCost->min_value === $mitigationCost->max_value) {
                                                echo get_setting('currency') . number_format($mitigationCost->min_value) . $valuation_level_name;
                                                } else {
                                                echo get_setting('currency') . number_format($mitigationCost->min_value) . ' to ' . get_setting('currency') . number_format($mitigationCost->max_value) . $valuation_level_name;
                                                }
                                                @endphp
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_cost"></span>
                                    </div>
                                    {{-- Mitigation Owner --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationOwner') }}</label>
                                        <select class="select2 form-select" name="mitigation_owner_id">
                                            <option value="">
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($enabledUsers as $owner)
                                            <option value="{{ $owner->id }}" data-manager="{{ json_encode($owner->manager) }}" {{ $data['mitigation']['mitigation_owner_id'] ?? '' == $owner->id ? 'selected' : '' }}>
                                                {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_owner_id"></span>
                                    </div>
                                    {{-- Mitigation Team --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationTeam') }}</label>
                                        <select name="mitigation_team_id[]" class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($teams as $team)
                                            <option value="{{ $team->id }}" {{ in_array($team->id, $data['mitigation']['team_ids'] ?? []) ? 'selected' : '' }}>
                                                {{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_team_id"></span>
                                    </div>
                                    {{-- Mitigation Percent --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.MitigationPercent') }}</label>
                                        <input type="number" min="0" class="form-control" name="mitigation_percent" value="{{ $data['mitigation']['mitigation_percent'] ?? '' }}">
                                        <span class="error error-mitigation_percent"></span>
                                    </div>

                                    {{-- Mitigation Controls --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.MitigationControls') }}</label>
                                        <select name="mitigation_control_id[]" class="form-select multiple-select2" multiple="multiple">
                                            @foreach ($frameworks as $framework)
                                            @foreach ($framework->FrameworkControls as $control)
                                            <option value="{{ $control->id }}" {{ in_array($control->id, $data['mitigation']['mitigation_control_ids'] ?? []) ? 'selected' : '' }}>
                                                {{ $control->short_name }}
                                            </option>
                                            @endforeach
                                            @endforeach
                                        </select>
                                        <span class="error error-mitigation_control_id"></span>
                                    </div>

                                </div>

                                <div class="col-12 col-md-6">
                                    {{-- Current Solution --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.CurrentSolution') }}</label>
                                        <textarea class="form-control" name="current_solution" rows="3">{{ $data['mitigation']['current_solution'] }}</textarea>
                                        <span class="error error-current_solution "></span>
                                    </div>
                                    {{-- Security Requirements --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.SecurityRequirements') }}</label>
                                        <textarea class="form-control" name="security_requirements" rows="3">{{ $data['mitigation']['security_requirements'] }}</textarea>
                                        <span class="error error-security_requirements "></span>
                                    </div>
                                    {{-- Security Recommendations --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('risk.SecurityRecommendations') }}</label>
                                        <textarea class="form-control" name="security_recommendations" rows="3">{{ $data['mitigation']['security_recommendations'] }}</textarea>
                                        <span class="error error-security_recommendations "></span>
                                    </div>
                                    {{-- Supporting Documentation --}}
                                    <div class="mb-1 supporting_documentation_container">
                                        <label class="text-label">{{ __('risk.SupportingDocumentation') }}</label>
                                        :
                                        <input type="file" multiple name="supporting_documentation[]" class="form-control dt-post" aria-label="{{ __('risk.SupportingDocumentation') }}" />
                                        <span class="error error-supporting_documentation "></span>
                                        @forelse($data['mitigation']['files'] ?? [] as $file)
                                        <div class="mitigation-files">
                                            <span class="badge bg-secondary supporting_documentation cursor-pointer" data-id="{{ $file['id'] }}" data-risk-id="{{ $data['id'] }}">{{ $file['name'] }}</span>
                                            <span class="text-danger delete_supporting_documentation cursor-pointer" data-id="{{ $file['id'] }}" data-risk-id="{{ $data['id'] }}"><i data-feather="x"></i></span>
                                        </div>
                                        @empty
                                        <span class="mx-2 text-danger">{{ __('locale.NONE') }}</span>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-2">
                                    <button id="submit-edit-mitigation" type="button" class="btn btn-primary me-1">
                                        {{ __('locale.SaveMitigation') }}</button>
                                    <button id="cancel-edit-mitigation" type="reset" class="btn btn-danger">
                                        {{ __('locale.Cancel') }}</button>
                                </div>

                            </form>
                            @endif                                    
                        </div>

                        {{-- Review tab --}}
                        <div class="tab-pane" id="review" aria-labelledby="review-tab" role="tabpanel">
                            <div class="row" id="static-review">
                                {{-- Last review --}}
                                <div class="col-12" id="last-review">
                                    <h5 class="mx-1 text-muted text-decoration-underline">
                                        {{ __('locale.LastReview') }}
                                    </h5>
                                    <div class="mx-2 mx-md-4">
                                        {{-- Review Date --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.ReviewDate') }}</label> :
                                            {{ $data['lastMgmtReviews']['review_date'] }}
                                        </div>
                                        {{-- Reviewer --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.Reviewer') }}</label> :
                                            {{ $data['lastMgmtReviews']['reviewer'] }}
                                        </div>
                                        {{-- Review --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.Review') }}</label> :
                                            {{ $data['lastMgmtReviews']['review'] }}
                                        </div>
                                        {{-- Next Step --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.NextStep') }}</label> :
                                            {{ $data['lastMgmtReviews']['next_step'] }}
                                        </div>
                                        {{-- Project Name --}}
                                        @if ($data['lastMgmtReviews']['next_step_id'] == 2)
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.ProjectName') }}</label> :
                                            {{ $data['lastMgmtReviews']['project'] }}
                                        </div>
                                        @endif
                                        {{-- Next Review Date --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.NextReviewDate') }}</label>
                                            :
                                            {{ $data['lastMgmtReviews']['next_review'] }}
                                        </div>
                                        {{-- Comment --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.Comment') }}</label> :
                                            {{ $data['lastMgmtReviews']['comments'] }}
                                        </div>
                                    </div>
                                </div>
                                {{-- Review history --}}
                                <div class="col-12" style="display:none" id="review-history">
                                    <h5 class="mx-1 text-muted text-decoration-underline">
                                        {{ __('locale.ReviewHistory') }}
                                    </h5>
                                    @foreach ($data['mgmtReviews'] as $review)
                                    <div class="mx-2 mx-md-4">
                                        {{-- Review Date --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.ReviewDate') }}</label>
                                            :
                                            {{ $review['review_date'] }}
                                        </div>
                                        {{-- Reviewer --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.Reviewer') }}</label> :
                                            {{ $review['reviewer'] }}
                                        </div>
                                        {{-- Review --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.Review') }}</label> :
                                            {{ $review['review'] }}
                                        </div>
                                        {{-- Next Step --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.NextStep') }}</label> :
                                            {{ $review['next_step'] }}
                                        </div>
                                        {{-- Project Name --}}
                                        @if ($review['next_step_id'] == 2)
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.ProjectName') }}</label>
                                            :
                                            {{ $review['project'] }}
                                        </div>
                                        @endif
                                        {{-- Next Review Date --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.NextReviewDate') }}</label>
                                            :
                                            {{ $review['next_review'] }}
                                        </div>
                                        {{-- Comment --}}
                                        <div class="mb-1">
                                            <label class="text-label">{{ __('locale.Comment') }}</label> :
                                            {{ $review['comments'] }}
                                        </div>
                                    </div>
                                    @if (!$loop->last)
                                    <hr>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-12 review-btn">
                                    <div class="row m-0 justify-content-center">
                                        <button id="review-history-btn" type="button" class="btn btn-secondary col-12 col-md-6">
                                            {{ __('locale.ViewAllReviews') }}</button>
                                    </div>
                                </div>
                                <div class="col-12 review-btn" style="display:none">
                                    <div class="row m-0 justify-content-center">
                                        <button id="last-review-btn" type="button" class="btn btn-secondary col-12 col-md-6">
                                            {{ __('locale.LastReview') }}</button>
                                    </div>
                                </div>
                            </div>
                            <form class="row d-none px-0" id="add-review-form" method="post" action="/">
                                @csrf
                                <input type="hidden" name="risk_id" value="{{ $data['id'] }}">
                                <div class="col-12 col-md-6">
                                    {{-- Reiew Date --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.ReviewDate') }}</label> :
                                        {{ date(get_default_date_format()) }}
                                    </div>
                                    {{-- Reviewer --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.Reviewer') }}</label> :
                                        {{ auth()->user()->name }}
                                        {{ $data['lastMgmtReviews']['reviewer'] }}
                                    </div>
                                    {{-- Review --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.Review') }}</label>
                                        <select class="select2 form-select" name="review">
                                            <option value="" selected disabled>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($reviews as $review)
                                            <option value="{{ $review->id }}">
                                                {{ $review->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-review"></span>
                                    </div>
                                    {{-- Next Step --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.NextStep') }}</label>
                                        <select class="select2 form-select" name="next_step">
                                            <option value="" selected disabled>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($nextSteps as $nextStep)
                                            <option value="{{ $nextStep->id }}">
                                                {{ $nextStep->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-next_step"></span>
                                    </div>
                                    {{-- Project Name --}}
                                    <div class="mb-1 d-none" id="project-container">
                                        <label class="text-label">{{ __('locale.ProjectName') }}</label>
                                        <select class="select2 form-select" name="project">
                                            <option value="" selected disabled>
                                                {{ __('locale.select-option') }}</option>
                                            @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">
                                                {{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-project"></span>
                                    </div>
                                    {{-- Comment --}}
                                    <div class="mb-1">
                                        <label class="text-label">{{ __('locale.Comment') }}</label>
                                        <textarea class="form-control" name="comments" rows="3"></textarea>
                                        <span class="error error-comments "></span>
                                    </div>
                                </div>

                                <div class="col-12 px-lg-5 col-md-6">
                                    {{-- Next Review Date --}}
                                    <div class="mb-1 px-lg-5">
                                        {{ __('locale.BasedOnTheCurrentRiskScore') }}
                                        {{ $data['get_next_review_default'] }} <br>
                                        {{ __('locale.WouldYouLikeToUseADifferentDate') }}
                                        <div class="mb-1 mt-1">
                                            <label class="text-label">{{ __('locale.NextReviewDate') }}</label>
                                            <input name="next_review_date" class="form-control flatpickr-date-time-compliance" value="{{ $data['get_next_review_default'] }}" />
                                            <span class="error error-next_review_date "></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-2">
                                    <button id="submit-add-review" type="button" class="btn btn-primary me-1">
                                        {{ __('locale.SubmitReview') }}</button>
                                    <button id="cancel-add-review" type="reset" class="btn btn-danger">
                                        {{ __('locale.Cancel') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Tabs ends -->
    </div>
</section>
<!-- Basic Tabs end -->

<!-- Tags start -->
<div class="card main-containers" id="tags-container">
    <div class="card-body">
        <h4 class="card-title">{{ __('risk.Tags') }}</h4>
        <p class="card-text">
            @forelse($data['tags'] as $tag)
            <span class="badge bg-secondary">{{ $tag['tag'] }}</span>
            @empty
            <span class="mx-2 text-danger">{{ __('locale.NoTagAssigned') }}</span>
            @endforelse
        </p>
    </div>
</div>
<!-- Tags end -->

<!-- collapseComments start -->
<section id="comment-container" class="main-containers">
    <div class="row">
        <div class="col-sm-12">
            <div class="card py-1">
                <div class="card-header py-0">
                    <div class="head-label">
                        <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComments" aria-expanded="false" aria-controls="collapseComments" id="show-comments-btn">
                            {{ __('locale.Comments') }}
                        </button>
                    </div>
                    @if (auth()->user()->hasPermission('riskmanagement.AbleToCommentRiskManagement'))                            
                        <div class="dt-action-buttons text-end">
                            <div class="dt-buttons d-inline-flex">
                                <button class="dt-button btn btn-success me-2" type="button" id="add-comment-btn">
                                    <i data-feather="plus"></i>
                                </button>
                                <span id="plus-icon" class="d-none">
                                    <i data-feather="plus"></i>
                                </span>
                                <span id="x-icon" class="d-none">
                                    <i data-feather="x"></i>
                                </span>
                            </div>
                        </div>
                    @endif                        
                </div>
                <div class="card-body pb-0">
                    <div class="collapse" id="collapseComments">
                        <div style="display: none" class="mt-md-1" id="add-comment" data-id="IDIDID">
                            <form id="add-comment-form" method="post" action="/" class="px-0">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['id'] }}">
                                <textarea class="form-control" rows="3" name="comment"></textarea>
                                <span class="error error-comment"></span>

                                <div style="text-align: right">
                                    {{-- <button class="button btn btn-danger mt-2"
                                        type="button">{{ __('locale.Cancel') }}</button> --}}
                                    <button id="submit-add-comment" class="button btn btn-success mt-2" type="button">{{ __('locale.Submit') }}</button>
                                </div>
                            </form>
                        </div>
                        <div id="all-comments">
                            @foreach ($data['comments'] as $comment)
                            <p class="card-text mt-1">
                                <b>
                                    {{ date(get_default_datetime_format('g:i A T'), strtotime($comment['date'])) }}</b>
                                {{ $comment['user']['name'] }}</b><br> {{ $comment['comment'] }}
                            </p>
                            <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- collapseComments end -->

<!-- collapseAuditTrail start -->
<section class="main-containers">
    <div class="row">
        <div class="col-sm-12">
            <div class="card py-1">
                <div class="card-header py-0">
                    <div class="head-label">
                        <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAuditTrail" aria-expanded="false" aria-controls="collapseAuditTrail">
                            {{ __('risk.Audit Trail') }}
                        </button>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="collapse" id="collapseAuditTrail">
                        @foreach ($data['logs'] as $log)
                        <p class="card-text mt-1">
                            {{ date(get_default_datetime_format('g:i A T'), strtotime($log['timestamp'])) }} >
                            {{ $log['message'] }}
                        </p>
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- collapseAuditTrail end -->
<form class="d-none" id="download-file-form" method="post" action="{{ route('admin.risk_management.ajax.download_file') }}">
    @csrf
    <input type="hidden" name="id">
    <input type="hidden" name="risk_id">
</form>

<!-- close risk start -->
@if (auth()->user()->hasPermission('riskmanagement.AbleToCloseRisks'))
<section class="d-none" id="close-risk-container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card py-1">
                <div class="card-header py-0">
                    <h3>{{ __('risk.CloseRisk') }}</h3>
                </div>
                <div class="card-body pb-0">
                    <form class="row px-0" id="close-reason-form" method="post" action="{{ route('admin.risk_management.ajax.update') }}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        <div class="col-12">
                            {{-- Close reason --}}
                            <div class="mb-1">
                                <label class="form-label ">{{ __('locale.Reason') }}</label>
                                <select class="select2 form-select" name="close_reason">
                                    <option value="" selected>
                                        {{ __('locale.select-option') }}</option>
                                    @foreach ($closeReasons as $closeReason)
                                    <option value="{{ $closeReason->id }}">
                                        {{ $closeReason->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-close_reason"></span>
                            </div>
                        </div>
                        {{-- Close-Out Information note --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('risk.CloseOutInformation') }}</label>
                            <textarea class="form-control" name="note" rows="3"></textarea>
                            <span class="error error-note "></span>
                        </div>

                        <div class="col-12 text-center mt-2">
                            <button id="submit-close-reason" type="button" class="btn btn-primary me-1">
                                {{ __('locale.Submit') }}</button>
                            <button id="cancel-close-reason" type="reset" class="btn btn-danger">
                                {{ __('locale.Reset') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- close risk end -->

<!-- change risk status start -->
<section class="d-none" id="change-risk-status-container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card py-1">
                <div class="card-header py-0">
                    <h3>{{ __('locale.SetRiskStatusTo') }}</h3>
                </div>
                <div class="card-body pb-0">
                    <form class="row px-0" id="change-risk-status-form" method="post" action="{{ route('admin.risk_management.ajax.update') }}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        <div class="col-12">
                            {{-- Close reason --}}
                            <div class="mb-1">
                                <select class="select2 form-select" name="status">
                                    <option value="" selected>
                                        {{ __('locale.select-option') }}</option>
                                    @foreach ($statuses as $status)
                                        @if ($status->name == 'Closed')
                                            @if(auth()->user()->hasPermission('riskmanagement.AbleToCloseRisks'))
                                                <option value="{{ $status->id }}">{{ __('risk.CloseRisk') }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="error error-status"></span>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-2">
                            <button id="submit-change-risk-status" type="button" class="btn btn-primary me-1">
                                {{ __('locale.Update') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- change risk status end -->

<!-- reset risk mitigations start -->
<section class="d-none" id="reset-risk-mitigations-container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12 text-center">
                        <button id="submit-reset-risk-mitigations" type="button" class="btn btn-primary me-1" data-id="{{ $data['id'] }}">
                            {{ __('risk.ResetMitigations') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- reset risk mitigations end -->

<!-- reset risk reviews start -->
<section class="d-none" id="reset-risk-reviews-container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12 text-center">
                        <button id="submit-reset-risk-reviews" type="button" class="btn btn-primary me-1" data-id="{{ $data['id'] }}">
                            {{ __('risk.ResetReviews') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- reset risk reviews end -->

@endsection
@section('vendor-script')
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset('vendors/js/extensions/moment.min.js') }}"></script>
<script src="{{ asset('js/scripts/highcharts.js') }}"></script>
<script>
    const lang = []
        , URLs = []
        , assets = [];
    lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
    lang['cancel'] = "{{ __('locale.Cancel') }}";
    lang['success'] = "{{ __('locale.Success') }}";
    lang['error'] = "{{ __('locale.Error') }}";
    lang['confirmDeleteFileMessage'] = "{{ __('locale.AreYouSureToDeleteThisFile') }}";
    lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";
    URLs['updateSubject'] = "{{ route('admin.risk_management.ajax.update_subject') }}";
    URLs['updateRiskScoring'] = "{{ route('admin.risk_management.ajax.update_risk_scoring') }}";
    URLs['addComment'] = "{{ route('admin.risk_management.ajax.add_comment') }}";
    URLs['getRiskLevels'] = "{{ route('admin.risk_management.ajax.get_risk_levels') }}";
    URLs['residualScoringHistory'] =
        "{{ route('admin.risk_management.ajax.residual_scoring_history', $data['id']) }}";
    URLs['getScoringHistories'] = "{{ route('admin.risk_management.ajax.get_scoring_histories', $data['id']) }}";
    URLs['updateDetails'] = "{{ route('admin.risk_management.ajax.update') }}";
    URLs['deleteFile'] = "{{ route('admin.risk_management.ajax.delete_file') }}";
    URLs['acceptRejectMitigation'] = "{{ route('admin.risk_management.ajax.accept_reject_mitigation') }}";
    URLs['updateRiskMitigation'] = "{{ route('admin.risk_management.ajax.update_risk_mitigation') }}";
    URLs['addRiskReview'] = "{{ route('admin.risk_management.ajax.add_risk_review') }}";
    URLs['riskCloseReason'] = "{{ route('admin.risk_management.ajax.risk_close_reason') }}";
    URLs['riskReopen'] = "{{ route('admin.risk_management.ajax.risk_reopen') }}";
    URLs['riskChangeStatus'] = "{{ route('admin.risk_management.ajax.risk_Change_Status') }}";
    URLs['resetRiskMitigations'] = "{{ route('admin.risk_management.ajax.reset_risk_mitigations') }}";
    URLs['resetRiskReviews'] = "{{ route('admin.risk_management.ajax.reset_risk_reviews') }}";


    const dataFormat = "{{ get_default_date_format() }}";


    Highcharts.setOptions({
        global: {
            timezone: "{{ get_setting('default_timezone') }}"
        }
    });
    assets['showLoading'] = "{{ asset('SR_images/progress.gif') }}";

</script>
<script src="{{ asset('ajax-files/risk_management/edit.js') }}"></script>
@endsection
