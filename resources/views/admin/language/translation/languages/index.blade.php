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
    <style>
       .header-btn {
            float: inline-end;
        }
    </style>

@endsection




@section('content')
@php
    $currentLanguage = app()->getLocale();
@endphp

    @if (count($languages))
        <div class="content">


            <div class="container-fluid">



                <section class="content service-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="row mb-1">
                                    <div class="col-12 ">
                                        <a href="{{ route('admin.languages.create') }}" class="btn btn-primary header-btn ">
                                            @lang('locale.add_language')
                                        </a>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div id="basic-datatable_wrapper"
                                            class="dataTables_wrapper dt-bootstrap4 no-footer">

                                                    <div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100 table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('locale.language_name') }}</th>
                                                            <th>{{ __('locale.locale') }}</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($languages as $language => $name)
                                                            <tr>
                                                                <td>
                                                                    {{ $name }}
                                                                </td>
                                                                <td>
                                                                    <a  href="{{ route('admin.languages.translations.index', $language) }}">
                                                                        {{ $language }}
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{--  </div>  --}}
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->



            </div>
        </div>
    @endif

@endsection
