<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginLog extends Model
{
	use HasFactory;
    protected $fillable = [
		'name',
		'email',
        'admin_id',
		'admin_name',
		'login_status',
    ];
	
}
