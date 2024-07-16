<?php

namespace App\Http\Controllers;

use App\Models\User;
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
				
        return redirect()->route('dashboard')->with('success', 'You are now logged in as ' . $userToImpersonate->name);
			
        
    }
	
	private function getAdminUser(){
		
		$adminUserId = session()->pull('adminUser');
		$adminLoggedUser = User::find($adminUserId);
		return $adminLoggedUser;
	}

    public function stop()
    {
		//dd('here');
        $adminUser = session()->pull('impersonate');
		Auth::logout();
		Auth::login($this->getAdminUser());
        return redirect()->route('dashboard')->with('success', 'Logged out as user successfully.');
 
    }
}

