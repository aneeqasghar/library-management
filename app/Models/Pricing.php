<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $fillable = ['min_days', 'max_days', 'amount'];

    public $timestamps = false;
}
