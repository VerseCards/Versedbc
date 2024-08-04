@php
    $users = \Auth::user();
    $businesses = App\Models\Business::allBusiness();
    $currantBusiness = $users->currentBusiness();
    $bussiness_id = $users->current_business;
@endphp
@extends('layouts.admin')

@section('page-title')
    {{ __('Leads Campaign') }}
@endsection
@section('title')
    {{ __('Leads Campaign') }}
@endsection
@section('content')
    <style>
        .export-btn {
            float: right;
        }
    </style>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- //business Display Start --}}
                <div class="d-flex align-items-center justify-content-between">
                    <ul class="list-unstyled">
                        
                    </ul>
					<div>
					
					
					<a href="{{ route('leads.export') }}" class="btn btn-primary export-btn" style="margin-bottom:30px">
						Export All Leads
					</a>
					
					<a href="{{ route('leadcontact.index') }}" class="btn btn-primary export-btn" style="background-color: aliceblue;color: black;margin-right: 8px;margin-bottom:30px">
						View All Leads
					</a>
					</div>
					

                    {{-- //business Display End --}}
                    
                </div>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-export">
                        <thead>
                            <tr><th>{{ __('#') }}</th>
                                <th>{{ __('Campaign Name') }}</th>
                                <th>{{ __('Total Leads') }}</th>
								<th>{{ __('Created On') }}</th>
                                <th id="ignore">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leadGeneration_content as $val)
							@php

								if($users->type == 'company'){
									$leadCount = App\Models\LeadContact::where('campaign_id', $val['id'])->where('business_id', $val['business_id'])->count();
								}else{
									$leadCount = App\Models\LeadContact::where('user_id',$users->id)->where('campaign_id', $val['id'])->where('business_id', $val['business_id'])->count();
								}
										
							@endphp
                                <tr>
									<td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $val['title'] }}</td>
                                    <td>{{ $leadCount }}</td>
									<td>{{ \Carbon\Carbon::parse($val['created_at'])->format('j F, Y') }}</td>
									
                                    
                                    
                                    
                                    <div class="row ">
                                        <td class="d-flex">
                                          
                                                <div class="action-btn bg-info  ms-2" style="width:100px; padding: 0 60px;">
                                                    <a href="{{ route('campaign.lead', ['id' => $val['id'], 'business_id_key' => $val['business_id'], 'list_id' => $val['id']]) }}"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('View Lead') }}"> <span
                                                            class="text-white" > <i
                                                                class="ti ti-brand-google-analytics  text-white"></i></span><span style="margin-left:5px; padding-right:5px">View Leads</span></a>
                                                </div>
                                            
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['leadcontact.destroy', $val['id']],
                                                    'id' => 'delete-form-' . $val['id'],
                                                ]) !!}
                                                {!! Form::close() !!}
                                            
                                            
                                        </td>

                                    </div>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
    <script>
        const table = new simpleDatatables.DataTable("#pc-dt-export", {
            searchable: true,
            fixedheight: true,
            dom: 'Bfrtip',
        });
        $('.csv').on('click', function() {
            $('#ignore').remove();
            $("#pc-dt-export").table2excel({
                filename: "contactDetail"
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        })
    </script>
@endpush
