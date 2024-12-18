@extends('layouts.auth')
@section('content')
    <div class="container">
        <div class="row justify-content-md-left">
            <div class="col-md-8 ">
                <div class="card">
                    <div class="card-header" style="border-bottom: none; font-weight:600; color:#fff">Multi Factor Authentication</div>
                    <div class="card-body">
                        

                        

                        <p style="color:#fff">Enter the OTP from Microsoft Authenticator app:</p><br/><br/>
                        <form class="form-horizontal" action="{{ route('2faVerify') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('one_time_password-code') ? ' has-error' : '' }}">
                                <label for="one_time_password" class="control-label" style="color:#fff"></label>
                                <input id="one_time_password" name="one_time_password" class="form-control col-md-4"  type="text" required/>
                            </div>
							@if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <button class="btn btn-primary" type="submit">Authenticate</button>
                        </form>
						
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection