<a href="javascript:void(0)" class="btn btn-sm btn-warning edit_answer_btn" data-id="{{$id}}" data-url="{{route('admin.answers.edit',['question'=>$question_id,'answer'=>$id])}}"><i class="fa fa-edit fa-sm"></i>{{__('locale.Edit')}}</a>
<a href="javascript:void(0)" class="btn btn-sm btn-danger delete_answer_btn" data-url="{{route('admin.answers.destroy',['question'=>$question_id,'answer'=>$id])}}"><i class="fa fa-close fa-sm"></i> {{__('locale.Delete')}}</a>


