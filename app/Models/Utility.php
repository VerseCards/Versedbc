<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\business_hours;
use App\Models\appoinment;
use App\Models\service;
use App\Models\leadGeneration;
use App\Models\social;
use App\Models\ContactInfo;
use App\Models\testimonial;
use App\Models\Business;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonEmailTemplate;
use Storage;
use Spatie\GoogleCalendar\Event as GoogleEvent;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Webhook;

class Utility extends Model
{
    public static function AddBusinessField()
    {

        $data = [
            ['name' => 'phone', 'icon' => 'fa fa-phone'],
            ['name' => 'email', 'icon' => 'fa fa-envelope'],
            ['name' => 'address', 'icon' => 'fa fa-map-marker'],
            ['name' => 'website', 'icon' => 'fa fa-link'],
            ['name' => 'custom_field', 'icon' => 'fa fa-align-left'],
            ['name' => 'facebook', 'icon' => 'fab fa-facebook'],
            ['name' => 'x', 'icon' => 'fab fa-twitter'],
            ['name' => 'instagram', 'icon' => 'fab fa-instagram'],
            ['name' => 'whatsapp', 'icon' => 'fab fa-whatsapp'],
        ];
        foreach ($data as $value) {
            \DB::insert(
                'insert into businessfields (`name`,`icon`,`created_at`,`updated_at`) values (?,?,?,?) ON DUPLICATE KEY UPDATE `name` = VALUES(`name`) ',
                [$value['name'], $value['icon'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]
            );
        }

        return true;
    }

    public static function createSlug($table, $title, $id = 0)
    {

        // Normalize the title
        $slug = Str::slug($title, '-');
        $routes = array_map(function (\Illuminate\Routing\Route $route) {
            return $route->uri;
        }, (array) Route::getRoutes()->getIterator());


        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = self::getRelatedSlugs($table, $slug, $id);
        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug) && !in_array($slug, $routes)) {

            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug) && !in_array($newSlug, $routes)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    public static function getRelatedSlugs($table, $slug, $id = 0)
    {
        return DB::table($table)->select()->where('slug', 'like', $slug . '%')->where('id', '<>', $id)->get();
    }

    public static function getFields()
    {
        $icons = [
            'Facebook',
            'Instagram',
            'LinkedIn',
            'Phone',
            'X',
            'Youtube',
            'Email',
            'Behance',
            'Dribbble',
            'Figma',
            'Messenger',
            'Pinterest',
            'Tiktok',
            'Whatsapp',
            'Address',
            'Web_url'
        ];

        return $icons;
    }

    public static function themeOne()
    {
        $arr = [];

        $arr = [
            
            
            
            'theme4' => [
                'color1-theme4' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme4/color1.png')),
                    'color' => '#003B65',
                    'theme_name' => 'theme4-v1'
                ],
                'color2-theme4' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme4/color2.png')),
                    'color' => '#222222',
                    'theme_name' => 'theme4-v2'
                ],
                'color3-theme4' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme4/color3.png')),
                    'color' => '#ffcd25',
                    'theme_name' => 'theme4-v3'
                ],
                'color4-theme4' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme4/color4.png')),
                    'color' => '#ff2599',
                    'theme_name' => 'theme4-v4'
                ],
				
				'color7-theme4' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme4/color7.png')),
                    'color' => '#f3f3f3',
                    'theme_name' => 'theme4-v7'
                ],
            ],
            
            

            'theme12' => [
                'color1-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color1.png')),
                    'color' => '#003B65',
                    'theme_name' => 'theme12-v1'
                ],
                'color2-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color2.png')),
                    'color' => '#ff009b',
                    'theme_name' => 'theme12-v2'
                ],
                'color3-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color3.png')),
                    'color' => '#313a84',
                    'theme_name' => 'theme12-v3'
                ],
                'color4-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color4.png')),
                    'color' => '#e8c401',
                    'theme_name' => 'theme12-v4'
                ],
                'color5-theme12' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme12/color5.png')),
                    'color' => '#e80137',
                    'theme_name' => 'theme12-v5'
                ],
            ],
 
            'theme19' => [
                'color1-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color1.png')),
                    'color' => 'linear-gradient(102.24deg, #003B65 6.21%, #656D4A 99.29%)',
                    'theme_name' => 'theme19-v1'
                ],
                'color2-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color2.png')),
                    'color' => 'linear-gradient(102.24deg, #723C70 6.21%, #2E6F95 99.29%)',
                    'theme_name' => 'theme19-v2'
                ],
                'color3-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color3.png')),
                    'color' => 'linear-gradient(102.24deg, #005F73 6.21%, #0A9396 99.29%)',
                    'theme_name' => 'theme19-v3'
                ],
                'color4-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color4.png')),
                    'color' => 'linear-gradient(102.24deg, #9B2226 6.21%, #BB3E03 99.29%)',
                    'theme_name' => 'theme19-v4'
                ],
                'color5-theme19' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme19/color5.png')),
                    'color' => 'linear-gradient(102.24deg, #76C893 6.21%, #99D98C 99.29%)',
                    'theme_name' => 'theme19-v5'
                ],
            ],
			
			'theme50' => [
                'color1-theme50' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme50/color1.png')),
                    'color' => '#003B65',
                    'theme_name' => 'theme50-v1'
                ],
                'color2-theme50' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme50/color2.png')),
                    'color' => '#ff009b',
                    'theme_name' => 'theme50-v2'
                ],
                'color3-theme50' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme50/color3.png')),
                    'color' => '#313a84',
                    'theme_name' => 'theme50-v3'
                ],
                'color4-theme50' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme50/color4.png')),
                    'color' => '#e8c401',
                    'theme_name' => 'theme50-v4'
                ],
				'color5-theme50' => [
                    'img_path' => asset(Storage::url('uploads/card_theme/theme50/color5.png')),
                    'color' => '#e80137',
                    'theme_name' => 'theme50-v5'
                ],
            ],

        ];

        return $arr;
    }

    public static function getCompanyPaymentSetting()
    {
        $data = \DB::table('admin_payment_settings');
        $settings = [];
        if (\Auth::check()) {
            $user_id = \Auth::user()->creatorId();
            $data = $data->where('created_by', '=', $user_id);

        }
        $data = $data->get();
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }
	
    public static function settings()
    {

        $data = DB::table('settings');
        if (\Auth::check()) {
            // $userId = \Auth::user()->id;
            // $data = $data->where('created_by', '=', $userId);

            if (\Auth::user()->type == 'company' || \Auth::user()->type == 'techsupport') {
                $data = $data->where('created_by', '=', \Auth::user()->creatorId())->get();
                if (count($data) == 0) {
                    $data = DB::table('settings')->where('created_by', '=', 1)->get();
                }
            } else {
                $data = $data->where('created_by', '=', \Auth::user()->creatorId())->get();

                if (count($data) == 0) {
                    $data = DB::table('settings')->where('created_by', '=', 1)->get();
                }

            }

        } else {
            $data = $data->where('created_by', '=', 1);
            $data = $data->get();
        }

        
        $settings = [
            "site_currency" => "USD",
            "site_currency_symbol" => "$",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INVO",
            "invoice_color" => "ffffff",
            "proposal_prefix" => "#PROP",
            "proposal_color" => "ffffff",
            "bill_prefix" => "#BILL",
            "bill_color" => "ffffff",
            "customer_prefix" => "#CUST",
            "vender_prefix" => "#VEND",
            "footer_title" => "",
            "footer_notes" => "",
            "invoice_template" => "template1",
            "bill_template" => "template1",
            "proposal_template" => "template1",
            "registration_number" => "",
            "vat_number" => "",
            "default_language" => "en",
            "enable_stripe" => "",
            "enable_paypal" => "",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "stripe_key" => "",
            "stripe_secret" => "",
            "decimal_number" => "2",
            "tax_type" => "",
            "shipping_display" => "on",
            "journal_prefix" => "#JUR",
            "display_landing_page" => "on",
            "title_text" => "Versecard",
            "footer_text" => "Versecard",
            "company_logo" => 'logo-dark.png',
            "company_logo_light" => 'logo-light.png',
            "company_favicon" => 'favicon.png',
            "signup_button" => "on",
            "color" => "theme-3",
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "SITE_RTL" => "",
            "storage_setting" => "local",
            "local_storage_validation" => "jpg,jpeg,png",
            "local_storage_max_upload_size" => "250000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url" => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
            "google_calender_id" => "",
            "google_calender_json_file" => "",
            "Google_Calendar" => "",
            'enable_cookie' => 'on',
            'necessary_cookies' => 'on',
            'cookie_logging' => 'on',
            'cookie_title' => 'We use cookies!',
            'cookie_description' => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it',
            'strictly_cookie_title' => 'Strictly necessary cookies',
            'strictly_cookie_description' => 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
            'more_information_description' => 'For any queries in relation to our policy on cookies and your choices,',
            'contactus_url' => '#',
            'chatgpt_key' => '',
            'enable_chatgpt' => '',
            "disable_lang" => '',
        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }
    public static function getStorageSetting()
    {

        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1);
        $data = $data->get();
        $settings = [
            "storage_setting" => "local",
            "local_storage_validation" => "jpg,jpeg,png",
            "local_storage_max_upload_size" => "250000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url" => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function languages()
    {
        $languages = Utility::langList();

        if (\Schema::hasTable('language')) {
            $settings = Utility::langSetting();
            if (!empty($settings['disable_lang'])) {
                $disabledlang = explode(',', $settings['disable_lang']);
                $languages = Languages::whereNotIn('code', $disabledlang)->pluck('fullName', 'code');
            } else {
                $languages = Languages::pluck('fullName', 'code');
            }
        }

        return $languages;
    }


    public static function getValByName($key)
    {
        $setting = Utility::settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }
    public static function getAdminPaymentSetting()
    {
        $data = \DB::table('admin_payment_settings');
        $settings = [];
        if (\Auth::check()) {
            $user_id = 1;
            $data = $data->where('created_by', '=', $user_id);

        }
        $data = $data->get();
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function getPaymentIsOn()
    {
        $payments = self::getAdminPaymentSetting();
        if (isset($payments['is_stripe_enabled']) && $payments['is_stripe_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paypal_enabled']) && $payments['is_paypal_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paystack_enabled']) && $payments['is_paystack_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_flutterwave_enabled']) && $payments['is_flutterwave_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_razorpay_enabled']) && $payments['is_razorpay_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_mercado_enabled']) && $payments['is_mercado_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paytm_enabled']) && $payments['is_paytm_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_mollie_enabled']) && $payments['is_mollie_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_skrill_enabled']) && $payments['is_skrill_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_coingate_enabled']) && $payments['is_coingate_enabled'] == 'on') {
            return true;
        } else {
            return false;
        }

    }
    public static function getSocialIcon($theme, $color)
    {
        if ($theme == 'theme1') {
            $black_icon = ['color1', 'color2', 'color5'];
            if (in_array($color, $black_icon)) {
                return 'black';
            } else {
                return 'white';
            }
        }

    }
    public static function getColorIcon($theme, $color)
    {
        if ($theme == 'theme1') {
            $black_icon = ['color1', 'color2', 'color5'];
            if (in_array($color, $black_icon)) {
                return 'black';
            } else {
                return 'white';
            }
        }
    }
    public static function getmSocialIcon($theme, $color)
    {
        if ($theme == 'theme1') {
            $black_icon = ['color3', 'color5'];
            if (in_array($color, $black_icon)) {
                return 'black';
            } else {
                return 'white';
            }
        }
    }

    public static function getDefaultThemeOrder($themename)
    {
        $order = [];
        
        
        
        if ($themename == 'theme4') {
            $order = [
                'description' => '1',
				 'social' => '2',
				 'contact_info' => '3',
				 'leadgeneration' => '4',

            ];
        }
        if ($themename == 'theme50') {
            $order = [
                'description' => '1',
                'social' => '2',
                'contact_info' => '3',
				'leadgeneration' => '4',

            ];
        }

        if ($themename == 'theme12') {
            $order = [
                'description' => '1',
				'social' => '2',
                'contact_info' => '3',
				'leadgeneration' => '4',

            ];
        }


        if ($themename == 'theme19') {
            $order = [
                'description' => '1',
                'contact_info' => '2',
                'social' => '3',
				'leadgeneration' => '4',

            ];
        }

        return $order;
    }

    public static function isEnableBlock($block, $id)
    {
        if ($block == 'contact_info') {
            $block_data = ContactInfo::where('business_id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }

        }
        if ($block == 'bussiness_hour') {
            $block_data = business_hours::where('business_id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'appointment') {
            $block_data = appoinment::where('business_id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
		
		if ($block == 'leadgeneration') {
            $block_data = LeadGeneration::where('business_id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'service') {
            $block_data = service::where('business_id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'testimonials') {
            $block_data = testimonial::where('business_id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'social') {
            $block_data = social::where('business_id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        if ($block == 'custom_html') {
            $block_data = Business::where('id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_custom_html_enabled;
            } else {
                $isenable = '0';
            }
        }
        //Gallery
        if ($block == 'gallery') {
            $block_data = Gallery::where('business_id', $id)->first();
            if ($block_data != NULL) {
                $isenable = $block_data->is_enabled;
            } else {
                $isenable = '0';
            }
        }
        return $isenable;
    }

    public static function getDateFormated($date, $time = false)
    {
        if (!empty($date) && $date != '0000-00-00') {
            if ($time == true) {
                return date("d M Y H:i A", strtotime($date));
            } else {
                return date("d M Y", strtotime($date));
            }
        } else {
            return '';
        }
    }
    public static function getfonts()
    {
        $fonts = [
            "Default" => [
                "link" => "https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap",
               "fontfamily" => "Inter,sans-serif",
            ],
            "Roboto" => [
                "link" => "https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap",
                "fontfamily" => "Roboto,sans-serif",
            ],
            "OpenSans" => [
                "link" => "https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap",
                "fontfamily" => "Open Sans,sans-serif",
            ],
            "Montserrat" => [
                "link" => "https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap",
                "fontfamily" => "Montserrat,sans-serif",
            ],
            "Lato" => [
                "link" => "https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap",
                "fontfamily" => "Lato,sans-serif",
            ],
            "Raleway" => [
                "link" => "https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap",
                "fontfamily" => "Raleway,sans-serif",
            ],
            "PTSans" => [
                "link" => "https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap",
                "fontfamily" => "PT Sans,sans-serif",
            ],
            "WorkSans" => [
                "link" => "https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap",
                "fontfamily" => "Work Sans,sans-serif",
            ],
            "Merriweather" => [
                "link" => "https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap",
                "fontfamily" => "Merriweather,serif",
            ],
            "Prompt" => [
                "link" => "https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap",
                "fontfamily" => "Prompt,sans-serif",
            ],
            "ConcertOne" => [
                "link" => "https://fonts.googleapis.com/css2?family=Concert+One&display=swap",
                "fontfamily" => "Concert One,cursive",
            ],
        ];

        return $fonts;
    }
    public static function getvalueoffont($font)
    {
        $allfonts = Utility::getfonts();
        if (!isset($allfonts[$font]) || empty($allfonts[$font])) {
            $allfonts[$font] = '';
        }

        return $allfonts[$font];
    }

    public static function colorset()
    {
        if (\Auth::user()) {
            $setting = DB::table('settings')->where('created_by', \Auth::user()->creatorId())->pluck('value', 'name')->toArray();
        } else {
            $setting = DB::table('settings')->pluck('value', 'name')->toArray();
        }
        if (!isset($setting['color'])) {
            $setting = Utility::settings();
        }
        return $setting;
    }

    public static function GetLogo()
    {
        $setting = Utility::colorset();

        if (\Auth::user() && \Auth::user()->type != 'super admin') {

            if (Utility::getValByName('cust_darklayout') == 'on') {

                return Utility::getValByName('company_logo_light');
            } else {
                return Utility::getValByName('company_logo');
            }
        } else {

            if (Utility::getValByName('cust_darklayout') == 'on') {

                return Utility::getValByName('landing_logo');
            } else {
                return Utility::getValByName('logo');
            }
        }
    }

    public static function getLayoutsSetting()
    {
        $data = DB::table('settings');
        if (\Auth::check()) {
            $data = $data->where('created_by', '=', \Auth::user()->creatorId())->get();
            $created_by = \Auth::user()->creatorId();
            if (count($data) == 0) {
                $data = DB::table('settings')->where('created_by', '=', 1)->get();
                $created_by = 1;
            }
        } else {
            $data = $data->where('created_by', '=', 1)->get();
            $created_by = 1;
        }
        $settings = [
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "color" => "theme-3",
            "SITE_RTL" => "off",
            "created_by" => $created_by,
        ];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }
    public static function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }

    public static function userDefaultData()
    {
        // Make Entry In User_Email_Template
        $allEmail = EmailTemplate::all();
        foreach ($allEmail as $email) {
            UserEmailTemplate::create(
                [
                    'template_id' => $email->id,
                    'user_id' => 1,
                    'is_active' => 1,
                ]
            );
        }
    }

    // Common Function That used to send mail with check all cases
    public static function sendEmailTemplate($emailTemplate, $obj, $mailTo)
    {

        if (empty($obj->lang)) {
            $user = User::where('id', $obj['created_by'])->first();
            $obj['lang'] = $user->lang;
        }
        // find template is exist or not in our record
        $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();

        if (isset($template) && !empty($template)) {

            // check template is active or not by company
            $is_actives = UserEmailTemplate::where('template_id', '=', $template->id)->first();


            if ($is_actives->is_active == 1) {
                // get email content language base
                $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $obj['lang'])->first();

                $content->from = $template->from;


                if (!empty($content->content)) {
                    $content->content = self::replaceVariables($content->content, $obj);
                    $settings = self::settings();


                    if ($emailTemplate == "Appointment Created") {
                        $userdata = [
                            'from_name' => $obj['appointment_name'],
                            'from_email' => $obj['appointment_email'],

                        ];
                    }

                    // send email
                    try {
                        Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));
                    } catch (\Exception $e) {

                        $error = __('E-Mail have been not sent due to SMTP configuration');
                    }
                    if (isset($error)) {
                        $arReturn = [
                            'is_success' => false,
                            'error' => $error,
                        ];
                    } else {
                        $arReturn = [
                            'is_success' => true,
                            'error' => false,
                        ];
                    }
                } else {
                    $arReturn = [
                        'is_success' => false,
                        'error' => __('Mail not send, email is empty'),
                    ];
                }
                return $arReturn;
            } else {
                return [
                    'is_success' => true,
                    'error' => false,
                ];
            }
        } else {
            return [
                'is_success' => false,
                'error' => __('Mail not send, email not found'),
            ];
        }
    }

    // used for replace email variable (parameter 'template_name','id(get particular record by id for data)')
    public static function replaceVariables($content, $obj)
    {

        $arrVariable = [
            '{app_name}',
            '{app_url}',
            '{user_name}',
            '{user_email}',
            '{user_password}',
            '{user_type}',
            '{appointment_name}',
            '{appointment_email}',
            '{appointment_phone}',
            '{appointment_date}',
            '{appointment_time}',
        ];
        $arrValue = [
            'app_name' => '-',
            'app_url' => '-',
            'user_name' => '-',
            'user_email' => '-',
            'user_password' => '-',
            'user_type' => '-',
            'appointment_name' => '-',
            'appointment_email' => '-',
            'appointment_phone' => '-',
            'appointment_date' => '-',
            'appointment_time' => '-',
        ];
        foreach ($obj as $key => $val) {

            $arrValue[$key] = $val;
        }

        $arrValue['app_name'] = (isset(\Utility::settings()['company_name']) && !empty(\Utility::settings()['company_name'])) ? \Utility::settings()['company_name'] : env('APP_NAME');
        $arrValue['app_url'] = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';

        return str_replace($arrVariable, array_values($arrValue), $content);
    }
    public static function paySettings()
    {
        $data = DB::table('admin_payment_settings');

        if (\Auth::check()) {
            $userId = \Auth::user()->creatorId();
            $data = $data->where('created_by', '=', $userId);
        } else {
            $data = $data->where('created_by', '=', 1);
        }
        $data = $data->get();
        $settings = [

            "is_stripe_enabled" => "off",
            "is_paypal_enabled" => "off",
            "is_paystack_enabled" => "off",
            "is_flutterwave_enabled" => "off",
            "is_razorpay_enabled" => "off",
            "is_mercado_enabled" => "off",
            "is_paytm_enabled" => "off",
            "is_mollie_enabled" => "off",
            "is_skrill_enabled" => "off",
            "is_coingate_enabled" => "off",

        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }
    public static function error_res($msg = "", $args = array())
    {
        $msg = $msg == "" ? "error" : $msg;
        $msg_id = 'error.' . $msg;
        $converted = \Lang::get($msg_id, $args);
        $msg = $msg_id == $converted ? $msg : $converted;
        $json = array(
            'flag' => 0,
            'msg' => $msg,
        );

        return $json;
    }

    public static function success_res($msg = "", $args = array())
    {
        $msg = $msg == "" ? "success" : $msg;
        $msg_id = 'success.' . $msg;
        $converted = \Lang::get($msg_id, $args);
        $msg = $msg_id == $converted ? $msg : $converted;
        $json = array(
            'flag' => 1,
            'msg' => $msg,
        );

        return $json;
    }
    public static function upload_file($request, $key_name, $name, $path, $custom_validation = [])
    {
        try {
            $settings = Utility::getStorageSetting();


            if (!empty($settings['storage_setting'])) {

                if ($settings['storage_setting'] == 'wasabi') {

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes = !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';

                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes = !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';


                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes = !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $file = $request->$key_name;


                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];

                }

                $validator = \Validator::make($request->all(), [
                    $key_name => $validation
                ]);

                if ($validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;
                    if ($settings['storage_setting'] == 'local') {
                        $request->$key_name->move(storage_path($path), $name);
                        $path = $path . $name;

                    } else if ($settings['storage_setting'] == 'wasabi') {

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                        // $path = $path.$name;

                    } else if ($settings['storage_setting'] == 's3') {

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                    }


                    $res = [
                        'flag' => 1,
                        'msg' => 'success',
                        'url' => $path
                    ];
                    return $res;
                }

            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }


    public static function get_file($path)
    {
        $settings = Utility::getStorageSetting();

        try {
            if ($settings['storage_setting'] == 'wasabi') {
                config(
                    [
                        'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                        'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                        'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                        'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                        'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                    ]
                );
            } elseif ($settings['storage_setting'] == 's3') {
                config(
                    [
                        'filesystems.disks.s3.key' => $settings['s3_key'],
                        'filesystems.disks.s3.secret' => $settings['s3_secret'],
                        'filesystems.disks.s3.region' => $settings['s3_region'],
                        'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                        'filesystems.disks.s3.use_path_style_endpoint' => false,
                    ]
                );
            }

            return \Storage::disk($settings['storage_setting'])->url($path);
        } catch (\Throwable $th) {
            return '';
        }
    }


    public static function keyWiseUpload_file($request, $key_name, $name, $path, $data_name, $data_key, $custom_validation = [])
    {

        try {
            $settings = Utility::getStorageSetting();


            if (!empty($settings['storage_setting'])) {

                if ($settings['storage_setting'] == 'wasabi') {

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes = !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';

                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes = !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';


                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes = !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $file = $request->$key_name;


                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];

                }
                $validator = \Validator::make($request->file($data_name)[$data_key], [
                    $key_name => $validation
                ]);

                if ($validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    if ($settings['storage_setting'] == 'local') {

                        \Storage::disk()->putFileAs(
                            $path,
                            $request->file($data_name)[$data_key][$key_name],
                            $name
                        );


                        $path = $path . $name;
                    } else if ($settings['storage_setting'] == 'wasabi') {

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $request->file($data_name)[$data_key][$key_name],
                            $name
                        );

                        // $path = $path.$name;

                    } else if ($settings['storage_setting'] == 's3') {

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $request->file($data_name)[$data_key][$key_name],
                            $name
                        );

                    }


                    $res = [
                        'flag' => 1,
                        'msg' => 'success',
                        'url' => $path
                    ];
                    return $res;
                }

            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    //googleCalendar
    public static function colorCodeData($type)
    {
        if ($type == 'event') {
            return 1;
        } elseif ($type == 'zoom_meeting') {
            return 2;
        } elseif ($type == 'task') {
            return 3;
        } elseif ($type == 'appointment') {
            return 11;
        } elseif ($type == 'rotas') {
            return 3;
        } elseif ($type == 'holiday') {
            return 4;
        } elseif ($type == 'call') {
            return 10;
        } elseif ($type == 'meeting') {
            return 5;
        } elseif ($type == 'leave') {
            return 6;
        } elseif ($type == 'work_order') {
            return 7;
        } elseif ($type == 'lead') {
            return 7;
        } elseif ($type == 'deal') {
            return 8;
        } elseif ($type == 'interview_schedule') {
            return 9;
        } else {
            return 11;
        }
    }

    public static $colorCode = [
        1 => 'event-warning',
        2 => 'event-secondary',
        3 => 'event-success',
        4 => 'event-warning',
        5 => 'event-danger',
        6 => 'event-dark',
        7 => 'event-black',
        8 => 'event-info',
        9 => 'event-secondary',
        10 => 'event-success',
        11 => 'event-warning',
    ];

    public static function googleCalendarConfig()
    {
        $setting = Utility::settings();
        $path = storage_path($setting['google_calender_json_file']);
        config([
            'google-calendar.default_auth_profile' => 'service_account',
            'google-calendar.auth_profiles.service_account.credentials_json' => $path,
            'google-calendar.auth_profiles.oauth.credentials_json' => $path,
            'google-calendar.auth_profiles.oauth.token_json' => $path,
            'google-calendar.calendar_id' => isset($setting['google_calender_id']) ? $setting['google_calender_id'] : '',
            'google-calendar.user_to_impersonate' => '',

        ]);
    }
    public static function addCalendarData($request, $type)
    {
        self::googleCalendarConfig();

        $event = new GoogleEvent();
        $event->name = $request->get('title');
        $event->startDateTime = Carbon::parse($request->get('start_date'));
        $event->endDateTime = Carbon::parse($request->get('end_date'));
        $event->colorId = self::colorCodeData($type);

        $event->save();
    }
    public static function getCalendarData($type)
    {
        self::googleCalendarConfig();

        $data = GoogleEvent::get();

        $type = self::colorCodeData($type);
        $arrayJson = [];
        foreach ($data as $val) {
            $end_date = date_create($val->endDateTime);
            date_add($end_date, date_interval_create_from_date_string("1 days"));

            if ($val->colorId == "$type") {

                $arrayJson[] = [
                    "id" => $val->id,
                    "title" => $val->summary,
                    "start" => $val->startDateTime,
                    "end" => date_format($end_date, "Y-m-d H:i:s"),
                    "className" => self::$colorCode[$type],
                    "allDay" => true,
                ];
            }

        }
        return $arrayJson;
    }

    //Gallary Option
    public static function gallaryoption()
    {
        $gallaryOption = [
            'video' => 'Video',
            'image' => 'Image',
            'custom_image_link' => 'Custom Image',
            'custom_video_link' => 'Custom Video',
        ];
        return $gallaryOption;
    }

    //PixelField
    public static function pixel_plateforms()
    {
        $plateforms = [
            '' => 'Please select',
            'facebook' => 'Facebook',
            'twitter' => 'X',
            'linkedin' => 'Linkedin',
            'pinterest' => 'Pinterest',
            'quora' => 'Quora',
            'bing' => 'Bing',
            'google-adwords' => 'Google Adwords',
            'google-analytics' => 'Google Analytics',
            'snapchat' => 'Snapchat',
            'tiktok' => 'Tiktok',
        ];

        return $plateforms;
    }

    //WebHook
    public static function webhookSetting($module, $id)
    {
        if (\Auth::user()) {
            
            $webhook = Webhook::where('module', $module)->where('created_by', '=', $id)->first();
        } else {
            $webhook = Webhook::where('module', $module)->where('created_by', '=', $id)->first();
        }
        if (!empty($webhook)) {
            $url = $webhook->url;
            $method = $webhook->method;
            $reference_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $data['method'] = $method;
            $data['reference_url'] = $reference_url;
            $data['url'] = $url;
            return $data;
        }
        return false;

    }

    public static function WebhookCall($url = null, $parameter = null, $method = 'POST')
    {
        if (!empty($url) && !empty($parameter)) {
            try {
                $curlHandle = curl_init($url);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameter);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                $curlResponse = curl_exec($curlHandle);
                curl_close($curlHandle);
                if (empty($curlResponse)) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Throwable $th) {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function cookie_settings()
    {
        $data = DB::table('settings')->where('created_by', '=', 1)->get();
        $cookie_settings = [
            "enable_cookie" => "on",
            "default_language" => "en",
            "cookie_title" => "We use cookies!",
            "cookie_description" => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it.',
            "strictly_cookie_title" => "Strictly necessary cookies",
            "strictly_cookie_description" => "These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly",
            "contact_description" => "For any queries in relation to our policy on cookies and your choices,",
            'more_information_description' => 'For any queries in relation to our policy on cookies and your choices,please',
            'contactus_url' => '<a class="cc-link" href="#yourcontactpage">contact us</a>.',
        ];
        foreach ($data as $row) {
            if (array_key_exists($row->name, $cookie_settings)) {
                $cookie_settings[$row->name] = $row->value;
            }
        }
        return $cookie_settings;
    }

    public static function getsettingsbyid($id)
    {
        $data = DB::table('settings');
        $data->where('created_by', '=', $id);
        $data = $data->get();

        $settings = [
            "site_currency" => "USD",
            "site_currency_symbol" => "$",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INVO",
            "invoice_color" => "ffffff",
            "proposal_prefix" => "#PROP",
            "proposal_color" => "ffffff",
            "bill_prefix" => "#BILL",
            "bill_color" => "ffffff",
            "customer_prefix" => "#CUST",
            "vender_prefix" => "#VEND",
            "footer_title" => "",
            "footer_notes" => "",
            "invoice_template" => "template1",
            "bill_template" => "template1",
            "proposal_template" => "template1",
            "registration_number" => "",
            "vat_number" => "",
            "default_language" => "en",
            "enable_stripe" => "",
            "enable_paypal" => "",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "stripe_key" => "",
            "stripe_secret" => "",
            "decimal_number" => "2",
            "tax_type" => "",
            "shipping_display" => "on",
            "journal_prefix" => "#JUR",
            "display_landing_page" => "on",
            "title_text" => "Versecard",
            "company_logo" => 'logo-dark.png',
            "company_logo_light" => 'logo-light.png',
            "company_favicon" => 'favicon.png',
            "signup_button" => "on",
            "email_verification" => 'on',
            "color" => "theme-3",
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "SITE_RTL" => "",
            "storage_setting" => "local",
            "local_storage_validation" => "jpg,jpeg,png",
            "local_storage_max_upload_size" => "250000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url" => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
            "google_calender_id" => "",
            "google_calender_json_file" => "",
            "Google_Calendar" => "",
            'enable_cookie' => 'on',
            'necessary_cookies' => 'on',
            'cookie_logging' => 'on',
            'cookie_title' => 'We use cookies!',
            'cookie_description' => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it',
            'strictly_cookie_title' => 'Strictly necessary cookies',
            'strictly_cookie_description' => 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
            'more_information_description' => 'For any queries in relation to our policy on cookies and your choices,',
            'contactus_url' => '#',
            'chatgpt_key' => '',
            'enable_chatgpt' => '',
        ];

        foreach ($data as $row) {

            $settings[$row->name] = $row->value;

        }

        return $settings;
    }


    public static function flagOfCountry()
    {
        $arr = [
            'ar' => '🇦🇪 ar',
            'da' => '🇩🇰 da',
            'de' => '🇩🇪 de',
            'es' => '🇪🇸 es',
            'fr' => '🇫🇷 fr',
            'it' => '🇮🇹 it',
            'ja' => '🇯🇵 ja',
            'nl' => '🇳🇱 nl',
            'pl' => '🇵🇱 pl',
            'ru' => '🇷🇺 ru',
            'pt' => '🇵🇹 pt',
            'en' => '🇮🇳 en',
            'tr' => '🇹🇷 tr',
            'pt-br' => '🇵🇹 pt-br',
            'zh' => '🇨🇳 zh',
            'he' => '🇮🇱 he',

        ];
        return $arr;
    }

    public static function chatgpt_setting($company_id)
    {
        $data = DB::table('settings')->where('created_by', '=', $company_id)->get();
        $chatgpt_setting = [
            "chatgpt_key" => '',
            "enable_chatgpt" => '',
        ];
        foreach ($data as $row) {
            if (array_key_exists($row->name, $chatgpt_setting)) {
                $chatgpt_setting[$row->name] = $row->value;
            }
        }

        return $chatgpt_setting;
    }

    //Language Data 
    public static function languagecreate()
    {
        $languages = Utility::langList();
        foreach ($languages as $key => $lang) {
            $languageExist = Languages::where('code', $key)->first();
            if (empty($languageExist)) {
                $language = new Languages();
                $language->code = $key;
                $language->fullName = $lang;
                $language->save();
            }
        }
        return $languages;
    }

    public static function langSetting()
    {
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1)->get();
        if (count($data) == 0) {
            $data = DB::table('settings')->where('created_by', '=', 1)->get();
        }
        $settings = [];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }

    public static function langList()
    {
        $languages = [
            "ar" => "Arabic",
            "zh" => "Chinese",
            "da" => "Danish",
            "de" => "German",
            "en" => "English",
            "es" => "Spanish",
            "fr" => "French",
            "he" => "Hebrew",
            "it" => "Italian",
            "ja" => "Japanese",
            "nl" => "Dutch",
            "pl" => "Polish",
            "pt" => "Portuguese",
            "ru" => "Russian",
            "tr" => "Turkish",
            "pt-br" => "Portuguese(Brazil)",
        ];
        return $languages;
    }

}