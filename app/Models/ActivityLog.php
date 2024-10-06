<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
	use HasFactory;
    protected $fillable = [
		'initiated_by',
		'user_id',
        'remark',
    ];


}
