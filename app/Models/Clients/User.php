<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Clients\Address;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'cpf', 'profile_picture',
        'phone_number', 'birth_date', 'is_active', 'company_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

       public function addresses() {
        return $this->morphMany(Address::class, 'addressable');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
