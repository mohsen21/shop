<?php

namespace Modules\Auth\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Modules\Appointment\Models\Appointment;
use Modules\Doctor\Models\Degree;
use Modules\Doctor\Models\Timing;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable ,HasRoles,SoftDeletes;

    protected $table = 'users';
    protected $softDelete = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'gender',
        'mobile_verify',
        'dossier_number',
        'birthday',
        'age',
        'height',
        'weight',
        'address',
        'degree_id',
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
    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes["password"]=Hash::make($value);
    }
    public function times()
    {
        return $this->hasMany(Timing::class,"user_id");
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function findForPassport($username)
    {
        return $this->where('mobile', $username)->first();
    }
    public function specializations()
    {
        return $this->belongsToMany(User::class,"rel_specialization_doctor","user_id","specialization_id");
    }
}
