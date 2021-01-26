<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;


    /** @var string  */
    protected $table = 'users';

    /** @var string  */
    protected $connection = "cassoviacode_interview_22_01_2021";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meno',
        'email',
        'password',
        'rola',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** @var array  */
    protected $dates = [
        'created_at', 'update_at', 'deleted_at'
    ];


    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getVytvorenyAttribute()
    {
        return "{$this->created_at->format('Y-m-d H:i:s')} ";
    }


    /**
     * Test, ci je prihlaseny uzivatel Administrator
     *
     */
    public function jeAdministrator() {
        if ($this->rola === 'admin') {
            return true;
        } else {
            return false;
        }
    }

}
