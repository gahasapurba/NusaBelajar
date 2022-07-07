<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MentorVerification extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'sender_users_id',
        'profile_summary',
        'id_card',
        'selfie_with_id_card',
        'resume',
        'whatsapp_number',
        'facebook_profile_link',
        'instagram_profile_link',
        'linkedin_profile_link',
        'bank_account_number',
        'bank_account_name',
        'bank_name',
        'is_accepted',
        'is_rejected',
    ];

    public function mentor_verification_creator()
    {
        return $this->belongsTo(User::class, 'sender_users_id')->withTrashed();
    }
}
