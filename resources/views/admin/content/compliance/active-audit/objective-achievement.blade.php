@if(count($frameworkControlTestAudit->ControlAuditObjectives))
<div class="card-datatable">
    <table class="dt-advanced-search table">
        <thead>
            <tr>
                <th>{{ __('locale.#') }}</th>
                <th>{{ __('compliance.ObjectiveName') }}</th>
                <th>{{ __('locale.Responsible') }}</th>
                <th>{{ __('locale.Status') }}</th>
                <th>{{ __('locale.Actions') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($frameworkControlTestAudit->ControlAuditObjectives as $controlAuditObjective)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $controlAuditObjective->controlControlObjective->objective->name }}</td>
                <td>
                    @if($controlAuditObjective->controlControlObjective->responsible_type == 'team')
                    {{ $controlAuditObjective->controlControlObjective->responsibleTeam->name }}
                    @elseif($controlAuditObjective->controlControlObjective->responsible_type == 'user' || $controlAuditObjective->controlControlObjective->responsible_type == 'manager')
                    {{ $controlAuditObjective->controlControlObjective->responsibleUser->name }}
                    @else
                    {{ 'Not Set' }}
                    @endif
                </td>
                <td>
                @if($controlAuditObjective->objective_audit_status == 'no_action')
                <span data-objective-id="{{ $controlAuditObjective->control_control_objective_id }}" class="status-span">
                    {{ __('locale.' . $controlAuditObjective->objective_audit_status) }}
                </span>
                @else
                <span data-objective-id="{{ $controlAuditObjective->control_control_objective_id }}" class="status-span badge rounded-pill badge-light-{{ $controlAuditObjective->objective_audit_status == 'approved'? 'success' : 'danger' }}">{{ __('locale.' . $controlAuditObjective->objective_audit_status) }}</span>
                @endif

                
                </td>
                <td>
                    <div class="d-inline-flex">
                        <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
                            <i class="ficon" data-feather="more-vertical"></i>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-end">
                            <span class="view-objective-evidences item-edit dropdown-item" data-objective-id="{{ $controlAuditObjective->control_control_objective_id }}" data-test-id="{{ $controlAuditObjective->framework_control_test_audit_id }}" data-editable="{{ $editable }}">
                                <i class="ficon" data-feather="list"></i> {{ __('compliance.Evidences') }}
                            </span>
                            @if($editable)
                            <span class="approve-objective text-success item-edit dropdown-item {{$controlAuditObjective->objective_audit_status == 'approved' ? 'bg-secondary' : ''}}" data-objective-id="{{ $controlAuditObjective->id }}" data-approved="{{ __('locale.approved') }}">
                                <i class="ficon" data-feather="check"></i> {{ __('locale.Approve') }}
                            </span>
                            <span class="reject-objective text-danger item-edit dropdown-item {{$controlAuditObjective->objective_audit_status == 'rejected' ? 'bg-secondary' : ''}}" data-objective-id="{{ $controlAuditObjective->id }}" data-rejected="{{ __('locale.rejected') }}">
                                <i class="ficon" data-feather="x"></i> {{ __('locale.Reject') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@else
<div class="alert alert-danger w-75 mx-auto text-center" role="alert">
    <div class="alert-body">{{ __('locale.ThereIsNoObjectives') }}</div>
</div>
@endif

