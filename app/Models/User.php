<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string|class-string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
    
        $nameParts = explode(' ', $this->name);
    
        $initial = count($nameParts) === 1
            ? substr($nameParts[0], 0, 1)
            : substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1);
    
        return Avatar::create(strtoupper($initial))->toBase64();
    }
}
