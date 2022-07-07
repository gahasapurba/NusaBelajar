<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkout extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'buyer_users_id',
        'course_courses_id',
        'discount_discounts_id',
        'discount_percentage',
        'payment_status',
        'midtrans_url',
        'midtrans_booking_code',
        'total',
    ];

    public function checkout_creator()
    {
        return $this->belongsTo(User::class, 'buyer_users_id')->withTrashed();
    }

    public function checkout_paid_course()
    {
        return $this->belongsTo(User::class, 'course_courses_id')->withTrashed();
    }

    public function checkout_used_discount()
    {
        return $this->belongsTo(User::class, 'discount_discounts_id')->withTrashed();
    }
}
