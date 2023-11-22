@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.translations'))

@section('vendor-style')

@endsection

@section('page-style')


    <link rel="stylesheet" href="{{ asset('vendor/translation/css/main.css') }}">
    @if (session()->has('locale'))
        @php $local_key = session()->get('locale'); @endphp
    @else
        @php $local_key = app()->getLocale(); @endphp
    @endif

    @if ($local_key == 'ar')
        <style>
            body {
                direction: rtl;

            }

            .cursor-pointer.fill-current {
                margin-left: 0.5rem;
            }
        </style>
    @endif
    <style>
        .panel-body th {
            font-weight: bold;
        }

        .panel-body td,
        .select-group select,
        .panel-header {
            font-weight: 500;
        }

        .panel-body td textarea {
            font-weight: 500;
            color: #009cc8;
            font-size: 14px;
        }

        .panel-header .select-group {
            margin: 5px;
        }

        .panel-header {
            background: #0097a7;
            border-radius: 15px 15px 0 0;
            color: #FFF !important;
        }

        .button {
            color: #FFF !important;
        }
    </style>


@endsection


@section('content')

    @php
        $currentLanguage = app()->getLocale();
    @endphp


    <div id="app">
        <form action="{{ route('admin.languages.translations.index', ['language' => $language]) }}" method="get">

            <div class="panel">

                <div class="panel-header">

                    {{ __('locale.translations') }}

                    <div class="flex flex-grow justify-end items-center">

                        @include('admin.language.translation.forms.search', [
                            'name' => 'filter',
                            'value' => Request::get('filter'),
                        ])

                        @include('admin.language.translation.forms.select', [
                            'name' => 'language',
                            'items' => $languages,
                            'submit' => true,
                            'selected' => $language,
                        ])

                        <div class="sm:hidden lg:flex items-center">

                            @include('admin.language.translation.forms.select', [
                                'name' => 'group',
                                'items' => $groups,
                                'submit' => true,
                                'selected' => Request::get('group'),
                                'optional' => true,
                            ])

                            <a href="{{ route('admin.languages.translations.create', $language) }}" class="button">
                                {{ __('locale.Add') }}
                            </a>

                        </div>

                    </div>

                </div>

                <div class="panel-body">

                    @if (count($translations))
                        @php
                            $language_key = request()->segment(3);
                        @endphp
                        <table>

                            <thead>
                                <tr>
                                    <th class="w-1/5 uppercase font-thin">{{ __('locale.group_single') }}</th>
                                    <th class="w-1/5 uppercase font-thin">{{ __('locale.key') }}</th>
                                    {{--  <th class="uppercase font-thin">{{ config('app.locale') }}</th>  --}}
                                    <th class="uppercase font-thin">{{ __('locale.'.$language_key) }}</th>
                                    <th class="uppercase font-thin">{{ $language }}</th>
                                </tr>
                            </thead>

                            <tbody>


                                @foreach ($translations as $type => $items)
                                    @foreach ($items as $group => $translations)
                                        @foreach ($translations as $key => $value)
                                            @if (!is_array($value[$language_key]))
                                                <tr>
                                                    <td>{{ $group }}</td>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ $value[$language_key] }}</td>
                                                    <td>

                                                        <translation-input initial-translation="{{ $value[$language] }}"
                                                            language="{{ $language }}" group="{{ $group }}"
                                                            translation-key="{{ $key }}"
                                                            route="{{ config('translation.ui_url') }}">
                                                        </translation-input>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>

                        </table>

                    @endif

                </div>

            </div>

        </form>

    </div>

@section('vendor-script')
    <script src="{{ asset('/vendor/translation/js/app.js') }}"></script>
@endsection
@endsection
