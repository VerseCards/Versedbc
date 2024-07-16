<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'slug',
		'user_id',
        'title',
        'designation',
        'sub_title',
        'description',
		'secret_code',
        'branding_text',
        'banner',
        'logo',
        'card_theme',
        'theme_color',
        'links',
        'meta_keyword',
        'meta_description',
        'meta_image',
        'domains',
        'enable_businesslink',
        'subdomain',
        'enable_domain',
        'created_by'

    ];

    public function getLanguage(){
        if (\Auth::user()->type == 'company')
        {
            $user = User::find($this->created_by);
        }
        else{
            $user = User::where('created_by','=',$this->created_by)->first();
        }
        
        return $user->currentLanguage();
    }

    public static function pwa_business($slug){

        $business = Business::where('slug', $slug)->first();
        try {

            $pwa_data = \File::get(storage_path('uploads/theme_app/business_' . $business->id. '/manifest.json'));

            $pwa_data = json_decode($pwa_data);
        } catch (\Throwable $th) {
            $pwa_data = [];
        }
        return $pwa_data;

    }

    public static function allBusiness()
    {        
        $business =  Business::where('created_by', \Auth::user()->creatorId())->get()->pluck('title', 'id');
        
        if(request()->route()->getName()=='appointments.index' || request()->route()->getName()=='contacts.index')
        {
            $business->prepend('All', '0');
        }
        
        return $business;
    }

    public static function card_cookie($slug)
    {
        $data = Business::where('slug', '=', $slug)->first();
        return $data->gdpr_text;
    }

    public static $qr_type = [
        0 => 'Normal',
        2 => 'Text',
        4 =>'Image',
    ];

}
