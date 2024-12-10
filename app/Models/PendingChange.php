<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingChange extends Model
{
	use HasFactory;
    protected $fillable = [
        'slug',
		'business_id',
		'user_id',
        'name', //name
        'designation',
        'department',
        'bio', //Description
		'secret_code',
        'profile_picture',
        'links',
		'status',
		'admin_name',
		'admin_id',
        'meta_image',
        'created_by',
		'old_slug',
        'old_name', //name
        'old_designation',
        'old_department',
        'old_bio', //Description
		'old_secret_code',
        'old_profile_picture',
		'remark'
    ];


}
