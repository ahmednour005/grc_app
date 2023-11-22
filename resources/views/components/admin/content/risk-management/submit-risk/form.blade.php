<!-- Risk Modal -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title">{{ $title }}</h1>
                </div>
                <!-- Risk form -->
                <form class="row" onsubmit="return false" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 mb-2">
                        <label class="form-label">{{ __('locale.Subject') }}</label>
                        <input type="text" name="subject" class="form-control" tabindex="-1" required />
                        <span class="error error-subject"></span>
                    </div>
                    <div class="col-12">
                        {{-- Risk Mapping --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('report.RiskMapping') }}</label>
                            <select name="risk_catalog_mapping_id[]" class="form-select multiple-select2" multiple="multiple">
                                @foreach($riskGroupings as $riskGrouping)
                                <optgroup label="{{$riskGrouping->name}}">
                                    @foreach($riskGrouping->RiskCatalogs as $riskCatalog)
                                    <option value="{{$riskCatalog->id}}">{{$riskCatalog->number. ' - ' . $riskCatalog->name}}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                            <span class="error error-risk_catalog_mapping_id"></span>
                        </div>
                        {{-- Threat Mapping --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('report.ThreatMapping') }}</label>
                            <select name="threat_catalog_mapping_id[]" class="form-select multiple-select2" multiple="multiple">
                                @foreach($threatGroupings as $threatGrouping)
                                <optgroup label="{{$threatGrouping->name}}">
                                    @foreach($threatGrouping->ThreatCatalogs as $ThreatCatalog)
                                    <option value="{{$ThreatCatalog->id}}">{{$ThreatCatalog->number . ' - ' . $ThreatCatalog->name}}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                            <span class="error error-threat_catalog_mapping_id"></span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        {{-- Category --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('report.Category') }}</label>
                            <select class="select2 form-select" name="category_id">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-category_id"></span>
                        </div>
                        {{-- Site Location --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.SiteLocation') }}</label>
                            <select class="form-select multiple-select2" name="location_id[]" multiple="multiple">
                                @foreach($locations as $location)
                                <option value="{{$location->id}}">{{$location->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-location_id"></span>
                        </div>
                        {{-- External Reference Id --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('report.ExternalReferenceId') }}</label>
                            <input type="text" name="reference_id" class="form-control dt-post" aria-label="{{ __('report.ExternalReferenceId') }}" />
                            <span class="error error-reference_id "></span>
                        </div>
                        {{-- Control Regulation --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('report.ControlRegulation') }}</label>
                            <select class="select2 form-select" name="framework_id">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                                @foreach($frameworks as $framework)
                                <option value="{{$framework->id}}" data-controls="{{json_encode($framework->FrameworkControls)}}">{{$framework->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-framework_id"></span>
                        </div>
                        {{-- Control Number --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('report.ControlNumber') }}</label>

                            <select class="select2 form-select" name="control_id">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                            </select>
                            <span class="error error-control_id"></span>
                        </div>
                        {{-- Affected Assets --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('report.AffectedAssets') }}</label>
                            <select name="affected_asset_id[]" class="form-select multiple-select2" multiple="multiple">
                                @if(count($assetGroups))
                                <optgroup label="{{__('risk.AssetGroups')}}">
                                    @foreach($assetGroups as $assetGroup)
                                    <option value="{{$assetGroup->id}}_group">{{$assetGroup->name}}</option>
                                    @endforeach
                                </optgroup>
                                @endif
                                <optgroup label="{{__('locale.Standards')}} {{__('report.Assets')}}">
                                    @foreach($assets as $asset)
                                    <option value="{{$asset->id}}_asset">{{$asset->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <span class="error error-affected_asset_id"></span>
                        </div>
                        {{-- Technology --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.Technology') }}</label>
                            <select name="technology_id[]" class="form-select multiple-select2" multiple="multiple">
                                @foreach($technologies as $technology)
                                <option value="{{$technology->id}}">{{$technology->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-technology_id"></span>
                        </div>
                        {{-- Team --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.Team') }}</label>
                            <select name="team_id[]" class="form-select multiple-select2" multiple="multiple">
                                @foreach($teams as $team)
                                <option value="{{$team->id}}">{{$team->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-team_id"></span>
                        </div>
                        {{-- AdditionalStakeholders --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.AdditionalStakeholders') }}</label>
                            <select name="additional_stakeholder_id[]" class="form-select multiple-select2" multiple="multiple">
                                @foreach($enabledUsers as $additionalStakeholder)
                                <option value="{{$additionalStakeholder->id}}">{{$additionalStakeholder->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-additional_stakeholder_id"></span>
                        </div>
                        {{-- Owner --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.Owner') }}</label>
                            <select class="select2 form-select" name="owner_id">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                                @foreach($owners as $owner)
                                <option value="{{$owner->id}}" data-manager="{{json_encode($owner->manager)}}">{{$owner->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-owner_id"></span>
                        </div>
                        {{-- OwnersManager --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.OwnersManager') }}</label>
                            <select class="select2 form-select" name="owner_manager_id">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                            </select>
                            <span class="error error-owners_manager_id"></span>
                        </div>

                    </div>

                    <div class="col-12 col-md-6">
                        {{-- Risk Source --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.RiskSource') }}</label>
                            <select class="select2 form-select" name="risk_source_id">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                                @foreach ($riskSources as $riskSource)
                                <option value="{{ $riskSource->id }}">{{ $riskSource->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-risk_source_id"></span>
                        </div>
                        {{-- Risk Scoring Method --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('report.RiskScoringMethod') }}</label>
                            <select class="select2 form-select" name="risk_scoring_method_id">
                                <option value="" disabled hidden>{{ __('locale.select-option') }}</option>
                                @foreach ($riskScoringMethods as $riskScoringMethod)
                                <option value="{{ $riskScoringMethod->id }}">{{ $riskScoringMethod->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-risk_scoring_method_id"></span>
                        </div>
                        {{-- Current Likelihood --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('report.CurrentLikelihood') }}</label>
                            <select class="select2 form-select" name="current_likelihood_id">
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                @foreach ($riskLikelihoods as $riskLikelihood)
                                <option value="{{ $riskLikelihood->id }}">{{ $riskLikelihood->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-current_likelihood_id"></span>
                        </div>
                        {{-- Current Impact --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('report.CurrentImpact') }}</label>
                            <select class="select2 form-select" name="current_impact_id">
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                @foreach ($impacts as $impact)
                                <option value="{{ $impact->id }}">{{ $impact->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-current_impact_id"></span>
                        </div>
                        {{-- Risk Assessment --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('report.RiskAssessment') }}</label>
                            <textarea class="form-control" name="risk_assessment" rows="3"></textarea>
                            <span class="error error-risk_assessment "></span>
                        </div>
                        {{-- Additional Notes --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('report.AdditionalNotes') }}</label>
                            <textarea class="form-control" name="additional_notes" rows="3"></textarea>
                            <span class="error error-additional_notes "></span>
                        </div>
                        {{-- Supporting Documentation --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('report.SupportingDocumentation') }}</label>
                            <input type="file" multiple name="supporting_documentation[]" class="form-control dt-post" aria-label="{{ __('locale.SupportingDocumentation') }}" />
                            <span class="error error-supporting_documentation "></span>
                        </div>
                    </div>

                    <div class="col-12">
                        {{-- Tags --}}
                        <div class="mb-1">
                            <label class="form-label"> {{ __('report.Tags') }}</label>
                            <select name="tags[]" class="form-select multiple-select2" multiple="multiple">
                                @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                @endforeach
                            </select>
                            <span class="error error-tags "></span>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-2">
                        <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}</button>
                    </div>
                </form>
                <!--/ Risk form -->
            </div>
        </div>
    </div>
</div>
<!--/ Risk Modal -->
