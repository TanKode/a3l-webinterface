<?php
namespace App\A3E;

class Territory extends Model
{
    protected $table = 'territory';
    protected $fillable = [
        'id',
        'owner_uid',
        'name',
        'level',
        'radius',
    ];

    protected $casts = [
        'radius' => 'int',
        'level' => 'int',
    ];

    protected $dates = [
        'created_at',
        'last_payed_at',
    ];
}