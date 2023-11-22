@extends('admin/layouts/contentLayoutMaster')

@section('title', 'Languages')

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



            <form action="{{ route('admin.languages.store') }}" class=" needs-validation p-0" method="post" novalidate>
                @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    @include('admin.language.translation.forms.text', [
                                        'field' => 'name',
                                        'label' => __('locale.language_name'),
                                    ])

                                    @include('admin.language.translation.forms.text', [
                                        'field' => 'locale',
                                        'label' => __('locale.locale'),
                                        'required' => true,
                                    ])


                                </div>

                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="text-center mb-3">
                            <a href="{{ url('/admin/languages') }}" type="reset"
                                class="btn w-sm btn-light waves-effect">@lang('locale.Cancel')</a>
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

@endsection
@endsection
