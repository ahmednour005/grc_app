@extends('admin/layouts/contentLayoutMaster')
<?php
$priorities = [
    'No Priority' => 'dark',
    'Low' => 'success',
    'Normal' => 'info',
    'High' => 'warning',
    'Urgent' => 'danger',
];

?>
@section('title', $createdByMe ? __('task.CreatedTasks') : __('task.Tasks'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/dragula.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-todo.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
@endsection

@section('content-sidebar')
    <div class="sidebar-content todo-sidebar">
        <div class="todo-app-menu">

            <div
                class="sidebar-menu-list {{ $createdByMe ? '' : 'mt-2' }} {{ !auth()->user()->hasPermission('task.export')? '': 'mt-2' }}">
                <div class="px-2 d-flex justify-content-between">
                    <h6 class="section-label mb-1">{{ __('locale.Tags') }}</h6>
                </div>
                <div class="list-group list-group-labels">
                    <span style="cursor:pointer" data-text="{{ __('locale.No Priority') }}"
                        class="list-group-item list-group-item-action d-flex align-items-center">
                        <span class="bullet bullet-sm bullet-dark me-1"></span>{{ __('locale.No Priority') }}
                    </span>
                    <span style="cursor:pointer" data-text="{{ __('locale.Low') }}"
                        class="list-group-item list-group-item-action d-flex align-items-center">
                        <span class="bullet bullet-sm bullet-success me-1"></span>{{ __('locale.Low') }}
                    </span>
                    <span style="cursor:pointer" data-text="{{ __('locale.Normal') }}"
                        class="list-group-item list-group-item-action d-flex align-items-center">
                        <span class="bullet bullet-sm bullet-info me-1"></span>{{ __('locale.Normal') }}
                    </span>
                    <span style="cursor:pointer" data-text="{{ __('locale.High') }}"
                        class="list-group-item list-group-item-action d-flex align-items-center">
                        <span class="bullet bullet-sm bullet-warning me-1"></span>{{ __('locale.High') }}
                    </span>
                    <span style="cursor:pointer" data-text="{{ __('locale.Urgent') }}"
                        class="list-group-item list-group-item-action d-flex align-items-center">
                        <span class="bullet bullet-sm bullet-danger me-1"></span>{{ __('locale.Urgent') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="body-content-overlay"></div>
    <div class="app-fixed-search d-flex align-items-center justify-content-end p-2">
        @if ($createdByMe)
            <div class="add-task mx-2">
                <button type="button" class="btn btn-primary w-100 " data-bs-toggle="modal"
                    data-bs-target="#new-task-modal">
                    {{ __('task.AddNewTask') }}
                </button>

            </div>
            <a href="{{ route('admin.task.notificationsSettingsTask') }}" class="dt-button btn btn-primary me-2"
            target="_self">
            {{ __('locale.NotificationsSettings') }}
        </a>
        @else
            <p class="mt-2"></p>
        @endif

        @php
            $exportName = $createdByMe ? __('task.CreatedTasks') : __('task.Tasks');
            $exportRoute = $createdByMe ? 'admin.task.ajax.created.export' : 'admin.task.ajax.assigned.export';
        @endphp


        <x-export-import :name="$exportName" createPermissionKey='task.create' exportPermissionKey='task.export'
            :exportRouteKey='$exportRoute' importRouteKey='will-added-TODO' />

    </div>
    <div class="todo-app-list">
        <!-- Todo search starts -->
        <div class="app-fixed-search d-flex align-items-center">
            <div class="sidebar-toggle d-block d-lg-none ms-1">
                <i data-feather="menu" class="font-medium-5"></i>
            </div>
            <div class="d-flex align-content-center justify-content-between w-100">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
                    <input type="text" class="form-control" id="todo-search"
                        placeholder="{{ __('locale.Search') . ' ' . __('task.Task') }}"
                        aria-label="{{ __('locale.Search') }}..." aria-describedby="todo-search" />
                </div>
            </div>
            <div class="dropdown">
                <a href="#" class="dropdown-toggle hide-arrow me-1" id="todoActions" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i data-feather="more-vertical" class="font-medium-2 text-body"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="todoActions">
                    <a class="dropdown-item sort-asc" href="#">{{ __('locale.Sort A - Z') }}</a>
                    <a class="dropdown-item sort-desc" href="#">{{ __('locale.Sort Z - A') }}</a>
                </div>
            </div>
        </div>
        <!-- Todo search ends -->

        <!-- Todo List starts -->
        <div class="todo-task-list-wrapper list-group">
            @if (count($tasks))
                <ul class="todo-task-list media-list" id="todo-task-list">
                    @foreach ($tasks as $key => $task)
                        <li class="todo-item" data-id="{{ $task->id }}" id="todo-item-{{ $task->id }}">
                            <div class="todo-title-wrapper">
                                <div class="todo-title-area">
                                    <i data-feather="more-vertical" class="drag-icon"></i>
                                    <div class="title-wrapper">
                                        <div class="form-check">
                                            <input type="checkbox" disabled class="form-check-input"
                                                id="customCheck.{{ $key }}"
                                                {{ $task->completed ? 'checked' : '' }} data-id="{{ $task->id }}" />
                                            <label class="form-check-label"
                                                for="customCheck.{{ $key }}"></label>
                                        </div>
                                        <span class="todo-title" style="font-weight: bolder">{{ $task->title }}</span>
                                    </div>
                                </div>
                                <div class="todo-item-action">
                                    <div class="badge-wrapper me-1">
                                        <span
                                            class="badge rounded-pill badge-light-{{ $priorities[$task->priority] ?? '' }}">{{ $task->priority }}</span>
                                    </div>
                                    {{-- <small class="text-nowrap text-muted me-1">{{ $task->due_date->format('F j h:i:s A') }}</small> --}}
                                    <small
                                        class="text-nowrap text-muted me-1">{{ $task->due_date->format('F j') }}</small>
                                    <div class="avatar bg-light-primary">
                                        <div class="avatar-content" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title=""
                                            data-bs-original-title="{{ (isset($task->assignable->username) ? __('locale.User') : __('locale.Team')) . ': ' . $task->assignable->name }}">
                                            {{ getFirstChartacterOfEachWord($task->assignable->name, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach

                </ul>
        </div>
    @else
        <div class="bg-light-danger w-75 py-1 mx-auto mt-3 text-center rounded">
            {{ $createdByMe ? __('locale.There is no tasks created by me') : __('locale.There is no tasks assigned to me') }}
        </div>
        @endif
        <!-- Todo List ends -->
    </div>

    <!-- Right Sidebar starts -->
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-task-modal">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                @if ($createdByMe)
                    <form id="form-modal-todo" class="todo-modal needs-validation" novalidate onsubmit="return false">
                        <input type="hidden" name="id">
                    @else
                        <div id="form-modal-todo" class="todo-modal needs-validation">
                            <input type="hidden" name="id">
                @endif
                @if ($createdByMe)
                    @csrf
                @endif
                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('task.AddNewTask') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 pb-1">
                    <div class="action-tags">
                        <div class="mb-1">
                            <label for="title" class="form-label">{{ __('task.TaskTitle') }}</label>
                            <input type="text" id="title" name="title" class="new-todo-item-title form-control"
                                placeholder="Title" {{ $createdByMe ? '' : 'readonly' }}>
                            <span class="error error-title"></span>
                        </div>
                        <div class="mb-1">
                            <label for="title" class="form-label">{{ __('locale.AssigneeType') }}</label>
                            <div class="demo-inline-spacing">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="assignee_type" id="Employee"
                                        value="User" checked {{ $createdByMe ? '' : 'disabled' }}>
                                    <label class="form-check-label" for="Employee">{{ __('locale.Employee') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="assignee_type" id="Team"
                                        value="Team" {{ $createdByMe ? '' : 'disabled' }}>
                                    <label class="form-check-label" for="Team">{{ __('locale.Team') }}</label>
                                </div>
                            </div>
                            <span class="error error-assignee_type"></span>
                        </div>

                        <div class="mb-1 position-relative" id="task_assigned_container">
                            <label for="task-assigned" class="form-label d-block">{{ __('locale.Assignee') }}</label>
                            <select class="select2 form-select" id="task-assigned" name="task-assigned"
                                {{ $createdByMe ? '' : 'disabled' }}>
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                @foreach ($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-task-assigned"></span>
                        </div>
                        {{-- Team --}}
                        <div class="mb-1 d-none" id="task_assigned_team_container">
                            <label class="form-label ">{{ __('locale.Team') }}</label>
                            <select name="task_assigned_team" id="task-assigned-team" class="form-select select2"
                                {{ $createdByMe ? '' : 'disabled' }}>
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-task_assigned_team"></span>
                        </div>
                        <div class="mb-1">
                            <label for="task-start-date" class="form-label">{{ __('locale.StartDate') }}</label>
                            <input type="text" class="form-control task-start-date" id="task-start-date"
                                name="task-start-date" {{ $createdByMe ? '' : 'disabled' }} />
                            <span class="error error-task-start-date"></span>
                        </div>
                        <div class="mb-1">
                            <label for="task-due-date" class="form-label">{{ __('locale.DueDate') }}</label>
                            <input type="text" class="form-control task-due-date" id="task-due-date"
                                name="task-due-date" {{ $createdByMe ? '' : 'disabled' }} />
                            <span class="error error-task-due-date"></span>
                        </div>
                        <div class="mb-1">
                            <label for="task-tag" class="form-label d-block">{{ __('task.TaskPriority') }}</label>
                            <select class="select2 form-select task-tag" id="task-tag" name="task-priority"
                                {{ $createdByMe ? '' : 'disabled' }}>
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                <option value="No Priority">{{ __('locale.No Priority') }}</option>
                                <option value="Low">{{ __('locale.Low') }}</option>
                                <option value="Normal">{{ __('locale.Normal') }}</option>
                                <option value="High">{{ __('locale.High') }}</option>
                                <option value="Urgent">{{ __('locale.Urgent') }}</option>
                            </select>
                            <span class="error error-task-priority"></span>
                        </div>
                        @if ($createdByMe)
                            <div class="mb-1 d-none" id="creator-task-status-container">
                                <label for="creator-task-status"
                                    class="form-label d-block">{{ __('task.TaskStatus') }}</label>
                                <select class="select2 form-select task-tag" id="creator-task-status" name="task-status"
                                    {{ $createdByMe ? '' : 'disabled' }}>
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}
                                    </option>
                                    <option value="Accepted">{{ __('locale.Accepted') }}</option>
                                    <option value="Closed">{{ __('locale.Closed') }}</option>
                                </select>
                                <span class="error error-task-status"></span>
                            </div>
                        @endif
                        <textarea name=description class='d-none'></textarea>
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.Description') }}</label>
                            @if ($createdByMe)
                                <div id="task-desc" class="border-bottom-0" data-placeholder="Write Your Description">
                                </div>
                                <div class="d-flex justify-content-end desc-toolbar border-top-0">
                                    <span class="ql-formats me-0">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-align"></button>
                                        <button class="ql-link"></button>
                                    </span>
                                </div>
                            @else
                                <div class="form-control" id="display-describtion" rows="3"
                                    style="background-color: #efefef;">Description</div>
                            @endif
                            <span class="error error-description"></span>
                        </div>

                        {{-- Supporting Documentation --}}
                        <div class="mb-1 supporting_documentation_container">
                            <label class="text-label">{{ __('locale.SupportingDocumentation') }}</label>
                            :
                            @if ($createdByMe)
                                <input type="file" multiple name="supporting_documentation[]"
                                    class="form-control dt-post"
                                    aria-label="{{ __('locale.SupportingDocumentation') }}" />
                                <span class="error error-supporting_documentation "></span>
                            @endif
                            {{-- <div class="mitigation-files" style="margin-top: 5px">
                                    <span class="badge bg-secondary supporting_documentation cursor-pointer" data-id="{{ $file->id ?? 'FID' }}" data-task-id="{{ 1 }}">{{ $file->display_name ?? 'DN' }}</span>
                                <span class="text-danger delete_supporting_documentation cursor-pointer" data-id="{{ $file->id ?? 'FID' }}" data-task-id="{{ 1 }}"><i data-feather="x"></i></span>
                            </div> --}}
                            {{-- <span class="mx-2 text-danger">{{ __('locale.NONE') }}</span> --}}
                        </div>
                    </div>
                    <div class="my-1">
                        <button type="submit"
                            class="btn btn-primary d-none add-todo-item me-1">{{ __('locale.Add') }}</button>
                        <button type="button" class="btn btn-outline-secondary add-todo-item d-none"
                            data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}
                        </button>
                        <button type="button"
                            class="btn btn-primary d-none update-btn update-todo-item me-1">{{ __('locale.Update') }}</button>
                        <button type="button" class="btn btn-outline-danger update-btn delete-todo-item d-none"
                            data-bs-dismiss="modal">
                            {{ __('locale.Delete') }}
                        </button>
                    </div>
                </div>
                @if ($createdByMe)
                    </form>
                @else
            </div>
            @endif
            @if (!$createdByMe)
                <form id="assignee-change-status-form" class="todo-modal needs-validation mx-2" novalidate
                    onsubmit="return false">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id">
                    <div class="mb-1">
                        <label for="assignee-task-status" class="form-label d-block">{{ __('task.TaskStatus') }}</label>
                        <select class="select2 form-select task-tag" id="assignee-task-status" name="task-status">
                            <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                            <option value="In Progress">{{ __('locale.In Progress') }}</option>
                            <option value="Completed">{{ __('locale.Completed') }}</option>
                        </select>
                        <span class="error error-task-status"></span>
                    </div>
                    <div class="my-1">
                        <button type="button" class="btn btn-primary me-1"
                            id="update-change-status-btn">{{ __('locale.Update') . ' ' . __('task.TaskStatus') }}</button>
                    </div>
                </form>
            @endif
            <div class="border-bottom mx-1 my-1">
            </div>
            <div id="chat-container" class="d-none">
                <!-- Main chat area -->
                <section class="chat-app-window">
                    <!-- To load Conversation -->
                    <div class="start-chat-area">
                        <h4 class="sidebar-toggle start-chat-text mx-1">{{ __('task.TaskNotes') }}</h4>
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
                                        <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}" alt="avatar"
                                            height="36" width="36" />
                                        <span class="avatar-status-busy"></span>
                                    </div>
                                    <h6 class="mb-0">Kristopher Candy</h6>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i data-feather="phone-call"
                                        class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                    <i data-feather="video"
                                        class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                    <i data-feather="search" class="cursor-pointer d-sm-block d-none font-medium-2"></i>
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
                        <p class="my-0 mx-2" id="file-name" data-content="{{ __('locale.FileName', ['name' => '']) }}">
                        </p>
                        <!-- Submit Chat form -->
                        <form class="chat-app-form" id="chat-app-form" action="javascript:void(0);"
                            onsubmit="enterChat();">
                            @csrf
                            <input type="hidden" name="task_id" />
                            <div class="input-group input-group-merge me-1 form-send-message">
                                <input type="text" class="form-control message"
                                    placeholder="{{ __('locale.TypeYourNote') }}" />
                                <span class="input-group-text" title="hhhh">
                                    <label for="attach-doc" class="attachment-icon form-label mb-0">
                                        <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                        <input name="note_file" type="file" id="attach-doc" hidden /> </label></span>
                            </div>
                            <button type="button" class="btn btn-primary send" onclick="enterChat();">
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
    <!-- Right Sidebar ends -->
    <form class="d-none" id="download-file-form" method="post" action="{{ route('admin.task.ajax.download_file') }}">
        @csrf
        <input type="hidden" name="id">
        <input type="hidden" name="task_id">
    </form>

    <!-- Right Sidebar ends -->
    <form class="d-none" id="download-note-file-form" method="post"
        action="{{ route('admin.task.ajax.download_note_file') }}">
        @csrf
        <input type="hidden" name="id">
        <input type="hidden" name="task_id">
    </form>

@endsection

@section('vendor-script')
    <!-- vendor js files -->
    <script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dragula.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script>
        const lang = []
        URLs = [],
            createdByMe = {{ $createdByMe ? 1 : 0 }},
            user_id = {{ auth()->id() }},
            customUserName = "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
        userName = "{{ auth()->user()->name }}";
        lang['AddNewTask'] = "{{ __('task.AddNewTask') }}";
        lang['Open'] = "{{ __('locale.Open') }}";
        lang['In Progress'] = "{{ __('locale.In Progress') }}";
        lang['Completed'] = "{{ __('locale.Completed') }}";
        lang['Accepted'] = "{{ __('locale.Accepted') }}";
        lang['Closed'] = "{{ __('locale.Closed') }}";
        lang['by'] = "{{ __('locale.by') }}";
        lang['at'] = "{{ __('locale.at') }}";
        lang['Select'] = "{{ __('locale.Select') }}";
        lang['TaskPriority'] = "{{ __('task.TaskPriority') }}";
        lang['TaskPriorities'] = [];
        lang['TaskPriorities']['No Priority'] = "{{ __('locale.No Priority') }}";
        lang['TaskPriorities']['Low'] = "{{ __('locale.Low') }}";
        lang['TaskPriorities']['Normal'] = "{{ __('locale.Normal') }}";
        lang['TaskPriorities']['High'] = "{{ __('locale.High') }}";
        lang['TaskPriorities']['Urgent'] = "{{ __('locale.Urgent') }}";
        lang['Description'] = "{{ __('locale.Description') }}";
        lang['NONE'] = "{{ __('locale.NONE') }}";

        lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['confirmDeleteFileMessage'] = "{{ __('locale.AreYouSureToDeleteThisFile') }}";
        lang['confirmDeleteRecordMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";
        lang['user'] = "{{ __('locale.User') }}";
        URLs['create'] = "{{ route('admin.task.ajax.store') }}";
        URLs['delete'] = "{{ route('admin.task.ajax.destroy', ':id') }}";
        URLs['show'] = "{{ route('admin.task.ajax.show', ':id') }}"
        URLs['edit'] = "{{ route('admin.task.ajax.edit', ':id') }}"
        URLs['update'] = "{{ route('admin.task.ajax.update') }}";
        URLs['deleteFile'] = "{{ route('admin.task.ajax.delete_file') }}";
        URLs['changeCompleteStatus'] = "{{ route('admin.task.ajax.change_complete_status') }}";
        URLs['assigneeUpdateStatus'] = "{{ route('admin.task.ajax.assignee_update_status') }}";
        URLs['sendNote'] = "{{ route('admin.task.ajax.send-note') }}";
        URLs['sendNoteFile'] = "{{ route('admin.task.ajax.send-note-file') }}";
    </script>
    <script src="{{ asset('ajax-files/task/app-todo.js') }}"></script>
    <script src="{{ asset('ajax-files/task/app-chat.js') }}"></script>
@endsection
