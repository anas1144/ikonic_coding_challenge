<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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



    public function requestsTo()
    {
        return $this->belongsToMany(User::class, 'requests', 'user_id', 'request_id')
            ->withPivot('accepted')
            ->withTimestamps();
    }

    public function requestsFrom()
    {
        return $this->belongsToMany(User::class, 'requests', 'request_id', 'user_id')
            ->withPivot('accepted')
            ->withTimestamps();
    }

    public function pendingRequestsTo()
    {
        return $this->requestsTo()->wherePivot('accepted', 0);
    }

    public function pendingRequestsFrom()
    {
        return $this->requestsFrom()->wherePivot('accepted', 0);
    }

    public function acceptedRequestsTo()
    {
        return $this->requestsTo()->wherePivot('accepted', 1);
    }

    public function acceptedRequestsFrom()
    {
        return $this->requestsFrom()->wherePivot('accepted', 1);
    }

    public function Connections()
    {
        return static::whereIn('id', function ($q) {
            $q->select('request_id')
                ->from('requests')
                ->where('user_id', $this->id)
                ->where('accepted',1);
        })->whereIn('id', function ($q)  {
            $q->select('user_id')
                ->from('requests')
                ->where('request_id', $this->id)
                ->where('accepted',1);
        })->where('id', '!=', $this->id);
    }

    public function getConnectionInCommonAttribute()
    {
        return static::whereIn('id', Auth::user()->connections()->pluck('id'))
            ->whereIn('id',$this->connections()->pluck('id'));
    }
}
