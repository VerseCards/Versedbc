<?php
    $social_no = 1;
    $appointment_no = 0;
    $service_row_no = 0;
    $testimonials_row_no = 0;
    $gallery_row_no = 0;
    
    $no = 1;
    $stringid = $business->id;
    $is_enable = false;
    $is_contact_enable = false;
    $is_enable_appoinment = false;
	$is_enable_leadgeneration = false;
    $is_enable_service = false;
    $is_enable_testimonials = false;
    $is_enable_sociallinks = false;
    $is_custom_html_enable = false;
    $is_enable_gallery = false;
    $custom_html = $business->custom_html_text;
    $is_branding_enabled = false;
    $branding = $business->branding_text;
    $is_gdpr_enabled = false;
    $gdpr_text = $business->gdpr_text;
    $card_theme = json_decode($business->card_theme);
    
    $banner = \App\Models\Utility::get_file('card_banner');
    $logo = \App\Models\Utility::get_file('card_logo');
    $image = \App\Models\Utility::get_file('testimonials_images');
    $s_image = \App\Models\Utility::get_file('service_images');
    
    $company_favicon = Utility::getsettingsbyid($business->created_by);
    $company_favicon = $company_favicon['company_favicon'];
    $logo1 = \App\Models\Utility::get_file('uploads/logo/');
    
    $meta_image = \App\Models\Utility::get_file('meta_image');
    $gallery_path = \App\Models\Utility::get_file('gallery');
    $qr_path = \App\Models\Utility::get_file('qrcode');
    
    if (!is_null($contactinfo) && !is_null($contactinfo)) {
        $contactinfo['is_enabled'] == '1' ? ($is_contact_enable = true) : ($is_contact_enable = false);
    }
    
    if (!is_null($business_hours) && !is_null($businesshours)) {
        $businesshours['is_enabled'] == '1' ? ($is_enable = true) : ($is_enable = false);
    }
    
    if (!is_null($appoinment_hours) && !is_null($appoinment)) {
        $appoinment['is_enabled'] == '1' ? ($is_enable_appoinment = true) : ($is_enable_appoinment = false);
    }
    
    if (!is_null($services_content) && !is_null($services)) {
        $services['is_enabled'] == '1' ? ($is_enable_service = true) : ($is_enable_service = false);
    }
    
    if (!is_null($testimonials_content) && !is_null($testimonials)) {
        $testimonials['is_enabled'] == '1' ? ($is_enable_testimonials = true) : ($is_enable_testimonials = false);
    }
    
    if (!is_null($social_content) && !is_null($sociallinks)) {
        $sociallinks['is_enabled'] == '1' ? ($is_enable_sociallinks = true) : ($is_enable_sociallinks = false);
    }
    
    if (!is_null($gallery_contents) && !is_null($gallery)) {
        $gallery['is_enabled'] == '1' ? ($is_enable_gallery = true) : ($is_enable_gallery = false);
    }
    
    if (!is_null($custom_html) && !is_null($customhtml)) {
        $customhtml->is_custom_html_enabled == '1' ? ($is_custom_html_enable = true) : ($is_custom_html_enable = false);
    }
    
    if (!is_null($business->is_branding_enabled) && !is_null($business->is_branding_enabled)) {
        !empty($business->is_branding_enabled) && $business->is_branding_enabled == 'on' ? ($is_branding_enabled = true) : ($is_branding_enabled = false);
    } else {
        $is_branding_enabled = false;
    }
    if (!is_null($business->is_gdpr_enabled) && !is_null($business->is_gdpr_enabled)) {
        !empty($business->is_gdpr_enabled) && $business->is_gdpr_enabled == 'on' ? ($is_gdpr_enabled = true) : ($is_gdpr_enabled = false);
    }
    
    $color = substr($business->theme_color, 0, 6);
    
    $SITE_RTL = Cookie::get('SITE_RTL');
    if ($SITE_RTL == '') {
        $SITE_RTL = 'off';
    }
    $SITE_RTL = Utility::settings()['SITE_RTL'];
    
    $url_link = env('APP_URL') . '/' . $business->slug;
    $meta_tag_image = $meta_image . '/' . $business->meta_image;
    
    // Cookie
    $cookie_data = App\Models\Business::card_cookie($business->slug);
    $a = $cookie_data;
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo e($SITE_RTL == 'on' ? 'rtl' : ''); ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="<?php echo e($business->title); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="HandheldFriendly" content="True">

    <title><?php echo e($business->title); ?></title>
    <meta name="author" content="<?php echo e($business->title); ?>">
    <meta name="keywords" content="<?php echo e($business->meta_keyword); ?>">
    <meta name="description" content="<?php echo e($business->meta_description); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e($url_link); ?>">
    <meta property="og:title" content="<?php echo e($business->title); ?>">
    <meta property="og:description" content="<?php echo e($business->meta_description); ?>">
    <meta property="og:image"
        content="<?php echo e(!empty($business->meta_image) ? $meta_tag_image : asset('custom/img/placeholder-image.jpg')); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e($url_link); ?>">
    <meta property="twitter:title" content="<?php echo e($business->title); ?>">
    <meta property="twitter:description" content="<?php echo e($business->meta_description); ?>">
    <meta property="twitter:image"
        content="<?php echo e(!empty($business->meta_image) ? $meta_tag_image : asset('custom/img/placeholder-image.jpg')); ?>">

    

    <link rel="icon"
        href="<?php echo e($logo1 . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')); ?>"
        type="image" sizes="16x16">
    <link rel="stylesheet" href="<?php echo e(asset('custom/theme5/libs/@fortawesome/fontawesome-free/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/theme5/fonts/stylesheet.css')); ?>">
    <?php if($SITE_RTL == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('custom/theme5/css/rtl-main-style.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('custom/theme5/css/rtl-responsive.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('custom/theme5/css/main-style.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('custom/theme5/css/responsive.css')); ?>">
    <?php endif; ?>
    <?php if(isset($is_slug)): ?>
        <link rel='stylesheet' href='<?php echo e(asset('css/cookieconsent.css')); ?>' media="screen" />
        <style type="text/css">
            <?php echo e($business->customcss); ?>

        </style>
    <?php endif; ?>
    <?php if($business->google_fonts != 'Default' && isset($business->google_fonts)): ?>
        <style>
            @import url('<?php echo e(\App\Models\Utility::getvalueoffont($business->google_fonts)['link']); ?>');

            :root {
                --Strawford: '<?php echo e(strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',')); ?>', <?php echo e(substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1)); ?>;
            }
        </style>
    <?php endif; ?>
    
    <meta name="mobile-wep-app-capable" content="yes">
    <meta name="apple-mobile-wep-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <link rel="apple-touch-icon"
        href="<?php echo e(asset(Storage::url('uploads/logo/') . (!empty($setting->value) ? $setting->value : 'favicon.png'))); ?>" />
    <?php if($business->enable_pwa_business == 'on'): ?>
        <link rel="manifest"
            href="<?php echo e(asset('storage/uploads/theme_app/business_' . $business->id . '/manifest.json')); ?>" />
    <?php endif; ?>
    <?php if(!empty($business->pwa_business($business->slug)->theme_color)): ?>
        <meta name="theme-color" content="<?php echo e($business->pwa_business($business->slug)->theme_color); ?>" />
    <?php endif; ?>
    <?php if(!empty($business->pwa_business($business->slug)->background_color)): ?>
        <meta name="apple-mobile-web-app-status-bar"
            content="<?php echo e($business->pwa_business($business->slug)->background_color); ?>" />
    <?php endif; ?>
    <?php $__currentLoopData = $pixelScript; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?= $script ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</head>

<body class="tech-card-body">
    <div class="<?php echo e(\App\Models\Utility::themeOne()['theme5'][$business->theme_color]['theme_name']); ?>"
        id="view_theme15">
        <main id="boxes">
            <div class="card-wrapper">
                <div class="bussiness-card">
                    <div class="bussiness-card-body">
                        <section class="profile-section">
                            <div class="profile-cover">
                                <img src="<?php echo e(isset($business->banner) && !empty($business->banner) ? $banner . '/' . $business->banner : asset('custom/img/placeholder-image.jpg')); ?>"
                                    id="banner_preview" alt="fs">
                            </div>
                            <div class="profile-content">
                                <div class="user-profile">
                                    <div class="user-name">
                                        <h2 class="text-white" id="<?php echo e($stringid . '_title'); ?>_preview">
                                            <?php echo e($business->title); ?></h2>
                                        <p id="<?php echo e($stringid . '_designation'); ?>_preview"><b>
                                                <?php echo e($business->designation); ?></b></p>
                                        <span id="<?php echo e($stringid . '_subtitle'); ?>_preview"
                                            class="subtitle"><?php echo e($business->sub_title); ?></span>
                                    </div>
                                    <div class="user-avatar">
                                        <img id="business_logo_preview"
                                            src="<?php echo e(isset($business->logo) && !empty($business->logo) ? $logo . '/' . $business->logo : asset('custom/img/logo-placeholder-image-2.png')); ?>"
                                            alt="">
                                    </div>

                                </div>
                                <div class="text-left desc-wrapper">
                                    <p class="text-white" id="<?php echo e($stringid . '_desc'); ?>_preview">
                                        <?php echo e($business->description); ?>

                                    </p>
                                </div>
                            </div>
                        </section>
                        <?php $j = 1; ?>
                        <?php $__currentLoopData = $card_theme->order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order_key => $order_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($j == $order_value): ?>
                                <?php if($order_key == 'social'): ?>
                                    <section class="social" id="social-div">
                                        <ul class="social-list" id="inputrow_socials_preview">
                                            <?php if(!is_null($social_content) && !is_null($sociallinks)): ?>
                                                <?php $__currentLoopData = $social_content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social_key => $social_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $social_val; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social_key1 => $social_val1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($social_key1 != 'id'): ?>
                                                            <li id="socials_<?php echo e($loop->parent->index + 1); ?>">
                                                                <?php if($social_key1 == 'Whatsapp'): ?>
                                                                    <?php if((new \Jenssegers\Agent\Agent())->isDesktop()): ?>
                                                                        <?php
                                                                            $social_links = url('https://web.whatsapp.com/send?phone=' . $social_val1);
                                                                        ?>
                                                                    <?php else: ?>
                                                                        <?php
                                                                            $social_links = url('https://wa.me/' . $social_val1);
                                                                        ?>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <?php
                                                                        $social_links = url($social_val1);
                                                                    ?>
                                                                <?php endif; ?>
                                                                <a href="<?php echo e($social_links); ?>" target="_blank"
                                                                    id="<?php echo e('social_link_' . $social_no . '_href_preview'); ?>">
                                                                    <img src="<?php echo e(asset('custom/theme5/icon/social/' . strtolower($social_key1) . '.svg')); ?>"
                                                                        alt="social" class="img-fluid">
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php
                                                            $social_no++;
                                                        ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                    </section>
                                <?php endif; ?>
                                <?php if($order_key == 'service'): ?>
                                    <section class="service-section" id="services-div">
                                        <div class="section-title text-center">
                                            <h2><?php echo e(__('Services')); ?></h2>
                                        </div>
                                        <div class="row row-gap" id="inputrow_service_preview">
                                            <?php $image_count = 0; ?>
                                            <?php $__currentLoopData = $services_content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k1 => $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-sm-6 col-12 service-card"
                                                    id="services_<?php echo e($service_row_no); ?>">
                                                    <div class="service-card-inner">
                                                        <div class="service-icon">
                                                            <img id="<?php echo e('s_image' . $image_count . '_preview'); ?>"
                                                                src="<?php echo e(isset($content->image) && !empty($content->image) ? $s_image . '/' . $content->image : asset('custom/img/logo-placeholder-image-21.png')); ?>"class="img-fluid"
                                                                alt="image">
                                                        </div>
                                                        <h5 id="<?php echo e('title_' . $service_row_no . '_preview'); ?>">
                                                            <?php echo e($content->title); ?></h5>
                                                        <p id="<?php echo e('description_' . $service_row_no . '_preview'); ?>">
                                                            <?php echo e($content->description); ?>

                                                        </p>
                                                        <?php if(!empty($content->purchase_link)): ?>
                                                            <a href="<?php echo e(url($content->purchase_link)); ?>"
                                                                class="btn"
                                                                id="<?php echo e('link_title_' . $service_row_no . '_preview'); ?>"><?php echo e($content->link_title); ?>

                                                                <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                    height="22" viewBox="0 0 21 22"
                                                                    fill="none">
                                                                    <path opacity="0.4"
                                                                        d="M10.5 19.5731C15.1833 19.5731 18.9799 15.7765 18.9799 11.0932C18.9799 6.40986 15.1833 2.61328 10.5 2.61328C5.81672 2.61328 2.02014 6.40986 2.02014 11.0932C2.02014 15.7765 5.81672 19.5731 10.5 19.5731Z"
                                                                        fill="white"></path>
                                                                    <path
                                                                        d="M14.4787 10.8497C14.4464 10.7717 14.3999 10.7014 14.3414 10.6429L11.7974 8.09894C11.549 7.85048 11.1462 7.85048 10.8977 8.09894C10.6492 8.3474 10.6492 8.75023 10.8977 8.99869L12.3562 10.4572H7.10804C6.75697 10.4572 6.47205 10.7421 6.47205 11.0932C6.47205 11.4443 6.75697 11.7292 7.10804 11.7292H12.3562L10.8977 13.1877C10.6492 13.4362 10.6492 13.839 10.8977 14.0875C11.0215 14.2113 11.1843 14.274 11.3472 14.274C11.51 14.274 11.6728 14.2121 11.7966 14.0875L14.3406 11.5435C14.3991 11.485 14.4456 11.4147 14.4778 11.3367C14.5431 11.1806 14.5431 11.0058 14.4787 10.8497Z"
                                                                        fill="white"></path>
                                                                </svg>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php
                                                    $image_count++;
                                                    $service_row_no++;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>


                                    </section>
                                <?php endif; ?>
                                <?php if($order_key == 'bussiness_hour'): ?>
                                    <section class="bussiness-hour" id="business-hours-div">
                                        <div class="section-title">
                                            <h2><?php echo e(__('Business Hours')); ?></h2>
                                        </div>
                                        <ul class="hours-list text-center">
                                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><b><?php echo e(__($day)); ?>:</b>
                                                    <span class="days_<?php echo e($k); ?>">
                                                        <?php if(isset($business_hours->$k) && $business_hours->$k->days == 'on'): ?>
                                                            <span
                                                                class="days_<?php echo e($k); ?>_start"><?php echo e(!empty($business_hours->$k->start_time) && isset($business_hours->$k->start_time) ? date('h:i A', strtotime($business_hours->$k->start_time)) : '00:00'); ?></span>
                                                            - <span
                                                                class="days_<?php echo e($k); ?>_end"><?php echo e(!empty($business_hours->$k->end_time) && isset($business_hours->$k->end_time) ? date('h:i A', strtotime($business_hours->$k->end_time)) : '00:00'); ?></span>
                                                        <?php else: ?>
                                                            <?php echo e(__('Closed')); ?>

                                                        <?php endif; ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </section>
                                <?php endif; ?>
                                <?php if($order_key == 'gallery'): ?>
                                    <section class="gallery-section" id="gallery-div">
                                        <div class="section-title text-center">
                                            <h2><?php echo e(__('Gallery')); ?></h2>
                                        </div>
                                        <div id="inputrow_gallery_preview">
                                            <?php $image_count = 0; ?>
                                            <?php if(isset($is_pdf)): ?>
                                                <div class="gallery-cards">
                                                    <div class="row">
                                                        <?php if(!is_null($gallery_contents) && !is_null($gallery)): ?>
                                                            <?php $__currentLoopData = $gallery_contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gallery_content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(isset($gallery_content->type)): ?>
                                                                    <?php if($gallery_content->type == 'video'): ?>
                                                                    <?php elseif($gallery_content->type == 'image'): ?>
                                                                        <div class="gallery-itm col-12">
                                                                            <div class="gallery-media">
                                                                                <a href="javascript:;" id="imagepopup"
                                                                                    tabindex="0" class="imagepopup">
                                                                                    <img src="<?php echo e(isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png')); ?>"
                                                                                        alt="images"
                                                                                        class="imageresource">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php
                                                                    $image_count++;
                                                                    $gallery_row_no++;
                                                                ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </div>

                                                </div>
                                            <?php else: ?>
                                                <div class="gallery-slider">
                                                    <?php if(!is_null($gallery_contents) && !is_null($gallery)): ?>
                                                        <?php $__currentLoopData = $gallery_contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gallery_content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="gallery-itm"
                                                                id="gallery_<?php echo e($gallery_row_no); ?>">
                                                                <div class="gallery-media">
                                                                    <?php if(isset($gallery_content->type)): ?>
                                                                        <?php if($gallery_content->type == 'video'): ?>
                                                                            <a href="javascript:;" tabindex="0"
                                                                                class="videopop play-btn">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="17" height="18"
                                                                                    viewBox="0 0 17 18"
                                                                                    fill="none">
                                                                                    <path
                                                                                        d="M14.8066 6.89104L5.00568 0.893935C3.05552 -0.298924 0.546997 1.09959 0.546997 3.38244V15.0443C0.546997 17.3271 3.05552 18.7256 5.00568 17.5328L14.8066 11.5357C16.5445 10.472 16.5445 7.95476 14.8066 6.89104Z"
                                                                                        fill="#242424" />
                                                                                </svg>
                                                                                <video loop  controls="true">
                                                                                    <source class="videoresource"
                                                                                        src="<?php echo e(isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png')); ?>"
                                                                                        type="video/mp4">
                                                                                </video>
                                                                            </a>
                                                                        <?php elseif($gallery_content->type == 'image'): ?>
                                                                            <a href="javascript:;" tabindex="0"
                                                                                class="imagepopup">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="17" height="18"
                                                                                    viewBox="0 0 17 18"
                                                                                    fill="none">
                                                                                    <path
                                                                                        d="M14.8066 6.89104L5.00568 0.893935C3.05552 -0.298924 0.546997 1.09959 0.546997 3.38244V15.0443C0.546997 17.3271 3.05552 18.7256 5.00568 17.5328L14.8066 11.5357C16.5445 10.472 16.5445 7.95476 14.8066 6.89104Z"
                                                                                        fill="#242424" />
                                                                                </svg>
                                                                                <img src="<?php echo e(isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png')); ?>"
                                                                                    alt="images"
                                                                                    class="imageresource">
                                                                            </a>
                                                                        <?php elseif($gallery_content->type == 'custom_video_link'): ?>
                                                                            <?php if(str_contains($gallery_content->value, 'youtube') || str_contains($gallery_content->value, 'youtu.be')): ?>
                                                                                <?php
                                                                                    if (strpos($gallery_content->value, 'src') !== false) {
                                                                                        preg_match('/src="([^"]+)"/', $gallery_content->value, $match);
                                                                                        $url = $match[1];
                                                                                        $video_url = str_replace('https://www.youtube.com/embed/', '', $url);
                                                                                    } elseif (strpos($gallery_content->value, 'src') == false && strpos($gallery_content->value, 'embed') !== false) {
                                                                                        $video_url = str_replace('https://www.youtube.com/embed/', '', $gallery_content->value);
                                                                                    } else {
                                                                                        $video_url = str_replace('https://youtu.be/', '', str_replace('https://www.youtube.com/watch?v=', '', $gallery_content->value));
                                                                                        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $gallery_content->value, $matches);
                                                                                        if (count($matches) > 0) {
                                                                                            $videoId = $matches[1];
                                                                                            $video_url = strtok($videoId, '&');
                                                                                        }
                                                                                    }
                                                                                ?>


                                                                                <a href="javascript:;" id=""
                                                                                    tabindex="0"
                                                                                    class="videopop1 play-btn">
                                                                                    <video loop controls="true"
                                                                                        poster="<?php echo e(asset('custom/img/video_youtube.jpg')); ?>">
                                                                                        <source class="videoresource1"
                                                                                            src="<?php echo e(isset($gallery_content->value) && !empty($gallery_content->value) ? 'https://www.youtube.com/embed/' . $video_url : asset('custom/img/logo-placeholder-image-2.png')); ?>"
                                                                                            type="video/mp4">
                                                                                    </video>
                                                                                </a>
                                                                            <?php else: ?>
                                                                                <a href="javascript:;" id=""
                                                                                    tabindex="0"
                                                                                    class="videopop1 play-btn">
                                                                                    <video loop controls="true"
                                                                                        poster="<?php echo e(asset('custom/img/video_youtube.jpg')); ?>">
                                                                                        <source class="videoresource1"
                                                                                            src="<?php echo e(isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png')); ?>"
                                                                                            type="video/mp4">
                                                                                    </video>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        <?php elseif($gallery_content->type == 'custom_image_link'): ?>
                                                                            <a href="javascript:;" tabindex="0"
                                                                                class="imagepopup1">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="17" height="18"
                                                                                    viewBox="0 0 17 18"
                                                                                    fill="none">
                                                                                    <path
                                                                                        d="M14.8066 6.89104L5.00568 0.893935C3.05552 -0.298924 0.546997 1.09959 0.546997 3.38244V15.0443C0.546997 17.3271 3.05552 18.7256 5.00568 17.5328L14.8066 11.5357C16.5445 10.472 16.5445 7.95476 14.8066 6.89104Z"
                                                                                        fill="#242424" />
                                                                                </svg>
                                                                                <img class="imageresource1"
                                                                                    src="<?php echo e(isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png')); ?>"
                                                                                    alt="images" id="upload_image">
                                                                            </a>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                        </div>

                                    </section>
                                <?php endif; ?>
                                <?php if($order_key == 'appointment'): ?>
                                    <section class="make-appointment" id="appointment-div">
                                        <div class="section-title text-center">
                                            <h2 class="text-white"><?php echo e(__('Make')); ?> <br>
                                                <?php echo e(__('an appointment')); ?></h2>
                                        </div>
                                        <div class="appointment-form">
                                            <div class="form-group">
                                                <label><?php echo e(__('Date:')); ?></label>
                                                <input type="text" name="date" class="datepicker_min"
                                                    placeholder="<?php echo e(__('Pick a Date')); ?>">
                                                <span class="text-white text-center h6 span-error-date"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="primary-text"><?php echo e(__('Hour:')); ?></label>
                                                <div class="cust-checkbox">
                                                    <div class="row row-gap" id="inputrow_appointment_preview">
                                                        <?php $radiocount = 1; ?>
                                                        <?php if(!is_null($appoinment_hours)): ?>
                                                            <?php $__currentLoopData = $appoinment_hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="col-sm-6 col-12"
                                                                    id="<?php echo e('appointment_' . $appointment_no); ?>">
                                                                    <div class="form-check">
                                                                        <input type="radio" class="app_time"
                                                                            id="radio-<?php echo e($radiocount); ?>"
                                                                            data-id="<?php if(!empty($hour->start)): ?> <?php echo e($hour->start); ?> <?php else: ?> 00:00 <?php endif; ?>-<?php if(!empty($hour->end)): ?> <?php echo e($hour->end); ?> <?php else: ?> 00:00 <?php endif; ?>"
                                                                            name="time">
                                                                        <label for="radio-<?php echo e($radiocount); ?>"><span
                                                                                id="appoinment_start_<?php echo e($appointment_no); ?>_preview">
                                                                                <?php if(!empty($hour->start)): ?>
                                                                                    <?php echo e($hour->start); ?>

                                                                                <?php else: ?>
                                                                                    00:00
                                                                                <?php endif; ?>
                                                                            </span> - <span
                                                                                id="appoinment_end_<?php echo e($appointment_no); ?>_preview">
                                                                                <?php if(!empty($hour->end)): ?>
                                                                                    <?php echo e($hour->end); ?>

                                                                                <?php else: ?>
                                                                                    00:00
                                                                                <?php endif; ?>
                                                                            </span></label>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    $radiocount++;
                                                                    $appointment_no++;
                                                                ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <span class="text-white text-center h6 span-error-time"></span>
                                            </div>
                                            <div class="text-center">
                                                <button
                                                    class="btn hover-secondary appointment-modal-toggle"><?php echo e(__('Make an appointment')); ?>

                                                </button>
                                            </div>
                                        </div>
                                    </section>
                                <?php endif; ?>
                                <?php if($order_key == 'testimonials'): ?>
                                    <section class="testimonial-section text-center" id="testimonials-div">
                                        <div class="section-title">
                                            <h2><?php echo e(__('Testimonials')); ?></h2>
                                        </div>
                                        <?php if(isset($is_pdf)): ?>
                                            <div class="row gap-bottom" id="inputrow_testimonials_preview">
                                                <?php
                                                    $t_image_count = 0;
                                                    $rating = 0;
                                                ?>
                                                <?php $__currentLoopData = $testimonials_content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k2 => $testi_content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="testimonial-card col-sm-6"
                                                        id="testimonials_<?php echo e($testimonials_row_no); ?>">
                                                        <div class="testimonial-card-inner">
                                                            <div class="user-pro">
                                                                <div class="user-avatar">
                                                                    <img id="<?php echo e('t_image' . $t_image_count . '_preview'); ?>"
                                                                        src="<?php echo e(isset($testi_content->image) && !empty($testi_content->image) ? $image . '/' . $testi_content->image : asset('custom/img/placeholder-image12.jpg')); ?>"
                                                                        alt="image">
                                                                </div>
                                                                <span
                                                                    class="total-rat"><?php echo e($testi_content->rating); ?>/5</span>
                                                                <?php
                                                                    if (!empty($testi_content->rating)) {
                                                                        $rating = (int) $testi_content->rating;
                                                                        $overallrating = $rating;
                                                                    } else {
                                                                        $overallrating = 0;
                                                                    }
                                                                ?>
                                                                <br>
                                                                <span id="<?php echo e('stars' . $testimonials_row_no); ?>_star"
                                                                    class="stars">
                                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                                        <?php if($overallrating < $i): ?>
                                                                            <?php if(is_float($overallrating) && round($overallrating) == $i): ?>
                                                                                <i
                                                                                    class="star-color fas fa-star-half-alt"></i>
                                                                            <?php else: ?>
                                                                                <i class="fa fa-star"></i>
                                                                            <?php endif; ?>
                                                                        <?php else: ?>
                                                                            <i class="star-color fas fa-star"></i>
                                                                        <?php endif; ?>
                                                                    <?php endfor; ?>
                                                                </span>

                                                            </div>
                                                            <p
                                                                id="<?php echo e('testimonial_description_' . $testimonials_row_no . '_preview'); ?>">
                                                                <?php echo e($testi_content->description); ?>

                                                            </p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        $t_image_count++;
                                                        $testimonials_row_no++;
                                                    ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="testimonial-slider" id="inputrow_testimonials_preview">
                                                <?php
                                                    $t_image_count = 0;
                                                    $rating = 0;
                                                ?>
                                                <?php $__currentLoopData = $testimonials_content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k2 => $testi_content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="testimonial-card"
                                                        id="testimonials_<?php echo e($testimonials_row_no); ?>">
                                                        <div class="testimonial-card-inner">
                                                            <div class="user-pro">
                                                                <div class="user-avatar">
                                                                    <img id="<?php echo e('t_image' . $t_image_count . '_preview'); ?>"
                                                                        src="<?php echo e(isset($testi_content->image) && !empty($testi_content->image) ? $image . '/' . $testi_content->image : asset('custom/img/placeholder-image12.jpg')); ?>"
                                                                        alt="image">
                                                                </div>
                                                                <span
                                                                    class="total-rat"><?php echo e($testi_content->rating); ?>/5</span>
                                                                <?php
                                                                    if (!empty($testi_content->rating)) {
                                                                        $rating = (int) $testi_content->rating;
                                                                        $overallrating = $rating;
                                                                    } else {
                                                                        $overallrating = 0;
                                                                    }
                                                                ?>
                                                                <br>
                                                                <span id="<?php echo e('stars' . $testimonials_row_no); ?>_star"
                                                                    class="stars">
                                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                                        <?php if($overallrating < $i): ?>
                                                                            <?php if(is_float($overallrating) && round($overallrating) == $i): ?>
                                                                                <i
                                                                                    class="star-color fas fa-star-half-alt"></i>
                                                                            <?php else: ?>
                                                                                <i class="fa fa-star"></i>
                                                                            <?php endif; ?>
                                                                        <?php else: ?>
                                                                            <i class="star-color fas fa-star"></i>
                                                                        <?php endif; ?>
                                                                    <?php endfor; ?>
                                                                </span>

                                                            </div>
                                                            <p
                                                                id="<?php echo e('testimonial_description_' . $testimonials_row_no . '_preview'); ?>">
                                                                <?php echo e($testi_content->description); ?>

                                                            </p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        $t_image_count++;
                                                        $testimonials_row_no++;
                                                    ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </section>
                                <?php endif; ?>
                                <?php if($order_key == 'contact_info'): ?>
                                    <section class="contact-section" id="contact-div" >
                                        <h2></h2>
                                        <ul id="inputrow_contact_preview">
                                            <?php if(!is_null($contactinfo_content) && !is_null($contactinfo)): ?>
                                                <?php $__currentLoopData = $contactinfo_content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $val; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $val1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($key1 == 'Phone'): ?>
                                                            <?php $href = 'tel:'.$val1; ?>
                                                        <?php elseif($key1 == 'Email'): ?>
                                                            <?php $href = 'mailto:'.$val1; ?>
                                                        <?php elseif($key1 == 'Address'): ?>
                                                            <?php $href = ''; ?>
                                                        <?php else: ?>
                                                            <?php $href = $val1 ?>
                                                        <?php endif; ?>
                                                        <?php if($key1 != 'id'): ?>
                                                            <li id="contact_<?php echo e($loop->parent->index + 1); ?>" style="border: 1px solid #a79483;border-radius: 25px;padding: 10px;margin-top:10px">
                                                                <?php if($key1 == 'Address'): ?>
                                                                    <?php $__currentLoopData = $val1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $val2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($key2 == 'Address_url'): ?>
                                                                            <?php $href = $val2; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <a href="<?php echo e($href); ?>">
                                                                        <?php $__currentLoopData = $val1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $val2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if($key2 == 'Address'): ?>
                                                                                <span
                                                                                    id="<?php echo e($key1 . '_' . $no); ?>_preview">
                                                                                    <?php echo e($val2); ?>

                                                                                </span>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <?php if($key1 == 'Whatsapp'): ?>
                                                                        <a href="<?php echo e(url('https://wa.me/' . $href)); ?>"
                                                                            target="_blank">
                                                                        <?php else: ?>
                                                                            <a href="<?php echo e($href); ?>">
                                                                    <?php endif; ?>
                                                                    <span id="<?php echo e($key1 . '_' . $no); ?>_preview">
                                                                        <?php echo e($val1); ?></span>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php
                                                            $no++;
                                                        ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												
												<li class="d-flex align-items-center"
                                                                   style="width: 100%;border: 1px solid #d8d8d8;border-radius: 20px;padding: 10px 60px; margin-top: 20px;box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;justify-content: center;">
																<a href="javascript:void(0)"class="make-contact-modal-toggle">

                                                                            <div class="contact-svg" style="left: 100px;padding-left: 3px;margin-left: -35px;">
                                                                                <img src="<?php echo e(asset('custom/theme12/icon/' . $color . '/phone.svg')); ?>"
                                                                                    class="img-fluid">
                                                                            </div>

                                                                           
                                                                                    <span
                                                                                       style="margin-left: 50px">
                                                                                        Connect With Me
                                                                                    </span>
                                                                               
                                                                        </a>
																</li>
																<li class="d-flex align-items-center"
                                                                   style="width: 100%;border: 1px solid #d8d8d8;border-radius: 20px;padding: 5px 80px; margin-top: 20px;box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;justify-content: center;">
																	<a href="javascript:void(0)"class="share-modal-toggle">

                                                                            <div class="contact-svg" style="left: 100px;padding-left: 3px;margin-left: -50px;">
                                                                                <img src="<?php echo e(asset('custom/theme12/icon/' . $color . '/signout.svg')); ?>"
                                                                                    class="img-fluid">
                                                                            </div>

                                                                           
                                                                                    <span
                                                                                       style="margin-left: 50px">
                                                                                        View QR Code
                                                                                    </span>
                                                                               
                                                                        </a>
																</li>
                                            <?php endif; ?>
											
                                        </ul>
                                    </section>
                                <?php endif; ?>
                                <?php if($order_key == 'more'): ?>
                                    <section class="more-info" style="padding: 15px; padding-bottom:75px">
                                        
                                        <ul class="btn-list">
                                            
											<?php $__currentLoopData = $leadGeneration_content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leadgen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
											
											<a href="javascript:;" class="btn mt-10 make-contact-modal-toggle<?php echo e($leadgen->id); ?>" tabindex="0" style="margin-top: 12px">
												
												<?php echo e(__($leadgen->btitle)); ?>

											</a>
										
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            
                                        </ul>
                                    </section>
                                <?php endif; ?>
                                <?php if($order_key == 'custom_html'): ?>
                                    <section class="card-footer custom_html_text">
                                        <div class="greetings-desk">
                                            <div class="user-text-avatar text-white"
                                                id="<?php echo e($stringid . '_chtml'); ?>_preview">
                                                <?php echo stripslashes($custom_html); ?>

                                            </div>
                                        </div>

                                    </section>
                                <?php endif; ?>
                                <?php $j = $j + 1; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if($is_branding_enabled): ?>
                            <div class="copy-right is_branding_enable" id="is_branding_enabled">
                                <p id="<?php echo e($stringid . '_branding'); ?>_preview"><?php echo e($business->branding_text); ?></p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <img src="<?php echo e(isset($qr_detail->image) ? $qr_path . '/' . $qr_detail->image : ''); ?>" id="image-buffers"
                style="display: none">
        </main>

        <div id="previewImage"> </div>
        <a id="download" href="#" class="font-lg download mr-3 text-white">
            <i class="fas fa-download"></i>
        </a>

        <!-- Share card popup -->
        <div class="theme-modal share-card">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close share-modal-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title"><?php echo e(__('Share This Card')); ?></h5>
                    </div>
                    <div class="modal-body">
                        <div class="qrcode-wrapper">
                            <div class="shareqrcode"></div>
                        </div>
                        <p><?php echo e(__('Point your camera at the QR code,')); ?> <br> <span class="qr-link text-wrap"></span>
                        </p>

                        <p><?php echo e(__('Or check my social channels')); ?></p>
                        <ul class="social-list modal-share">
                            <li>
                                <a href="https://facebook.com">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55"
                                        viewBox="0 0 55 55" fill="none">
                                        <g clip-path="url(#clip0_5_272)">
                                            <path
                                                d="M54.9802 27.7657C54.9802 12.7763 42.8289 0.625 27.8395 0.625C12.8501 0.625 0.698853 12.7763 0.698853 27.7657C0.698853 41.3122 10.6238 52.5406 23.5988 54.5767V35.611H16.7076V27.7657H23.5988V21.7863C23.5988 14.9841 27.6508 11.2268 33.8503 11.2268C36.8188 11.2268 39.9256 11.7569 39.9256 11.7569V18.4361H36.5034C33.132 18.4361 32.0803 20.5284 32.0803 22.6768V27.7657H39.6076L38.4043 35.611H32.0803V54.5767C45.0553 52.5406 54.9802 41.3122 54.9802 27.7657Z"
                                                fill="#1877F2" />
                                            <path
                                                d="M38.4043 35.6113L39.6076 27.7659H32.0803V22.677C32.0803 20.5307 33.132 18.4363 36.5034 18.4363H39.9257V11.7571C39.9257 11.7571 36.8198 11.2271 33.8503 11.2271C27.6509 11.2271 23.5988 14.9843 23.5988 21.7865V27.7659H16.7076V35.6113H23.5988V54.5769C26.4089 55.0165 29.2702 55.0165 32.0803 54.5769V35.6113H38.4043Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_5_272">
                                                <rect width="54.2814" height="54.2814" fill="white"
                                                    transform="translate(0.698853 0.625)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://instagram.com" class="insta-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="55"
                                        viewBox="0 0 56 55" fill="none">
                                        <g clip-path="url(#clip0_5_273)">
                                            <path
                                                d="M28.0397 5.12524C35.2914 5.12524 36.1501 5.15704 39.002 5.28426C41.6525 5.40088 43.0837 5.84616 44.0379 6.21723C45.2995 6.70491 46.2113 7.29861 47.1548 8.24218C48.109 9.19634 48.6921 10.0975 49.1798 11.3591C49.5509 12.3133 49.9961 13.7551 50.1128 16.395C50.24 19.2575 50.2718 20.1162 50.2718 27.3573C50.2718 34.6089 50.24 35.4677 50.1128 38.3196C49.9961 40.97 49.5509 42.4013 49.1798 43.3554C48.6921 44.6171 48.0984 45.5288 47.1548 46.4724C46.2007 47.4265 45.2995 48.0096 44.0379 48.4973C43.0837 48.8684 41.6419 49.3137 39.002 49.4303C36.1395 49.5575 35.2808 49.5893 28.0397 49.5893C20.7881 49.5893 19.9293 49.5575 17.0774 49.4303C14.427 49.3137 12.9957 48.8684 12.0416 48.4973C10.78 48.0096 9.8682 47.4159 8.92463 46.4724C7.97047 45.5182 7.38737 44.6171 6.89968 43.3554C6.52862 42.4013 6.08334 40.9594 5.96672 38.3196C5.8395 35.4571 5.8077 34.5983 5.8077 27.3573C5.8077 20.1056 5.8395 19.2469 5.96672 16.395C6.08334 13.7445 6.52862 12.3133 6.89968 11.3591C7.38737 10.0975 7.98107 9.18574 8.92463 8.24218C9.8788 7.28801 10.78 6.70491 12.0416 6.21723C12.9957 5.84616 14.4376 5.40088 17.0774 5.28426C19.9293 5.15704 20.7881 5.12524 28.0397 5.12524ZM28.0397 0.237793C20.6715 0.237793 19.7491 0.269598 16.8548 0.39682C13.9711 0.524042 11.9886 0.990523 10.2711 1.65844C8.47936 2.35816 6.9633 3.28052 5.45784 4.79658C3.94177 6.30204 3.01941 7.8181 2.31969 9.59921C1.65178 11.3273 1.1853 13.2992 1.05808 16.1829C0.930853 19.0878 0.899048 20.0102 0.899048 27.3785C0.899048 34.7468 0.930853 35.6691 1.05808 38.5634C1.1853 41.4471 1.65178 43.4297 2.31969 45.1472C3.01941 46.9389 3.94177 48.4549 5.45784 49.9604C6.9633 51.4658 8.47936 52.3988 10.2605 53.0879C11.9886 53.7558 13.9605 54.2223 16.8442 54.3495C19.7385 54.4768 20.6609 54.5086 28.0291 54.5086C35.3974 54.5086 36.3198 54.4768 39.2141 54.3495C42.0978 54.2223 44.0803 53.7558 45.7978 53.0879C47.5789 52.3988 49.095 51.4658 50.6004 49.9604C52.1059 48.4549 53.0389 46.9389 53.728 45.1578C54.3959 43.4297 54.8624 41.4577 54.9896 38.574C55.1168 35.6797 55.1486 34.7574 55.1486 27.3891C55.1486 20.0208 55.1168 19.0985 54.9896 16.2042C54.8624 13.3205 54.3959 11.3379 53.728 9.62041C53.0601 7.8181 52.1377 6.30204 50.6216 4.79658C49.1162 3.29112 47.6001 2.35816 45.819 1.66904C44.0909 1.00112 42.119 0.534644 39.2353 0.407422C36.3304 0.269598 35.408 0.237793 28.0397 0.237793Z"
                                                fill="black" />
                                            <path
                                                d="M28.0398 13.437C20.3429 13.437 14.0984 19.6815 14.0984 27.3784C14.0984 35.0754 20.3429 41.3198 28.0398 41.3198C35.7367 41.3198 41.9812 35.0754 41.9812 27.3784C41.9812 19.6815 35.7367 13.437 28.0398 13.437ZM28.0398 36.4218C23.0463 36.4218 18.9964 32.3719 18.9964 27.3784C18.9964 22.385 23.0463 18.3351 28.0398 18.3351C33.0333 18.3351 37.0832 22.385 37.0832 27.3784C37.0832 32.3719 33.0333 36.4218 28.0398 36.4218Z"
                                                fill="black" />
                                            <path
                                                d="M45.7872 12.8861C45.7872 14.6884 44.3242 16.1409 42.5325 16.1409C40.7302 16.1409 39.2777 14.6778 39.2777 12.8861C39.2777 11.0838 40.7408 9.63135 42.5325 9.63135C44.3242 9.63135 45.7872 11.0944 45.7872 12.8861Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_5_273">
                                                <rect width="54.2814" height="54.2814" fill="black"
                                                    transform="translate(0.899048 0.237793)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/" class="linkedin-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55"
                                        viewBox="0 0 55 55" fill="none">
                                        <g clip-path="url(#clip0_5_274)">
                                            <path
                                                d="M50.3735 0.625H4.10614C3.04341 0.625 2.02421 1.04717 1.27275 1.79863C0.521289 2.55009 0.0991211 3.56929 0.0991211 4.63202V50.8994C0.0991211 51.9621 0.521289 52.9813 1.27275 53.7328C2.02421 54.4842 3.04341 54.9064 4.10614 54.9064H50.3735C51.4362 54.9064 52.4554 54.4842 53.2069 53.7328C53.9583 52.9813 54.3805 51.9621 54.3805 50.8994V4.63202C54.3805 3.56929 53.9583 2.55009 53.2069 1.79863C52.4554 1.04717 51.4362 0.625 50.3735 0.625ZM16.278 46.866H8.11694V20.9428H16.278V46.866ZM12.1918 17.3505C11.2661 17.3452 10.3626 17.0659 9.5955 16.5477C8.82837 16.0296 8.23192 15.2957 7.88144 14.4389C7.53095 13.5821 7.44214 12.6406 7.62621 11.7334C7.81028 10.8261 8.25897 9.99369 8.91567 9.34119C9.57237 8.68869 10.4076 8.24535 11.3161 8.06711C12.2245 7.88888 13.1654 7.98373 14.0199 8.33971C14.8745 8.69569 15.6045 9.29683 16.1177 10.0673C16.6309 10.8377 16.9045 11.7429 16.9037 12.6687C16.9125 13.2885 16.7963 13.9037 16.5622 14.4776C16.3282 15.0516 15.9809 15.5725 15.5412 16.0094C15.1015 16.4463 14.5783 16.7902 14.0029 17.0206C13.4275 17.251 12.8115 17.3632 12.1918 17.3505ZM46.3589 46.8886H38.2016V32.7264C38.2016 28.5498 36.4262 27.2606 34.1343 27.2606C31.7143 27.2606 29.3394 29.085 29.3394 32.832V46.8886H21.1784V20.9617H29.0266V24.554H29.1321C29.92 22.9595 32.6793 20.2342 36.8898 20.2342C41.4434 20.2342 46.3627 22.9369 46.3627 30.8529L46.3589 46.8886Z"
                                                fill="#0A66C2" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_5_274">
                                                <rect width="54.2814" height="54.2814" fill="white"
                                                    transform="translate(0.0991211 0.625)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <?php
                                    $whatsapp_link = url('https://wa.me/send/?text=' . $url_link);
                                ?>
                                <a href="<?php echo e($whatsapp_link); ?>">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_213_9336)">
                                            <path
                                                d="M15 30C23.2843 30 30 23.2843 30 15C30 6.71573 23.2843 0 15 0C6.71573 0 0 6.71573 0 15C0 23.2843 6.71573 30 15 30Z"
                                                fill="#29A71A" />
                                            <path
                                                d="M21.6137 8.38606C20.0531 6.80986 17.9806 5.84323 15.7701 5.66053C13.5595 5.47782 11.3564 6.09107 9.55818 7.38965C7.75996 8.68824 6.48496 10.5867 5.96319 12.7425C5.44141 14.8984 5.70719 17.1697 6.7126 19.1469L5.72567 23.9383C5.71543 23.986 5.71514 24.0353 5.72481 24.0831C5.73449 24.1309 5.75393 24.1762 5.78192 24.2162C5.82291 24.2768 5.88143 24.3235 5.94965 24.35C6.01788 24.3765 6.09256 24.3815 6.16373 24.3645L10.8598 23.2514C12.8313 24.2314 15.0867 24.48 17.2244 23.9532C19.3621 23.4264 21.2436 22.1583 22.5341 20.3744C23.8246 18.5906 24.4404 16.4067 24.2718 14.2115C24.1033 12.0163 23.1614 9.95202 21.6137 8.38606ZM20.1495 20.0724C19.0697 21.1492 17.6793 21.86 16.1741 22.1046C14.669 22.3492 13.125 22.1154 11.7598 21.4361L11.1052 21.1122L8.22623 21.794L8.23476 21.7582L8.83135 18.8605L8.51089 18.2281C7.81333 16.8581 7.56725 15.3025 7.80792 13.7841C8.04858 12.2657 8.76364 10.8624 9.85067 9.77526C11.2165 8.40983 13.0688 7.64277 15.0001 7.64277C16.9314 7.64277 18.7837 8.40983 20.1495 9.77526C20.1612 9.7886 20.1737 9.80113 20.187 9.81276C21.536 11.1817 22.289 13.0284 22.282 14.9503C22.275 16.8722 21.5084 18.7134 20.1495 20.0724Z"
                                                fill="white" />
                                            <path
                                                d="M19.8939 17.9466C19.5411 18.5023 18.9837 19.1824 18.2831 19.3512C17.0559 19.6478 15.1724 19.3614 12.8286 17.1762L12.7996 17.1506C10.7388 15.2398 10.2036 13.6495 10.3331 12.3881C10.4047 11.6722 11.0013 11.0245 11.5042 10.6018C11.5837 10.5339 11.6779 10.4856 11.7794 10.4607C11.881 10.4358 11.9869 10.435 12.0887 10.4583C12.1906 10.4817 12.2856 10.5286 12.3661 10.5952C12.4467 10.6618 12.5105 10.7464 12.5525 10.8421L13.311 12.5466C13.3603 12.6572 13.3785 12.779 13.3638 12.8991C13.3491 13.0193 13.302 13.1331 13.2275 13.2285L12.8439 13.7262C12.7616 13.829 12.712 13.954 12.7014 14.0852C12.6907 14.2165 12.7196 14.3479 12.7843 14.4626C12.9991 14.8393 13.5138 15.3932 14.0849 15.9063C14.7258 16.4858 15.4366 17.016 15.8866 17.1966C16.007 17.2458 16.1394 17.2578 16.2666 17.2311C16.3939 17.2044 16.5103 17.1401 16.6008 17.0466L17.0456 16.5983C17.1315 16.5137 17.2382 16.4533 17.355 16.4234C17.4718 16.3934 17.5944 16.395 17.7104 16.4279L19.5121 16.9393C19.6115 16.9697 19.7026 17.0226 19.7785 17.0936C19.8543 17.1647 19.9129 17.2522 19.9497 17.3494C19.9866 17.4467 20.0007 17.551 19.991 17.6545C19.9814 17.758 19.9482 17.8579 19.8939 17.9466Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_213_9336">
                                                <rect width="30" height="30" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- appointment popup -->
        <div class="theme-modal appointment-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close close-search1 appointment-modal-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title"><?php echo e(__('Make Appointment')); ?></h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?php echo e(__('Name:')); ?></label>
                                <input type="text" name="name" class="app_name"
                                    placeholder="<?php echo e(__('')); ?>Enter your name">
                                <span class="  text-white h6 span-error-name"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Email:')); ?></label>
                                <input type="email" name="email" class="app_email"
                                    placeholder="<?php echo e(__('')); ?>Enter your email">
                                <span class="  text-white h6 span-error-email"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Phone:')); ?></label>
                                <input type="tel" name="phone" class="app_phone"
                                    placeholder="<?php echo e(__('Enter your phone no')); ?>">
                                <span class=" text-white  h6 span-error-phone"></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary appointment-modal-toggle"
                                type="button"><?php echo e(__('Close')); ?></button>
                            <button class="btn-secondary" id="makeappointment"
                                type="button"><?php echo e(__('Make Appointment')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Make Contact Popup -->
        <div class="theme-modal contact-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close make-contact-modal-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title"><?php echo e(__('Enter Contact Details')); ?></h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?php echo e(__('Name:')); ?></label>
                                <input type="text" name="name" class="contact_name"
                                    placeholder="<?php echo e(__('Enter your name')); ?>">
                                <span class=" text-white h6 span-error-contactname"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Email:')); ?></label>
                                <input type="email" name="email" class="contact_email"
                                    placeholder="<?php echo e(__('Enter your email')); ?>">
                                <span class=" text-white h6 span-error-contactemail"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Phone:')); ?></label>
                                <input type="tel" name="phone" class="contact_phone"
                                    placeholder="<?php echo e(__('Enter your phone no')); ?>">
                                <span class="  text-white h6 span-error-contactphone"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Message:')); ?></label>
                                <textarea name="message" class="contact_message" cols="30" rows="5"></textarea>
                                <span class="text-white h6 span-error-contactmessage"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary make-contact-modal-toggle"
                                type="button"><?php echo e(__('Close')); ?></button>
                            <button class="btn-secondary" id="makecontact"
                                type="button"><?php echo e(__('Send')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		
		
		<!-- Make leads Popup -->
		<?php $__currentLoopData = $leadGeneration_content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leadgen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <div class="theme-modal<?php echo e($leadgen->id); ?> contact-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close make-contact-modal-toggle<?php echo e($leadgen->id); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title"><?php echo e(__($leadgen->title)); ?></h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?php echo e(__('Name:')); ?></label>
                                <input type="text" name="name<?php echo e($leadgen->id); ?>" class="contact_name<?php echo e($leadgen->id); ?>"
                                    placeholder="<?php echo e(__('Enter your name')); ?>">
                                <span class=" text-white h6 span-error-contactname"></span>
								<input type="hidden" name="campaign_name<?php echo e($leadgen->id); ?>" class="form-control campaign_name<?php echo e($leadgen->id); ?>" value = "<?php echo e($leadgen->title); ?>">
								<input type="hidden" name="campaign_id<?php echo e($leadgen->id); ?>" class="form-control campaign_id<?php echo e($leadgen->id); ?>" value = "<?php echo e($leadgen->id); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Email:')); ?></label>
                                <input type="email" name="email<?php echo e($leadgen->id); ?>" class="contact_email<?php echo e($leadgen->id); ?>"
                                    placeholder="<?php echo e(__('Enter your email')); ?>">
                                <span class=" text-white h6 span-error-contactemail"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Phone:')); ?></label>
                                <input type="tel" name="phone<?php echo e($leadgen->id); ?>" class="contact_phone<?php echo e($leadgen->id); ?>"
                                    placeholder="<?php echo e(__('Enter your phone no')); ?>">
                                <span class="  text-white h6 span-error-contactphone"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Message:')); ?></label>
                                <textarea name="message<?php echo e($leadgen->id); ?>" class="contact_message<?php echo e($leadgen->id); ?>" cols="30" rows="5"></textarea>
                                <span class="text-white h6 span-error-contactmessage"></span>
                            </div>
                        </div>
                        <div class="modal-footer" style="flex-direction: column;">
                            <button class="btn-secondary make-contact-modal-toggle<?php echo e($leadgen->id); ?>"
                                type="button" style="display:none"><?php echo e(__('Close')); ?></button>
                            <button class="btn-secondary" id="leadcontact<?php echo e($leadgen->id); ?>"
                                type="button"><?php echo e(__('Send')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		
	<div class="add-to-contact-wrapper " style="position: fixed;bottom: 10px;left: 50%;transform: translateX(-50%);z-index: 999999">
		 <a href="<?php echo e(route('bussiness.save', $business->slug)); ?>" class="btn btn-primary add-to-contact-btn add-to-contact-botton" style="border-radius: 10px;font-family:poppinsregular"><i class="fa fa-address-card"></i>&nbsp; Add to Contact</a>
		</div>
        
        <div class="theme-modal" id="passwordmodel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title"><?php echo e(__('Password')); ?></h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?php echo e(__('Password:')); ?></label>
                                <input type="password" name="Password" class="password_val"
                                    placeholder="<?php echo e(__('Enter password')); ?>">
                                <span class="text-danger text-white h6 span-error-password"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary password-submit"
                                type="button"><?php echo e(__('Submit')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
        <div class="theme-modal" id="gallerymodel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close close-model">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title"><?php echo e(__('Gallary')); ?></h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?php echo e(__('Image preview:')); ?></label>
                                <img src="" class="imagepreview" style="width: 500px; height: 300px;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary close-model" type="button"><?php echo e(__('Close')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
        <div class="theme-modal" id="videomodel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close close-model1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45"
                                viewBox="0 0 45 45" fill="none">
                                <path opacity="0.4"
                                    d="M37.2376 24.5509H7.76834C6.74981 24.5509 5.92651 23.7258 5.92651 22.7091C5.92651 21.6924 6.74981 20.8672 7.76834 20.8672H37.2376C38.2561 20.8672 39.0794 21.6924 39.0794 22.7091C39.0794 23.7258 38.2561 24.5509 37.2376 24.5509Z"
                                    fill="#F9D254" />
                                <path
                                    d="M15.1357 31.9183C14.6642 31.9183 14.1926 31.7378 13.8335 31.3787L6.46614 24.0114C5.74599 23.2912 5.74599 22.1271 6.46614 21.4069L13.8335 14.0396C14.5536 13.3194 15.7178 13.3194 16.4379 14.0396C17.1581 14.7598 17.1581 15.9239 16.4379 16.6441L10.3728 22.7091L16.4379 28.7742C17.1581 29.4944 17.1581 30.6585 16.4379 31.3787C16.0788 31.7378 15.6072 31.9183 15.1357 31.9183Z"
                                    fill="#F9D254" />
                            </svg>
                        </button>
                        <h5 class="modal-title"><?php echo e(__('Gallary')); ?></h5>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?php echo e(__('Video preview:')); ?></label>
                                <iframe width="100%" height="360" class="videopreview" src=""
                                    frameborder="0" allowfullscreen ></iframe>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-secondary close-model1" type="button"><?php echo e(__('Close')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        

    </div>
    <script src="<?php echo e(asset('custom/theme5/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('custom/theme5/js/slick.min.js')); ?>" defer="defer"></script>
    <?php if($SITE_RTL == 'on'): ?>
        <script src="<?php echo e(asset('custom/theme5/js/rtl-custom.js')); ?>" defer="defer"></script>
    <?php else: ?>
        <script src="<?php echo e(asset('custom/theme5/js/custom.js')); ?>" defer="defer"></script>
    <?php endif; ?>
    <script src="<?php echo e(asset('custom/js/jquery.qrcode.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.date.js"></script>
    <script src="<?php echo e(asset('custom/js/emojionearea.min.js')); ?>"></script>
    <script src="<?php echo e(asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('custom/js/socialSharing.js')); ?>"></script>
    <script src="<?php echo e(asset('custom/js/socialSharing.min.js')); ?>"></script>
    <?php if($business->enable_pwa_business == 'on'): ?>
        <script type="text/javascript">
            const container = document.querySelector("body")

            const coffees = [];

            if ("serviceWorker" in navigator) {
                window.addEventListener("load", function() {
                    navigator.serviceWorker
                        .register("<?php echo e(asset('serviceWorker.js')); ?>")
                        .then(res => console.log("service worker registered"))
                        .catch(err => console.log("service worker not registered", err))

                })
            }
        </script>
    <?php endif; ?>
    <script>
        $(".imagepopup").on("click", function(e) {
            var imgsrc = $(this).children(".imageresource").attr("src");
            $('.imagepreview').attr('src',
                imgsrc); // here asign the image to the modal when the user click the enlarge link
            $("#gallerymodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#gallerymodel').css("background", 'rgb(0 0 0 / 50%)')
        });

        $(".imagepopup1").on("click", function() {
            var imgsrc1 = $(this).children(".imageresource1").attr("src");
            $('.imagepreview').attr('src',
                imgsrc1); // here asign the image to the modal when the user click the enlarge link
            $("#gallerymodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#gallerymodel').css("background", 'rgb(0 0 0 / 50%)')
        });

        $(".videopop").on("click", function() {
            var videosrc = $(this).children('video').children(".videoresource").attr("src");
            $('.videopreview').attr('src',
                videosrc); // here asign the image to the modal when the user click the enlarge link
            $("#videomodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#videomodel').css("background",
                'rgb(0 0 0 / 50%)'
            ) // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

        $(".videopop1").on("click", function() {
            var videosrc1 = $(this).children('video').children(".videoresource1").attr("src");
            $('.videopreview').attr('src',
                videosrc1); // here asign the image to the modal when the user click the enlarge link
            $("#videomodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#videomodel').css("background",
                'rgb(0 0 0 / 50%)'
            ) // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

        $(".close-model").on("click", function() {
            $("#gallerymodel").removeClass("active");
            $("body").removeClass("no-scroll");
            $('html').removeClass('modal-open');
            $('#gallerymodel').css("background", '')
        });

        $(".close-model1").on("click", function() {
            $("#videomodel").removeClass("active");
            $("body").removeClass("no-scroll");
            $('html').removeClass('modal-open');
            $('#videomodel').css("background", '')
        });


        $(document).ready(function() {

            var date = new Date();
            $('.datepicker_min').pickadate({
                min: date,
            })

        });
        //Password Check
        <?php if(!Auth::check()): ?>

            let ispassword;
            var ispassenable = '<?php echo e($business->enable_password); ?>';
            var business_password = '<?php echo e($business->password); ?>';

            if (ispassenable == 'on') {
                $('.password-submit').click(function() {

                    ispassword = 'true';
                    passwordpopup('true');
                });

                function passwordpopup(type) {
                    if (type == 'false') {

                        $("#passwordmodel").addClass("active");
                        $("body").toggleClass("no-scroll");
                        $('html').addClass('modal-open');
                        $('#passwordmodel').css("background", 'rgb(0 0 0 / 50%)')
                    } else {

                        var password_val = $('.password_val').val();

                        if (password_val == business_password) {
                            $("#passwordmodel").removeClass("active");
                            $("body").removeClass("no-scroll");
                            $('html').removeClass('modal-open');
                            $('#passwordmodel').css("background", '')
                        } else {

                            $(`.span-error-password`).text("<?php echo e(__('*Please enter correct password')); ?>");
                            passwordpopup('false');

                        }
                    }
                }

                if (ispassword == undefined) {
                    passwordpopup('false');
                }
            }
        <?php endif; ?>


        function downloadURI(uri, name) {
            var link = document.createElement("a");
            link.download = name;
            link.href = uri;
            R
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            delete link;
        };


        $(document).ready(function() {
            $(".emojiarea").emojioneArea();
            $(`.span-error-date`).text("");
            $(`.span-error-time`).text("");
            $(`.span-error-name`).text("");
            $(`.span-error-email`).text("");
            $(`.span-error-contactname`).text("");
            $(`.span-error-contactemail`).text("");
            $(`.span-error-contactphone`).text("");
            $(`.span-error-contactmessage`).text("");


            var slug = '<?php echo e($business->slug); ?>';
            var url_link = `<?php echo e(url('/')); ?>/${slug}`;
            $(`.qr-link`).text(url_link);
            var foreground_color =
                `<?php echo e(isset($qr_detail->foreground_color) ? $qr_detail->foreground_color : '#000000'); ?>`;
            var background_color =
                `<?php echo e(isset($qr_detail->background_color) ? $qr_detail->background_color : '#ffffff'); ?>`;
            var radius = `<?php echo e(isset($qr_detail->radius) ? $qr_detail->radius : 26); ?>`;
            var qr_type = `<?php echo e(isset($qr_detail->qr_type) ? $qr_detail->qr_type : 0); ?>`;
            var qr_font = `<?php echo e(isset($qr_detail->qr_text) ? $qr_detail->qr_text : 'vCard'); ?>`;
            var qr_font_color = `<?php echo e(isset($qr_detail->qr_text_color) ? $qr_detail->qr_text_color : '#f50a0a'); ?>`;
            var size = `<?php echo e(isset($qr_detail->size) ? $qr_detail->size : 9); ?>`;

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
        });


        $(`.rating_preview`).attr('id');
        var from_$input = $('#input_from').pickadate(),
            from_picker = from_$input.pickadate('picker')


        var to_$input = $('#input_to').pickadate(),
            to_picker = to_$input.pickadate('picker')

        var is_enabled = "<?php echo e($is_enable); ?>";
        if (is_enabled) {
            $('#business-hours-div').show();
        } else {
            $('#business-hours-div').hide();
        }

        var is_contact_enable = "<?php echo e($is_contact_enable); ?>";
        if (is_contact_enable) {
            $('#contact-div').show();
        } else {
            $('#contact-div').hide();
        }

        var is_enable_appoinment = "<?php echo e($is_enable_appoinment); ?>";
        if (is_enable_appoinment) {
            $('#appointment-div').show();
        } else {
            $('#appointment-div').hide();
        }
		
		var is_enable_leadgeneration = "<?php echo e($is_enable_leadgeneration); ?>";

        if (is_enable_leadgeneration) {
            $('#leadgeneration-div').show();
        } else {
            $('#leadgeneration-div').hide();
        }

        var is_enable_service = "<?php echo e($is_enable_service); ?>";
        if (is_enable_service) {
            $('#services-div').show();
        } else {
            $('#services-div').hide();
        }

        var is_enable_testimonials = "<?php echo e($is_enable_testimonials); ?>";
        if (is_enable_testimonials) {
            $('#testimonials-div').show();
        } else {
            $('#testimonials-div').hide();
        }

        var is_enable_sociallinks = "<?php echo e($is_enable_sociallinks); ?>";
        if (is_enable_sociallinks) {
            $('#social-div').show();
        } else {
            $('#social-div').hide();
        }

        var is_enable_gallery = "<?php echo e($is_enable_gallery); ?>";
        if (is_enable_gallery) {
            $('#gallery-div').show();
        } else {
            $('#gallery-div').hide();
        }

        var is_custom_html_enable = "<?php echo e($is_custom_html_enable); ?>";
        if (is_custom_html_enable) {
            $('.custom_html_text').show();
        } else {
            $('.custom_html_text').hide();
        }
        var is_branding_enable = "<?php echo e($is_branding_enabled); ?>";
        if (is_branding_enable) {
            $('.branding_text').show();
        } else {
            $('.branding_text').hide();
        }
        $(`#makeappointment`).click(function() {
            var name = $(`.app_name`).val();
            var email = $(`.app_email`).val();
            var date = $(`.datepicker_min`).val();
            var phone = $(`.app_phone`).val();
            // var time = $("input[type='radio']:checked").data('id');
            var time = $("input[type='radio']:checked").data('id');
            var business_id = '<?php echo e($business->id); ?>';

            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }
            $(`.span-error-date`).text("");
            $(`.span-error-time`).text("");
            $(`.span-error-name`).text("");
            $(`.span-error-email`).text("");

            if (date == "") {

                $(`.span-error-date`).text("<?php echo e(__('*Please choose date')); ?>");
                $(".close-search1").trigger({
                    type: "click"
                });
                // } else if (document.querySelectorAll('.app_time').length < 1) {
            } else if (document.querySelectorAll('input[type="radio"][name="time"]:checked').length < 1) {

                $(`.span-error-time`).text("<?php echo e(__('*Please choose time')); ?>");
                $(".close-search1").trigger({
                    type: "click"
                });
            } else if (name == "") {

                $(`.span-error-name`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-email`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-phone`).text("<?php echo e(__('*Please enter your phone no')); ?>");
            } else {

                $(`.span-error-date`).text("");
                $(`.span-error-time`).text("");
                $(`.span-error-name`).text("");
                $(`.span-error-email`).text("");

                date = formatDate(date);
                $.ajax({
                    url: '<?php echo e(route('appoinment.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
                        "email": email,
                        "phone": phone,
                        "date": date,
                        "time": time,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        if (data.flag == false) {
                            $(".close-search1").trigger({
                                type: "click"
                            });
                            show_toastr('Error', data.msg, 'error');

                        } else {
                            $(".close-search1").trigger({
                                type: "click"
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                            show_toastr('Success',
                                "<?php echo e(__('Thank you for booking an appointment.')); ?>", 'success');
                        }
                    }
                });
            }
        });

        $(`#makecontact`).click(function() {

            var name = $(`.contact_name`).val();
            var email = $(`.contact_email`).val();
            var phone = $(`.contact_phone`).val();
            var message = $(`.contact_message`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname`).text("");
            $(`.span-error-contactemail`).text("");
            $(`.span-error-contactphone`).text("");
            $(`.span-error-contactmessage`).text("");

            if (name == "") {
                $(`.span-error-contactname`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname`).text("");
                $(`.span-error-contactemail`).text("");
                $(`.span-error-contactphone`).text("");
                $(`.span-error-contactmessage`).text("");

                $.ajax({
                    url: '<?php echo e(route('contacts.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".make-contact-modal-toggle").trigger({
                            type: "click"
                        });
                        show_toastr('Success', "<?php echo e(__('Your contact details has been noted.')); ?>",
                            'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);

                    }
                });
            }
        });
		
		$(`#leadcontact1`).click(function() {

            var name = $(`.contact_name1`).val();
			var campaign_name = $(`.campaign_name1`).val();
			var campaign_id = $(`.campaign_id1`).val();
            var email = $(`.contact_email1`).val();
            var phone = $(`.contact_phone1`).val();
            var message = $(`.contact_message1`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname1`).text("");
			$(`.span-error-campaign_name1`).text("");
            $(`.span-error-contactemail1`).text("");
            $(`.span-error-contactphone1`).text("");
            $(`.span-error-contactmessage1`).text("");

            if (name == "") {
                $(`.span-error-contactname1`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail1`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone1`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage1`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname1`).text("");
                $(`.span-error-contactemail1`).text("");
                $(`.span-error-contactphone1`).text("");
                $(`.span-error-contactmessage1`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		$(`#leadcontact2`).click(function() {
            var name = $(`.contact_name2`).val();
			var campaign_name = $(`.campaign_name2`).val();
			var campaign_id = $(`.campaign_id2`).val();
            var email = $(`.contact_email2`).val();
            var phone = $(`.contact_phone2`).val();
            var message = $(`.contact_message2`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname2`).text("");
			$(`.span-error-campaign_name2`).text("");
            $(`.span-error-contactemail2`).text("");
            $(`.span-error-contactphone2`).text("");
            $(`.span-error-contactmessage2`).text("");

            if (name == "") {
                $(`.span-error-contactname2`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail2`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone2`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage2`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname2`).text("");
                $(`.span-error-contactemail2`).text("");
                $(`.span-error-contactphone2`).text("");
                $(`.span-error-contactmessage2`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact3`).click(function() {
            var name = $(`.contact_name3`).val();
			var campaign_name = $(`.campaign_name3`).val();
			var campaign_id = $(`.campaign_id3`).val();
            var email = $(`.contact_email3`).val();
            var phone = $(`.contact_phone3`).val();
            var message = $(`.contact_message3`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname3`).text("");
			$(`.span-error-campaign_name3`).text("");
            $(`.span-error-contactemail3`).text("");
            $(`.span-error-contactphone3`).text("");
            $(`.span-error-contactmessage3`).text("");

            if (name == "") {
                $(`.span-error-contactname3`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail3`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone3`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage3`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname3`).text("");
                $(`.span-error-contactemail3`).text("");
                $(`.span-error-contactphone3`).text("");
                $(`.span-error-contactmessage3`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact4`).click(function() {
            var name = $(`.contact_name4`).val();
			var campaign_name = $(`.campaign_name4`).val();
			var campaign_id = $(`.campaign_id4`).val();
            var email = $(`.contact_email4`).val();
            var phone = $(`.contact_phone4`).val();
            var message = $(`.contact_message4`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname4`).text("");
			$(`.span-error-campaign_name4`).text("");
            $(`.span-error-contactemail4`).text("");
            $(`.span-error-contactphone4`).text("");
            $(`.span-error-contactmessage4`).text("");

            if (name == "") {
                $(`.span-error-contactname4`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail4`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone4`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage4`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname4`).text("");
                $(`.span-error-contactemail4`).text("");
                $(`.span-error-contactphone4`).text("");
                $(`.span-error-contactmessage4`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		$(`#leadcontact5`).click(function() {
            var name = $(`.contact_name5`).val();
			var campaign_name = $(`.campaign_name5`).val();
			var campaign_id = $(`.campaign_id5`).val();
            var email = $(`.contact_email5`).val();
            var phone = $(`.contact_phone5`).val();
            var message = $(`.contact_message5`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname5`).text("");
			$(`.span-error-campaign_name5`).text("");
            $(`.span-error-contactemail5`).text("");
            $(`.span-error-contactphone5`).text("");
            $(`.span-error-contactmessage5`).text("");

            if (name == "") {
                $(`.span-error-contactname5`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail5`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone5`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage5`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname5`).text("");
                $(`.span-error-contactemail5`).text("");
                $(`.span-error-contactphone5`).text("");
                $(`.span-error-contactmessage5`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact6`).click(function() {
            var name = $(`.contact_name6`).val();
			var campaign_name = $(`.campaign_name6`).val();
			var campaign_id = $(`.campaign_id6`).val();
            var email = $(`.contact_email6`).val();
            var phone = $(`.contact_phone6`).val();
            var message = $(`.contact_message6`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname6`).text("");
			$(`.span-error-campaign_name6`).text("");
            $(`.span-error-contactemail6`).text("");
            $(`.span-error-contactphone6`).text("");
            $(`.span-error-contactmessage6`).text("");

            if (name == "") {
                $(`.span-error-contactname6`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail6`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone6`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage6`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname6`).text("");
                $(`.span-error-contactemail6`).text("");
                $(`.span-error-contactphone6`).text("");
                $(`.span-error-contactmessage6`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact7`).click(function() {
            var name = $(`.contact_name7`).val();
			var campaign_name = $(`.campaign_name7`).val();
			var campaign_id = $(`.campaign_id7`).val();
            var email = $(`.contact_email7`).val();
            var phone = $(`.contact_phone7`).val();
            var message = $(`.contact_message7`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname7`).text("");
			$(`.span-error-campaign_name7`).text("");
            $(`.span-error-contactemail7`).text("");
            $(`.span-error-contactphone7`).text("");
            $(`.span-error-contactmessage7`).text("");

            if (name == "") {
                $(`.span-error-contactname7`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail7`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone7`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage7`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname7`).text("");
                $(`.span-error-contactemail7`).text("");
                $(`.span-error-contactphone7`).text("");
                $(`.span-error-contactmessage7`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact8`).click(function() {
            var name = $(`.contact_name8`).val();
			var campaign_name = $(`.campaign_name8`).val();
			var campaign_id = $(`.campaign_id8`).val();
            var email = $(`.contact_email8`).val();
            var phone = $(`.contact_phone8`).val();
            var message = $(`.contact_message8`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname8`).text("");
			$(`.span-error-campaign_name8`).text("");
            $(`.span-error-contactemail8`).text("");
            $(`.span-error-contactphone8`).text("");
            $(`.span-error-contactmessage8`).text("");

            if (name == "") {
                $(`.span-error-contactname8`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail8`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone8`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage8`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname8`).text("");
                $(`.span-error-contactemail8`).text("");
                $(`.span-error-contactphone8`).text("");
                $(`.span-error-contactmessage8`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact9`).click(function() {
            var name = $(`.contact_name9`).val();
			var campaign_name = $(`.campaign_name9`).val();
			var campaign_id = $(`.campaign_id9`).val();
            var email = $(`.contact_email9`).val();
            var phone = $(`.contact_phone9`).val();
            var message = $(`.contact_message9`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname9`).text("");
			$(`.span-error-campaign_name9`).text("");
            $(`.span-error-contactemail9`).text("");
            $(`.span-error-contactphone9`).text("");
            $(`.span-error-contactmessage9`).text("");

            if (name == "") {
                $(`.span-error-contactname9`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail9`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone9`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage9`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname9`).text("");
                $(`.span-error-contactemail9`).text("");
                $(`.span-error-contactphone9`).text("");
                $(`.span-error-contactmessage9`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact10`).click(function() {
            var name = $(`.contact_name10`).val();
			var campaign_name = $(`.campaign_name10`).val();
			var campaign_id = $(`.campaign_id10`).val();
            var email = $(`.contact_email10`).val();
            var phone = $(`.contact_phone10`).val();
            var message = $(`.contact_message10`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname10`).text("");
			$(`.span-error-campaign_name10`).text("");
            $(`.span-error-contactemail10`).text("");
            $(`.span-error-contactphone10`).text("");
            $(`.span-error-contactmessage10`).text("");

            if (name == "") {
                $(`.span-error-contactname10`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail10`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone10`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage10`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname10`).text("");
                $(`.span-error-contactemail10`).text("");
                $(`.span-error-contactphone10`).text("");
                $(`.span-error-contactmessage10`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact11`).click(function() {
            var name = $(`.contact_name11`).val();
			var campaign_name = $(`.campaign_name11`).val();
			var campaign_id = $(`.campaign_id11`).val();
            var email = $(`.contact_email11`).val();
            var phone = $(`.contact_phone11`).val();
            var message = $(`.contact_message11`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname11`).text("");
			$(`.span-error-campaign_name11`).text("");
            $(`.span-error-contactemail11`).text("");
            $(`.span-error-contactphone11`).text("");
            $(`.span-error-contactmessage11`).text("");

            if (name == "") {
                $(`.span-error-contactname11`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail11`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone11`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage11`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname11`).text("");
                $(`.span-error-contactemail11`).text("");
                $(`.span-error-contactphone11`).text("");
                $(`.span-error-contactmessage11`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact12`).click(function() {
            var name = $(`.contact_name12`).val();
			var campaign_name = $(`.campaign_name12`).val();
			var campaign_id = $(`.campaign_id12`).val();
            var email = $(`.contact_email12`).val();
            var phone = $(`.contact_phone12`).val();
            var message = $(`.contact_message12`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname12`).text("");
			$(`.span-error-campaign_name12`).text("");
            $(`.span-error-contactemail12`).text("");
            $(`.span-error-contactphone12`).text("");
            $(`.span-error-contactmessage12`).text("");

            if (name == "") {
                $(`.span-error-contactname12`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail12`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone12`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage12`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname12`).text("");
                $(`.span-error-contactemail12`).text("");
                $(`.span-error-contactphone12`).text("");
                $(`.span-error-contactmessage12`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact13`).click(function() {
            var name = $(`.contact_name13`).val();
			var campaign_name = $(`.campaign_name13`).val();
			var campaign_id = $(`.campaign_id13`).val();
            var email = $(`.contact_email13`).val();
            var phone = $(`.contact_phone13`).val();
            var message = $(`.contact_message13`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname13`).text("");
			$(`.span-error-campaign_name13`).text("");
            $(`.span-error-contactemail13`).text("");
            $(`.span-error-contactphone13`).text("");
            $(`.span-error-contactmessage13`).text("");

            if (name == "") {
                $(`.span-error-contactname13`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail13`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone13`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage13`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname13`).text("");
                $(`.span-error-contactemail13`).text("");
                $(`.span-error-contactphone13`).text("");
                $(`.span-error-contactmessage13`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact14`).click(function() {
            var name = $(`.contact_name14`).val();
			var campaign_name = $(`.campaign_name14`).val();
			var campaign_id = $(`.campaign_id14`).val();
            var email = $(`.contact_email14`).val();
            var phone = $(`.contact_phone14`).val();
            var message = $(`.contact_message14`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname14`).text("");
			$(`.span-error-campaign_name14`).text("");
            $(`.span-error-contactemail14`).text("");
            $(`.span-error-contactphone14`).text("");
            $(`.span-error-contactmessage14`).text("");

            if (name == "") {
                $(`.span-error-contactname14`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail14`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone14`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage14`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname14`).text("");
                $(`.span-error-contactemail14`).text("");
                $(`.span-error-contactphone14`).text("");
                $(`.span-error-contactmessage14`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact15`).click(function() {
            var name = $(`.contact_name15`).val();
			var campaign_name = $(`.campaign_name15`).val();
			var campaign_id = $(`.campaign_id15`).val();
            var email = $(`.contact_email15`).val();
            var phone = $(`.contact_phone15`).val();
            var message = $(`.contact_message15`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname15`).text("");
			$(`.span-error-campaign_name15`).text("");
            $(`.span-error-contactemail15`).text("");
            $(`.span-error-contactphone15`).text("");
            $(`.span-error-contactmessage15`).text("");

            if (name == "") {
                $(`.span-error-contactname15`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail15`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone15`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage15`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname15`).text("");
                $(`.span-error-contactemail15`).text("");
                $(`.span-error-contactphone15`).text("");
                $(`.span-error-contactmessage15`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact16`).click(function() {
            var name = $(`.contact_name16`).val();
			var campaign_name = $(`.campaign_name16`).val();
			var campaign_id = $(`.campaign_id16`).val();
            var email = $(`.contact_email16`).val();
            var phone = $(`.contact_phone16`).val();
            var message = $(`.contact_message16`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname16`).text("");
			$(`.span-error-campaign_name16`).text("");
            $(`.span-error-contactemail16`).text("");
            $(`.span-error-contactphone16`).text("");
            $(`.span-error-contactmessage16`).text("");

            if (name == "") {
                $(`.span-error-contactname16`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail16`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone16`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage16`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname16`).text("");
                $(`.span-error-contactemail16`).text("");
                $(`.span-error-contactphone16`).text("");
                $(`.span-error-contactmessage16`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact17`).click(function() {
            var name = $(`.contact_name17`).val();
			var campaign_name = $(`.campaign_name17`).val();
			var campaign_id = $(`.campaign_id17`).val();
            var email = $(`.contact_email17`).val();
            var phone = $(`.contact_phone17`).val();
            var message = $(`.contact_message17`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname17`).text("");
			$(`.span-error-campaign_name17`).text("");
            $(`.span-error-contactemail17`).text("");
            $(`.span-error-contactphone17`).text("");
            $(`.span-error-contactmessage17`).text("");

            if (name == "") {
                $(`.span-error-contactname17`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail17`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone17`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage17`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname17`).text("");
                $(`.span-error-contactemail17`).text("");
                $(`.span-error-contactphone17`).text("");
                $(`.span-error-contactmessage17`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact18`).click(function() {
            var name = $(`.contact_name18`).val();
			var campaign_name = $(`.campaign_name18`).val();
			var campaign_id = $(`.campaign_id18`).val();
            var email = $(`.contact_email18`).val();
            var phone = $(`.contact_phone18`).val();
            var message = $(`.contact_message18`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname18`).text("");
			$(`.span-error-campaign_name18`).text("");
            $(`.span-error-contactemail18`).text("");
            $(`.span-error-contactphone18`).text("");
            $(`.span-error-contactmessage18`).text("");

            if (name == "") {
                $(`.span-error-contactname18`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail18`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone18`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage18`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname18`).text("");
                $(`.span-error-contactemail18`).text("");
                $(`.span-error-contactphone18`).text("");
                $(`.span-error-contactmessage18`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact19`).click(function() {
            var name = $(`.contact_name19`).val();
			var campaign_name = $(`.campaign_name19`).val();
			var campaign_id = $(`.campaign_id19`).val();
            var email = $(`.contact_email19`).val();
            var phone = $(`.contact_phone19`).val();
            var message = $(`.contact_message19`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname19`).text("");
			$(`.span-error-campaign_name19`).text("");
            $(`.span-error-contactemail19`).text("");
            $(`.span-error-contactphone19`).text("");
            $(`.span-error-contactmessage19`).text("");

            if (name == "") {
                $(`.span-error-contactname19`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail19`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone19`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage19`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname19`).text("");
                $(`.span-error-contactemail19`).text("");
                $(`.span-error-contactphone19`).text("");
                $(`.span-error-contactmessage19`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
		
		
		$(`#leadcontact20`).click(function() {
            var name = $(`.contact_name20`).val();
			var campaign_name = $(`.campaign_name20`).val();
			var campaign_id = $(`.campaign_id20`).val();
            var email = $(`.contact_email20`).val();
            var phone = $(`.contact_phone20`).val();
            var message = $(`.contact_message20`).val();
            var business_id = '<?php echo e($business->id); ?>';

            $(`.span-error-contactname20`).text("");
			$(`.span-error-campaign_name20`).text("");
            $(`.span-error-contactemail20`).text("");
            $(`.span-error-contactphone20`).text("");
            $(`.span-error-contactmessage20`).text("");

            if (name == "") {
                $(`.span-error-contactname20`).text("<?php echo e(__('*Please enter your name')); ?>");
            } else if (email == "") {

                $(`.span-error-contactemail20`).text("<?php echo e(__('*Please enter your email')); ?>");
            } else if (phone == "") {

                $(`.span-error-contactphone20`).text("<?php echo e(__('*Please enter your phone no.')); ?>");
            } else if (message == "") {
                $(`.span-error-contactmessage20`).text("<?php echo e(__('*Please enter your message.')); ?>");
            } else {

                $(`.span-error-contactname20`).text("");
                $(`.span-error-contactemail20`).text("");
                $(`.span-error-contactphone20`).text("");
                $(`.span-error-contactmessage20`).text("");

                $.ajax({
                    url: '<?php echo e(route('leadcontact.store')); ?>',
                    type: 'POST',
                    data: {
                        "name": name,
						"campaign_name": campaign_name,
						"campaign_id": campaign_id,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "<?php echo e(__('Saved Successfully.')); ?>",
                            'success');

                    }
                });
            }
        });
    </script>
    <?php if(isset($is_slug)): ?>
        <script>
            function show_toastr(title, message, type) {
                var o, i;
                var icon = '';
                var cls = '';

                if (type == 'success') {
                    icon = 'ti ti-check-circle';
                    cls = 'success';
                } else {
                    icon = 'ti ti-times-circle';
                    cls = 'danger';
                }

                $.notify({
                    icon: icon,
                    title: " " + title,
                    message: message,
                    url: ""
                }, {
                    element: "body",
                    type: cls,
                    allow_dismiss: !0,
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    offset: {
                        x: 15,
                        y: 15
                    },
                    spacing: 80,
                    z_index: 1080,
                    delay: 2500,
                    timer: 2000,
                    url_target: "_blank",
                    mouse_over: !1,
                    animate: {
                        enter: o,
                        exit: i
                    },
                    template: '<div class="alert theme-toaster theme-toaster-success alert-{0} alert-icon theme-toaster-danger  theme-toaster-success  alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                });
            }
            if ($(".datepicker").length) {
                $('.datepicker').daterangepicker({
                    singleDatePicker: true,
                    format: 'yyyy-mm-dd',
                });
            }
        </script>
    
        <?php if($message = Session::get('success')): ?>
            <script>
                show_toastr('Success', '<?php echo $message; ?>', 'success');
            </script>
        <?php endif; ?>
        <?php if($message = Session::get('error')): ?>
            <script>
                show_toastr('Error', '<?php echo $message; ?>', 'error');
            </script>
        <?php endif; ?>
    <?php endif; ?>
    <!-- Google Analytic Code -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($business->google_analytic); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '<?php echo e($business->google_analytic); ?>');
    </script>
    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo e($business->fbpixel_code); ?>');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=0000&ev=PageView&noscript=<?php echo e($business->fbpixel_code); ?>" /></noscript>
    <!-- Custom Code -->
    <script type="text/javascript">
        <?php echo $business->customjs; ?>

    </script>
    <?php if(isset($is_pdf)): ?>
        <?php echo $__env->make('business.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
    <?php endif; ?>
    <?php if(isset($is_slug)): ?>
        <?php if($is_gdpr_enabled): ?>
            <script src="<?php echo e(asset('js/cookieconsent.js')); ?>"></script>
            <script>
                let myVar = <?php echo json_encode($a); ?>;
                let data = JSON.parse(myVar);
                let language_code = document.documentElement.getAttribute('lang');
                let languages = {};
                languages[language_code] = {
                    consent_modal: {
                        title: 'hello',
                        description: 'description',
                        primary_btn: {
                            text: 'primary_btn text',
                            role: 'accept_all'
                        },
                        secondary_btn: {
                            text: 'secondary_btn text',
                            role: 'accept_necessary'
                        }
                    },
                    settings_modal: {
                        title: 'settings_modal',
                        save_settings_btn: 'save_settings_btn',
                        accept_all_btn: 'accept_all_btn',
                        reject_all_btn: 'reject_all_btn',
                        close_btn_label: 'close_btn_label',
                        blocks: [{
                                title: 'block title',
                                description: 'block description'
                            },

                            {
                                title: 'title',
                                description: 'description',
                                toggle: {
                                    value: 'necessary',
                                    enabled: true,
                                    readonly: false
                                }
                            },
                        ]
                    }
                };
            </script>
            <script>
                function setCookie(cname, cvalue, exdays) {
                    const d = new Date();
                    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                    let expires = "expires=" + d.toUTCString();
                    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                }

                function getCookie(cname) {
                    let name = cname + "=";
                    let decodedCookie = decodeURIComponent(document.cookie);
                    let ca = decodedCookie.split(';');
                    for (let i = 0; i < ca.length; i++) {
                        let c = ca[i];
                        while (c.charAt(0) == ' ') {
                            c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length, c.length);
                        }
                    }
                    return "";
                }


                // obtain plugin
                var cc = initCookieConsent();
                // run plugin with your configuration
                cc.run({
                    current_lang: 'en',
                    autoclear_cookies: true, // default: false
                    page_scripts: true,
                    // ...
                    gui_options: {
                        consent_modal: {
                            layout: 'cloud', // box/cloud/bar
                            position: 'bottom center', // bottom/middle/top + left/right/center
                            transition: 'slide', // zoom/slide
                            swap_buttons: false // enable to invert buttons
                        },
                        settings_modal: {
                            layout: 'box', // box/bar
                            // position: 'left',           // left/right
                            transition: 'slide' // zoom/slide
                        }
                    },

                    onChange: function(cookie, changed_preferences) {},
                    onAccept: function(cookie) {
                        if (!getCookie('cookie_consent_logged')) {
                            var cookie = cookie.level;
                            var slug = '<?php echo e($business->slug); ?>';
                            $.ajax({
                                url: '<?php echo e(route('card-cookie-consent')); ?>',
                                datType: 'json',
                                data: {
                                    cookie: cookie,
                                    slug: slug,
                                },
                            })
                            setCookie('cookie_consent_logged', '1', 182, '/');
                        }
                    },
                    languages: {
                        'en': {
                            consent_modal: {
                                title: data.cookie_title,
                                description: data.cookie_description + ' ' +
                                    '<button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
                                primary_btn: {
                                    text: "<?php echo e(__('Accept all')); ?>",
                                    role: 'accept_all' // 'accept_selected' or 'accept_all'
                                },
                                secondary_btn: {
                                    text: "<?php echo e(__('Reject all')); ?>",
                                    role: 'accept_necessary' // 'settings' or 'accept_necessary'
                                },
                            },
                            settings_modal: {
                                title: "<?php echo e(__('Cookie preferences')); ?>",
                                save_settings_btn: "<?php echo e(__('Save settings')); ?>",
                                accept_all_btn: "<?php echo e(__('Accept all')); ?>",
                                reject_all_btn: "<?php echo e(__('Reject all')); ?>",
                                close_btn_label: "<?php echo e(__('Close')); ?>",
                                cookie_table_headers: [{
                                        col1: 'Name'
                                    },
                                    {
                                        col2: 'Domain'
                                    },
                                    {
                                        col3: 'Expiration'
                                    },
                                    {
                                        col4: 'Description'
                                    }
                                ],
                                blocks: [{
                                    title: data.cookie_title + ' ' + '📢',
                                    description: data.cookie_description,
                                }, {
                                    title: data.strictly_cookie_title,
                                    description: data.strictly_cookie_description,
                                    toggle: {
                                        value: 'necessary',
                                        enabled: true,
                                        readonly: true // cookie categories with readonly=true are all treated as "necessary cookies"
                                    }
                                }, {
                                    title: "<?php echo e(__('More information')); ?>",
                                    description: data.more_information_description + ' ' +
                                        '<a class="cc-link" href="' + data.contactus_url + '">Contact Us</a>.',
                                }]
                            }
                        }
                    }

                });
            </script>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>
<?php /**PATH C:\wamp64\www\versedbc\resources\views/card/theme5/index.blade.php ENDPATH**/ ?>