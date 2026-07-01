<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestQuotation extends Model
{
    use HasFactory;

    protected $table = 'request_quotations';

    protected $fillable = [
        'name',
        'company_name',
        'email',
        'whatsapp',
        'project_type',
        'location',
        'building_area',
        'budget',
        'description',
        'file_path',
        'status',
    ];
}
