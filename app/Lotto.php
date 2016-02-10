<?php
namespace App;

use Carbon\Carbon;

class Lotto extends Model
{
    protected $table = 'lottodraws';

    protected $fillable = [
        'week',
        'year',
        'numbers',
        'jackpot',
    ];
    protected $hidden = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_lottos', 'lotto_id', 'user_id')->withPivot('numbers');
    }

    public function setNumbersAttribute()
    {
        $this->attributes['numbers'] = collect(range(1,49))->random(6)->sort()->implode(',');
    }

    public function setWeekAttribute()
    {
        $this->attributes['week'] = $this->getNextDrawDate()->weekOfYear;
    }

    public function setYearAttribute()
    {
        $this->attributes['year'] = $this->getNextDrawDate()->year;
    }

    public function setJackpotAttribute()
    {
        $this->attributes['jackpot'] = round(mt_rand(min(config('a3lwebinterface.lotto.jackpot')), max(config('a3lwebinterface.lotto.jackpot'))));
    }

    public function scopeNext($query)
    {
        $query->year()->week();
    }

    public function scopeLast($query)
    {
        $lastDraw = $this->getNextDrawDate()->subDays(7);
        $query->year($lastDraw->year)->week($lastDraw->week);
    }

    public function scopeYear($query, $year = null)
    {
        $year = is_null($year) ? $this->getNextDrawDate()->year : $year;
        $query->where('year', $year);
    }

    public function scopeWeek($query, $week = null)
    {
        $week = is_null($week) ? $this->getNextDrawDate()->weekOfYear : $week;
        $query->where('week', $week);
    }

    public function getNextDrawDate()
    {
        $now = Carbon::now(config('app.timezone'))->next(config('a3lwebinterface.lotto.draw.day'));
        $now->second = 0;
        $now->hour = explode(':', config('a3lwebinterface.lotto.draw.time'))[0];
        $now->minute = explode(':', config('a3lwebinterface.lotto.draw.time'))[1];
        return $now;
    }
}
