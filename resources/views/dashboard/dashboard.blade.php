@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
    $qr_path = \App\Models\Utility::get_file('qrcode');
    $businesses = App\Models\Business::allBusiness();
    $currantBusiness = $user->currentBusiness();
    $bussiness_id = $user->current_business;
	$users = \Auth::user();
@endphp
@extends('layouts.admin')
@push('css-page')
    <style>
        .shareqrcode img {
            width: 65%;
            height: 65%;
        }
    </style>
@endpush
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('content')
    <div class="row">
        <div class="page-title mb-3">
            <div class="row justify-content-between align-items-center">
                <div class="d-flex ol-md-10 mb-3 mb-md-0" style="justify-content: space-between">
                    <h5 class="h3  mb-0">{{ __('Dashboard') }}</h5>
                     {{-- //business Display Start --}}
                     <ul class="list-unstyled d-none">
                        <li class="dropdown dash-h-item drp-language">
                            <a class="dash-head-link dropdown-toggle arrow-none me-0 cust-btn shadow-sm border border-success"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-original-title="{{ __('Select your bussiness') }}">
                                <i class="ti ti-credit-card"></i>
                                <span class="drp-text hide-mob">{{ __(ucfirst($currantBusiness)) }}</span>
                                <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                            </a>
                            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end page-inner-dropdowm">
                                @foreach ($businesses as $key => $business)
                                    <a href="{{ route('business.change', $key) }}" class="dropdown-item">
                                        <i
                                            class="@if ($bussiness_id == $key) ti ti-checks text-primary @elseif($currantBusiness == $business) ti ti-checks text-primary @endif "></i>
                                        <span>{{ ucfirst($business) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    </ul>
			<h5 class="h3  mb-0" style="font-size:11px">{{ __('Last Login:') }}  {{ \Carbon\Carbon::parse($users->last_login)->format('jS F Y | g:iA') }}</h5>
                    {{-- //business Display End --}}
                </div>

            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
			@if ($users->type == 'company')
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body" style="min-height: 230px;">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-users dash-micon"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2"></p>
                            <h6 class="mb-3">{{ __('Total Staff') }}</h6>
                            <h3 class="mb-0">{{ $total_staff }}</h3>
                        </div>
                    </div>
                </div>
				<div class="col-md-4">
                    <div class="card">
                        <div class="card-body" style="min-height: 230px;">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-briefcase dash-micon"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2"></p>
                            <h6 class="mb-3">{{ __('Total Business Cards') }}</h6>
                            <h3 class="mb-0">{{ $total_bussiness }} </h3>
                        </div>
                    </div>
                </div>
				@endif
                
                
				
					@if ($businessData)
					<div class="col-md-4">
						<div class="card">
							<div class="card-body" style="min-height: 230px;">
								<div class="theme-avtar bg-primary">
									<i class="ti ti-briefcase dash-micon"></i>
								</div>
								<p class="text-muted text-sm mt-4 mb-2"></p>
								<h6 class="mb-3">{{ __('Total Taps/Scans') }}</h6>
								<h3 class="mb-0">{{ $businessData->scans_taps }} </h3>
							</div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="card">
							<div class="card-body" style="min-height: 230px;">
								<div class="theme-avtar bg-primary">
									<i class="ti ti-briefcase dash-micon"></i>
								</div>
								<p class="text-muted text-sm mt-4 mb-2"></p>
								<h6 class="mb-3">{{ __('Total Leads Campaign') }}</h6>
								<h3 class="mb-0">{{ $total_leads_campaign }} </h3>
							</div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="card">
							<div class="card-body" style="min-height: 230px;">
								<div class="theme-avtar bg-primary">
									<i class="ti ti-briefcase dash-micon"></i>
								</div>
								<p class="text-muted text-sm mt-4 mb-2"></p>
								<h6 class="mb-3">{{ __('Total Leads') }}</h6>
								<h3 class="mb-0">{{ $total_leads }} </h3>
							</div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="card">
							<div class="card-body" style="min-height: 230px;">
								<div class="theme-avtar bg-primary">
									<i class="ti ti-briefcase dash-micon"></i>
								</div>
								<p class="text-muted text-sm mt-4 mb-2"></p>
								<h6 class="mb-3">{{ __('Total Contacts') }}</h6>
								<h3 class="mb-0">{{ $total_contacts }} </h3>
							</div>
						</div>
					</div>
					@endif
				
                
				
                
				<div class="col-md-4">
                    <div class="card">
                        <div class="card-body" style="min-height: 230px;">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-briefcase dash-micon"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2"></p>
                            <h6 class="mb-3">{{ __('Department') }}</h6>
						@if($user->type == 'company')
                            <h3 class="mb-0">Admin - M&CC</h3>
						@else
							<h3 class="mb-0">{{ $user->type}}</h3>
						@endif
                        </div>
                    </div>
                </div>
				
                

            </div>
        </div>
        <img src="{{ isset($qr_detail->image) ? $qr_path . '/' . $qr_detail->image : '' }}" id="image-buffers"
            style="display: none">
    @endsection
    @push('custom-scripts')
        <script src="{{ asset('custom/js/purpose.js') }}"></script>
        <script src="{{ asset('custom/js/jquery.qrcode.min.js') }}"></script>
        <script type="text/javascript">
            $(document).on("change", "select[name='select_card']", function() {
                var b_id = $("select[name='select_card']").val();
                if (b_id == '0') {
                    window.location.href = '{{ url('/dashboard') }}';
                } else {
                    window.location.href = '{{ url('business/analytics') }}/' + b_id;
                }

            });
        </script>
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
        <script>
            (function() {
                var options = {
                    chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: {!! json_encode($chartData['data']) !!},
                    xaxis: {
                        labels: {
                            format: "MMM",
                            style: {
                                colors: PurposeStyle.colors.gray[600],
                                fontSize: "14px",
                                fontFamily: PurposeStyle.fonts.base,
                                cssClass: "apexcharts-xaxis-label"
                            }
                        },
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !0,
                            borderType: "solid",
                            color: PurposeStyle.colors.gray[300],
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        },
                        type: "text",
                        categories: {!! json_encode($chartData['label']) !!}
                    },
                    yaxis: {
                        labels: {
                            style: {
                                color: PurposeStyle.colors.gray[600],
                                fontSize: "12px",
                                fontFamily: PurposeStyle.fonts.base
                            }
                        },
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !0,
                            borderType: "solid",
                            color: PurposeStyle.colors.gray[300],
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        }
                    },

                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY: -25,
                        offsetX: -5
                    },

                };
                var chart = new ApexCharts(document.querySelector("#apex-storedashborad"), options);
                chart.render();
            })();

            var options = {
                chart: {
                    height: 250,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: true,
                },
                series: {!! json_encode($devicearray['data']) !!},
                colors: ["#6fd943", '#ffa21d', '#FF3A6E', '#3ec9d6'],
                labels: {!! json_encode($devicearray['label']) !!},
                legend: {
                    show: true,
                    position: 'bottom',
                },
            };
            var chart = new ApexCharts(document.querySelector("#pie-storedashborad"), options);
            chart.render();

            var options = {
                chart: {
                    height: 250,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: true,
                },
                series: {!! json_encode($browserarray['data']) !!},
                colors: ["#6fd943", '#ffa21d', '#FF3A6E', '#3ec9d6'],
                labels: {!! json_encode($browserarray['label']) !!},
                legend: {
                    show: true,
                    position: 'bottom',
                },
            };
            var chart = new ApexCharts(document.querySelector("#pie-storebrowser"), options);
            chart.render();
        </script>
        <script>
            var WorkedHoursChart = (function() {
                var $chart = $('#user_platform-chart');

                function init($this) {
                    var options = {
                        chart: {
                            height: 250,
                            type: 'bar',
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false
                            },
                            shadow: {
                                enabled: false,
                            },

                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '10%',
                                borderRadius: 10,
                                dataLabels: {
                                    position: 'top',
                                },
                            }
                        },
                        stroke: {
                            show: true,
                            width: 1,
                            colors: ['#fff']
                        },
                        series: [{
                            name: 'Operating System',
                            data: {!! json_encode($platformarray['data']) !!},
                        }],
                        xaxis: {
                            labels: {
                                // format: 'MMM',
                                style: {
                                    colors: PurposeStyle.colors.gray[600],
                                    fontSize: '14px',
                                    fontFamily: PurposeStyle.fonts.base,
                                    cssClass: 'apexcharts-xaxis-label',
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: true,
                                borderType: 'solid',
                                color: PurposeStyle.colors.gray[300],
                                height: 6,
                                offsetX: 0,
                                offsetY: 0
                            },
                            title: {
                                text: '{{ __('Operating System') }}'
                            },
                            categories: {!! json_encode($platformarray['label']) !!},
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    color: PurposeStyle.colors.gray[600],
                                    fontSize: '12px',
                                    fontFamily: PurposeStyle.fonts.base,
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: true,
                                borderType: 'solid',
                                color: PurposeStyle.colors.gray[300],
                                height: 6,
                                offsetX: 0,
                                offsetY: 0
                            }
                        },
                        fill: {
                            type: 'solid',
                            opacity: 1

                        },
                        markers: {
                            size: 4,
                            opacity: 0.7,
                            strokeColor: "#fff",
                            strokeWidth: 3,
                            hover: {
                                size: 7,
                            }
                        },
                        grid: {
                            borderColor: PurposeStyle.colors.gray[300],
                            strokeDashArray: 5,
                        },
                        dataLabels: {
                            enabled: false
                        }
                    }
                    // Get data from data attributes
                    var dataset = $this.data().dataset,
                        labels = $this.data().labels,
                        color = $this.data().color,
                        height = $this.data().height,
                        type = $this.data().type;


                    options.chart.height = height ? height : 350;
                    // Init chart
                    var chart = new ApexCharts($this[0], options);
                    // Draw chart
                    setTimeout(function() {
                        chart.render();
                    }, 300);
                }

                // Events
                if ($chart.length) {
                    $chart.each(function() {
                        init($(this));
                    });
                }
            })();
        </script>
        <script>
            $(document).ready(function() {
                @if ($businessData)
                    var slug = '{{ $businessData->slug }}';
                    var url_link = `{{ url('/') }}/${slug}`;

                    $(`.qr-link`).text(url_link);
                    var foreground_color =
                        `{{ isset($qr_detail->foreground_color) ? $qr_detail->foreground_color : '#000000' }}`;
                    var background_color =
                        `{{ isset($qr_detail->background_color) ? $qr_detail->background_color : '#ffffff' }}`;
                    var radius = `{{ isset($qr_detail->radius) ? $qr_detail->radius : 26 }}`;
                    var qr_type = `{{ isset($qr_detail->qr_type) ? $qr_detail->qr_type : 0 }}`;
                    var qr_font = `{{ isset($qr_detail->qr_text) ? $qr_detail->qr_text : 'vCard' }}`;
                    var qr_font_color =
                        `{{ isset($qr_detail->qr_text_color) ? $qr_detail->qr_text_color : '#f50a0a' }}`;
                    var size = `{{ isset($qr_detail->size) ? $qr_detail->size : 9 }}`;

                    $('.shareqrcode').empty().qrcode({
                        render: 'image',
                        size: 500,
                        ecLevel: 'H',
                        minVersion: 3,
                        quiet: 1,
                        text: url_link,
                        fill: foreground_color,
                        background: background_color,
                        radius: .01 * parseInt(radius, 10),
                        mode: parseInt(qr_type, 10),
                        label: qr_font,
                        fontcolor: qr_font_color,
                        image: $("#image-buffers")[0],
                        mSize: .01 * parseInt(size, 10)
                    });
                @endif
            });
        </script>
        <script>
            var timezone = '{{ !empty(env('APP_TIMEZONE')) ? env('APP_TIMEZONE') : 'IST' }}';
            let today = new Date(new Date().toLocaleString("en-US", {
                timeZone: timezone
            }));
            var curHr = today.getHours()
            var target = document.getElementById("greetings");

            if (curHr < 12) {
                target.innerHTML = "Good Morning,";
            } else if (curHr < 17) {
                target.innerHTML = "Good Afternoon,";
            } else {
                target.innerHTML = "Good Evening,";
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                @if ($businessData)
                var customURL = {!! json_encode(url('/' . $businessData->slug)) !!};
                $('.Demo1').socialSharingPlugin({
                    url: customURL,
                    title: $('meta[property="og:title"]').attr('content'),
                    description: $('meta[property="og:description"]').attr('content'),
                    img: $('meta[property="og:image"]').attr('content'),
                    enable: ['whatsapp', 'facebook', 'twitter', 'pinterest', 'linkedin']
                });
    
                $('.socialShareButton').click(function (e) {
                    e.preventDefault();
                    $('.sharingButtonsContainer').toggle();
                });
            });
            @endif
         </script>
    @endpush
