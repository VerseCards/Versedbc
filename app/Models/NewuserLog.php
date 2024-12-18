<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewuserLog extends Model
{
	use HasFactory;
    protected $fillable = [
		'name',
		'email',
        'department',
		'designation',
		'bio',
		'mobile',
		'role',
		'admin_name',
		'admin_id',
		'action',
		'status',
		'old_name',
		'old_email',
        'old_department',
		'old_designation',
		'password_reset',
    ];
	
}
