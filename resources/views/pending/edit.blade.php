{{Form::model($role,array('route' => array('approveChanges', $role->business_id, $role->id,), 'method' => 'POST')) }}
    <div>
        <div class="row">
            <div class="col-md-6">
            <h6 style="margin-bottom:20px"> Old Data</h6>
			@if($role->name != '')
            <p><strong>Name:</strong> {{__($role->old_name) }}</p>
		@endif
		@if($role->department != '')
            <p><strong>Department:</strong> {{__($role->old_department) }}</p>
		@endif
		@if($role->designation != '')
            <p><strong>Designation:</strong> {{__($role->old_designation) }}</p>
		@endif
		@if($role->bio != '')
			<p><strong>Bio:</strong> {{__($role->old_bio) }}</p>
		@endif
		@if($role->slug != '')
			<p><strong>Url:</strong> {{__($role->old_slug) }}</p>
		@endif
		@if($role->secret_code != '')
			<p><strong>Secret Code:</strong> {{__($role->old_secret_code) }}</p>
		@endif
          </div>
          <div class="col-md-6">
            <h6 style="margin-bottom:20px">New Data</h6>
			@if($role->name != '')
            <p><strong>Name:</strong> {{__($role->name) }}</p>
			{{ Form::hidden('name', null) }}

			@endif
			@if($role->department != '')
            <p><strong>Department:</strong> {{__($role->department) }}</p>
			{{ Form::hidden('department', null) }}

			@endif
			@if($role->designation != '')
            <p><strong>Designation:</strong> {{__($role->designation) }}</p>
			{{ Form::hidden('designation', null) }}
			@endif
			@if($role->bio != '')
			<p><strong>Bio:</strong> {{__($role->bio) }}</p>
			{{ Form::hidden('bio', null) }}
			@endif
			@if($role->slug != '')
			<p><strong>Url:</strong> {{__($role->slug) }}</p>
			{{ Form::hidden('slug', null) }}
			@endif
			@if($role->secret_code != '')
			<p><strong>Secret Code:</strong> {{__($role->secret_code) }}</p>
			{{ Form::hidden('secret_code', null) }}
		@endif
		
		
          </div>
        </div>
     </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Close')}}" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
		 <button type="submit" name="action" value="reject" class="btn btn-danger ms-2">{{__('Reject')}}</button>
		 <button type="submit" name="action" value="approve" class="btn btn-primary ms-2">{{__('Approve')}}</button>
    </div>
{{Form::close()}}

<script>
    $(document).ready(function () {
           $("#checkall").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
           $(".ischeck").click(function(){
                var ischeck = $(this).data('id');
                $('.isscheck_'+ ischeck).prop('checked', this.checked);
            });
        });
</script>
