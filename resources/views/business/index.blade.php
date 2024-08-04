@php
	$users = \Auth::user();
    $cardLogo = \App\Models\Utility::get_file('card_logo/');
@endphp
@extends('layouts.admin')
@section('page-title')
    {{ __('All Business Cards') }}
@endsection
@section('title')
    {{ __('All Business Cards') }}
@endsection

@section('action-btn')
    @if($users->type == 'company')
        <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
            data-bs-placement="top">
            <a href="#" data-size="xl" data-url="{{ route('business.create') }}" data-ajax-popup="true"
                data-bs-toggle="tooltip" title="{{ __('Create') }}" data-title="{{ __('Create New Business') }}"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    @endif
@endsection
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('Profile Picture') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th class="text-end">{{ __('Operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($business as $val)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="avatar">
                                            
                                            <img style="width: 55px;height: 55px;" class="rounded-circle "
                                                src="{{ isset($val->logo) && !empty($val->logo) ? $cardLogo.'/'.$val->logo : asset('custom/img/logo-placeholder-image-21.png') }}"
                                                alt="">
                                        </div>
                                    </td>

                                    <td class="">
                                        <a class=""
                                            href="{{ route('business.edit', $val->id) }}"><b>{{ ucFirst($val->title) }}</b></a>
                                    </td>
                                    <td><span
                                            class="badge fix_badge @if ($val->status == 'locked') bg-danger @else bg-info @endif p-2 px-3 rounded">{{ ucFirst($val->status) }}</span>
                                    </td>
                                    @php
                                        $now = $val->created_at;
                                        $date = $now->format('Y-m-d');
                                        $time = $now->format('H:i:s');
                                    @endphp
                                    <td>{{ $val->created_at }}</td>

                                    <td class="text-end">
                                        @if ($val->status != 'lock')
										<button type="button" class="btn"
											data-bs-toggle="dropdown" aria-haspopup="true"
											aria-expanded="false">
											<i class="feather icon-more-vertical"></i>
										</button>
									<div class="dropdown-menu dropdown-menu-end">
                                    
                                    
									<a href="{{ route('business.edit', $val->id) }}"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-edit"></i>
                                            <span class="ml-2"> {{ __('Edit Card Details') }}</span>
                                        </a>
									
										<a href="{{ route('business.analytics', $val->id) }}"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-brand-google-analytics"></i>
                                            <span class="ml-2"> {{ __('View Analytics') }}</span>
                                        </a>
									
									
										<a href="{{ route('business.contacts.show', $val->id) }}"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-phone"></i>
                                            <span class="ml-2"> {{ __('View Contacts') }}</span>
                                        </a>
										
										
									
									
										<a href="{{ route('appointment.calendar', $val->id) }}"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-calendar"></i>
                                            <span class="ml-2"> {{ __('My Calender') }}</span>
                                        </a>
									
										
									
									
									<a href="#"
                                            class="dropdown-item user-drop cp_link" data-link="{{ url('/' . $val->slug) }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Click to copy card link') }}">
                                            <i class="ti ti-copy"></i>
                                            <span class="ml-2"> {{ __('Copy Link') }}</span>
                                        </a>
										
										<a href="{{ url('/' . $val->slug) }}" target="-blank"
                                            class="dropdown-item user-drop" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Click to preview link') }}">
                                            <i class="ti ti-copy"></i>
                                            <span class="ml-2"> {{ __('Preview Link') }}</span>
                                        </a>

									@if($users->type == 'company')
                                        <a href="#" class="bs-pass-para dropdown-item user-drop"  data-confirm="{{__('Are You Sure?')}}" data-text="{{__('This action will delete all business card details permanently. Continue?')}}" data-confirm-yes="delete-form-{{$val->id}}" title="{{__('Delete')}}" data-bs-toggle="tooltip" data-bs-placement="top"><i class="ti ti-trash"></i><span class="ml-2">{{__('Delete')}}</span></a>
										
										{!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['business.destroy', $val->id],
                                                    'id' => 'delete-form-' . $val->id,
                                                ]) !!}
                                                {!! Form::close() !!}
                                    @else
                                                <span class="edit-icon align-middle bg-gray"><i
                                                        class="fas fa-lock text-white"></i></span>
                                    @endif
                                                
                                @endif
                            </div>
                                            
                                            
                                            
                                        {{-- @else
                                            <div class="action-btn bg-dark  ms-2">
                                                {{ Form::open(['route' => ['business.status', $val->id], 'class' => 'm-0']) }}
                                                @method('POST')
                                                <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                    data-bs-toggle="tooltip" title=""
                                                    data-bs-original-title="Business Unlock"
                                                    aria-label="Business Unlock"
                                                    data-confirm="{{ __('Are You Sure?') }}"
                                                    data-text="{{ __('This action will delete all business card details. Continue?') }}"
                                                    data-confirm-yes="delete-form-{{ $val->id }}">
                                                    <i class="ti ti-lock-open"></i></a>

                                                {!! Form::close() !!}
                                            </div> --}}
                                      
                                    </td>

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
    <script type="text/javascript">
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastrs('{{ __('Success') }}', '{{ __('Link Copy on Clipboard') }}', 'success');
        });
    </script>
@endpush
