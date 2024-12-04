{{Form::open(array('url'=>'users','method'=>'post'))}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {{Form::label('name',__('Name*'),['class'=>'form-label']) }}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
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
            {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
            @error('email')
            <small class="invalid-email" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
	<div class="col-md-6">
        <div class="form-group">
            {{Form::label('mobile',__('Mobile*'),['class'=>'form-label'])}}
            {{Form::text('mobile',null,array('class'=>'form-control','placeholder'=>__('Enter Mobile Number'),'required'=>'required'))}}
            @error('mobile')
            <small class="invalid-email" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
	<div class="col-md-6">
        <div class="form-group">
            {{Form::label('designation',__('Designation*'),['class'=>'form-label'])}}
            {{Form::text('designation',null,array('class'=>'form-control','placeholder'=>__('Enter Designation'),'required'=>'required'))}}
            @error('designation')
            <small class="invalid-email" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>

		 
        <div class="form-group col-md-6">
            {{ Form::label('role', __('Department*'),['class'=>'form-label']) }}
            {!! Form::select('role', $roles, null,array('class' => 'form-control select2','required'=>'required')) !!}
            @error('role')
            <small class="invalid-role" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
   
	
	<div class="col-md-12">
		<div class="form-group">
			{{ Form::label('brief_bio', __('Brief Bio*'), ['class' => 'form-label']) }}
			{{ Form::textarea('brief_bio', null, ['class' => 'form-control', 'placeholder' => __('Enter Brief Bio'), 'required' => 'required', 'style' => 'height: 80px;']) }}
			@error('brief_bio')
				<small class="invalid-email" role="alert">
					<strong class="text-danger">{{ $message }}</strong>
				</small>
			@enderror
		</div>


    </div>
    
   
</div>
<div class="modal-footer p-0 pt-3">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
</div>
{{Form::close()}}
