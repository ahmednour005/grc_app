@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Hierarchy'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
@endsection
@section('content')

    <div id="event_result"></div>

    <section class="context-drag-drop-tree">
        <div class="row">

            <!-- Ajax Tree -->
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('hierarchy.Hierarchy') }}</h4>
                    </div>
                    <div class="card-body">
                        <div id="jstree-ajax"></div>
                    </div>
                    <!--/ Ajax Tree -->
                </div>
            </div>

            <!-- Department details -->
            <div class="col-12 col-md-6" style="display: none" id="department-details">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('hierarchy.Department') . ' ' . __('locale.Details') }}</h4>
                    </div>
                    <div class="card-body">
                        <div style="padding-bottom: 10px;">
                            <h5 class="d-inline">{{ __('locale.Name') }}:</h5>
                            <div id="department-data-name" class="d-inline-block p-0"></div>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <h5 class="d-inline">{{ __('locale.Code') }}:</h5>
                            <div id="department-data-code" class="d-inline-block p-0"></div>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <h5 class="d-inline">{{ __('hierarchy.DepartmentColor') }}:</h5>
                            <div id="department-data-color" style="background-color: #f00div"
                                class="d-inline-block text-center rounded p-0">
                                </p>
                            </div>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <h5 class="d-inline">{{ __('hierarchy.Manager') }}:</h5>
                            <div id="department-data-manager" class="d-inline-block p-0"></div>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <h5 class="d-inline">{{ __('hierarchy.ParentDepartment') }}:
                            </h5>
                            <div id="department-data-parent" class="d-inline-block p-0"></div>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <h5 class="d-inline">
                                {{ __('locale.RequiredNumberOfEmplyees') }}:</h5>
                            <div id="department-data-required-num-employee" class="d-inline-block p-0"></div>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <h5 class="d-inline">
                                {{ __('locale.ActualNumberOfEmplyees') }}:</h5>
                            <div id="department-data-actual-num-employee" class="d-inline-block p-0"></div>
                        </div>
                        <div>
                            <h5>{{ __('hierarchy.vision') }}:</h5>
                            <div id="department-data-vision" class="ql-editor"></div>
                        </div>
                        <div>
                            <h5>{{ __('hierarchy.message') }}:</h5>
                            <div id="department-data-message" class="ql-editor"></div>
                        </div>
                        <div>
                            <h5>{{ __('hierarchy.mission') }}:</h5>
                            <div id="department-data-mission" class="ql-editor"></div>
                        </div>
                        <div>
                            <h5>{{ __('hierarchy.objectives') }}:</h5>
                            <div id="department-data-objectives" class="ql-editor"></div>
                        </div>
                        <div>
                            <h5>{{ __('hierarchy.responsibilities') }}:</h5>
                            <div id="department-data-responsibilities" class="ql-editor"></div>
                        </div>
                        <div>
                            <h5 class="d-inline">{{ __('locale.CreatedDate') }}:</h5>
                            <div class="d-inline-block" id="department-data-created-at"></div>
                        </div>
                    </div>
                </div>
                <!--/ Department details -->
            </div>
        </div>

    </section>
    <!--/ Tree section -->
    <div id="quill-content" class="d-none"></div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
@endsection


@section('page-script')
    <script>
        const error = "{{ __('locale.Error') }}",
            success = "{{ __('locale.Success') }}",
            thisIsNotDraggable = "{{ __('locale.ThisIsNotDraggable') }}",
            url = "{{ route('admin.hierarchy.ajax.index') }}",
            updateUrl = "{{ route('admin.hierarchy.ajax.drag_and_drop') }}",
            getDepartmentURL = "{{ route('admin.hierarchy.department.ajax.show', ':id') }}";

        const quill = new Quill('#quill-content', {
            theme: 'bubble'
        });
        const obj = {
            "ops": [{
                "attributes": {
                    "color": "#5e5873",
                    "bold": true
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }, {
                "attributes": {
                    "color": "#5e5873"
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }, {
                "attributes": {
                    "color": "#5e5873"
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }, {
                "attributes": {
                    "color": "#5e5873"
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }, {
                "attributes": {
                    "color": "#5e5873"
                },
                "insert": "رسالة"
            }, {
                "attributes": {
                    "list": "bullet"
                },
                "insert": "\n"
            }]
        };
    </script>
    
    <script src="{{ asset('ajax-files/hierarchy/index.js') }}"></script>

    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

@endsection
