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
        'role',
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

    static string $SUPERADMIN_ROLE = 'superadmin';
    static string $ADMIN_ROLE = 'admin';
    static string $GURU_ROLE = 'guru';
    static string $SISWA_ROLE = 'siswa';

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
        return $this->role === self::$SUPERADMIN_ROLE;
    }

    public function isSuperadminOrAdmin()
    {
        // return $this->role()->name === 'superadmin';
        return $this->role === self::$SUPERADMIN_ROLE || $this->role === self::$ADMIN_ROLE;
    }

    public function isTeacher()
    {
        // return $this->role()->name === 'guru';
        return $this->role === self::$GURU_ROLE;
    }

    public function isStudent()
    {
        // return $this->role()->name === 'siswa';
        return $this->role === self::$SISWA_ROLE;
    }
}
