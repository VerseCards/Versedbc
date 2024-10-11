@extends('layouts.admin')
@php
    
    $profile = \App\Models\Utility::get_file('uploads/avatar');
    
    $users = \Auth::user();
@endphp
@section('page-title')
    {{ __('Profile Account') }}
@endsection
@push('custom-scripts')
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
@endpush

@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            
                            <a href="#useradd-3"
                                class="list-group-item list-group-item-action border-0">{{ __('Change Password') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    

                    <div id="useradd-3" class="card">
                        <div class="card-header">
                            <h5>{{ __('Change Password') }}</h5>
                            <small class="text-muted">{{ __('Edit details about your Password') }}</small>
                        </div>
                        {{ Form::model($userDetail, ['route' => ['update.password', $userDetail->id], 'method' => 'post']) }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('current_password', __('Current Password'), ['class' => 'form-label']) }}
                                        {{ Form::password('current_password', ['class' => 'form-control', 'placeholder' => __('Enter Current Password')]) }}
                                        @error('current_password')
                                            <span class="invalid-current_password" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('new_password', __('New Password'), ['class' => 'form-label']) }}
                                        {{ Form::password('new_password', ['class' => 'form-control', 'placeholder' => __('Enter New Password')]) }}
                                        @error('new_password')
                                            <span class="invalid-new_password" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('confirm_password', __('Re-type New Password'), ['class' => 'form-label']) }}
                                        {{ Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => __('Enter Re-type New Password')]) }}
                                        @error('confirm_password')
                                            <span class="invalid-confirm_password" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            {{ Form::submit(__('Save Change'), ['class' => 'btn btn-print-invoice  btn-primary']) }}
                        </div>
                        {{ Form::close() }}



                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection
