<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_id',
		'user_id',
        'name',
		'campaign_title',
		'campaign_id',
        'email',
        'phone',
        'message',
        'created_by'
    ];
}
