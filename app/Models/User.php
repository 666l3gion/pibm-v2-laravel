<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'role_id',
        'username',
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

    public function isSuperadmin()
    {
        // return $this->role()->name === 'superadmin';
        return $this->role_id === 1;
    }

    public function isTeacher()
    {
        // return $this->role()->name === 'guru';
        return $this->role_id === 2;
    }

    public function isStudent()
    {
        // return $this->role()->name === 'siswa';
        return $this->role_id === 3;
    }

    public function isSuperadminOrAdmin(): bool
    {
        return ($this->isSuperadmin() || $this->isAdmin());
        // return in_array($this->role, ['superadmin', 'admin']);
    }

    public function role()
    {
        // return $this->hasOne(Role::class, 'id', 'role_id');
        return $this->belongsTo(Role::class);
    }
}
