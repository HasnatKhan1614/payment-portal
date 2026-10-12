<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'sort_order',
        'status',
        'key1',
        'key2',
        'key3',
    ];

    public static $rules = [
        'type' => 'required',
        'name' => 'required',
        'sort_order' => 'nullable|integer|min:0',
        'status' => 'nullable|boolean',
        'key1' => 'required',
        'key2' => 'required',
        'key3' => 'nullable|string',
    ];

}
