<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'name',
        'email', 
        'password',
        'phone',
        'cedula',
        'birth_date',
        'city_id',
        'role'
    ];

    protected $hidden = ['password', 'remember_token'];
    
    protected $casts = [
        'birth_date' => 'date',
        'email_verified_at' => 'datetime',
    ];

    // Relaciones
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    // Accesores
    public function getAgeAttribute()
    {
        return $this->birth_date->age;
    }

    public function getFullLocationAttribute()
    {
        if ($this->city) {
            return "{$this->city->name}, {$this->city->state->name}, {$this->city->state->country->name}";
        }
        return 'No especificada';
    }

    // Scopes
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeRegularUsers($query)
    {
        return $query->where('role', 'user');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}