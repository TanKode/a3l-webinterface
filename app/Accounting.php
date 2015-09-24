<?php
namespace App;

class Accounting extends Model
{
    protected $table = 'accountings';
    protected $fillable = [
        'booker_id',
        'amount',
        'description',
    ];

    protected $casts = [
        'booker_id' => 'int',
        'amount' => 'float',
    ];

    public static $rules = [
        'amount' => 'required',
        'description' => 'required|string',
    ];

    public function getBookerAttribute()
    {
        return User::withTrashed()->find($this->booker_id);
    }

    public function getAmountAttribute($value)
    {
        return format_money($value);
    }
}
