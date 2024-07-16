<link rel="stylesheet" href="{{ asset('custom/css/emojionearea.min.css') }}">
{{ Form::open(array('route' => ['contact.note.store',$contact->id])) }}

    <div class="row">
        <div class="col-12 form-group">
            <div class="row gutters-xs">
                    <div class="col-12"><h6 class="">{{__('Status')}}</h6></div>
                    <div class="col-6 ">
                        <div class="form-check ">
                            <input type="radio" id="pending" class="form-check-input mt-1"  name="status" value="pending" @if($contact->status == 'pending') checked @endif>
                        {{ Form::label('pending', 'Pending',['class'=>'custom-control-label ml-4 badge bg-warning p-2 px-3 rounded']) }}
                        </div>
                        
                    </div>
                    <div class="col-6 ">
                        <div class=" form-check  ">
                            <input type="radio" id="completed" class="form-check-input mt-1"  name="status" value="completed" @if($contact->status == 'completed') checked @endif>
                            {{ Form::label('completed', 'Completed',['class'=>'custom-control-label ml-4  badge bg-success p-2 px-3 rounded']) }}
                        </div>
                        
                    </div>
            </div>
        </div>
        <div class="col-12 form-group mt-4">
            <div class="row gutters-xs">
                <div class="col-12"><h6 class="ml-2">{{__('Add Remark')}}</h6></div>
                <div class="col-12">
                    <textarea class="summernote-simple" row="3" id="note" name="note">{!! $contact->note !!}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input class="btn btn-primary" type="submit" value="{{ __('Save') }}">
    </div>   
{{ Form::close() }}
<script src="{{ asset('custom/js/emojionearea.min.js')}}"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $("#emojiarea").emojioneArea();   
    });
</script>
<link rel="stylesheet" href="{{asset('custom/libs/summernote/summernote-bs4.css')}}">
<script src="{{ asset('custom/libs/summernote/summernote-bs4.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote();
    });
</script>
 
     