@extends('admin/layouts/contentLayoutMaster')

@section('title', 'Translations')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}

@endsection

@section('content')

    <div class="content">

        <div class="container-fluid">

            <form action="{{ route('admin.languages.translations.store', $language) }}" class=" needs-validation p-0"
                method="post" novalidate>
                @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        @include('admin.language.translation.forms.text', [
                                            'field' => 'group',
                                            'label' => __('locale.group_label'),
                                            'placeholder' => __('locale.group_placeholder'),
                                            'required' => true,
                                        ])
                                    </div>
                                    <div class="col-md-6">
                                        @include('admin.language.translation.forms.text', [
                                            'field' => 'key',
                                            'label' => __('locale.key_label'),
                                            'placeholder' => __('locale.key_placeholder'),
                                            'required' => true,
                                        ])
                                    </div>
                                    <div class="col-md-6">
                                        @include('admin.language.translation.forms.text', [
                                            'field' => 'value',
                                            'label' => __('locale.value_label'),
                                            'placeholder' => __('locale.value_placeholder'),
                                            'required' => true,
                                        ])
                                    </div>


                                </div>

                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="text-center mb-3">
                            @if (session()->has('locale'))
                                <a href="{{ url(session()->get('locale') . '/admin/languages') }}" type="reset"
                                    class="btn w-sm btn-light waves-effect">@lang('locale.Cancel')</a>
                            @else
                                <a href="{{ url(app()->getLocale() . '/admin/languages') }}" type="reset"
                                    class="btn w-sm btn-light waves-effect">@lang('locale.Cancel')</a>
                            @endif

                            <button type="submit"
                                class="btn w-sm btn-primary waves-effect waves-light">@lang('locale.Save')</button>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </form>



        </div>
    </div>
@section('custom-script')
    <script src="{{ asset('/vendor/translation/js/app.js') }}"></script>
@endsection
@endsection
