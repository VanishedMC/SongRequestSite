<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function fetchRequests() {
        $requests = $this->hasMany(SongRequest::class)->where('fetched', false)->get();
        
        $res = [];

        foreach($requests as $request) {
            $request->fetched = true;
            $request->save();
            $res[] = json_decode($request->song);
        }

        return $res;
    }

    public function getAllRequests() {
        return $this->hasMany(SongRequest::class)->get();
    }
}
