<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_number',
        'address',
        'email',
        'password',
        'avatar',
        'is_admin',
        'is_mentor',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $cascadeDeletes = [
        'user_created_mentor_verifications',
        'user_received_notifications',
        'user_created_messages',
        'user_received_messages',
        'user_created_articles',
        'user_created_article_comments',
        'user_created_discussions',
        'user_created_discussion_answers',
        'user_created_events',
        'user_created_courses',
        'user_created_course_members',
        'user_created_course_exam_answers',
        'user_received_course_certificates',
        'user_created_course_reviews',
        'user_created_checkouts',
    ];

    public function user_created_mentor_verifications()
    {
        return $this->hasMany(MentorVerification::class, 'sender_users_id');
    }

    public function user_received_notifications()
    {
        return $this->hasMany(Notification::class, 'receiver_users_id');
    }

    public function user_created_messages()
    {
        return $this->hasMany(Message::class, 'sender_users_id');
    }

    public function user_received_messages()
    {
        return $this->hasMany(Message::class, 'receiver_users_id');
    }

    public function user_created_articles()
    {
        return $this->hasMany(Article::class, 'author_users_id');
    }

    public function user_created_article_comments()
    {
        return $this->hasMany(ArticleComment::class, 'sender_users_id');
    }

    public function user_created_discussions()
    {
        return $this->hasMany(Discussion::class, 'sender_users_id');
    }

    public function user_created_discussion_answers()
    {
        return $this->hasMany(DiscussionAnswer::class, 'sender_users_id');
    }

    public function user_created_events()
    {
        return $this->hasMany(Event::class, 'organizer_users_id');
    }

    public function user_created_courses()
    {
        return $this->hasMany(Course::class, 'mentor_users_id');
    }

    public function user_created_course_members()
    {
        return $this->hasMany(CourseMember::class, 'member_users_id');
    }

    public function user_created_course_exam_answers()
    {
        return $this->hasMany(CourseExamAnswer::class, 'sender_users_id');
    }

    public function user_received_course_certificates()
    {
        return $this->hasMany(CourseCertificate::class, 'receiver_users_id');
    }

    public function user_created_course_reviews()
    {
        return $this->hasMany(CourseReview::class, 'sender_users_id');
    }

    public function user_created_checkouts()
    {
        return $this->hasMany(Checkout::class, 'buyer_users_id');
    }
}