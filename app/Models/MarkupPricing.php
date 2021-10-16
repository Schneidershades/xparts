<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkupPricing extends Model
{
    use HasFactory;

    protected $fillable = ['min_value', 'max_value', 'percentage', 'active', 'type'];
}
