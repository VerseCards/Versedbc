@extends('layouts.admin')
@section('page-title')
    {{ __('Card Updates') }}
@endsection
@section('title')
    {{ __('Card Updates') }}
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
							<th>{{__('Department')}} </th>
							<th>{{__('Requested By')}} </th>
							<th>{{__('Remark')}} </th>
							 <th>{{__('Status')}} </th>
                            @if(Auth::user()->name == 'Super Admin')
                            <th width="200px">{{__('Action')}} </th>
						@endif
                        </thead>
                        <tbody>
                        @foreach ($pending as $role)
                            <tr>
							<td>{{ $loop->index + 1 }}</td>
                                <td>{{ ucfirst($role->old_name)}}</td>
								<td>{{ ucfirst($role->old_department)}}</td>
								<td>{{ ucfirst($role->admin_name)}}</td>
								<td>{{ ucfirst($role->remark)}}</td>
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
                                <td>
                                   
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center " data-url="{{ route('showPending',$role->id) }}" data-size="lg" data-ajax-popup="true"  data-title="{{__('Pending Approval')}}" title="{{__('Update')}}" data-bs-toggle="tooltip" data-bs-placement="top"><span class="text-white"><i class="ti ti-edit text-white"></i></span></a>
                                        </div>

                                </td>
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