@component('mail::message')
# Introduction

the survey available check it now 

@component('mail::button', ['url' =>route('admin.awarness_survey.GetExam',$survey->id)])
Show Survey
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
