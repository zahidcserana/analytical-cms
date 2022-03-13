<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Arr;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
}
