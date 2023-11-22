@component('mail::message')
# Hello, {{$contact['name']}}

{{ __('assessment.Admin has asked you to complete the following risk assessment questionnaire') }}

@component('mail::button', ['url' =>  route('admin.questionnaires.view',encrypt($data->id))])
{{$data->name}}
@endcomponent

{{ __('locale.Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
