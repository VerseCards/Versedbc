@extends('layouts.admin')
@section('page-title')
    {{ __('Activity Log') }}
@endsection
@section('title')
    {{ __('Activity Log') }}
@endsection
@section('action-btn')

@endsection

@section('content')
    
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style ">
               
				<div class="d-flex align-items-center justify-content-between">
                    <ul class="list-unstyled">
                        
                    </ul>

                    {{-- //business Display End --}}
                    <a href="{{ route('activitylog.export') }}" class="btn btn-primary export-btn" style="margin-bottom:30px">
						Export Activity Log
					</a>
                </div>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
						<th>{{__('SN')}} </th>
                            <th>{{__('Action By')}} </th>
							<th>{{__('Remark')}} </th>
							<th>{{__('Created_at')}} </th>
                            
                            
                        </thead>
                        <tbody>
                        @foreach ($log as $role)
                            <tr>
							<td>{{ $loop->index + 1 }}</td>
                                <td>{{ ucfirst($role->initiated_by)}}</td>
                                <td>{{ ucfirst($role->remark)}}</td>
								<td>{{ ucfirst($role->created_at)}}</td>
                                
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