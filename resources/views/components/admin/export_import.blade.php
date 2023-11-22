@if (auth()->user()->hasPermission($createPermissionKey) ||
    auth()->user()->hasPermission($exportPermissionKey))
    <div id="import-export-container" class="text-center">
        <!-- Export form -->
        <form target="_blank" class="d-none" id="export-form" method="post" action="{{ route($exportRouteKey) }}">
            @csrf
            <input type="hidden" name="type" value="excel">
        </form>

        {{-- Export --}}
        @if (auth()->user()->hasPermission($exportPermissionKey))
            <div class="btn-group dropdown dropdown-icon-wrapper me-1">
                <button type="button" class="btn btn-primary submit-export"
                    data-type="excel">{{ __('locale.Export') }}</button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-file-excel"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end export-types">
                    <span class="dropdown-item" data-type="excel">
                        <span class="px-1">{{ __('locale.Excel') }}</span>
                        <i class="fa-regular fa-file-excel"></i>
                    </span>
                    {{-- <span class="dropdown-item" data-type="pdf">
                        <span class="px-1">{{ __('locale.PDF') }}</span>
                        <i class="fa-regular fa-file-pdf"></i>
                    </span> --}}
                </div>
            </div>
        @endif

        {{-- Import --}}
{{--
        @if (auth()->user()->hasPermission($createPermissionKey) && $createOtherCondition && $importRouteKey != "will-added-TODO")
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ __('locale.Import') }}
                </button>
                <div class="dropdown-menu" style="min-width:20rem">
// Import form
                    <form class="px-2 pt-1" id="import-form" action="{{ route($importRouteKey) }}">
                        @csrf
                        <div class="mb-1">
                            <input type="file" name="import_file" class="form-control">
                            <span class="error error-import_file "></span>
                        </div>
                        <div class="mb-0">
                            <button type="submit"
                                class="btn btn-primary submit-import">{{ __('locale.Submit') }}</button>
                        </div>
                    </form>

                    <div class="dropdown-divider"></div>
                    <span class="dropdown-item download-template"><i class="fa-solid fa-download"></i>
                        {{ __('locale.DownloadItemTemplate', ['item' => $name]) }}</span>
                </div>
// Download import template file
                <form class="d-none" id="download-import-template-file" method="post"
                    action="{{ route($importRouteKey) }}/template">
                    @csrf
                </form>

// Error Modal //
                <div class="modal fade text-start" id="import-errors-modal" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel16">{{$name}} {{ __('locale.importingErrors') }}</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.RowNumber') }}</th>
                                    <th>{{ __('locale.Attribute') }}</th>
                                    <th>{{ __('locale.Value') }}</th>
                                    <th>{{ __('locale.Errors') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
                
            </div>
        @endif
--}}
@if (auth()->user()->hasPermission($createPermissionKey) && $importRouteKey!= "will-added-TODO")
<a href="{{ route($importRouteKey) }}" class="dt-button btn btn-primary me-2" target="_self">
    {{ __('locale.Import') }}
</a>
@endif
    </div>
@endif
