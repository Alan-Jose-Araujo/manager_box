<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];
}
