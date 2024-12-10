<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ImpersonateController extends Controller
{
	
	

    public function start($id)
    {
        $userToImpersonate = User::findOrFail($id);
		$adminUser = Auth::user();

			session(['impersonate' => $userToImpersonate->id]);
			session(['adminUser' => $adminUser->id]);
			
			ActivityLog::create([
				'user_id' => Auth::id(),
				'initiated_by' => \Auth::user()->name,
				'remark' => \Auth::user()->name . ' '.'logged into' .' '. $userToImpersonate->name,
			]);
				
        return redirect()->route('dashboard')->with('success', 'You are now logged in as ' . $userToImpersonate->name);
			
        
    }
	
	private function getAdminUser(){
		
		$adminUserId = session()->pull('adminUser');
		$adminLoggedUser = User::find($adminUserId);
		return $adminLoggedUser;
	}

    public function stop()
{
    // Get the admin user ID from the session
    $adminUser = $this->getAdminUser();
    $impersonatedUserId = session()->pull('impersonate');

    // Log the activity if admin user is found
    if ($adminUser) {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'initiated_by' => $adminUser->name,
            'remark' => $adminUser->name . ' logged out of ' . Auth::user()->name,
        ]);

        // Logout the impersonated user and login the admin again
        Auth::logout();
        Auth::login($adminUser);

        return redirect()->route('dashboard')->with('success', 'Logged out as user successfully.');
    } else {
        // Handle the case where the admin user could not be retrieved
        return redirect()->route('dashboard')->with('error', 'Admin user not found. Unable to complete the logout process.');
    }
}

}

