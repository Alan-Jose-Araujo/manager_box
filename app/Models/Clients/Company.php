<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Stocks\Warehouse;
use App\Models\Clients\User;
use App\Models\Clients\Address;
use App\Models\Stocks\ItemInStockCategory;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fantasy_name', 'corporate_name', 'cnpj', 'state_registration',
        'logo_picture', 'phone_number', 'landline_number', 'contact_email',
        'website_url', 'is_active'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function warehouses() {
        return $this->hasMany(Warehouse::class);
    }

    public function addresses() {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function itemInStockCategories(){
        return $this->hasMany(ItemInStockCategory::class);
    }
}
