@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.DocumentProgram'))
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
        <div class="todo-app-menu">
            {{--  <div class="add-task"
                style="display: flex;flex-direction:column;align-items:center;justify-content:space-between">

            </div>  --}}

            <div class="sidebar-menu-list pt-2">
                <div class="list-group list-group-filters">
                    <div class="tab CategoryList" id="tabs">
                        @foreach ($category2 as $item)
                            <button
                                class="list-group-item list-group-item-action tablinks sideNavBtn @if (session('doc_current_id_dtb') == $item->id) activeItemTab @endif"
                                id="item{{ $item->id }}">
                                <span class=" fa {{ $item->icon }}" style=" padding: 0 6px;  font-size: 20px; "></span>
                                {{ $item->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @if ($checkCount > 5)
                    <div class="customPgination" style="width: 100px;margin: auto">
                        <input type="hidden" value="1" id="currentPage">
                        <input type="hidden" value="10" id="lastPage">
                        <button id="PrevDocPage" class="btn btn-primary "
                            style="width: 30px;height: 25px;text-align: center;padding: 5px">&#8249;</button>
                        <button id="NexDocPage" class="btn btn-primary "
                            style="width: 30px;height: 25px;text-align: center;padding: 5px;">&#8250;</button>
                    </div>
                @endif

            </div>

        </div>
    </div>

@endsection

@section('content')

    <div class="body-content-overlay"></div>
    <div class="todo-app-list">

        <!-- control List starts -->
        <div class="todo-task-list-wrapper list-group">
            <div class="app-fixed-search d-flex align-items-center justify-content-end p-2">

                @if (auth()->user()->hasPermission('category.create'))
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#new-frame-modal">
                        {{ __('locale.AddNewCategory') }}
                    </button>
                    {{-- <a href="{{ route('admin.governance.notificationsSettingsCateogry') }}" class="dt-button btn btn-primary mx-2 mt-1"
                        target="_self">
                        {{ __('locale.NotificationsSettings') }}
                    </a> --}}
                @endif
            </div>



            <ul class="todo-task-list media-list" id="todo-task-list">

                @foreach ($categoryList as $item)
                    <div id="firstTab{{ $item->id }}" class="tabcontent">

                        <!-- Dark Tables start -->
                        <div class="row" id="dark-table">
                            <div class="col-12">

                                <div class="card2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="frame">
                                                <h4 class="card-title"> {{ __('locale.Name') }} : </h4>
                                                <h5 class="card-desc DocName"> {{ $item->name }} </h5>
                                            </div>

                                            <!-- <a href="#" class="card-link">Another link</a> -->
                                            @if (auth()->user()->hasPermission('category.update'))
                                                <button type="button" class="card-link btn btn-outline-primary updateItem"
                                                    data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->id }}">
                                                    {{ __('locale.Edit') }}
                                                </button>
                                            @endif
                                            @if (auth()->user()->hasPermission('category.delete'))
                                                <button class="card-link btn btn-outline-danger deleteItem"
                                                    alt="item{{ $item->id }}"> {{ __('locale.Delete') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal modal-slide-in sidebar-todo-modal fade EditModal"
                            id="edit-modal{{ $item->id }}">
                            <div class="modal-dialog sidebar-lg">
                                <div class="modal-content p-0">

                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                        <ul></ul>
                                    </div>
                                    <form id="form-edit" class=" form-edit todo-modal needs-validation" novalidate
                                        method="POST" action="{{ route('admin.governance.category.update', $item->id) }}">
                                        @csrf

                                        <div class="modal-header align-items-center mb-1">
                                            <h5 class="modal-title">{{ __('locale.Update') }} {{ __('locale.Category') }}
                                            </h5>
                                            <div
                                                class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                                <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                                        class="font-medium-2"></i></span>
                                                <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal"
                                                    stroke-width="3"></i>
                                            </div>
                                        </div>
                                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                            <div class="action-tags">
                                                <div class="mb-1">
                                                    <label for="title"
                                                        class="form-label">{{ __('locale.Name') }}</label>
                                                    <input type="text" name="name"
                                                        class="form-control FrameNameInput" value="{{ $item->name }}"
                                                        required />
                                                    <span class="error error-name "></span>
                                                </div>
                                                <div class="mb-1 ">
                                                    <label for="task-assigned"
                                                        class="form-label d-block">{{ __('locale.Icons') }}</label>
                                                    <select class="form-select IconsSelect"
                                                        style="text-align-last: left;font-weight: 600;margin-right: 0;vertical-align: text-bottom;"
                                                        id="view_type_sorting" aria-haspopup="true" aria-expanded="false"
                                                        name="icon">
                                                        <option value="" selected disabled hidden>
                                                            {{ __('locale.select-option') }}</option>
                                                        <option {{ $item->icon == 'fas fa-ban' ? 'selected' : '' }}
                                                            value='fas fa-ban'>&#xf05e; fa-ban</option>
                                                        <option {{ $item->icon == 'fas fa-bug' ? 'selected' : '' }}
                                                            value='fas fa-bug'>&#xf188; fa-bug</option>
                                                        <option {{ $item->icon == 'fas fa-dungeon' ? 'selected' : '' }}
                                                            value='fas fa-dungeon'>&#xf6d9; fa-dungeon</option>
                                                        <option {{ $item->icon == 'far fa-eye' ? 'selected' : '' }}
                                                            value='far fa-eye'>&#xf06e; fa-eye </option>
                                                        <option {{ $item->icon == 'far fa-eye-slash' ? 'selected' : '' }}
                                                            value='far fa-eye-slash'>&#xf070; fa-eye-slash </option>
                                                        <option
                                                            {{ $item->icon == 'fas fa-file-signature' ? 'selected' : '' }}
                                                            value='fas fa-file-signature'>&#xf573; fa-file-signature
                                                        </option>
                                                        <option
                                                            {{ $item->icon == 'fas fa-id-fingerprint' ? 'selected' : '' }}
                                                            value='fas fa-id-fingerprint'>&#xf577; fa-id-fingerprint
                                                        </option>
                                                        <option {{ $item->icon == 'far fa-id-badge' ? 'selected' : '' }}
                                                            value='far fa-id-badge'>&#xf2c1; fa-id-badge</option>
                                                        <option {{ $item->icon == 'fas fa-id-badge' ? 'selected' : '' }}
                                                            value='fas fa-id-badge'>&#xf2c1; fa-id-badge </option>
                                                        <option {{ $item->icon == 'far fa-id-card' ? 'selected' : '' }}
                                                            value='far fa-id-card'>&#xf2c2;fa-id-card </option>
                                                        <option {{ $item->icon == 'fas fa-key' ? 'selected' : '' }}
                                                            value='fas fa-key'>&#xf084; fa-key </option>
                                                        <option {{ $item->icon == 'fas  fa-lock' ? 'selected' : '' }}
                                                            value='fas  fa-lock'>&#xf023; fa-lock</option>
                                                        <option {{ $item->icon == 'fas fa-unlock' ? 'selected' : '' }}
                                                            value='fas fa-unlock'>&#xf09c; fa-unlock</option>
                                                        <!-- <option {{ $item->icon == 'fas fa-unlock-alt' ? 'selected' : '' }} value='fas fa-unlock-alt'>&#xf13e; fa-unlock-alt </option> -->
                                                        <!-- <option {{ $item->icon == 'fas user-lock' ? 'selected' : '' }} value='fas user-lock'>&#xf502; user-lock</option> -->
                                                        <option {{ $item->icon == 'fas fa-user-secret' ? 'selected' : '' }}
                                                            value='fas fa-user-secret'>&#xf21b; fa-user-secret </option>
                                                        <option {{ $item->icon == 'fa-underline' ? 'selected' : '' }}
                                                            value='fa-underline'>&#xf0cd; fa-underline </option>
                                                        <option {{ $item->icon == 'fa-undo' ? 'selected' : '' }}
                                                            value='fa-undo'>&#xf0e2; fa-undo </option>
                                                        <option
                                                            {{ $item->icon == 'fa-universal-access' ? 'selected' : '' }}
                                                            value='fa-universal-access'>&#xf29a; fa-universal-access
                                                        </option>
                                                        <option {{ $item->icon == 'fa-university' ? 'selected' : '' }}
                                                            value='fa-university'>&#xf19c; fa-university </option>
                                                        <option {{ $item->icon == 'fa-unlink' ? 'selected' : '' }}
                                                            value='fa-unlink'>&#xf127; fa-unlink </option>
                                                        <option {{ $item->icon == 'fa-unlock' ? 'selected' : '' }}
                                                            value='fa-unlock'>&#xf09c; fa-unlock </option>
                                                        <option {{ $item->icon == 'fa-unlock-alt' ? 'selected' : '' }}
                                                            value='fa-unlock-alt'>&#xf13e; fa-unlock-alt </option>
                                                        <option {{ $item->icon == 'fa-unsorted' ? 'selected' : '' }}
                                                            value='fa-unsorted'>&#xf0dc; fa-unsorted </option>
                                                        <option {{ $item->icon == 'fa-upload' ? 'selected' : '' }}
                                                            value='fa-upload'>&#xf093; fa-upload </option>
                                                        <option {{ $item->icon == 'fa-usb' ? 'selected' : '' }}
                                                            value='fa-usb'>&#xf287; fa-usb </option>
                                                        <option {{ $item->icon == 'fa-usd' ? 'selected' : '' }}
                                                            value='fa-usd'>&#xf155; fa-usd </option>
                                                        <option {{ $item->icon == 'fa-user' ? 'selected' : '' }}
                                                            value='fa-user'>&#xf007; fa-user </option>
                                                        <option {{ $item->icon == 'fa-user-circle' ? 'selected' : '' }}
                                                            value='fa-user-circle'>&#xf2bd; fa-user-circle </option>
                                                        <option {{ $item->icon == 'fa-user-circle-o' ? 'selected' : '' }}
                                                            value='fa-user-circle-o'>&#xf2be; fa-user-circle-o </option>
                                                        <option {{ $item->icon == 'fa-user-md' ? 'selected' : '' }}
                                                            value='fa-user-md'>&#xf0f0; fa-user-md </option>
                                                        <option {{ $item->icon == 'fa-user-o' ? 'selected' : '' }}
                                                            value='fa-user-o'>&#xf2c0; fa-user-o </option>
                                                        <option {{ $item->icon == 'fa-user-plus' ? 'selected' : '' }}
                                                            value='fa-user-plus'>&#xf234; fa-user-plus </option>
                                                        <option {{ $item->icon == 'fa-user-secret' ? 'selected' : '' }}
                                                            value='fa-user-secret'>&#xf21b; fa-user-secret </option>
                                                        <option {{ $item->icon == 'fa-user-times' ? 'selected' : '' }}
                                                            value='fa-user-times'>&#xf235; fa-user-times </option>
                                                        <option {{ $item->icon == 'fa-users' ? 'selected' : '' }}
                                                            value='fa-users'>&#xf0c0; fa-users </option>
                                                        <option {{ $item->icon == 'fa-vcard' ? 'selected' : '' }}
                                                            value='fa-vcard'>&#xf2bb; fa-vcard </option>
                                                        <option {{ $item->icon == 'fa-vcard-o' ? 'selected' : '' }}
                                                            value='fa-vcard-o'>&#xf2bc; fa-vcard-o </option>
                                                        <option {{ $item->icon == 'fa-venus' ? 'selected' : '' }}
                                                            value='fa-venus'>&#xf221; fa-venus </option>
                                                        <option {{ $item->icon == 'fa-venus-double' ? 'selected' : '' }}
                                                            value='fa-venus-double'>&#xf226; fa-venus-double </option>
                                                        <option {{ $item->icon == 'fa-venus-mars' ? 'selected' : '' }}
                                                            value='fa-venus-mars'>&#xf228; fa-venus-mars </option>
                                                        <option {{ $item->icon == 'fa-viacoin' ? 'selected' : '' }}
                                                            value='fa-viacoin'>&#xf237; fa-viacoin </option>
                                                        <option {{ $item->icon == 'fa-viadeo' ? 'selected' : '' }}
                                                            value='fa-viadeo'>&#xf2a9; fa-viadeo </option>
                                                        <option {{ $item->icon == 'fa-viadeo-square' ? 'selected' : '' }}
                                                            value='fa-viadeo-square'>&#xf2aa; fa-viadeo-square </option>
                                                        <option {{ $item->icon == 'fa-video-camera' ? 'selected' : '' }}
                                                            value='fa-video-camera'>&#xf03d; fa-video-camera </option>
                                                        <option {{ $item->icon == 'fa-vimeo' ? 'selected' : '' }}
                                                            value='fa-vimeo'>&#xf27d; fa-vimeo </option>
                                                        <option {{ $item->icon == 'fa-vimeo-square' ? 'selected' : '' }}
                                                            value='fa-vimeo-square'>&#xf194; fa-vimeo-square </option>
                                                        <option {{ $item->icon == 'fa-vine' ? 'selected' : '' }}
                                                            value='fa-vine'>&#xf1ca; fa-vine </option>
                                                        <option {{ $item->icon == 'fa-vk' ? 'selected' : '' }}
                                                            value='fa-vk'>&#xf189; fa-vk </option>
                                                        <option
                                                            {{ $item->icon == 'fa-volume-control-phone' ? 'selected' : '' }}
                                                            value='fa-volume-control-phone'>&#xf2a0;
                                                            fa-volume-control-phone </option>
                                                        <option {{ $item->icon == 'fa-volume-down' ? 'selected' : '' }}
                                                            value='fa-volume-down'>&#xf027; fa-volume-down </option>
                                                        <option {{ $item->icon == 'fa-volume-off' ? 'selected' : '' }}
                                                            value='fa-volume-off'>&#xf026; fa-volume-off </option>
                                                        <option {{ $item->icon == 'fa-volume-up' ? 'selected' : '' }}
                                                            value='fa-volume-up'>&#xf028; fa-volume-up </option>
                                                        <option {{ $item->icon == 'fa-warning' ? 'selected' : '' }}
                                                            value='fa-warning'>&#xf071; fa-warning </option>
                                                        <option {{ $item->icon == 'fa-wechat' ? 'selected' : '' }}
                                                            value='fa-wechat'>&#xf1d7; fa-wechat </option>
                                                        <option {{ $item->icon == 'fa-weibo' ? 'selected' : '' }}
                                                            value='fa-weibo'>&#xf18a; fa-weibo </option>
                                                        <option {{ $item->icon == 'fa-weixin' ? 'selected' : '' }}
                                                            value='fa-weixin'>&#xf1d7; fa-weixin </option>
                                                        <option {{ $item->icon == 'fa-whatsapp' ? 'selected' : '' }}
                                                            value='fa-whatsapp'>&#xf232; fa-whatsapp </option>
                                                        <option {{ $item->icon == 'fa-wheelchair' ? 'selected' : '' }}
                                                            value='fa-wheelchair'>&#xf193; fa-wheelchair </option>
                                                        <option {{ $item->icon == 'fa-wheelchair-alt' ? 'selected' : '' }}
                                                            value='fa-wheelchair-alt'>&#xf29b; fa-wheelchair-alt </option>
                                                        <option {{ $item->icon == 'fa-wifi' ? 'selected' : '' }}
                                                            value='fa-wifi'>&#xf1eb; fa-wifi </option>
                                                    </select>
                                                    <span class="error error-icon "></span>
                                                </div>
                                            </div>
                                            <div class="my-1">

                                                <button type="submit"
                                                    class="btn btn-primary update-btn  me-1">{{ __('locale.Update') }}</button>
                                                <button type="button" class="btn btn-outline-danger update-btn "
                                                    data-bs-dismiss="modal">
                                                    {{ __('locale.Delete') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--edit category ends -->

                        <!-- add document starts -->
                        <div class="modal modal-slide-in sidebar-todo-modal fade add_document"
                            id="add_control{{ $item->id }}">
                            <div class="modal-dialog sidebar-lg">
                                <div class="modal-content p-0">
                                    <form class=" form-add_control todo-modal needs-validation" novalidate method="POST"
                                        action="{{ route('admin.governance.document.store', $item->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="modal-header align-items-center mb-1">
                                            <h5 class="modal-title">{{ __('locale.AddANewDocument') }}</h5>
                                            <div
                                                class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                                <span class="todo-item-favorite cursor-pointer me-75"><i
                                                        data-feather="star" class="font-medium-2"></i></span>
                                                <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal"
                                                    stroke-width="3"></i>
                                            </div>
                                        </div>
                                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                            <div class="action-tags">
                                                <div class="mb-1">
                                                    <label for="title"
                                                        class="form-label">{{ __('locale.Name') }}</label>
                                                    <input type="text" name="name" class=" form-control"
                                                        required />
                                                    <span class="error error-name "></span>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('governance.Frameworks') }}</label>
                                                    <select class="js-example-basic-multiple" _id="framework"
                                                        name="framework_ids[]" multiple>
                                                        @foreach ($frameworks as $framework)
                                                            <option class="option"
                                                                data-controls="{{ json_encode($framework->FrameworkControls) }}"
                                                                value="{{ $framework->id }}"
                                                                data-available_text="{{ $framework->id }}">
                                                                {{ $framework->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-framework_ids"></span>
                                                </div>

                                                <div class="mb-1">
                                                    <label class="form-label">{{ __('governance.Controls') }}</label>
                                                    <select class="js-example-basic-multiple" name="control_ids[]"
                                                        _id="controls_id" multiple="multiple">
                                                    </select>
                                                    <span class="error error-control_ids"></span>
                                                </div>

                                                <!-- //AdditionalStakeholders -->
                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="additional_stakeholders">{{ __('locale.AdditionalStakeholders') }}</label>
                                                    <select name="additional_stakeholders[]"
                                                        class="js-example-basic-multiple" _id="additional_stakeholders"
                                                        multiple>
                                                        <option value="">{{ __('locale.select-option') }}</option>
                                                        @foreach ($testers as $tester)
                                                            <option value="{{ $tester->id }}">{{ $tester->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    <span class="error error-additional_stakeholders"></span>
                                                </div>

                                                <!-- //owner -->

                                                @if (auth()->user()->role_id == 1)
                                                    <div class="mb-1">
                                                        <label class="form-label"
                                                            for="owner">{{ __('locale.DocumentOwner') }}</label>
                                                        <select class="select2 form-select" _id="task-assigned"
                                                            name="owner">
                                                            <option value="">{{ __('locale.select-option') }}
                                                            </option>
                                                            @foreach ($owners as $owner)
                                                                <option value="{{ $owner->id }}">{{ $owner->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="error error-owner"></span>
                                                    </div>
                                                @endif

                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="teams">{{ __('locale.Teams') }}</label>

                                                    <select _id="teams" name="team_ids[]"
                                                        class="js-example-basic-multiple" multiple>
                                                        <option value="">{{ __('locale.select-option') }}</option>
                                                        @foreach ($teams as $team)
                                                            <option value="{{ $team->id }}">{{ $team->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-team_ids"></span>
                                                </div>

                                                <div class="mb-1">
                                                    <label for="">{{ __('locale.CreationDate') }}</label>
                                                    <input type="text" name="creation_date"
                                                        value="<?php echo date('Y-m-d'); ?>" id="creation_date"
                                                        class="form-control js-datepicker">
                                                    <span class="error error-creation_date"></span>
                                                </div>

                                                <div class="mb-1">
                                                    <label for="">{{ __('locale.LastReview') }}</label>
                                                    <input type="text" data-i="0" name="last_review_date"
                                                        value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD "
                                                        id="last_review" class="form-control js-datepicker">
                                                    <span class="error error-last_review_date"></span>
                                                </div>

                                                <div class="mb-1">
                                                    <label for="">{{ __('locale.ReviewFrequency') }}
                                                        ({{ __('locale.days') }})</label>
                                                    <input type="number" min="0" name="review_frequency"
                                                        id="review_frequency" value="0" class="form-control">
                                                    <span class="error error-review_frequency"></span>
                                                </div>

                                                <div class="mb-1">
                                                    <label for="">{{ __('locale.NextReviewDate') }}</label>
                                                    <input type="text" data-i="0"disabled name="next_review_date"
                                                        placeholder="YYYY-MM-DD " id="next_review" class="form-control">
                                                    <span class="error error-next_review_date"></span>
                                                </div>

                                                {{-- <div class="mb-1">
                                            <label for=""> ParentDocument </label>
                                            <div class="parent_documents_container">
                                                <select name="parent" class="form-select select2 ">
                                                    <option value="">select parent</option>
                                                    @foreach ($documents as $doc)
                                                    <option value="{{$doc->id}}">{{$doc->document_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}

                                                <div class="mb-1">
                                                    <label for="">{{ __('locale.Status') }}</label>
                                                    <div class="parent_documents_container">
                                                        <select name="status" _id="status"
                                                            class="form-select select2 "
                                                            onchange="changePrivacy(this.value)">
                                                            <option value="" selected disabled hidden>
                                                                {{ __('locale.select-option') }}</option>
                                                            @foreach ($status as $sta)
                                                                <option value="{{ $sta->id }}">{{ $sta->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="error error-status"></span>
                                                    </div>
                                                </div>

                                                <div class="mb-1" id="approval_date">
                                                    <label for="">{{ __('locale.ApprovalDate') }}</label>
                                                    <input type="text" data-i="0" name="approval_date"
                                                        placeholder="YYYY-MM-DD " class="form-control js-datepicker">
                                                    <span class="error error-approval_date"></span>
                                                </div>

                                                <!-- //owner -->
                                                <div class="mb-1" id="reviewer">
                                                    <label class="form-label"
                                                        for="reviewer">{{ __('locale.Reviewer') }}</label>
                                                    <select class="select2 form-select" name="reviewer">
                                                        <option value="">{{ __('locale.select-option') }}</option>
                                                        @foreach ($testers as $tester)
                                                            <option value="{{ $tester->id }}">{{ $tester->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error error-reviewer"></span>
                                                </div>

                                                <div class="mb-1" id="privacy">
                                                    <label for="">{{ __('locale.Privacy') }}</label>
                                                    <div class="parent_documents_container">
                                                        <select name="privacy" class="form-select select2 ">
                                                            @foreach ($privacies as $priv)
                                                                <option value="{{ $priv->id }}">{{ $priv->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="error error-privacy"></span>
                                                    </div>
                                                </div>

                                                <div class="mb-1 supporting_documentation_container">
                                                    <label class="text-label">{{ __('locale.File') }}</label>
                                                    :
                                                    <input type="file" name="file" class="form-control dt-post"
                                                        aria-label="{{ __('locale.File') }}" />
                                                    <span class="error error-file "></span>
                                                </div>

                                                <div class="my-1">
                                                    <button type="submit"
                                                        class="btn btn-primary add-todo-item me-1">{{ __('locale.Add') }}</button>
                                                    <button type="button"
                                                        class="btn btn-outline-secondary add-todo-item "
                                                        data-bs-dismiss="modal">
                                                        {{ __('locale.Cancel') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- add document end -->

                        <li class="todo-item">

                            <!-- Advanced Search -->
                            <section id="advanced-search-datatable">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">

                                            <div class="card-header border-bottom p-1">
                                                <div class="head-label">
                                                    <h4 class="card-title">{{ __('governance.Documents') }}</h4>
                                                </div>
                                                @if (auth()->user()->hasPermission('document.create'))
                                                    <div class="dt-action-buttons text-end">
                                                        <div class="dt-buttons d-inline-flex">
                                                            <button class="dt-button  btn btn-primary  me-2 AddDocBtn"
                                                                type="button" data-bs-toggle="modal"
                                                                data-bs-target="#add_control{{ $item->id }}">
                                                                {{ __('locale.AddANewDocument') }}
                                                            </button>
                                                            <a href="{{ route('admin.governance.notificationsSettingsDocumentation') }}"
                                                                class="dt-button btn btn-primary me-2" target="_self">
                                                                {{ __('locale.NotificationsSettings') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!--Search Form -->

                                            <hr class="my-0" />
                                            <div class="card-datatable table-responsive mx-1">

                                                <table class="table DocTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="all">{{ __('locale.Name') }}</th>
                                                            <th class="all">{{ __('governance.Frameworks') }}</th>
                                                            <th class="all">{{ __('governance.Controls') }}</th>
                                                            <th class="all">{{ __('locale.CreationDate') }}</th>
                                                            <th class="all">{{ __('locale.ApprovalDate') }}</th>
                                                            <th class="all">{{ __('locale.Status') }}</th>
                                                            <th class="all">{{ __('locale.Actions') }}</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!--/ Advanced Search -->
                        </li>
                    </div>
                @endforeach
            </ul>
            <div class="no-results">
                <h5>No Items Found</h5>
            </div>
        </div>
        <!-- Todo List ends -->
    </div>


    <!-- Right Sidebar starts -->

    <!-- add category start -->
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-frame-modal">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <form id="add_frame" class="add_frame todo-modal needs-validation" novalidate method="POST"
                    action="{{ route('admin.governance.category.store') }}">
                    @csrf

                    <div class="modal-header align-items-center mb-1">
                        <h5 class="modal-title">{{ __('locale.AddNewCategory') }}</h5>
                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                            <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                    class="font-medium-2"></i></span>
                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('locale.Title') }}</label>
                                <input type="text" name="name" class=" form-control" placeholder="Title"
                                    required />
                                <span class="error error-name "></span>
                            </div>

                            <div class="mb-1 ">
                                <label for="task-assigned" class="form-label d-block">{{ __('locale.Icons') }}</label>
                                <select class="form-select"
                                    style="text-align-last: left;font-weight: 600;margin-right: 0;vertical-align: text-bottom;"
                                    id="view_type_sorting" aria-haspopup="true" aria-expanded="false" name="icon">
                                    <option value="" selected disabled hidden>{{ __('locale.select-option') }}
                                    </option>
                                    <option value='fas fa-ban'>&#xf05e; fa-ban</option>
                                    <option value='fas fa-bug'>&#xf188; fa-bug</option>
                                    <option value='fas fa-dungeon'>&#xf6d9; fa-dungeon</option>
                                    <option value='far fa-eye'>&#xf06e; fa-eye </option>
                                    <option value='far fa-eye-slash'>&#xf070; fa-eye-slash </option>
                                    <option value='fas fa-file-signature'>&#xf573; fa-file-signature</option>
                                    <option value='fas fa-id-fingerprint'>&#xf577; fa-id-fingerprint </option>
                                    <option value='far fa-id-badge'>&#xf2c1; fa-id-badge</option>
                                    <option value='fas fa-id-badge'>&#xf2c1; fa-id-badge </option>
                                    <option value='far fa-id-card'>&#xf2c2;fa-id-card </option>
                                    <option value='fas fa-key'>&#xf084; fa-key </option>
                                    <option value='fas  fa-lock'>&#xf023; fa-lock</option>
                                    <option value='fas fa-unlock'>&#xf09c; fa-unlock</option>
                                    <!-- <option value='fas fa-unlock-alt'>&#xf13e; fa-unlock-alt </option> -->
                                    <!-- <option value='fas user-lock'>&#xf502; user-lock</option> -->
                                    <option value='fas fa-user-secret'>&#xf21b; fa-user-secret </option>
                                    <option value='fa-underline'>&#xf0cd; fa-underline </option>
                                    <option value='fa-undo'>&#xf0e2; fa-undo </option>
                                    <option value='fa-universal-access'>&#xf29a; fa-universal-access </option>
                                    <option value='fa-university'>&#xf19c; fa-university </option>
                                    <option value='fa-unlink'>&#xf127; fa-unlink </option>
                                    <option value='fa-unlock'>&#xf09c; fa-unlock </option>
                                    <option value='fa-unlock-alt'>&#xf13e; fa-unlock-alt </option>
                                    <option value='fa-unsorted'>&#xf0dc; fa-unsorted </option>
                                    <option value='fa-upload'>&#xf093; fa-upload </option>
                                    <option value='fa-usb'>&#xf287; fa-usb </option>
                                    <option value='fa-usd'>&#xf155; fa-usd </option>
                                    <option value='fa-user'>&#xf007; fa-user </option>
                                    <option value='fa-user-circle'>&#xf2bd; fa-user-circle </option>
                                    <option value='fa-user-circle-o'>&#xf2be; fa-user-circle-o </option>
                                    <option value='fa-user-md'>&#xf0f0; fa-user-md </option>
                                    <option value='fa-user-o'>&#xf2c0; fa-user-o </option>
                                    <option value='fa-user-plus'>&#xf234; fa-user-plus </option>
                                    <option value='fa-user-secret'>&#xf21b; fa-user-secret </option>
                                    <option value='fa-user-times'>&#xf235; fa-user-times </option>
                                    <option value='fa-users'>&#xf0c0; fa-users </option>
                                    <option value='fa-vcard'>&#xf2bb; fa-vcard </option>
                                    <option value='fa-vcard-o'>&#xf2bc; fa-vcard-o </option>
                                    <option value='fa-venus'>&#xf221; fa-venus </option>
                                    <option value='fa-venus-double'>&#xf226; fa-venus-double </option>
                                    <option value='fa-venus-mars'>&#xf228; fa-venus-mars </option>
                                    <option value='fa-viacoin'>&#xf237; fa-viacoin </option>
                                    <option value='fa-viadeo'>&#xf2a9; fa-viadeo </option>
                                    <option value='fa-viadeo-square'>&#xf2aa; fa-viadeo-square </option>
                                    <option value='fa-video-camera'>&#xf03d; fa-video-camera </option>
                                    <option value='fa-vimeo'>&#xf27d; fa-vimeo </option>
                                    <option value='fa-vimeo-square'>&#xf194; fa-vimeo-square </option>
                                    <option value='fa-vine'>&#xf1ca; fa-vine </option>
                                    <option value='fa-vk'>&#xf189; fa-vk </option>
                                    <option value='fa-volume-control-phone'>&#xf2a0; fa-volume-control-phone </option>
                                    <option value='fa-volume-down'>&#xf027; fa-volume-down </option>
                                    <option value='fa-volume-off'>&#xf026; fa-volume-off </option>
                                    <option value='fa-volume-up'>&#xf028; fa-volume-up </option>
                                    <option value='fa-warning'>&#xf071; fa-warning </option>
                                    <option value='fa-wechat'>&#xf1d7; fa-wechat </option>
                                    <option value='fa-weibo'>&#xf18a; fa-weibo </option>
                                    <option value='fa-weixin'>&#xf1d7; fa-weixin </option>
                                    <option value='fa-whatsapp'>&#xf232; fa-whatsapp </option>
                                    <option value='fa-wheelchair'>&#xf193; fa-wheelchair </option>
                                    <option value='fa-wheelchair-alt'>&#xf29b; fa-wheelchair-alt </option>
                                    <option value='fa-wifi'>&#xf1eb; fa-wifi </option>
                                </select>
                                <span class="error error-icon"></span>
                            </div>
                        </div>
                        <div class="my-1">
                            <button type="submit"
                                class="btn btn-primary   add-todo-item me-1">{{ __('locale.Add') }}</button>
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

    <!-- edit category start -->
    <!-- //edit control -->
    <!-- Right Sidebar ends -->



    <!-- Right Sidebar ends -->
    <form class="" id="download-doc-note-file-form" method="post"
        action="{{ route('admin.governance.download_note_file') }}">

        @csrf
        <input type="text" name="id">
        <input type="text" name="document_id">
    </form>

    {{-- Start update document --}}
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit_contModal" role="dialog">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">


                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title" data-title="{{ __('locale.EditDocument') }}">
                        {{ __('locale.EditDocument') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                class="font-medium-2"></i></span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>

                {{-- Update document --}}
                <form id="form-update_control" class="todo-modal" novalidate method="POST"
                    action="{{ route('admin.governance.document.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="action-tags">

                            <input type="hidden" name="id">
                            {{-- Name --}}
                            <div class="mb-1">
                                <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                                <input type="text" name="name" class=" form-control" placeholder="Name"
                                    required />
                                <span class="error error-name"></span>
                            </div>

                            {{-- Frameworks --}}
                            <div class="mb-1">
                                <label class="form-label">{{ __('governance.Frameworks') }}</label>
                                <select class="js-example-basic-multiple" __id="framework" name="framework_ids[]"
                                    multiple>
                                    @foreach ($frameworks as $framework)
                                        <option class="option" value="{{ $framework->id }}"
                                            data-controls="{{ json_encode($framework->FrameworkControls) }}"
                                            data-available_text="{{ $framework->id }}">{{ $framework->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-framework_ids"></span>
                            </div>

                            {{-- Controls --}}
                            <div class="mb-1">
                                <label class="form-label">{{ __('governance.Controls') }}</label>
                                <select class="js-example-basic-multiple" name="control_ids[]" __id="controls_id"
                                    multiple="multiple">
                                </select>
                                <span class="error error-control_ids"></span>
                            </div>

                            {{-- Additional Stakeholders --}}
                            <div class="mb-1">
                                <label class="form-label"
                                    for="additional_stakeholders">{{ __('locale.AdditionalStakeholders') }}</label>
                                <select name="additional_stakeholders[]" class="js-example-basic-multiple"
                                    __id="additional_stakeholders" multiple>
                                    @foreach ($testers as $tester)
                                        <option value="{{ $tester->id }}">{{ $tester->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-additional_stakeholders"></span>
                            </div>

                            {{-- Owner --}}
                            @if (auth()->user()->role_id == 1)
                                <div class="mb-1">
                                    <label class="form-label" for="owner">{{ __('locale.DocumentOwner') }}</label>
                                    <select class="select2 form-select" __id="task-assigned" name="owner">
                                        <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                        </option>
                                        @foreach ($owners as $owner)
                                            <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-owner"></span>
                                </div>
                            @endif

                            {{-- Teams --}}
                            <div class="mb-1">
                                <label class="form-label" for="teams">{{ __('locale.Teams') }}</label>
                                <select __id="teams" name="team_ids[]" class="js-example-basic-multiple" multiple>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-teams"></span>
                            </div>

                            {{-- Creation Date --}}
                            <div class="mb-1">
                                <label for="">{{ __('locale.CreationDate') }}</label>
                                <input type="text" disabled name="creation_date" __id="creation_date"
                                    class="form-control">
                                <span class="error error-creation_date"></span>
                            </div>

                            {{-- Last Review --}}
                            <div class="mb-1">
                                <label for="">{{ __('locale.LastReview') }}</label>
                                <input type="text" data-i="0" name="last_review_date" value="<?php echo date('Y-m-d'); ?>"
                                    placeholder="YYYY-MM-DD " __id="last_review" class="form-control js-datepicker">
                                <span class="error error-last_review_date"></span>
                            </div>

                            {{-- Review Frequency --}}
                            <div class="mb-1">
                                <label for="">{{ __('locale.ReviewFrequency') }} ({{ __('locale.days') }})
                                </label>
                                <input type="number" min="0" name="review_frequency" __id="review_frequency"
                                    value="0" class="form-control">
                                <span class="error error-review_frequency"></span>
                            </div>

                            {{-- Next Review Date --}}
                            <div class="mb-1">
                                <label for="">{{ __('locale.NextReviewDate') }}</label>
                                <input type="text" data-i="0" disabled name="next_review_date"
                                    placeholder="YYYY-MM-DD " __id="next_review" class="form-control">
                                <span class="error error-next_review_date"></span>
                            </div>

                            {{-- Parent Document --}}
                            {{-- <div class="mb-1">
                            <label for="">{{__('locale.ParentDocument')}}</label>
                            <div class="parent_documents_container">
                                <select name="parent" class="form-select select2 ">
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                    @foreach ($documents as $doc)
                                    <option value="{{$doc->id}}">{{$doc->document_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                            {{-- Status --}}
                            <div class="mb-1">
                                <label for="">{{ __('locale.Status') }}</label>
                                <div class="parent_documents_container">
                                    <select name="status" __id="status" class="form-select select2 "
                                        onchange="changePrivacy2(this.value)">
                                        <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                        </option>
                                        @foreach ($status as $sta)
                                            <option value="{{ $sta->id }}">{{ $sta->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-status"></span>
                                </div>
                            </div>

                            {{-- Reviewer --}}
                            <div class="mb-1" id="reviewer_update">
                                <label class="form-label" for="reviewer">{{ __('locale.Reviewer') }}</label>
                                <select class="select2 form-select" name="reviewer">
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($testers as $tester)
                                        <option value="{{ $tester->id }}">{{ $tester->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-reviewer"></span>
                            </div>

                            {{-- Approval Date --}}
                            <div class="mb-1" id="approval_date_update">
                                <label for="">{{ __('locale.ApprovalDate') }}</label>
                                <input type="text" data-i="0" name="approval_date" placeholder="YYYY-MM-DD "
                                    class="form-control js-datepicker">
                                <span class="error error-approval_date"></span>
                            </div>

                            {{-- privacy --}}
                            <div class="mb-1" id="privacy_update">
                                <label for="">{{ __('locale.Privacy') }}</label>
                                <div class="parent_documents_container">
                                    <select name="privacy" class="form-select select2 ">
                                        <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                        </option>
                                        @foreach ($privacies as $priv)
                                            <option value="{{ $priv->id }}">{{ $priv->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error error-privacy"></span>
                                </div>
                            </div>

                            {{-- File --}}
                            <div class="mb-1 supporting_documentation_container">
                                <label class="text-label">{{ __('locale.File') }}</label>
                                :
                                <input type="file" name="file" class="form-control dt-post"
                                    aria-label="{{ __('locale.File') }}" />
                                <span class="error error-file"></span>
                            </div>

                            {{-- Submit button --}}
                            <div class="my-1">
                                <button type="submit"
                                    class="btn btn-primary   add-todo-item me-1">{{ __('locale.Update') }}</button>
                                <button type="button" class="btn btn-outline-secondary add-todo-item "
                                    data-bs-dismiss="modal">
                                    {{ __('locale.Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="border-bottom mx-1 my-1">
                </div>

                <div id="chat-container">
                    <!-- Main chat area -->
                    <section class="chat-app-window">
                        <!-- To load Conversation -->
                        <div class="start-chat-area">
                            <h4 class="sidebar-toggle start-chat-text mx-1">{{ __('locale.DocumentNotes') }}</h4>
                        </div>
                        <!--/ To load Conversation -->

                        <!-- Active Chat -->
                        <div class="active-chat">
                            <!-- Chat Header -->
                            <div class="chat-navbar">
                                <header class="chat-header d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="sidebar-toggle d-block d-lg-none me-1">
                                            <i data-feather="menu" class="font-medium-5"></i>
                                        </div>
                                        <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                            <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}"
                                                alt="avatar" height="36" width="36" />
                                            <span class="avatar-status-busy"></span>
                                        </div>
                                        <h6 class="mb-0">Kristopher Candy</h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i data-feather="phone-call"
                                            class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                        <i data-feather="video"
                                            class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                        <i data-feather="search"
                                            class="cursor-pointer d-sm-block d-none font-medium-2"></i>
                                        <div class="dropdown">
                                            <button class="btn-icon btn btn-transparent hide-arrow btn-sm dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i data-feather="more-vertical" id="chat-header-actions"
                                                    class="font-medium-2"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="chat-header-actions">
                                                <a class="dropdown-item" href="#">View Contact</a>
                                                <a class="dropdown-item" href="#">Mute Notifications</a>
                                                <a class="dropdown-item" href="#">Block Contact</a>
                                                <a class="dropdown-item" href="#">Clear Chat</a>
                                                <a class="dropdown-item" href="#">Report</a>
                                            </div>
                                        </div>
                                    </div>
                                </header>
                            </div>
                            <!--/ Chat Header -->

                            <!-- User Chat messages -->
                            <div class="user-chats">
                                <div class="chats">
                                </div>
                            </div>
                            <!-- User Chat messages -->
                            <p class="my-0 mx-2 file-name" data-content="{{ __('locale.FileName', ['name' => '']) }}">
                            </p>
                            <!-- Submit Chat form -->
                            <form class="chat-app-form" id="chat-app-form" action="javascript:void(0);"
                                onsubmit="enterChat('#edit_contModal');">
                                @csrf
                                <input type="hidden" name="document_id" />
                                <div class="input-group input-group-merge me-1 form-send-message">
                                    <input type="text" class="form-control message"
                                        placeholder="{{ __('locale.TypeYourNote') }}" />
                                    <span class="input-group-text" title="hhhh">
                                        <label for="attach-doc" class="attachment-icon form-label mb-0">
                                            <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                            <input name="note_file" type="file" class="attach-doc" id="attach-doc"
                                                hidden /> </label></span>
                                </div>
                                <button type="button" class="btn btn-primary send"
                                    onclick="enterChat('#edit_contModal');">
                                    {{-- <i data-feather="send" class="d-lg-none"></i> --}}
                                    <i data-feather="send"></i>
                                    {{-- <span class="d-none d-lg-block">Send</span> --}}
                                </button>
                            </form>
                            <!--/ Submit Chat form -->
                        </div>
                        <!--/ Active Chat -->
                    </section>
                    <!--/ Main chat area -->
                </div>

            </div>
        </div>
    </div>
    {{-- End update document --}}

    {{-- Start show document --}}
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="show_contModal" role="dialog">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">


                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title" data-title="{{ __('locale.EditDocument') }}">
                        {{ __('locale.EditDocument') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                class="font-medium-2"></i></span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>

                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div class="action-tags">

                        <input type="hidden" name="id">
                        {{-- Name --}}
                        <div class="mb-1">
                            <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                            <input type="text" name="name" class=" form-control" placeholder="Name" disabled />
                        </div>

                        {{-- Frameworks --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('governance.Frameworks') }}</label>
                            <select class="js-example-basic-multiple" __id="framework" name="framework_ids[]" multiple
                                disabled>
                            </select>
                        </div>

                        {{-- Controls --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('governance.Controls') }}</label>
                            <select class="js-example-basic-multiple" name="control_ids[]" __id="controls_id"
                                multiple="multiple" disabled>
                            </select>
                        </div>

                        {{-- Additional Stakeholders --}}
                        <div class="mb-1">
                            <label class="form-label"
                                for="additional_stakeholders">{{ __('locale.AdditionalStakeholders') }}</label>
                            <select name="additional_stakeholders[]" class="js-example-basic-multiple"
                                __id="additional_stakeholders" multiple disabled>
                            </select>
                        </div>

                        {{-- Owner --}}
                        @if (auth()->user()->role_id == 1)
                            <div class="mb-1">
                                <label class="form-label" for="owner">{{ __('locale.DocumentOwner') }}</label>
                                <select class="select2 form-select" __id="task-assigned" name="owner" disabled>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                </select>
                            </div>
                        @endif

                        {{-- Teams --}}
                        <div class="mb-1">
                            <label class="form-label" for="teams">{{ __('locale.Teams') }}</label>
                            <select __id="teams" name="team_ids[]" class="js-example-basic-multiple" multiple disabled>
                            </select>
                        </div>

                        {{-- Creation Date --}}
                        <div class="mb-1">
                            <label for="">{{ __('locale.CreationDate') }}</label>
                            <input type="text" disabled name="creation_date" __id="creation_date"
                                class="form-control" disabled>
                        </div>

                        {{-- Last Review --}}
                        <div class="mb-1">
                            <label for="">{{ __('locale.LastReview') }}</label>
                            <input type="text" data-i="0" name="last_review_date" disabled
                                value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD " __id="last_review"
                                class="form-control">
                        </div>

                        {{-- Review Frequency --}}
                        <div class="mb-1">
                            <label for="">{{ __('locale.ReviewFrequency') }} ({{ __('locale.days') }}) </label>
                            <input type="number" min="0" name="review_frequency" __id="review_frequency"
                                value="0" class="form-control" disabled>
                        </div>

                        {{-- Next Review Date --}}
                        <div class="mb-1">
                            <label for="">{{ __('locale.NextReviewDate') }}</label>
                            <input type="text" data-i="0" disabled name="next_review_date"
                                placeholder="YYYY-MM-DD " __id="next_review" class="form-control" disabled>
                        </div>

                        {{-- Status --}}
                        <div class="mb-1">
                            <label for="">{{ __('locale.Status') }}</label>
                            <div class="parent_documents_container">
                                <select name="status" __id="status" class="form-select select2 "
                                    onchange="changePrivacy3(this.value)" disabled>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($status as $sta)
                                        <option value="{{ $sta->id }}">{{ $sta->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-status"></span>
                            </div>
                        </div>

                        {{-- Reviewer --}}
                        <div class="mb-1" id="reviewer_show">
                            <label class="form-label" for="reviewer">{{ __('locale.Reviewer') }}</label>
                            <select class="select2 form-select" name="reviewer" disabled>
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                            </select>
                            <span class="error error-reviewer"></span>
                        </div>

                        {{-- Approval Date --}}
                        <div class="mb-1" id="approval_date_show">
                            <label for="">{{ __('locale.ApprovalDate') }}</label>
                            <input type="text" data-i="0" name="approval_date" placeholder="YYYY-MM-DD "
                                class="form-control" disabled>
                            <span class="error error-approval_date"></span>
                        </div>

                        {{-- privacy --}}
                        <div class="mb-1" id="privacy_show">
                            <label for="">{{ __('locale.Privacy') }}</label>
                            <div class="parent_documents_container">
                                <select name="privacy" class="form-select select2" disabled>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    @foreach ($privacies as $priv)
                                        <option value="{{ $priv->id }}">{{ $priv->title }}</option>
                                    @endforeach
                                </select>
                                <span class="error error-privacy"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-bottom mx-1 my-1">
                </div>

                {{-- chat container --}}
                <div>
                    <!-- Main chat area -->
                    <section class="chat-app-window">
                        <!-- To load Conversation -->
                        <div class="start-chat-area">
                            <h4 class="sidebar-toggle start-chat-text mx-1">{{ __('locale.DocumentNotes') }}</h4>
                        </div>
                        <!--/ To load Conversation -->

                        <!-- Active Chat -->
                        <div class="active-chat">
                            <!-- Chat Header -->
                            <div class="chat-navbar">
                                <header class="chat-header d-none">
                                    <div class="d-flex align-items-center">
                                        <div class="sidebar-toggle d-block d-lg-none me-1">
                                            <i data-feather="menu" class="font-medium-5"></i>
                                        </div>
                                        <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                            <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}"
                                                alt="avatar" height="36" width="36" />
                                            <span class="avatar-status-busy"></span>
                                        </div>
                                        <h6 class="mb-0">Kristopher Candy</h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i data-feather="phone-call"
                                            class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                        <i data-feather="video"
                                            class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                        <i data-feather="search"
                                            class="cursor-pointer d-sm-block d-none font-medium-2"></i>
                                        <div class="dropdown">
                                            <button class="btn-icon btn btn-transparent hide-arrow btn-sm dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i data-feather="more-vertical" class="font-medium-2"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="chat-header-actions">
                                                <a class="dropdown-item" href="#">View Contact</a>
                                                <a class="dropdown-item" href="#">Mute Notifications</a>
                                                <a class="dropdown-item" href="#">Block Contact</a>
                                                <a class="dropdown-item" href="#">Clear Chat</a>
                                                <a class="dropdown-item" href="#">Report</a>
                                            </div>
                                        </div>
                                    </div>
                                </header>
                            </div>
                            <!--/ Chat Header -->

                            <!-- User Chat messages -->
                            <div class="user-chats">
                                <div class="chats">
                                </div>
                            </div>
                            <!-- User Chat messages -->
                            <p class="my-0 mx-2 file-name" data-content="{{ __('locale.FileName', ['name' => '']) }}">
                            </p>
                            <!-- Submit Chat form -->
                            <form class="chat-app-form" _id="chat-app-form" action="javascript:void(0);"
                                onsubmit="enterChat('#show_contModal');">
                                @csrf
                                <input type="hidden" name="document_id" />
                                <div class="input-group input-group-merge me-1 form-send-message">
                                    <input type="text" class="form-control message"
                                        placeholder="{{ __('locale.TypeYourNote') }}" />
                                    <span class="input-group-text" title="hhhh">
                                        <label for="attach-doc2" class="attachment-icon form-label mb-0">
                                            <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                            <input name="note_file" type="file" class="attach-doc" id="attach-doc2"
                                                hidden /> </label></span>
                                </div>
                                <button type="button" class="btn btn-primary send"
                                    onclick="enterChat('#show_contModal');">
                                    {{-- <i data-feather="send" class="d-lg-none"></i> --}}
                                    <i data-feather="send"></i>
                                    {{-- <span class="d-none d-lg-block">Send</span> --}}
                                </button>
                            </form>
                            <!--/ Submit Chat form -->
                        </div>
                        <!--/ Active Chat -->
                    </section>
                    <!--/ Main chat area -->
                </div>

            </div>
        </div>
    </div>
    {{-- End show document --}}

    <!-- collapseAuditTrail end -->
    <form class="d-none" id="download-file-form" method="post"
        action="{{ route('admin.governance.ajax.download_file') }}">
        @csrf
        {{-- <input type="hidden" name="id"> --}}
        <input type="hidden" name="document_id">
    </form>
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
    <script src="https://amsul.ca/pickadate.js/vendor/pickadate/lib/picker.js"></script>
    <script src="https://amsul.ca/pickadate.js/vendor/pickadate/lib/picker.date.js"></script>

@endsection

@section('page-script')

    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script>
        const activeDocumentType = "{{ $activeDocumentType }}";

        var permission = [];
        permission['edit'] = {{ auth()->user()->hasPermission('document.update')? 1: 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('document.delete')? 1: 0 }};
        permission['download'] = {{ auth()->user()->hasPermission('document.download')? 1: 0 }};


        $('.js-example-basic-multiple').select2();
        //datepicker start

        var $input = $('.js-datepicker').pickadate({
            format: 'yyyy-mm-dd',
            firstDay: 1,
            formatSubmit: 'yyyy-mm-dd',
            // hiddenName: true,
            editable: true,
            // today: 'Today',
            today: '',
        });

        // $(document).ready(function() {
        //     if(activeDocumentType)
        //         document.getElementById(`category-btn-${activeDocumentType}`).click();
        //     //change last review datepicker
        //
        //
        //     $('.js-example-basic-multiple').select2();
        //     //datepicker start
        //
        //     var $input = $('.js-datepicker').pickadate({
        //         format: 'yyyy-mm-dd'
        //         , firstDay: 1
        //         , formatSubmit: 'yyyy-mm-dd',
        //         // hiddenName: true,
        //         editable: true,
        //         // today: 'Today',
        //         today: '',
        //
        //     });
        //
        //     var picker = {};
        //
        //
        //     $('button').on('click', function(e) {
        //         e.stopPropagation();
        //         {{-- picker[$(e.target).data('i')].open(); --}}
        //     });
        //
        //     //datepicker end
        //
        // });
    </script>

    <script>
        //tab
        // function openTab(evt, cityName, id) {
        //     var i, tabcontent, tablinks;
        //     tabcontent = document.getElementsByClassName("tabcontent");
        //     for (i = 0; i < tabcontent.length; i++) {
        //         tabcontent[i].style.display = "none";
        //     }
        //     tablinks = document.getElementsByClassName("tablinks");
        //     for (i = 0; i < tablinks.length; i++) {
        //         tablinks[i].className = tablinks[i].className.replace(" active", "");
        //     }
        //     document.getElementById(cityName).style.display = "block";
        //     evt.currentTarget.className += " active";
        //
        //     // $( "#todo-item" ).empty();
        //
        //     var url = "{{ route('admin.governance.ajax.get-list-document', '') }}" + "/" + id;
        //     var unmap_url = "{{ route('admin.governance.unmap.control', '') }}" + "/" + id;
        //     var myobj = document.getElementsByClassName('dt-advanced-search' + id);
        //     $(this).remove();
        //     $.ajax({
        //         url: url
        //         , type: "GET"
        //         , headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //         , data: {}
        //         , success: function(data) {
        //             var isRtl = $('html').attr('data-textdirection') === 'rtl';
        //             var dt_ajax_table = $('.datatables-ajax')
        //                 , dt_filter_table = $('.dt-column-search')
        //                 , dt_adv_filter_table = $('.dt-advanced-search' + id)
        //                 , dt_responsive_table = $('.dt-responsive')
        //                 , assetPath = '../../../app-assets/';
        //             if ($('body').attr('data-framework') === 'laravel') {
        //                 assetPath = $('body').attr('data-asset-path');
        //             }
        //             if (dt_adv_filter_table.length) {
        //                 dt_adv_filter_table.DataTable().clear().destroy();
        //                 var dt_adv_filter = dt_adv_filter_table.DataTable({
        //                     data: data
        //                     , lengthMenu: [
        //                         [10, 25, 50, -1]
        //                         , [10, 25, 50, "All"]
        //                     ],
        //
        //                     columns: [{
        //                             data: 'responsive_id'
        //                         },
        //                         // { data: 'framework' },
        //                         {
        //                             data: 'document_name'
        //                         }
        //                         , {
        //                             data: 'framework_name'
        //                         },
        //
        //                         {
        //                             data: 'control'
        //                         }
        //                         , {
        //                             data: 'creation_date'
        //                         }
        //                         , {
        //                             data: 'approval_date'
        //                         }
        //                         , {
        //                             data: 'status'
        //                         },
        //                         {
        //                             data: 'id'
        //                         },
        //
        //                     ]
        //                     , columnDefs: [{
        //                         title: '#'
        //                         , className: 'index'
        //                         , orderable: false
        //                         , responsivePriority: 2
        //                         , targets: 0
        //                     }, {
        //                         // Actions
        //                         targets: -1
        //                         , title: 'Actions'
        //                         , orderable: false
        //                         , render: function(data, type, full, meta) {
        //                             let returnedString = '';
        //
        //                             returnedString += '<a  href="javascript:;" onclick="showDocument(' + data + ')" class="item-edit dropdown-item ">' +
        //                                 feather.icons['eye'].toSvg({
        //                                     class: 'me-50 font-small-4'
        //                                 }) +
        //                                 'View</a>';
        //
        //
        //                             if (permission['download']) {
        //                                     returnedString +=`<span class="tem-edit dropdown-item supporting_documentation" data-document-id="${data}">` + feather.icons['edit'].toSvg({ class: 'me-50 font-small-4'}) + `download</span>`
        //                             }
        //
        //                            if (full.editable) {
        //                                 returnedString += '<a  href="javascript:;" onclick="editDocument(' + data + ')" class="item-edit dropdown-item ">' +
        //                                     feather.icons['edit'].toSvg({
        //                                         class: 'me-50 font-small-4'
        //                                     }) +
        //                                     'Edit</a>';
        //                             }
        //
        //                             if (full.deletable) {
        //                                 returnedString += '<a  href="javascript:;" onclick="deleteDocument(' + data + ')" class="dropdown-item  btn-flat-danger">' +
        //                                     feather.icons['trash-2'].toSvg({
        //                                         class: 'me-50 font-small-4'
        //                                     }) +
        //                                     'Delete</a>';
        //                             }
        //
        //                             if (returnedString == ''){
        //                                 returnedString = '------';
        //                                 return returnedString;
        //                             }
        //
        //                             else
        //                                 return (
        //                                     '<div class="d-inline-flex">' +
        //                                     '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
        //                                     feather.icons['more-vertical'].toSvg({
        //                                         class: 'font-small-4'
        //                                     }) +
        //                                     '</a>' +
        //                                     '<div class="dropdown-menu dropdown-menu-end">' +
        //                                     returnedString +
        //                                     '</div>' +
        //                                     '</div>'
        //
        //
        //                                 );
        //                         }
        //                     }, {
        //                         // Label for frameworks
        //                         targets: -6,
        //                         render: function (data, type, full, meta) {
        //                             returnedData = '';
        //                             data.forEach(element => {
        //                             returnedData += '<span class="badge rounded-pill badge-light-success">' +
        //                                 element +
        //                                 '</span>'
        //                             });
        //                             return returnedData;
        //                         }
        //                     }, {
        //                         // Label for controls
        //                         targets: -5,
        //                         render: function (data, type, full, meta) {
        //                             returnedData = '';
        //                             data.forEach(element => {
        //                             returnedData += '<span class="badge rounded-pill badge-light-success">' +
        //                                 element +
        //                                 '</span>'
        //                             });
        //                             return returnedData;
        //                         }
        //                     }]
        //                     , dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
        //                     , orderCellsTop: true
        //                     , responsive: {
        //                         details: {
        //                             display: $.fn.dataTable.Responsive.display.modal({
        //                                 header: function(row) {
        //                                     var data = row.data();
        //                                     return 'Details of ' + data['name'];
        //                                 }
        //                             })
        //                             , type: 'column'
        //                             , renderer: function(api, rowIdx, columns) {
        //                                 var data = $.map(columns, function(col, i) {
        //                                     return col.title !== '' ?
        //                                         '<tr data-dt-row="' +
        //                                         col.rowIndex +
        //                                         '" data-dt-column="' +
        //                                         col.columnIndex +
        //                                         '">' +
        //                                         '<td>' +
        //                                         col.title +
        //                                         ':' +
        //                                         '</td> ' +
        //                                         '<td>' +
        //                                         col.data +
        //                                         '</td>' +
        //                                         '</tr>' :
        //                                         '';
        //                                 }).join('');
        //                                 return data ? $('<table class="table"/><tbody />').append(data) : false;
        //                             }
        //                         }
        //                     }
        //                     , language: {
        //                         paginate: {
        //                             previous: '&nbsp;'
        //                             , next: '&nbsp;'
        //                         }
        //                     }
        //                 });
        //                 dt_adv_filter.on('order.dt search.dt', function() {
        //                     dt_adv_filter.column(0, {
        //                         search: 'applied'
        //                         , order: 'applied'
        //                     }).nodes().each(function(cell, i) {
        //                         cell.innerHTML = i + 1;
        //                     });
        //                 }).draw();
        //             }
        //             $('input.dt-input').on('keyup', function() {
        //                 filterColumn($(this).attr('data-column'), $(this).val());
        //             });
        //             $('select.dt-select').on('change', function() {
        //                 filterColumn($(this).attr('data-column'), $(this).val());
        //             });
        //             $('.dataTables_filter .form-control').removeClass('form-control-sm');
        //             $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass('form-control-sm');
        //         }
        //         , error: function() {
        //             //
        //         }
        //     });
        //
        //     function filterColumn(i, val) {
        //         $('.dt-advanced-search').DataTable().column(i).search(val, false, true).draw();
        //     }
        //
        // }

        /* Start Category */
        // Submit form for creating category
        $('#new-frame-modal form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#new-frame-modal').modal('hide');
                        if (data.reload)
                            location.reload();
                        else {
                            $("#advanced-search-datatable").load(location.href +
                                " #advanced-search-datatable>*", "");
                            loadDatatable();
                        }
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

        // Submit form for deleting category
        $(".category_del").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "DELETE",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        if (data.reload)
                            location.reload();
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });

            // event.preventDefault();
            // $.ajax({
            //     url: $(this).attr('action')
            //     , type: "POST"
            //     , data: $(this).serialize()
            //     , success: function(data) {
            //         if (data.status == "success") {
            //             makeAlert('success', data.message, "category deleted successfully");
            //             location.reload();

            //         } else {
            //             makeAlert('error', data.message, "sorry, category contains document");
            //         }
            //     }
            // });
        });

        // Submit form for updating category
        $('.form-edit').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        location.reload();
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
        /* End Category */

        /* Start Document */
        // Submit form for creating document
        $('.add_document form').on('submit', function(e) {
            e.preventDefault();
            const modal = $(this).parents('.add_document');
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        if (data.reload)
                            location.reload();
                        modal.modal('hide');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    const responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });

        // show document
        function showDocument(data) {
            var url = "{{ route('admin.governance.ajax.show_document', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    if (response.status) {
                        const showModal = $("#show_contModal");

                        const modalTitle = $('#show_contModal .modal-title');

                        let title =
                            `<button type="button" class="btn btn-sm btn-outline-success complete-todo-item waves-effect waves-float waves-light mx-1">${response.data.document_status_name}</button>`;
                        modalTitle.html(modalTitle.data('title') + title);

                        // Start Assign task data to modal
                        showModal.find('input[name="id"]').val(response.data.id);

                        // Set name
                        showModal.find("input[name='name']").val(response.data.document_name);

                        // Set frameworks
                        const framworkContainer = showModal.find(`select[name='framework_ids[]']`);
                        framworkContainer.find('option').remove();
                        response.data.frameworks.forEach(frameworkName => {
                            framworkContainer.append(`<option selected>${frameworkName}</option>`);
                        });

                        // Set controls
                        const controlContainer = showModal.find(`select[name='control_ids[]']`);
                        controlContainer.find('option').remove();
                        response.data.controls.forEach(controlName => {
                            controlContainer.append(`<option selected>${controlName}</option>`);
                        });

                        // Set additional_stakeholders
                        const additionalStakeholderContainer = showModal.find(
                            `select[name='additional_stakeholders[]']`);
                        additionalStakeholderContainer.find('option').remove();
                        response.data.additional_stakeholders.forEach(additionalStakeholderName => {
                            additionalStakeholderContainer.append(
                                `<option selected>${additionalStakeholderName}</option>`);
                        });

                        // Set document owner
                        const documentOwnerContainer = showModal.find(`select[name='owner']`);
                        documentOwnerContainer.find('option').remove();
                        documentOwnerContainer.append(
                            `<option selected>${response.data.document_owner}</option>`);

                        // Set team
                        const teamContainer = showModal.find(`select[name='team_ids[]']`);
                        teamContainer.find('option').remove();
                        response.data.teams.forEach(teamName => {
                            teamContainer.append(`<option selected>${teamName}</option>`);
                        });

                        // Set creation date
                        showModal.find("input[name='creation_date']").val(response.data.creation_date);

                        // Set last review date
                        showModal.find("input[name='last_review_date']").val(response.data.last_review_date);

                        // Set review frequency
                        showModal.find("input[name='review_frequency']").val(response.data.review_frequency);

                        // Set next review date
                        showModal.find("input[name='next_review_date']").val(response.data.next_review_date);

                        // Set approval date
                        showModal.find("input[name='approval_date']").val(response.data.approval_date)
                            .flatpickr({
                                dateFormat: 'Y-m-d',
                                defaultDate: response.data.approval_date,
                                onReady: function(selectedDates, dateStr, instance) {
                                    if (instance.isMobile) {
                                        $(instance.mobileInput).attr('step', null);
                                    }
                                }
                            });

                        // Set status
                        showModal.find("select[name='status'] option").attr('disabled', false);
                        if (!response.data.document_status) {
                            showModal.find("select[name='status'] option").attr('selected', false).trigger(
                                'change');
                            showModal.find("select[name='status'] option").first().attr('selected', true)
                                .trigger('change');
                        } else
                            showModal.find(
                                `select[name='status'] option[value='${response.data.document_status}']`).attr(
                                'selected', true).trigger('change');
                        // showModal.find("select[name='status'] option").attr('disabled', true);

                        // Set document reviewer
                        const documentReviewerContainer = showModal.find(`select[name='reviewer']`);
                        documentReviewerContainer.find('option').remove();
                        documentReviewerContainer.append(
                            `<option selected>${response.data.document_reviewer}</option>`);

                        // Set privacy
                        if (!response.data.privacy) {
                            showModal.find("select[name='privacy'] option").attr('selected', false).trigger(
                                'change');
                            showModal.find("select[name='privacy'] option").first().attr('selected', true)
                                .trigger('change');
                        } else
                            showModal.find(`select[name='privacy'] option[value='${response.data.privacy}']`)
                            .attr('selected', true).trigger('change');

                        addMessageToChat(response.data);

                        $('#show_contModal').modal('show');

                        $('button').on('click', function(e) {
                            e.stopPropagation();
                            // picker[$(e.target).data('i')].open();
                        });
                    }
                },
                error: function(response, data) {
                    let responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                }

            });
        };

        // edit document
        function editDocument(data) {
            var url = "{{ route('admin.governance.ajax.edit_document', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    if (response.status) {
                        const editForm = $("#form-update_control");

                        const modalTitle = $('#edit_contModal .modal-title');

                        let title =
                            `<button type="button" class="btn btn-sm btn-outline-success complete-todo-item waves-effect waves-float waves-light mx-1">${response.data.document_status_name}</button>`;
                        modalTitle.html(modalTitle.data('title') + title);

                        // Start Assign task data to modal
                        editForm.find('input[name="id"]').val(response.data.id);

                        // Set name
                        editForm.find("input[name='name']").val(response.data.document_name);

                        // Set frameworks
                        response.data.framework_ids.forEach(frameworkId => {
                            editForm.find(
                                    `select[name='framework_ids[]'] option[value='${frameworkId}']`)
                                .attr('selected', true).trigger('change');
                        });

                        // Set controls
                        response.data.control_ids.forEach(controlId => {
                            editForm.find(`select[name='control_ids[]'] option[value='${controlId}']`)
                                .attr('selected', true).trigger('change');
                            editForm.find(`select[name='control_ids[]'] option[value='${controlId}']`);
                        });

                        // Set additional_stakeholders
                        response.data.additional_stakeholders.forEach(additionalStakeholderId => {
                            editForm.find(
                                `select[name='additional_stakeholders[]'] option[value='${additionalStakeholderId}']`
                            ).attr('selected', true).trigger('change');
                        });

                        // Set document owner
                        if (!response.data.document_owner) {
                            editForm.find("select[name='owner'] option").attr('selected', false).trigger(
                                'change');
                            editForm.find("select[name='owner'] option").first().attr('selected', true).trigger(
                                'change');
                        } else
                            editForm.find(
                                `select[name='owner'] option[value='${response.data.document_owner}']`).attr(
                                'selected', true).trigger('change');

                        // Set team
                        response.data.team_ids.forEach(teamId => {
                            editForm.find(`select[name='team_ids[]'] option[value='${teamId}']`).attr(
                                'selected', true).trigger('change');
                        });

                        // Set creation date
                        editForm.find("input[name='creation_date']").val(response.data.creation_date);

                        // Set last review date
                        editForm.find("input[name='last_review_date']").val(response.data.last_review_date)
                            .flatpickr({
                                dateFormat: 'Y-m-d',
                                defaultDate: response.data.last_review_date,
                                onReady: function(selectedDates, dateStr, instance) {
                                    if (instance.isMobile) {
                                        $(instance.mobileInput).attr('step', null);
                                    }
                                }
                            });

                        // Set review frequency
                        editForm.find("input[name='review_frequency']").val(response.data.review_frequency);

                        // Set next review date
                        editForm.find("input[name='next_review_date']").val(response.data.next_review_date);

                        // Set approval date
                        editForm.find("input[name='approval_date']").val(response.data.approval_date)
                            .flatpickr({
                                dateFormat: 'Y-m-d',
                                defaultDate: response.data.approval_date,
                                onReady: function(selectedDates, dateStr, instance) {
                                    if (instance.isMobile) {
                                        $(instance.mobileInput).attr('step', null);
                                    }
                                }
                            });

                        // Set parent
                        // if(!response.data.parent){
                        //     editForm.find("select[name='parent'] option").attr('selected', false).trigger('change');
                        //     editForm.find("select[name='parent'] option").first().attr('selected', true).trigger('change');
                        // }
                        // else
                        //     editForm.find(`select[name='parent'] option[value='${response.data.parent}']`).attr('selected', true).trigger('change');

                        // Set status
                        if (!response.data.document_status) {
                            editForm.find("select[name='status'] option").attr('selected', false).trigger(
                                'change');
                            editForm.find("select[name='status'] option").first().attr('selected', true)
                                .trigger('change');
                        } else
                            editForm.find(
                                `select[name='status'] option[value='${response.data.document_status}']`).attr(
                                'selected', true).trigger('change');

                        // Set reviewer
                        if (!response.data.document_reviewer) {
                            editForm.find("select[name='reviewer'] option").attr('selected', false).trigger(
                                'change');
                            editForm.find("select[name='reviewer'] option").first().attr('selected', true)
                                .trigger('change');
                        } else
                            editForm.find(
                                `select[name='reviewer'] option[value='${response.data.document_reviewer}']`)
                            .attr('selected', true).trigger('change');

                        // Set privacy
                        if (!response.data.privacy) {
                            editForm.find("select[name='privacy'] option").attr('selected', false).trigger(
                                'change');
                            editForm.find("select[name='privacy'] option").first().attr('selected', true)
                                .trigger('change');
                        } else
                            editForm.find(`select[name='privacy'] option[value='${response.data.privacy}']`)
                            .attr('selected', true).trigger('change');

                        addMessageToChat(response.data);

                        $('#edit_contModal').modal('show');

                        $('button').on('click', function(e) {
                            e.stopPropagation();
                            // picker[$(e.target).data('i')].open();
                        });
                    }
                },
                error: function(response, data) {
                    let responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                }

            });
        };

        // update document
        const editForm = $("#form-update_control"),
            editFormModal = $('#edit_contModal');
        editForm.submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);

                        $(editFormModal).modal('hide');
                        if (data.reload)
                            location.reload();
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    let responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });

        // delete document
        function deleteDocument(id) {
            let url = "{{ route('admin.governance.document.destroy', ':id') }}";
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
                        if (data.reload)
                            location.reload();
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });

            // var url = "{{ route('admin.governance.document.destroy', '') }}" + "/" + data;
            // // AJAX request
            // $.ajax({
            //     url: url
            //     , type: "GET"
            //     , data: {}
            //     , success: function(response) {
            //         makeAlert('success', "deleted successfuly", "{{ __('locale.Success') }}");
            //         location.reload();
            //     }
            // });
        }
        /* End Document */

        /* Start change status event */
        $('#privacy').hide();
        $('#approval_date').hide();
        $('#reviewer').hide();

        $('#privacy_update').hide();
        $('#approval_date_update').hide();
        $('#reviewer_update').hide();

        $('#privacy_show').hide();
        $('#approval_date_show').hide();
        $('#reviewer_show').hide();

        function changePrivacy(status_id) {
            if (status_id == 3) {
                $('#privacy').show();
                $('#approval_date').show();
                $('#reviewer').hide();
            } else if (status_id == 2) {
                $('#privacy').hide();
                $('#approval_date').hide();
                $('#reviewer').show();
            } else {
                $('#privacy').hide();
                $('#approval_date').hide();
                $('#reviewer').hide();
            }
        }

        function changePrivacy2(status_id) {
            if (status_id == 3) {
                $('#privacy_update').show();
                $('#approval_date_update').show();
                $('#reviewer_update').hide();
            } else if (status_id == 2) {
                $('#privacy_update').hide();
                $('#approval_date_update').hide();
                $('#reviewer_update').show();
            } else {
                $('#privacy_update').hide();
                $('#approval_date_update').hide();
                $('#reviewer_update').hide();
            }
        }

        function changePrivacy3(status_id) {
            if (status_id == 3) {
                $('#privacy_show').show();
                $('#approval_date_show').show();
                $('#reviewer_show').hide();
            } else if (status_id == 2) {
                $('#privacy_show').hide();
                $('#approval_date_show').hide();
                $('#reviewer_show').show();
            } else {
                $('#privacy_show').hide();
                $('#approval_date_show').hide();
                $('#reviewer_show').hide();
            }
        }
        /* End change status event */

        // // mapping using ajax
        $('.userinfo').click(function() {

            var userid = $(this).data('id');
            var url = "{{ route('admin.governance.ajax.get-list-map', '') }}" + "/" + userid;

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
        });

        // unmap
        // // mapping using ajax
        function unmap(data) {

            var unmap_url = "{{ route('admin.governance.unmap.control', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: unmap_url,
                type: "GET",
                data: {},
                success: function(response) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                }
            });
        };


        $('.multiple-select2').select2();


        // function to show error validation
        function showError(data) {
            $('.error').empty().css('display', 'none');
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
                $('.error-' + key).css('display', 'inline-block');
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

        /* Start downlaod file */
        function downloadDoc(data) {
            var unmap_url = "{{ route('admin.governance.document.download', '') }}" + "/" + data;
            // AJAX request
            $.ajax({
                url: unmap_url,
                type: "GET",
                data: {},
                success: function(response) {}
            });
        };
        /* End downlaod file */
    </script>
    <script>
        // Load controls of framework
        $('[name="framework_ids[]"]').change(function() {
            $(this).parents('form').find("select[name='control_ids[]'] option").remove();
            const frameworks = $(this).find('option:selected');

            $.each(frameworks, function(indexInArray, framework) {
                $(framework).data('controls').forEach(frameworkControl => {
                    $(this).parents('form').find("select[name='control_ids[]']").append(
                        `<option value="${frameworkControl.id}">${frameworkControl.short_name}</option>`
                    );
                });
            });
        });

        // link last review with next review

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

        /* Start reset modal */
        function resetFormData(form) {
            $('.error').empty();
            form.trigger("reset")
            form.find('input:not([name="_token"])').val('');
            form.find('select.multiple-select2 option[selected]').attr('selected', false);
            form.find('select.js-example-basic-multiple option[selected]').attr('selected', false);
            form.find('select.select2 option').attr('selected', false);
            form.find('select.js-example-basic-multiple option').attr('selected', false);
            form.find('select').trigger('change');
        }

        $('.modal').on('hidden.bs.modal', function() {
            if ($(this).is($('#edit_contModal')) || $(this).is($('#add_control1')))
                resetFormData($(this).find('form'));
        });

        $('.modal').on('hidden.bs.modal', function() {
            resetFormData($(this).find('form'));
        })
        /* End reset modal */
    </script>

    <!-- Page js files -->
    <script>
        const lang = []
        URLs = [], user_id = {{ auth()->id() }}, customUserName =
            "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
        userName = "{{ auth()->user()->name }}";
        URLs['sendNote'] = "{{ route('admin.governance.send-note') }}";
        URLs['sendNoteFile'] = "{{ route('admin.governance.send-note-file') }}";

        // Download supporting documentation start
        $(document).on("click", ".supporting_documentation", function() {
            const form = $('#download-file-form');
            form.find('[name="document_id"').val($(this).data('documentId'));
            form.trigger('submit');
        });
    </script>

    <script src="{{ asset('ajax-files/governance/document/app-chat.js') }}"></script>
    <!-- // Add message to chat - function call on form submit -->

    <style>
        .activeItemTab {
            color: #0097a7 !important;
        }

        .activeItemTab:hover {
            color: #0097a7 !important;
        }

        .activeItemTab:active {
            color: #0097a7 !important;
        }
    </style>

    @include('admin.content.governance.DocumentationAjax')
@endsection
