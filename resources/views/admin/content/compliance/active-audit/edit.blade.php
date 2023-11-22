<div>
    <form class="needs-validation" id="form-audit-update" action="{{route('admin.compliance.audit.update',$id)}}" method="POST">
        {{ method_field('PUT') }}
        @csrf
        <div class="row">

            <!-- AuditStatus -->
            <div class="col-xl-6 col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="status">{{ __('compliance.AuditStatus') }}</label>
                    <select class="select2 form-select" id="status" name="status" {{$editable ? '' : 'disabled'}}>
                        <option value="">{{ __('locale.select-option') }} </option>
                        @foreach($auditStatusGroups as $auditStatusGroup)
                        <option value="{{$auditStatusGroup->id}}" {{option_select($auditStatusGroup->id,$frameworkControlTestAudit->status)}}>{{$auditStatusGroup->name}}</option>
                        @endforeach
                    </select>
                    <span class="error error-status "></span>
                </div>
            </div>


            <!-- TestResult -->
            <div class="col-xl-6 col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="test_result">{{ __('locale.TestResult') }}</label>
                    <select class="select2 form-select" id="test_result" name="test_result" {{$editable ? '' : 'disabled'}}>
                        <option value="" selected disabled>{{ __('locale.select-option') }} </option>
                        @foreach($testResultGroups as $testResultGroup)
                        <option value="{{$testResultGroup->id}}" {{option_select($testResultGroup->id,$frameworkControlTestResult->test_result)}}>{{$testResultGroup->name}}</option>
                        @endforeach
                    </select>
                    <span class="error error-test_result "></span>
                </div>
            </div>

            <!-- Summary -->
            <div class="col-xl-6 col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="summary">{{ __('locale.Summary') }}</label>
                    <textarea class="form-control" id="summary" rows="3" name="summary" {{$editable ? '' : 'disabled'}}>
                    {{$frameworkControlTestResult->summary}}
                    </textarea>
                    <span class="error error-summary "></span>
                </div>
            </div>

            <!-- TestDate -->
            <div class="col-xl-6 col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="test_date">{{ __('locale.TestDate') }}</label>
                    <input type="text" id="fp-default" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" name="test_date" value="{{ViewDate($frameworkControlTestResult->test_date)}}" {{$editable ? '' : 'disabled'}} />
                    <span class="error error-test_date "></span>
                </div>
            </div>

            <!-- Tester -->
            <div class="col-xl-6 col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="Tester">{{ __('locale.Tester') }}</label>: <b>{{ $frameworkControlTestAudit->UserTester->name ?? '' }}</b>
                    {{-- <select class="select2 form-select" id="tester" name="tester" {{$editable ? '' : 'disabled'}}>
                        <option value="">{{ __('locale.select-option') }} </option>
                        @foreach($testers as $tester)
                        <option value="{{$tester->id}}" {{option_select($tester->id,$frameworkControlTestAudit->tester)}}>{{$tester->name}}</option>
                        @endforeach
                    </select>
                    <span class="error error-tester "></span> --}}
                </div>
            </div>

            <!-- Teams -->
            <div class="col-xl-6 col-md-6 col-12">
                <div class="mb-1">
                    {{-- <br> --}}
                    <label class="form-label" for="teams">{{ __('locale.Teams') }}</label>
                    {{-- @foreach($testTeamsNames as $team)
                        <span class="badge rounded-pill badge-light-primary">{{$team}}</span>
                    @endforeach --}}
                    <select class="form-select multiple-select2" name="teams[]" id="teams" multiple="multiple" {{$editable ? '' : 'disabled'}}>
                        <option select disabled value="">{{ __('locale.select-option') }} </option>
                        @foreach($teams as $team)
                        <option value="{{$team->id}}" {{optionMultiSelect($team->id,$testTeams)}}>{{$team->name}}</option>
                        @endforeach
                    </select>
                    <span class="error error-teams "></span>
                </div>
            </div>

            <!-- file uploads -->
            @if($editable)

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.AttachmentFiles') }}</h4>
                    </div>
                    <div class="card-body">

                        <div enctype="multipart/form-data" class="dropzone dropzone-area" id="dropzone">
                            <div class="dz-message"> {{ __('locale.DropFilesHereOrClickToUpload') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row m-0 mb-1 col-12">
                <div <?= $editable? 'style="padding: 0 1.5rem;"' : '' ?> id="download-audit-file">
                    @foreach($frameworkControlTestAudit->compliance_files as $compliance_file)
                        <a id="{{ str_replace(".","-",$compliance_file->unique_name) }}" style="padding: 7px 3px" class="btn btn-primary col-md-3 col-lg-2 col-12" href="{{ asset('/uploads/compliance/' . $compliance_file->unique_name) }}" download><i style="margin: 0 5px" data-feather="file"></i>{{ $compliance_file->name }}</a>
                    @endforeach
                </div>
            </div>

            @if($editable)
            {{-- submit --}}
            <div class="col-xl-6 col-md-6 col-12">
                <button class="btn btn-primary waves-effect waves-float waves-light" type="submit"> {{ __('locale.Submit') }}</button>
            </div>
            @endif
        </div>
    </form>

</div>
