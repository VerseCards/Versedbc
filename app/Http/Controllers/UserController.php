<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\PlanOrder;
use App\Mail\UserCreate;
use Illuminate\Support\Facades\Hash;
use Auth;
use File;
use App\Models\Utility;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('impersonate');
	}
	
	
	
    public function index()
    {
       
            $user = \Auth::user();
			if($user->type == 'company' || \Auth::user()->type == 'techsupport'){
				
				$users = User::where('created_by', '!=', 0)->get();
			}elseif($user->type == 'techsupport'){
				$users = User::get();
			}elseif(session()->has('impersonate')){
				$users = User::where('created_by', '!=', 0)->get();
			}else{
				return redirect()->back()->with('error', 'Permission Denied');
			}
            return view('user.index')->with('users', $users);
			
			if (session()->has('impersonate')) {
    // The user is being impersonated
}
        
    }


    public function create()
    {
        $user  = \Auth::user();
        $roles = Role::where('created_by', '=', 1)->get()->pluck('name', 'id');
        return view('user.create', compact('roles'));
        
    }

    public function store(Request $request)
    {
        
            $default_language = \DB::table('settings')->select('value')->where('name', 'default_language')->first();
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $role = Role::findById($request->role);
            $user               = new User();
            $user['name']       = $request->name;
            $user['email']      = $request->email;
            $psw                = $request->password;
            $user['password']   = \Hash::make($request->password);
            $user['type']       = $role->name;  
            $user['lang']       = !empty($default_language) ? $default_language->value : 'en';
            $user['created_by'] = 1;
            
            $user->save();
            $user->password = $psw;
            $user->assignRole($role);

            $userArr=[
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_password' => $request->password,
                'user_type' => $user->type,
                'created_by' => $user->created_by,
            ];

            try
            {
                $resp = \Utility::sendEmailTemplate('User Created',$userArr,$user->email);
                
                // \Mail::to($user->email)->send(new UserCreate($user));
            }
            catch(\Exception $e)
            {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }
            $module ='New User';
            $webhook=  Utility::webhookSetting($module,\Auth::user()->creatorId());
            
            if($webhook)
            {
                $parameter = json_encode($user);
               
                // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
                $status = Utility::WebhookCall($webhook['url'],$parameter,$webhook['method']);
                if($status == true)
                {
                    return redirect()->back()->with('success', __('User successfully created!'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Webhook call failed.'));
                }
            }
            return redirect()->route('users.index')->with('success', __('User successfully added.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));

    }

    public function edit($id)
    {
        
        $user  = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');    
        $user = User::findOrFail($id);
        return view('user.edit', compact('user', 'roles'));
    }


    public function update(Request $request, $id)
    {
        
            $user = User::findOrFail($id);
            $validator = \Validator::make(
                $request->all(), [
                                    'name' => 'required|max:120',
                                    'email' => 'required|email|unique:users,email,' . $id,
                                    'role' => 'required',
                                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $role          = Role::findById($request->role);
            $input = $request->all();
            $input['type'] = $role->name;
            $user->fill($input)->save();

            $roles[] = $request->role;
            $user->roles()->sync($roles);


            return redirect()->route('users.index')->with('success', 'User successfully updated.'
            );
    }

    public function destroy($id)
    {
        
            $user = User::find($id);
            if($user)
            {
                    $user->delete();

                return redirect()->route('users.index')->with('success', __('User successfully deleted .'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
    }

    public function profile()
    {
        $userDetail              = \Auth::user();
        return view('user.profile', compact('userDetail'));
    }

    public function editprofile(Request $request)
    {
        $userDetail = \Auth::user();
        $user       = User::findOrFail($userDetail['id']);
        $this->validate(
            $request, [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users,email,' . $userDetail['id'],
                    ]
        );
        if($request->hasFile('profile'))
        {
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $settings = Utility::getStorageSetting();

            if($settings['storage_setting']=='local'){
                $dir        = 'uploads/avatar/';
            }
            else{
                    $dir        = 'uploads/avatar';
            }

            $image_path = $dir . $userDetail['avatar'];
            if(File::exists($image_path))
            {
                File::delete($image_path);
            }

            $path = Utility::upload_file($request,'profile',$fileNameToStore,$dir,[]);
            if($path['flag'] == 1){
                $url = $path['url'];
            }else{
                return redirect()->route('profile', \Auth::user()->id)->with('error', __($path['msg']));
            }

        }
        if(!empty($request->profile))
        {
            $user['avatar'] = $fileNameToStore;
        }
        $user['name']  = $request['name'];
        $user['email'] = $request['email'];
        $user->save();

        return redirect()->back()->with(
            'success', 'Profile successfully updated.'
        );
    }

     public function updatePassword(Request $request)
    {

        if(Auth::Check())
        {
            $request->validate(
                [
                    'current_password' => 'required',
                    'new_password' => 'required|same:new_password',
                    'confirm_password' => 'required|same:new_password',
                ]
            );
            $objUser          = Auth::user();
            $request_data     = $request->All();
            $current_password = $objUser->password;

            if(Hash::check($request_data['current_password'], $current_password))
            {
                $user_id            = Auth::User()->id;
                $obj_user           = User::find($user_id);
                $obj_user->password = Hash::make($request_data['new_password']);;
                $obj_user->save();

                return redirect()->route('profile')->with('success', __('Password Updated Successfully!'));
            }
            else
            {
                return redirect()->route('profile')->with('error', __('Please Enter Correct Current Password!'));
            }
        }
        else
        {
            return redirect()->route('profile')->with('error', __('Something is wrong!'));
        }
    }

    public function changeLanquage($lang)
    {
        $user       = Auth::user();
        $user->lang = $lang;
        if($lang == 'ar' || $lang == 'he'){
            $setting = Utility::settings();
            $arrSetting['SITE_RTL'] = 'on';
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            foreach ($arrSetting as $key => $val) {
                \DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                    [
                        $val,
                        $key,
                        \Auth::user()->creatorId(),
                        $created_at,
                        $updated_at,
                    ]
                );
            }
        }
        else{
            $arrSetting['SITE_RTL'] = 'off';
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            foreach ($arrSetting as $key => $val) {
                \DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                    [
                        $val,
                        $key,
                        \Auth::user()->creatorId(),
                        $created_at,
                        $updated_at,
                    ]
                );
            }
        }
        $user->save();
        return redirect()->back()->with('success', __('Language Change Successfully!'));
    }

    public function userPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::where('id',$eId)->first();
        return view('user.reset', compact('user'));
    }
    public function userPasswordReset(Request $request, $id){
        $validator = \Validator::make(
            $request->all(), [
                               'password' => 'required|confirmed|same:password_confirmation',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $user                 = User::where('id', $id)->first();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();
        return redirect()->route('users.index')->with(
                     'success', 'User Password successfully updated.'
                 );
    }

    public function LoginManage($id)
    {
        $eId = \Crypt::decrypt($id);
        $user = User::find($eId);
        if ($user->is_enable_login == 1) {
            $user->is_enable_login = 0;
            $user->save();
            return redirect()->route('users.index')->with('success', 'User account disabled successfully.');
        } else {
            $user->is_enable_login = 1;
            $user->save();
            return redirect()->route('users.index')->with('success', 'User account enabled successfully.');
        }

    }
	
	public function makeAdmin($id)
    {
        $eId = \Crypt::decrypt($id);
        $user = User::find($eId);
        if ($user->type == 'company') {
            $user->type = 'MCC';
            $user->save();
            return redirect()->route('users.index')->with('success', 'Admin Status Disabled Successfully.');
        } else {
            $user->type = 'company';
            $user->save();
            return redirect()->route('users.index')->with('success', 'Admin Status Enabled Successfully.');
        }

    }

}
