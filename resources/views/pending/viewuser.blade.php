@if($role->action == 1)
{{Form::model($role,array('route' => array('approveNewUserAdmin', $role->id,), 'method' => 'POST', 'onsubmit' => 'disableButtons(this)')) }}
	@csrf
    <div>
        <div class="row">
            <div class="col-md-6">
            <h6>Are you sure you want to approve this New User?</h6>

          </div>
        </div>
     </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Close')}}" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
		 <button type="submit" name="action" value="reject" class="btn btn-danger ms-2" data-confirm-text="Rejected">{{__('Reject')}}</button>
		 <button type="submit" name="action" value="approve" class="btn btn-primary ms-2" data-confirm-text="Approved">{{__('Approve')}}</button>
    </div>
{{Form::close()}}
@elseif($role->action == 2)
{{Form::model($role,array('route' => array('approveUserDelete', $role->id,), 'method' => 'POST', 'onsubmit' => 'disableButtons(this)')) }}
@csrf
    <div>
        <div class="row">
            <div class="col-md-6">
            <h6>Are you sure you want to delete this User?</h6>
		
		
          </div>
        </div>
     </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Close')}}" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
		 <button type="submit" name="action" value="reject" class="btn btn-danger ms-2" data-confirm-text="Rejected">{{__('No!')}}</button>
		 <button type="submit" name="action" value="approve" class="btn btn-primary ms-2" data-confirm-text="Approved">{{__('Yes! Delete')}}</button>
    </div>
{{Form::close()}}	

@elseif($role->action == 4)
{{Form::model($role,array('route' => array('user.password.approve', $role->id,), 'method' => 'POST', 'onsubmit' => 'disableButtons(this)')) }}
@csrf
    <div>
        <div class="row">
            <div class="col-md-12">
            <h6>Are you sure you want to reset this User password?</h6>
		
		
          </div>
        </div>
     </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Close')}}" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
		 <button type="submit" name="action" value="reject" class="btn btn-danger ms-2" data-confirm-text="Rejected">{{__('No!')}}</button>
		 <button type="submit" name="action" value="approve" class="btn btn-primary ms-2" data-confirm-text="Approved">{{__('Yes! Reset')}}</button>
    </div>
{{Form::close()}}	
@elseif($role->action == 5)
{{Form::model($role,array('route' => array('approveLoginStatus', $role->id,), 'method' => 'POST', 'onsubmit' => 'disableButtons(this)')) }}
@csrf
    <div>
        <div class="row">
            <div class="col-md-12">
            <h6>Are you sure you want to enable this account?</h6>
		
		
          </div>
        </div>
     </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Close')}}" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
		 <button type="submit" name="action" value="reject" class="btn btn-danger ms-2" data-confirm-text="Rejected">{{__('No!')}}</button>
		 <button type="submit" name="action" value="approve" class="btn btn-primary ms-2" data-confirm-text="Approved">{{__('Yes! Enable')}}</button>
    </div>
{{Form::close()}}	
@elseif($role->action == 6)
{{Form::model($role,array('route' => array('approveLoginStatus', $role->id,), 'method' => 'POST', 'onsubmit' => 'disableButtons(this)')) }}
@csrf
    <div>
        <div class="row">
            <div class="col-md-12">
            <h6>Are you sure you want to diable this account?</h6>
		
		
          </div>
        </div>
     </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Close')}}" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
		 <button type="submit" name="action" value="reject" class="btn btn-danger ms-2"  data-confirm-text="Rejected">{{__('No!')}}</button>
		 <button type="submit" name="action" value="approve" class="btn btn-primary ms-2" data-confirm-text="Approved">{{__('Yes! Disable')}}</button>
    </div>
{{Form::close()}}
@elseif($role->action == 7)
{{ Form::model($role, ['route' => ['approveMakerAdmin', $role->id], 'method' => 'POST', 'onsubmit' => 'disableButtons(this)']) }}
@csrf
<div>
    <div class="row">
        <div class="col-md-12">
            <h6>Are you sure you want to enable this user as Maker Admin?</h6>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Close') }}" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
    <button type="submit" name="action" value="reject" class="btn btn-danger ms-2" data-confirm-text="Rejected">{{ __('No!') }}</button>
    <button type="submit" name="action" value="approve" class="btn btn-primary ms-2" data-confirm-text="Approved">{{ __('Yes! Enable') }}</button>
</div>
{{ Form::close() }}
@elseif($role->action == 8)
{{ Form::model($role, ['route' => ['approveMakerAdmin', $role->id], 'method' => 'POST', 'onsubmit' => 'disableButtons(this)']) }}
@csrf
<div>
    <div class="row">
        <div class="col-md-12">
            <h6>Are you sure you want to disable this user as Maker Admin?</h6>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Close') }}" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
    <button type="submit" name="action" value="reject" class="btn btn-danger ms-2" data-confirm-text="Rejected">{{ __('No!') }}</button>
    <button type="submit" name="action" value="approve" class="btn btn-primary ms-2" data-confirm-text="Approved">{{ __('Yes! Disable') }}</button>
</div>
{{ Form::close() }}

@else
	
{{Form::model($role,array('route' => array('approveUserUpdate', $role->id,), 'method' => 'POST', 'onsubmit' => 'disableButtons(this)')) }}
@csrf
    <div>
        <div class="row">
            <div class="col-md-6">
            <h6 style="margin-bottom:20px"> Old Data</h6>
			@if($role->name != '')
            <p><strong>Name:</strong> {{__($role->name) }}</p>
		@endif
		@if($role->old_email != '')
            <p><strong>Email:</strong> {{__($role->email) }}</p>
		@endif
		@if($role->old_designation != '')
            <p><strong>Designation:</strong> {{__($role->designation) }}</p>
		@endif
		@if($role->old_department != '')
            <p><strong>Department:</strong> {{__($role->department) }}</p>
		@endif


          </div>
          <div class="col-md-6">
            <h6 style="margin-bottom:20px">New Data</h6>
			@if($role->name != '')
            <p><strong>Name:</strong> {{__($role->old_name) }}</p>
			{{ Form::hidden('old_name', null) }}

			@endif
			@if($role->old_email != '')
            <p><strong>Email:</strong> {{__($role->old_email) }}</p>
			{{ Form::hidden('old_email', null) }}

			@endif
			@if($role->old_designation != '')
            <p><strong>Designation:</strong> {{__($role->old_designation) }}</p>
			{{ Form::hidden('old_designation', null) }}
			@endif
			@if($role->old_department != '')
            <p><strong>Department:</strong> {{__($role->old_department) }}</p>
			{{ Form::hidden('old_department', null) }}
			@endif
			
		
		
          </div>
        </div>
     </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Close')}}" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
		 <button type="submit" name="action" value="reject" class="btn btn-danger ms-2" data-confirm-text="Rejected">{{__('No! Reject')}}</button>
		 <button type="submit" name="action" value="approve" class="btn btn-primary ms-2"  data-confirm-text="Approved">{{__('Yes! Update')}}</button>
    </div>
{{Form::close()}}

@endif
<script>

    $(document).ready(function () {
        // Checkbox toggle logic
        $("#checkall").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(".ischeck").click(function () {
            var ischeck = $(this).data('id');
            $('.isscheck_' + ischeck).prop('checked', this.checked);
        });
    });

function disableButtons(form) {
    // Ensure the form is submitted before disabling buttons
    setTimeout(() => {
        const buttons = form.querySelectorAll('button[type="submit"]');
        buttons.forEach(button => {
            // Disable all buttons after form submission
            button.disabled = true;
            button.textContent = "Processing..."; // Temporary text
        });
    }, 100); // Give a small delay before disabling buttons
    
    // Allow form submission to proceed
}






</script>
