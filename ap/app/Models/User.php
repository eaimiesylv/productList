<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Support\Str;
use App\Traits\SetCreatedBy;
use Auth;

class User extends Authenticatable
{
    use SetCreatedBy, HasUuids, HasApiTokens, HasFactory, Notifiable;

   

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'company_name',
        'contact_person',
        'last_name',
        'middle_name',
        'phone_number',
        'type_id',
        'organization_id',
        'organization_code',
        'email',
        'role_id',
        'dob',
        'password',
        'token'
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
        'password' => 'hashed',
    ];
    // public function getTypeIdAttribute($value)
    // {
        
    //     switch ($value) {
        
    //         case 0:
    //             return 'customer';
    //         case 1:
    //             return 'supplier';
    //         case 2:
    //             return 'company';
    //         default:
    //             return 'customer'; 
    //     }
    // }
  














}
