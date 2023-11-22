<section>
    <div class="row">
        <div class="col-12">
            {{-- <div class="card"> --}}

                {{-- <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                    </div>
                </div> --}}
                <!--Search Form -->
                {{-- <div class="card-body mt-2"> --}}
                    <form class="dt_adv_search" method="POST">
                        {{-- <div class="row g-1 mb-md-1">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('report.control') }}</label>
                                <select class="form-control dt-input dt-select select2 " name="filter_control"
                                data-column="2"
                                        data-column-index="1"
                                    id="control">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($controls as $control)
                                        <option value="{{ $control['short_name'] }}" data-id="{{ $control['id'] }}">
                                            {{ $control['short_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.CompletionTime') }}</label>
                                <select class="form-control dt-input dt-select select2 " name="filter_completion_time"
                                    id="completion_time">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    <option value="before_due_date">{{ __('locale.BeforeDueDate') }}</option>
                                    <option value="late">{{ __('locale.Late') }}</option>
                                </select>
                            </div> --}}
                        {{-- </div> --}}
                    </form>
                {{-- </div> --}}
            {{-- </div> --}}
            <hr class="my-0" />
            <div class="card-datatable">
                <table class="dt-advanced-server-search table" aria-label="">
                    <thead>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('report.Objective') }}</th>
                            <th>{{ __('report.Control') }}</th>
                            <th>{{ __('locale.Responsible') }}</th>
                            <th>{{ __('locale.DueDate') }}</th>
                            <th>{{ __('report.EvidencesCreatedAt') }}</th>
                            <th>{{ __('report.EvidencesUpdatedAt') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('report.Objective') }}</th>
                            <th>{{ __('report.Control') }}</th>
                            <th>{{ __('locale.Responsible') }}</th>
                            <th>{{ __('locale.DueDate') }}</th>
                            <th>{{ __('report.EvidencesCreatedAt')    }}</th>
                            <th>{{ __('report.EvidencesUpdatedAt') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
