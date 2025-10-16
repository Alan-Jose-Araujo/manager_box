<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'fantasy_name',
        'corporate_name',
        'cnpj',
        'state_registration',
        'logo_picture_path',
        'phone_number',
        'landline_number',
        'contact_email',
        'website_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    # Relationships.

    // It returns the company admin.
    public function admin(): User
    {
        return User::role('company_admin')->where('company_id', $this->id)->first();
    }

    // It returns all employees except the company admin.
    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'company_id')->whereHas('roles', function ($query) {
            $query->where('name', '!=', 'company_admin');
        });
    }

    public function generalUsers(): HasMany
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class, 'company_id');
    }

    public function itemsInStock(): HasMany
    {
        return $this->hasMany(ItemInStock::class, 'company_id');
    }

    public function itemInStockCategories(): HasMany
    {
        return $this->hasMany(ItemInStockCategory::class, 'company_id');
    }
}
