@extends('admin.layouts.contentLayoutMaster')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">


                <div class="card-header"></div>


                {{--  @error('answer_percentage')
                  <div class="alert alert-danger text-center container">
                      {{$message}}
                  </div>
                  @enderror
  --}}
                @if($session =session('success'))
                    <div class="alert alert-success text-center container">
                        {{$session}}
                    </div>
                @endif

                @if($error =session('error'))
                    <div class="alert alert-danger text-center container">
                        {{$error}}
                    </div>
                @endif


                @if(session('errors') != null)
                    <div class="alert alert-danger text-center container">
                        <ul>
                            @foreach(session('errors') as $err)

                                <li>{{$err}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">

                    <form action="{{route('admin.questionnaires.answer')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="submission_type" id="submission_type" value="complete">

                        <input type="hidden" name="contact_id" value="{{auth()->id()}}">
                        <input type="hidden" name="questionnaire_id" value="{{$questionnaire->id}}">

                        <div class="row">
                        <span class="col-md-4 text-warning">
                            {{__('locale.Instructions')}}:
                        </span>
                            <div class="col-md-8  text-warning">
                                {{$questionnaire->instructions}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="d-inline">{{__('assessment.AssetName')}} </label>

                                    <select name="asset_id" required class="form-control select2" id="">
                                        <option value="">{{ __('locale.Choose') }}</option>
                                        @foreach($assets as $asset)
                                            <option {{ (old('asset_id') == $asset->id) ? 'selected':""}} {{@$questionnaire->latestAnswers->asset_id == $asset->id ? 'selected':""}} value="{{$asset->id}}">{{$asset->name}}</option>
                                        @endforeach
                                    </select>


                                </div>
                            </div>

                        </div>

                        <input type="hidden" name="answer_percentage" value="{{$questionnaire->answer_percentage}}">
                        <input type="hidden" name="percentage_number" value="{{$questionnaire->percentage_number}}">

                        <br>
                        @foreach($questionnaire->assessment->questions as $index=> $question)
                            <div class="form-group">
                                <label for="">
                                    <b class="badge badge-light-warning " style="font-size: 15px">{{++$index}}</b>
                                    <span class="" style="font-size: 15px; font-weight: bold"> {{$question->question}}</span>
                                    {{--  @error('questions.'.$index.'.answers')
                                      <span class="text-danger">{{$message}}</span>
                                      @enderror--}}
                                    @if($questionnaire->all_questions_mandatory || ($questionnaire->specific_mandatory_questions && in_array($question->id,$questionnaire->questions->pluck('id')->toArray())))
                                        <span class="text-danger"><span class="text-danger">*</span></span>

                                    @endif

                                </label>
                            </div>
                            <br>
                            {{--                        Answers :--}}

                            @isset($questionnaire->latestAnswers)

                                @php
                                    if($questionnaire->latestAnswers->status =='complete'){
                                         $complete = true;
                                    }else{
                                         $complete = false;
                                    }
                                @endphp
                            @endisset
                            @if($question->answer_type == 1 )

                                @isset($questionnaire->latestAnswers->results)

                                    @foreach($questionnaire->latestAnswers->results as $result)

                                        @php

                                            if($result->answer_type == $question->answer_type && $result->question_id == $question->id){
                                                    $correct_question_answer = $result->answer_id;

                                                    $comment = $result->comment;

                                            }
                                        @endphp

                                    @endforeach
                                @endisset



                                <input type="hidden" name="questions[{{$index}}][answer_type]" value="{{$question->answer_type}}">
                                <input type="hidden" name="questions[{{$index}}][question_id]" value="{{$question->id}}">
                                {{--single select answer--}}
                                @if($questionnaire->all_questions_mandatory || ($questionnaire->specific_mandatory_questions && in_array($question->id,$questionnaire->questions->pluck('id')->toArray())))
                                    <input type="hidden" name="questions[{{$index}}][question_is_required]" value="true">
                                @else
                                    <input type="hidden" name="questions[{{$index}}][question_is_required]" value="false">
                                @endif


                                @foreach($question->answers as $answer)

                                    <input type="radio" {{$complete ? ' readonly disabled':''}} {{--{{$questionnaire->all_questions_mandatory || ($questionnaire->specific_mandatory_questions && in_array($question->id,$questionnaire->questions->pluck('id')->toArray())) ? 'required':""}}--}}
                                    name="questions[{{$index}}][answers]" {{old('questions.'.$index.'.answers') == $answer->id || (@$correct_question_answer == $answer->id)?  'checked':''}} value="{{$answer->id}}" id="answer_{{$answer->id}}">
                                    <label for="answer_{{$answer->id}}">{!! trim($answer->answer) !!}</label>
                                    <br>
                                @endforeach
                                <br>
                                <label for="" class="d-block"> {{__('assessment.Comment')}}</label>
                                <textarea cols="70" rows="2" name="questions[{{$index}}][comment]">
                                  {{old('questions.'.$index.'.comment',@$comment)}}
                                </textarea>
                                <br>

                            @elseif($question->answer_type == 2)

                                @isset($questionnaire->latestAnswers->results)
                                    @foreach($questionnaire->latestAnswers->results as $result)

                                        @php
                                            if($result->answer_type == $question->answer_type && $result->question_id == $question->id){

                                                $correct_question_answer = explode(',',$result->answer);
                                                $comment = $result->comment;
                                            }
                                        @endphp

                                    @endforeach
                                @endisset


                                <input type="hidden" name="questions[{{$index}}][answer_type]" value="{{$question->answer_type}}">
                                <input type="hidden" name="questions[{{$index}}][question_id]" value="{{$question->id}}">
                                @if($questionnaire->all_questions_mandatory || ($questionnaire->specific_mandatory_questions && in_array($question->id,$questionnaire->questions->pluck('id')->toArray())))
                                    <input type="hidden" name="questions[{{$index}}][question_is_required]" value="true">
                                @else
                                    <input type="hidden" name="questions[{{$index}}][question_is_required]" value="false">
                                @endif

                                @foreach($question->answers as $answer)
                                    <input type="checkbox" {{$complete ? ' readonly disabled':''}} {{ (is_array(old('questions.'.$index.'.answers')) && in_array($answer->id , old('questions.'.$index.'.answers'))) || (in_array($answer->id,@$correct_question_answer??[])) ? 'checked':''}}
                                    name="questions[{{$index}}][answers][]" value="{{$answer->id}}" id="answer_{{$answer->id}}">
                                    <label for="answer_{{$answer->id}}">{!! trim($answer->answer) !!}</label>
                                    <br>
                                @endforeach
                                <br>
                                <label for="" class="d-block">{{__('assessment.Comment')}}</label>
                                <textarea cols="70" rows="2" name="questions[{{$index}}][comment]">
                                    {{old('questions.'.$index.'.comment',@$comment)}}
                                </textarea>
                                <br>
                            @else

                                @isset($questionnaire->latestAnswers->results)
                                    @foreach($questionnaire->latestAnswers->results as $result)

                                        @php
                                            if($result->answer_type == $question->answer_type && $result->question_id == $question->id){

                                                $correct_question_answer =$result->answer;
                                            }
                                        @endphp

                                    @endforeach
                                @endisset

                                @if($questionnaire->all_questions_mandatory || ($questionnaire->specific_mandatory_questions && in_array($question->id,$questionnaire->questions->pluck('id')->toArray())))
                                    <input type="hidden" name="questions[{{$index}}][question_is_required]" value="true">
                                @else
                                    <input type="hidden" name="questions[{{$index}}][question_is_required]" value="false">
                                @endif

                                <input type="hidden" name="questions[{{$index}}][answer_type]" value="{{$question->answer_type}}">
                                <input type="hidden" name="questions[{{$index}}][question_id]" value="{{$question->id}}">

                                <textarea {{$complete ? ' readonly disabled':''}} name="questions[{{$index}}][answers]" id="" cols="70" rows="2"
                                          {{$questionnaire->all_questions_mandatory || ($questionnaire->specific_mandatory_questions && in_array($question->id,$questionnaire->questions->pluck('id')->toArray())) ? 'required':""}}>


                                    {{ old('questions.'.$index.'.answers',@$correct_question_answer)}}
                                </textarea>

                                <br>

                            @endif
                            @if($question->file_attachment)
                                <input type="file" name="questions[{{$index}}][file]">
                                <br>
                                <br>
                            @endif
                        @endforeach
                        @if(!$complete)
                            <button type="submit" class="btn btn-warning draft_submit">{{__('assessment.Draft')}}</button>
                            <button type="submit" class="btn btn-success complete_submit">{{__('assessment.Complete')}}</button>
                        @endif


                        <a href="{{url()->to('/admin/dashboard')}}" type="submit" class="btn btn-primary">{{__('assessment.Back')}}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $('.complete_submit,  .draft_submit').on('click', function (e) {
            e.preventDefault();
            if ($(this).hasClass('draft_submit')) {
                $('#submission_type').val('draft');
            } else {
                $('#submission_type').val('complete');
            }

            $('form').submit();
        })


    </script>
@endsection
