<?php
namespace App;

class Donation extends Model
{
    protected $table = 'donations';
    protected $fillable = [
        'donator_id',
        'booker_id',
        'euro_amount',
        'bamboo_amount',
        'method',
        'description',
    ];

    protected $casts = [
        'donator_id' => 'int',
        'booker_id' => 'int',
        'euro_amount' => 'float',
        'bamboo_amount' => 'int',
    ];

    public static $rules = [
        'donator_id' => 'required|integer',
        'bamboo_amount' => 'required|integer',
        'description' => 'required|string',
    ];

    public function getDonatorAttribute()
    {
        return User::withTrashed()->find($this->donator_id);
    }

    public function getBookerAttribute()
    {
        return User::withTrashed()->find($this->booker_id);
    }

    public function getEuroAmountAttribute($value)
    {
        return format_money($value);
    }

    public function setMethodAttribute($value)
    {
        $this->attributes['method'] = str_slug($value, '_');
    }

    public function scopeDonator($query, $user)
    {
        if (is_integer($user)) {
            $userId = $user;
        } elseif ($user instanceof User) {
            $userId = $user->id;
        } else {
            $userId = 0;
        }
        return $query->where('donator_id', $userId);
    }

    public function scopeBooker($query, $user)
    {
        if (is_integer($user)) {
            $userId = $user;
        } elseif ($user instanceof User) {
            $userId = $user->id;
        } else {
            $userId = 0;
        }
        return $query->where('booker_id', $userId);
    }
}
