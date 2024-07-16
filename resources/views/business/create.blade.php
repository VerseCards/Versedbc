@php
    $chatgpt_setting = App\Models\Utility::chatgpt_setting(\Auth::user()->creatorId());
@endphp

{{ Form::open(array('url' => route('business.store')))}}

    <div class="row">
        <div class="col-12">
            {{Form::label('Business',__('Card Name'),['class'=>'form-control-label'])}}
            {{Form::text('business_title',null,['class'=>'form-control mt-2', 'placeholder' => __('Enter Business Name')])}}
            @error('business_title')
                <span class="invalid-favicon text-xs text-danger" role="alert">{{ $message }}</span>
            @enderror
        </div>  
        <div class="horizontal mt-3">
            <div class="verticals twelve">
                <div class="form-group col-md-6">
                    {{ Form::label('Select Themes', __('Select Themes & Colour'), ['class' => 'form-control-label']) }}
                </div>
                <div class="uploaded-pics gy-3 row">
                    {{ Form::hidden('theme', null, ['id' => 'themefile1']) }}
                    @foreach (\App\Models\Utility::themeOne() as $key => $v)
                        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-5 theme-view-card">
                            <div class="theme-view-inner">
                                <div class="theme-view-img ">

                                    <img class="color_theme1 {{ $key }}_img" data-id="{{ $key }}"
                                        src="{{ asset(Storage::url('uploads/card_theme/' . $key . '/color1.png')) }}"
                                        alt="">
                                </div>
                                <div class=" mt-3">
                                    <h6>{{ __('Modern Theme') }}</h6>
                                    <span class="mb-1">{{ __('Select Sub-Color:') }}</span>
                                    <div class="d-flex align-items-center" id="{{ $key }}">
                                        @foreach ($v as $css => $val)
                                            <label class="colorinput">
                                                <input name="theme_color" id="{{ $css }}" type="radio"
                                                    value="{{ $css }}" data-theme="{{ $key }}"
                                                    data-imgpath="{{ $val['img_path'] }}" class="colorinput-input"
                                                    {{ isset($business->theme_color) && $business->theme_color == $css ? 'checked' : '' }}>
                                                <span class="border-box">
                                                    <span class="colorinput-color"
                                                        style="background:{{ $val['color'] }}"></span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
    </div>

    <script>
        $(document).on('click', 'input[name="theme_color"]', function() {
          var eleParent = $(this).attr('data-theme');
            $('#themefile1').val(eleParent);
            var imgpath = $(this).attr('data-imgpath');
            $('.' + eleParent + '_img').attr('src', imgpath);
      
            $('.theme_preview_img').attr('src', imgpath);
            $(this).closest('.theme-view-card').addClass('selected-theme');
       });
      
        $(document).on("click",".color_theme1",function() {
            var id = $(this).attr('data-id');
            $(".theme-view-card").removeClass('selected-theme')
            $(this).closest('.theme-view-card').addClass('selected-theme');
            
            var dataId = $(this).attr("data-id");
            $('#color1-' + dataId).trigger('click');
            // $(".theme-view-card").addClass('')
        });
      
        $(document).ready(function() {
            var checked = $("input[type=radio][name='theme_color']:checked");
            $('#themefile1').val(checked.attr('data-theme'));
            $(checked).closest('.theme-view-card').addClass('selected-theme');
        });
      
      </script>
  