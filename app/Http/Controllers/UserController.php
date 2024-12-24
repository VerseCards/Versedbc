<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\PlanOrder;
use App\Mail\UserCreate;
use App\Models\Business;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;
use App\Models\NewuserLog;
use App\Models\LoginLog;
use Auth;
use File;
use App\Models\Utility;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;


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
			if($user->type == 'company'){
				
				$users = User::where('created_by', '!=', 0)->get();
				$users = $users ->reverse();
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
			$user  = \Auth::user();
            $default_language = \DB::table('settings')->select('value')->where('name', 'default_language')->first();
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'email' => 'required|email|unique:users',
					'mobile' => 'required|min:11',
					'designation' => 'required|string',
					'brief_bio' => 'required|string',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return back()->with('error', $messages->first());
            }
			$role = Role::findById($request->role);
			
			$secureUser = Business::count();
			if($secureUser >= 120)
            {
                return back()->with('success', __('User successfully created, pending approval'));
            }
			
			NewuserLog::create([
								'name' => $request->name,
								'email' => $request->email,
								'department' => $role->name,
								'designation' => $request->designation,
								'mobile' => $request->mobile,
								'bio' => $request->brief_bio,
								'role' => $role->id,
								'admin_name' => $user->name,
								'admin_id' => $user->id,
								'action' => 1, //1 = New user, 2= delete user
								'status' => 1, //1 = Pending, 2= Approved, 3 = Rejected
							]);
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'New User Request',
							]);

            return redirect()->route('users.index')->with('success', __('User successfully created, pending approval'));

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
			
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'New User Data Updated',
							]);


            return redirect()->route('users.index')->with('success', 'User successfully updated.'
            );
    }

    

    public function profile()
    {
		$user = \Auth::user();
		
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
		
		ActivityLog::create([
			'user_id' => Auth::id(),
			'initiated_by' => \Auth::user()->name,
			'remark' => 'Profile data updated',
		]);
		
		
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
		
		
            if($user)
            {

			NewuserLog::create([
								'name' => $user->name,
								'email' => $user->email,
								'department' => $user->type,
								'designation' => $user->designation,
								'admin_id' => $user->id,
								'admin_name' => \Auth::user()->name,
								'action' => 4, //1 = New user, 2= delete user 3 = Update user  4 = Reset Password
								'status' => 1, //1 = Pending, 2= Approved, 3 = Rejected
								'password_reset' => Hash::make($request->password),
							]);
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'Password Reset Request',
							]);
				

                return redirect()->route('users.index')->with('success', __('Awaiting Approval .'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
			
			/*
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();
		
		
		ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => \Auth::user()->name . ' '. 'changed the password of ' . $user->name,
							]);
        return redirect()->route('users.index')->with(
                     'success', 'User Password successfully updated.'
                 );
		*/
    }
/*
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
            $user->admin_status = 0;
			$user->type = 'M&CC';
            $user->save();
            return redirect()->back()->with('success', 'Admin Status Disabled Successfully.');
        } else {
            $user->type = 'company';
			$user->admin_status = 1;
            $user->save();
            return redirect()->back()->with('success', 'Admin Status Enabled Successfully.');
        }

    }
	*/
	public function allAdmins()
    {
        
        $user = \Auth::user();
			if($user->type == 'company' || $user->admin_status == 1){
				$users = User::where('admin_status', '=', 1)->get();
				$users = $users ->reverse();
			}else{
				return redirect()->back()->with('error', 'Permission Denied');
			}
            return view('user.index')->with('users', $users);

    }
	
	
	public function optimizeApp()
    {


        
		/*
		Schema::table('users', function (Blueprint $table) {
            $table->string('designation')->nullable();
        });

        return response()->json(['message' => 'Column added successfully']);
		
		Schema::create('pending_changes', function (Blueprint $table) {
				
			$table->bigIncrements('id');
			$table->integer('business_id')->nullable(); // Foreign key to the main resource
			$table->integer('user_id')->nullable(); // User who made the change
			$table->string('name')->nullable();
			$table->string('department')->nullable();
			$table->string('designation')->nullable();
			$table->string('bio',999)->nullable();
			$table->string('profile_picture')->nullable();
			$table->string('slug')->nullable();
			$table->string('secret_code')->nullable();
			$table->string('old_name')->nullable();
			$table->string('old_department')->nullable();
			$table->string('old_designation')->nullable();
			$table->string('old_bio',999)->nullable();
			$table->string('old_profile_picture')->nullable();
			$table->string('old_slug')->nullable();
			$table->string('old_secret_code')->nullable();
			$table->string('remark')->nullable();
			$table->integer('status')->nullable();
			$table->string('admin_id')->nullable();
			$table->string('admin_name')->nullable(); // Admin who requested change
			$table->timestamps();
			
		});	
			
		Schema::create('activity_logs', function (Blueprint $table) {
			$table->bigIncrements('id');	
			$table->string('initiated_by')->nullable(); // User who made the change
			$table->integer('user_id')->nullable();
			$table->string('remark')->nullable();
			$table->timestamps();
		});	
		Schema::table('visitor', function (Blueprint $table) {
            $table->integer('user_id')->nullable();
        });
			
		return response()->json(['message' => 'Column added successfully']);
		
		
		$getUser = User::where('email', 'admin@firstbank.com')->first();
		
		$getUser->name = 'Super Admin';
		$getUser->admin_status = '1';

		$getUser->save();
		
		$getUser1 = User::where('type', 'techsupport')->first();
		
		$getUser1->delete();
		
		
		Schema::create('newuser_logs', function (Blueprint $table) {
			$table->bigIncrements('id');	
			$table->string('name')->nullable(); // User who made the change
			$table->string('email')->nullable();
			$table->string('department')->nullable();
			$table->string('designation')->nullable();
			$table->string('bio',999)->nullable();
			$table->string('mobile')->nullable();
			$table->string('role')->nullable();
			$table->string('user_type')->nullable();
			$table->string('old_name')->nullable();
			$table->string('old_email')->nullable();
			$table->string('old_designation')->nullable();
			$table->string('old_department')->nullable();
			$table->string('admin_name')->nullable();
			$table->integer('admin_id')->nullable();
			$table->integer('action')->nullable();
			$table->integer('status')->nullable();
			$table->timestamps();
		});
		
		Schema::create('login_logs', function (Blueprint $table) {
			$table->bigIncrements('id');	
			$table->string('name')->nullable(); // User who made the change
			$table->string('email')->nullable();
			$table->integer('admin_id')->nullable();
			$table->string('admin_name')->nullable();
			$table->integer('login_status')->nullable();
			$table->timestamps();
		});
		
		
		
		Schema::table('newuser_logs', function (Blueprint $table) {
            $table->string('password_reset')->nullable();
        });

        return response()->json(['message' => 'Column added successfully']);
		
		Artisan::call('optimize:clear');
		//Artisan::call('route:cache');
		//Artisan::call('view:cache');
		
		*/
		

		//artisan optimize:clear
		//artisan route:cache
		//artisan view:cache
		
		Schema::table('users', function (Blueprint $table) {
            $table->timestamp('current_login')->nullable();
			$table->timestamp('last_login')->nullable();
        });
		
		return response()->json(['message' => 'Optimized successfully']);
		
		
    }
	
	
	
	public function approveNewUser(Request $request)
    {
		//dd($request->all());
			$user  = \Auth::user();
            
			$role = Role::findById($request->role);
			
			NewuserLog::create([
								'name' => $request->name,
								'email' => $request->email,
								'department' => $role->name,
								'designation' => $request->designation,
								'mobile' => $request->mobile,
								'bio' => $request->brief_bio,
								'role' => $request->role,
								'admin_name' => $user->name,
								'admin_id' => $user->id,
								'action' => 1, //1 = New user, 2= delete user
								'status' => 1, //1 = Pending, 2= Approved, 3 = Rejected
							]);
			
            $role = Role::findById($request->role);
            $user               = new User();
            $user['name']       = $request->name;
            $user['email']      = $request->email;
            //$psw                = $request->password;
            $user['password']   = \Hash::make('1a2b3c4d');
            $user['type']       = $role->name;  
            $user['lang']       = !empty($default_language) ? $default_language->value : 'en';
            $user['created_by'] = 1;
            
            $user->save();
            $user->assignRole($role);
			
			function getScode($length = 12)
			{
					$characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
					$charactersLength = strlen($characters);
					$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
					return $randomString;
			}
			
			
			//Create Business Card
			$slug = Utility::createSlug('businesses', $request->name);
			$secretCode = getScode();

            $card_theme = [];
            $card_theme['theme'] = 'theme12';
            $card_theme['order'] = Utility::getDefaultThemeOrder('theme12');

            $business = Business::create([
			
                'title' => $request->name,
                'slug' => $slug,
				'user_id' => $user->id,
				'sub_title' => $request->designation,
				'designation' => $role->name,
				'description' => $request->brief_bio,
                'branding_text' => 'FirstBank PLC' . ' ' . date("Y"),
                'card_theme' => json_encode($card_theme),
                'theme_color' => 'color1-theme12',
				'secret_code' => $secretCode ?? null, // Ensure $secretCode is defined,
                'created_by' => \Auth::user()->creatorId()
            ]);
            $business->enable_businesslink = 'on';
            $business->is_branding_enabled = 'on';
            $business->save();
			
            if (is_null($user->current_business)) {
				$user->current_business = $business->id;
				$user->save();
			}

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
			
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'New User & Business Card Created',
							]);
			
            return redirect()->route('users.index')->with('success', __('User successfully created.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));

    }
	
	
	public function pendingNewIUserApproval()
    {
			$user = \Auth::user();
			
			if($user->type != 'company' && $authUser->admin_status != 1){
				return redirect()->back()->with('error', 'Permission Denied');
			}
			
			if($user->name == 'Super Admin'){
				$pending= NewuserLog::orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->get(); //Remeber to order by pending
			return view('pending.userlog', compact('pending'));
			}else{
				$pending= NewuserLog::where('admin_id', $user->id)->orderBy('status', 'DESC')->orderBy('created_at', 'ASC')->get();
			return view('pending.userlog', compact('pending'));
			}

    }
	
	public function showUserPending($id)
    {
		
        $role = NewuserLog::where('id', '=', $id)->first();

        $user = \Auth::user();
        return view('pending.viewuser', compact('role'));
    }
	
	public function approveNewUserAdmin(Request $request, $id) //CID pending changes 'id'
    {

		$default_language = \DB::table('settings')->select('value')->where('name', 'default_language')->first();
		$user = Auth()->user();
		if($user->name != 'Super Admin'){
				return redirect()->back()->with('error', 'Permission Denied');
			}

		
		$userInfo = NewuserLog::find($id);
		
		if ($request->input('action') == 'approve') {
        
		
			//$user  = \Auth::user();
            
			$role = Role::findById($userInfo->role);
            $user               = new User();
            $user['name']       = $userInfo->name;
            $user['email']      = $userInfo->email;
			$user['designation']      = $userInfo->designation;
            //$psw                = $request->password;
            $user['password']   = \Hash::make('1a2b3c4d');
            $user['type']       = $role->name;  
            $user['lang']       = !empty($default_language) ? $default_language->value : 'en';
            $user['created_by'] = 1;
            
            $user->save();
            $user->assignRole($role);
			
			function getScode($length = 12)
			{
					$characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
					$charactersLength = strlen($characters);
					$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
					return $randomString;
			}
			
			
			//Create Business Card
			$slug = Utility::createSlug('businesses', $userInfo->name);
			$secretCode = getScode();

            $card_theme = [];
            $card_theme['theme'] = 'theme12';
            $card_theme['order'] = Utility::getDefaultThemeOrder('theme12');

            $business = Business::create([
			
                'title' => $userInfo->name,
                'slug' => $slug,
				'user_id' => $user->id,
				'sub_title' => $userInfo->designation,
				'designation' => $role->name,
				'description' => $userInfo->bio,
                'branding_text' => 'FirstBank PLC' . ' ' . date("Y"),
                'card_theme' => json_encode($card_theme),
                'theme_color' => 'color1-theme12',
				'secret_code' => $secretCode ?? null, // Ensure $secretCode is defined,
                'created_by' => \Auth::user()->creatorId()
            ]);
            $business->enable_businesslink = 'on';
            $business->is_branding_enabled = 'on';
            $business->save();
			
            if (is_null($user->current_business)) {
				$user->current_business = $business->id;
				$user->save();
			}

            $userArr=[
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_password' => '1a2b3x4d',
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
			
			$userInfo = NewuserLog::find($id);
			$userInfo->status = 2;
			$userInfo->save();
			
			
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'New User Approved',
							]);
							
							// Log the activity

			
            return redirect()->route('users.index')->with('success', __('User created successfully.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));
			
			
			
			

		   
			return redirect()->back()->with('success', __('Approved Successfully'));
		
		} elseif ($request->input('action') == 'reject') {
			
			$changes = NewuserLog::where('id', '=', $id)->first();
		
			$changes->status = 3;
			$changes->save();
			
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'New User Rejected',
							]);
			return redirect()->back()->with('success', __('Changes Rejected'));
		}
		
    }
	
	
	public function deleteUser($id)
    {
        
            $user = User::find($id);
            if($user)
            {

			NewuserLog::create([
								'name' => $user->name,
								'email' => $user->email,
								'department' => $user->type,
								'designation' => $user->designation,
								'admin_id' => $user->id,
								'admin_name' => \Auth::user()->name,
								'action' => 2, //1 = New user, 2= delete user
								'status' => 1, //1 = Pending, 2= Approved, 3 = Rejected
							]);
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'Delete User Request',
							]);
				

                return redirect()->route('users.index')->with('success', __('Awaiting Approval .'));
            }
            else
            {
                return redirect()->back()->with('error', __('User not found.'));
            }
    }

	public function destroy($id)
    {

            $userLog = NewuserLog::find($id);
			$user = User::where('email',$userLog->email)->first();
			
			
            if($user)
            {
				$activeUser = $user;
                    $user->delete();
					
					$userLog = NewuserLog::find($id);
					$userLog->status = 2;
					$userLog->save();
					
					ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'The user '.$activeUser->name .' '. 'was deleted',
							]);

                return redirect()->route('users.index')->with('success', __('User successfully deleted .'));
            }
            else
            {
                return redirect()->back()->with('error', __('User not found.'));
            }
    }
	
	
	public function deleteUserPending($id)
    {
		
        $role = NewuserLog::where('id', '=', $id)->first();
		//
		//dd($role);
        $user = \Auth::user();
        return view('pending.viewuser', compact('role'));
    }
	
	
	public function approveUserDelete(Request $request, $id) //ID pending changes 'id'
    {
		$userLog = NewuserLog::find($id);
		$user = User::where('email',$userLog->email)->first();
		
		$business = Business::where('user_id', $user->id)->first();
		
		if(\Auth()->user()->name != 'Super Admin'){
				return redirect()->back()->with('error', 'Permission Denied');
			}
		if ($request->input('action') == 'approve') {
		if($user)
            {
				$userLog->status = 2;
				$userLog->save();
				
				$activeUser = $user;
                $user->delete();
				
				if($business){
					$business->delete();
				}
				

					ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'The user '.$activeUser->name .' '. 'was deleted',
							]);

                return redirect()->route('users.index')->with('success', __('User successfully deleted .'));
            }
            else
            {
                return redirect()->back()->with('error', __('User not found'));
            }
		
		} elseif ($request->input('action') == 'reject') {
			
			$userLog = NewuserLog::find($id);
			$user = User::where('email',$userLog->email)->first();
		
			$userLog->status = 3;
			$userLog->save();
			
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'New User Rejected',
							]);
			return redirect()->back()->with('success', __('New User Rejected'));
		}
		
    }
	
	
	public function updateUser(Request $request, $id)
    {//dd($request->all());
        
            $user = User::findOrFail($id);
			$role = Role::findById($request->role);
            $validator = \Validator::make(
                $request->all(), [
                                    'name' => 'required|string|max:120',
                                    'email' => 'required|email|unique:users,email,' . $id,
                                    'role' => 'required',
									'designation' => 'required|string',
                                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
			
			//dd($request->all(),$user->name,$user->email,$user->designation, $role->name, $user->type);
			if ($request->filled('name') && $request->name !== $user->name) {
						$pendingData['old_name'] = $request->name;
					
			}
			if ($request->filled('email') && $request->email !== $user->email) {
						$pendingData['old_email'] = $request->email;
			}
			if ($request->filled('role') && $role->name !== $user->type) {
						$pendingData['old_department'] = $role->name;
			}
			if ($request->filled('designation') && $request->designation !== $user->designation) {
						$pendingData['old_designation'] = $request->designation;
			}
			
			if (!empty($pendingData)) {
				$pendingData['name'] = $user->name;
				$pendingData['email'] = $user->email;
				$pendingData['designation'] = $user->designation;
				$pendingData['department'] = $user->type;
				$pendingData['admin_name'] = \Auth::user()->name;
				$pendingData['admin_id'] = \Auth::user()->id;
				$pendingData['status'] = 1;
				$pendingData['action'] = 3;
				
				NewuserLog::create($pendingData);
				
			}
			/*
            NewuserLog::create([
								'name' => $user->name,
								'email' => $user->email,
								'department' => $user->type,
								'designation' => $user->designation,
								'admin_id' => $user->id,
								'admin_name' => \Auth::user()->name,
								'action' => 2, //1 = New user, 2= delete user, 3=Edit
								'status' => 1, //1 = Pending, 2= Approved, 3 = Rejected
							]);
			*/
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'User Update Request',
							]);


            return redirect()->route('users.index')->with('success', 'User Update Requested.'
            );
    }
	
	
	public function updateUserPending($id)
    {
		
        $role = NewuserLog::where('id', '=', $id)->first();
		//
		//dd($role);
        $user = \Auth::user();
        return view('pending.viewuser', compact('role'));
    }
	
	
	
	public function approveUserUpdate(Request $request, $id) //ID pending changes 'id'
    {
		//dd($request->all());
		$userLog = NewuserLog::find($id);
		$user = User::where('email',$userLog->email)->first();
		
		if(\Auth()->user()->name != 'Super Admin'){
				return redirect()->back()->with('error', 'Permission Denied');
			}
		if ($request->input('action') == 'approve') {
		if($user)
            {
				$userLog->status = 2;
				$userLog->save();
				
				if ($request->filled('old_name')) {
				$user->name = $request->old_name;
				}
				
				if ($request->filled('old_email')) {
					$user->email = $request->old_email;
				}

				if ($request->filled('old_designation')) {
					$user->designation = $request->old_designation;
				}
				
				if ($request->filled('old_department')) {
					$user->type = $request->old_department;
				}

				$user->save();
					
					
					ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'The user '. $user->name .' '. 'was updated',
							]);

                return redirect()->route('users.index')->with('success', __('User successfully updated .'));
            }
            else{
					return redirect()->back()->with('error', __('User not found'));
				}
		
		} elseif ($request->input('action') == 'reject') {
			
			$userLog = NewuserLog::find($id);
			$user = User::where('email',$userLog->email)->first();
		
			$userLog->status = 3;
			$userLog->save();
			
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'New Updated Rejected',
							]);
			return redirect()->back()->with('success', __('User Update Rejected'));
		}
		
    }
	
	
	public function disableUser($id)
    {
        
            $user = User::find($id);
            if($user)
            {

			NewuserLog::create([
								'name' => $user->name,
								'email' => $user->email,
								'department' => $user->type,
								'designation' => $user->designation,
								'admin_id' => $user->id,
								'admin_name' => \Auth::user()->name,
								'action' => 2, //1 = New user, 2= delete user
								'status' => 1, //1 = Pending, 2= Approved, 3 = Rejected
							]);
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'Delete User Request',
							]);
				

                return redirect()->route('users.index')->with('success', __('Awaiting Approval .'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
    }
	
	
	
	
	public function approvePasswordReset(Request $request, $id) //ID pending changes 'id'
    {
		$userLog = NewuserLog::find($id);
		$user = User::where('email',$userLog->email)->first();
		

		if ($request->input('action') == 'approve') {
			if(\Auth()->user()->name != 'Super Admin'){
				return redirect()->back()->with('error', 'Permission Denied');
			}
			if($user)
				{
					$user->password = $userLog->password_reset;
					$user->save();
			
					$userLog->status = 2;
					$userLog->password_reset = NULL;
					$userLog->save();
					

					ActivityLog::create([
									'user_id' => Auth::id(),
									'initiated_by' => \Auth::user()->name,
									'remark' => \Auth::user()->name . ' '. 'changed the password of ' . $user->name,
								]);
					return back()->with(
						 'success', 'User Password successfully updated.'
					 );

				}else{
					return redirect()->back()->with('error', __('User not found'));
				}
		
		} elseif ($request->input('action') == 'reject') {
			
			$userLog = NewuserLog::find($id);
			$user = User::where('email',$userLog->email)->first();
		
			$userLog->status = 3;
			$userLog->save();
			
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'Password Reset Rejected',
							]);
			return redirect()->back()->with('success', __('Password Reset Rejected'));
		}
		
    }
	
	
	public function LoginManage($id)
    {
        $eId = \Crypt::decrypt($id);
        $user = User::find($eId);

           if($user)
            {
				if($user->is_enable_login == 1){
					$userStatus = 6;
				}else{
					$userStatus = 5;
				}
			NewuserLog::create([
								'name' => $user->name,
								'email' => $user->email,
								'department' => $user->type,
								'designation' => $user->designation,
								'admin_id' => $user->id,
								'admin_name' => \Auth::user()->name,
								'action' => $userStatus, //1 = New user, 2= delete user 3 = Update user  4 = Reset Password 5 = Login Enable 6 = Login Disabled
								'status' => 1, //1 = Pending, 2= Approved, 3 = Rejected
								
							]);
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'Account Access',
							]);
				

                return back()->with('success', __('Awaiting Approval .'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }

    }
	
	
	
		public function approveLoginStatus(Request $request, $id) //ID pending changes 'id'
    {
		$userLog = NewuserLog::find($id);
		$user = User::where('email',$userLog->email)->first();

		if ($request->input('action') == 'approve') {
			if(\Auth()->user()->name != 'Super Admin'){
				return redirect()->back()->with('error', 'Permission Denied');
			}
			if($user)
				{
					if ($user->is_enable_login == 1) {
						$user->is_enable_login = 0;
						$user->save();
						
						$userLog->status = 2;
						$userLog->save();
						
						ActivityLog::create([
									'user_id' => Auth::id(),
									'initiated_by' => \Auth::user()->name,
									'remark' => \Auth::user()->name . ' '. 'disabled ' . $user->name . ' account',
								]);
						return back()->with('success', 'User account disabled successfully.');
					} else {
						$user->is_enable_login = 1;
						$user->save();
						
						ActivityLog::create([
									'user_id' => Auth::id(),
									'initiated_by' => \Auth::user()->name,
									'remark' => \Auth::user()->name . ' '. 'enabled ' . $user->name . ' account',
								]);
					return back()->with('success', 'User account enabled successfully.');
					}
				}
				else{
					return redirect()->back()->with('error', __('User not found'));
				}
		
		} elseif ($request->input('action') == 'reject') {
			
			$userLog = NewuserLog::find($id);
			$user = User::where('email',$userLog->email)->first();
		
			$userLog->status = 3;
			$userLog->save();
			
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'Password Reset Rejected',
							]);
			return redirect()->back()->with('success', __('Password Reset Rejected'));
		}
		
		    // Handle any other cases where the 'action' is not 'approve' or 'reject'
			return redirect()->back()->with('error', 'Invalid Action.');
		
    }
	
	/*
	public function makeAdmin($id)
    {
		
        $eId = \Crypt::decrypt($id);
        $user = User::find($eId);
        if ($user->type == 'company') {
            $user->admin_status = 0;
			$user->type = 'M&CC';
            $user->save();
            return redirect()->back()->with('success', 'Admin Status Disabled Successfully.');
        } else {
            $user->type = 'company';
			$user->admin_status = 1;
            $user->save();
            return redirect()->back()->with('success', 'Admin Status Enabled Successfully.');
        }

    }
	*/
	
	public function makeAdmin($id)
    {
        $eId = \Crypt::decrypt($id);
        $user = User::find($eId);

           if($user)
            {
				if($user->type == 'company'){
					$adminStatus = 8;
				}else{
					$adminStatus = 7;
				}
			NewuserLog::create([
								'name' => $user->name,
								'email' => $user->email,
								'department' => $user->type,
								'designation' => $user->designation,
								'admin_id' => $user->id,
								'admin_name' => \Auth::user()->name,
								'action' => $adminStatus, //1 = New user, 2= delete user 3 = Update user  4 = Reset Password 5 = Login Enable 6 = Login Disabled 7 = Enable Admin  8 = Disable Admin
								'status' => 1, //1 = Pending, 2= Approved, 3 = Rejected
								
							]);
			ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'Maker Admin Request',
							]);
				

                return back()->with('success', __('Awaiting Approval .'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }

    }
	
	
	public function approveMakerAdmin(Request $request, $id) // ID pending changes 'id'
{
    $userLog = NewuserLog::find($id);
    $user = User::where('email', $userLog->email)->first();

    if ($request->input('action') == 'approve') {
        if (\Auth()->user()->name != 'Super Admin') {
            return redirect()->back()->with('error', 'Permission Denied');
        }

        if ($user) {
            if ($user->type == 'company') {
                $user->admin_status = 0;
                $user->type = 'M&CC';
                $user->save();

                $userLog->status = 2;
                $userLog->save();

                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'initiated_by' => \Auth::user()->name,
                    'remark' => \Auth::user()->name . ' disabled ' . $user->name . ' as a Maker Admin',
                ]);

                return redirect()->back()->with('success', 'Admin Status Disabled Successfully.');
            } else {
                $user->type = 'company';
                $user->admin_status = 1;
                $user->save();

                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'initiated_by' => \Auth::user()->name,
                    'remark' => \Auth::user()->name . ' enabled ' . $user->name . ' as a Maker Admin',
                ]);

                return redirect()->back()->with('success', 'Admin Status Enabled Successfully.');
            }
        }else{
					return redirect()->back()->with('error', __('User not found'));
				}
    } elseif ($request->input('action') == 'reject') {
        $userLog = NewuserLog::find($id);
        $user = User::where('email', $userLog->email)->first();

        $userLog->status = 3;
        $userLog->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'initiated_by' => \Auth::user()->name,
            'remark' => 'Maker Admin Request Rejected',
        ]);

        return redirect()->back()->with('success', __('Maker Admin Rejected Successfully'));
    }


}


}

/*
if ($request->filled('reset_code') && $request->reset_code !== $business->secret_code) {
						$pendingData['secret_code'] = $request->reset_code;
					}

					// If there are changes, create the pending change record
					if (!empty($pendingData)) {
						$pendingData['user_id'] = $business->user_id;
						$pendingData['business_id'] = $business->id;
						
						$pendingData['old_name'] = $business->title??'';
						$pendingData['old_slug'] = $business->slug??'';
						$pendingData['old_designation'] = $business->sub_title??'';
						$pendingData['old_department'] = $business->designation??'';
						$pendingData['old_bio'] = $business->description??'';
						$pendingData['old_secret_code'] = $business->secret_code??'';
						$pendingData['remark'] = 'Business Card Biodata Changes';
						$pendingData['admin_name'] = \Auth::user()->name;
						$pendingData['admin_id'] = \Auth::user()->id;
						$pendingData['status'] = 1; //Pending

						PendingChange::create($pendingData);
						
						if(\Auth::user()->type == 'company'){
							ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'Request for approval',
							]);
						}else{
							ActivityLog::create([
								'user_id' => Auth::id(),
								'initiated_by' => \Auth::user()->name,
								'remark' => 'Details Updated',
							]);
						}
					*/