<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0 @if(session('serviceDescription'))cursor-pointer @endif" @if(session('serviceDescription')) data-bs-toggle="modal" data-bs-target="#service-description-modal" @endif>@if(session('serviceDescription'))<i data-feather="help-circle"></i>@endif @yield('title')</h2>
                <div class="breadcrumb-wrapper">
                    @if(@isset($breadcrumbs))
                    <ol class="breadcrumb">
                        {{-- this will load breadcrumbs dynamically from controller --}}
                        @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item">
                            @if(isset($breadcrumb['link']))
                            <a href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link']:url($breadcrumb['link']) }}">
                                @endif
                                {{$breadcrumb['name']}}
                                @if(isset($breadcrumb['link']))
                            </a>
                            @endif
                        </li>
                        @endforeach
                    </ol>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

    <div class="modal-size-lg d-inline-block">
        <!-- Modal -->
        <div class="modal fade text-start" id="service-description-modal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel17">@yield('title') {{ __('locale.ServicesDescription') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="service-description-data" class="ql-editor"></div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
    <div class="mb-1 breadcrumb-right">
      <div class="dropdown">
        <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="grid"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="{{url('app/todo')}}">
    <i class="me-1" data-feather="check-square"></i>
    <span class="align-middle">Todo</span>
    </a>
    <a class="dropdown-item" href="{{url('app/chat')}}">
        <i class="me-1" data-feather="message-square"></i>
        <span class="align-middle">Chat</span>
    </a>
    <a class="dropdown-item" href="{{url('app/email')}}">
        <i class="me-1" data-feather="mail"></i>
        <span class="align-middle">Email</span>
    </a>
    <a class="dropdown-item" href="{{url('app/calendar')}}">
        <i class="me-1" data-feather="calendar"></i>
        <span class="align-middle">Calendar</span>
    </a>
</div>
</div>
</div>
</div> --}}
</div>
