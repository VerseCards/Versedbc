{{Form::model($user,array('route' => array('userUpdate', $user->id), 'method' => 'GET')) }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group ">
            {{Form::label('name',__('Name*'),['class'=>'form-label']) }}
            {{Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter User Name')))}}
            @error('name')
            <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{Form::label('email',__('Email*'),['class'=>'form-label'])}}
            {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email')))}}
            @error('email')
            <small class="invalid-email" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>

    @if(\Auth::user()->type == 'company')
        <div class="form-group col-md-6">
            {{ Form::label('role', __('Staff Department*'),['class'=>'form-label']) }}
            {!! Form::select('role', $roles, $user->roles,array('class' => 'form-control select2','required'=>'required')) !!}
            @error('role')
            <small class="invalid-role" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
		<div class="col-md-6">
        <div class="form-group">
            {{Form::label('designation',__('Designation*'),['class'=>'form-label'])}}
            {{Form::text('designation',null,array('class'=>'form-control','placeholder'=>__('Enter Designation')))}}
            @error('designation')
            <small class="invalid-email" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
		
    @endif
</div>
 <div class="modal-footer p-0 pt-3">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Update') }}">
</div>
{{Form::close()}}