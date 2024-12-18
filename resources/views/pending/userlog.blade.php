@extends('layouts.admin')
@section('page-title')
    {{ __('User Approval') }}
@endsection
@section('title')
    {{ __('User Approval') }}
@endsection
@section('action-btn')

@endsection

@section('content')
    
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style ">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
						<th>{{__('SN')}} </th>
                            <th>{{__('Staff Name')}} </th>
							<th>{{__('email')}} </th>
							<th>{{__('Department')}} </th>
							<th>{{__('Designation')}} </th>
							<th>{{__('Requested By')}} </th>
							<th>{{__('Action')}} </th>
							 <th>{{__('Status')}} </th>
                            @if(Auth::user()->name == 'Super Admin')
                            <th width="200px">{{__('Action')}} </th>
						@endif
                        </thead>
                        <tbody>
                        @foreach ($pending as $role)
                            <tr>
							<td>{{ $loop->index + 1 }}</td>
                                <td>{{ ucfirst($role->name)}}</td>
								<td>{{ ucfirst($role->email)}}</td>
								<td>{{ ucfirst($role->department)}}</td>
								<td>{{ ucfirst($role->designation)}}</td>
								<td>{{ ucfirst($role->admin_name)}}</td>
								<td>
								@if (ucfirst($role->action) ==  1)
                                        <span class="badge btn--success" style="background: #4caf50;color: #ffffff;font-size: .8rem">@lang('New User')</span>
                                  @elseif(ucfirst($role->action) ==  3)
								  <span class="badge btn--success" style="background: #3432a3;color: #ffffff;font-size: .8rem">@lang('Update User')</span>
								  @elseif(ucfirst($role->action) ==  4)
								  <span class="badge btn--success" style="background: #3432a3;color: #ffffff;font-size: .8rem">@lang('Reset Password')</span>
								  @elseif(ucfirst($role->action) ==  5)
								  <span class="badge btn--success" style="background: #3432a3;color: #ffffff;font-size: .8rem">@lang('Enable Account')</span>
								  @elseif(ucfirst($role->action) ==  6)
								  <span class="badge btn--success" style="background: #3432a3;color: #ffffff;font-size: .8rem">@lang('Disable Account')</span>
								  @elseif(ucfirst($role->action) ==  7)
								  <span class="badge btn--success" style="background: #3432a3;color: #ffffff;font-size: .8rem">@lang('Enable Maker Admin')</span>
								  @elseif(ucfirst($role->action) ==  8)
								  <span class="badge btn--success" style="background: #3432a3;color: #ffffff;font-size: .8rem">@lang('Disable Maker Admin')</span>
								  @else
                                          <span class="badge badge--success" style="background: #ff0000;color: #fffff;font-size: .8rem">@lang('Delete User')</span>
								@endif</td>
								<td>
								 @if (ucfirst($role->status) ==  1)
                                        <span class="badge btn--warning" style="background: #ff8400;color: #ffffff;font-size: .8rem">@lang('Pending')</span>
                                  @elseif(ucfirst($role->status) ==  2)
                                          <span class="badge badge--success" style="background: #00b246;color: #fffff;font-size: .8rem">@lang('Approved')</span>
								@else
									 <span class="badge badge--danger" style="background: #ff0303;color: #ffffff;font-size: .8rem">@lang('Rejected')</span>
                                @endif
                                </td>
								@if(Auth::user()->name == 'Super Admin')
									@if($role->action == 2)
									<td>
									   
											<div class="action-btn bg-info ms-2">
												<a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center " data-url="{{ route('deleteUserPending',$role->id) }}" data-size="lg" data-ajax-popup="true"  data-title="{{__('Delete New User')}}" title="{{__('Update')}}" data-bs-toggle="tooltip" data-bs-placement="top"><span class="text-white"><i class="ti ti-edit text-white"></i></span></a>
											</div>

									</td>
									@elseif($role->action == 3)
										
									<td>
									   
											<div class="action-btn bg-info ms-2">
												<a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center " data-url="{{ route('updateUserPending',$role->id) }}" data-size="lg" data-ajax-popup="true"  data-title="{{__('Update User')}}" title="{{__('Update')}}" data-bs-toggle="tooltip" data-bs-placement="top"><span class="text-white"><i class="ti ti-edit text-white"></i></span></a>
											</div>

									</td>
									@else
										<td>
									   
											<div class="action-btn bg-info ms-2">
												<a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center " data-url="{{ route('showUserPending',$role->id) }}" data-size="lg" data-ajax-popup="true"  data-title="{{__('New User')}}" title="{{__('Update')}}" data-bs-toggle="tooltip" data-bs-placement="top"><span class="text-white"><i class="ti ti-edit text-white"></i></span></a>
											</div>

									</td>
								@endif
								@endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script-page')


@endpush