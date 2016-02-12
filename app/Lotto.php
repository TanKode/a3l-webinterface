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
        return $this->belongsToMany(User::class, 'user_lottos', 'lotto_id', 'user_id')->withPivot('numbers', 'created_at');
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
        $now = Carbon::now(config('app.timezone'));
        $next = Carbon::now(config('app.timezone'))->next(config('a3lwebinterface.lotto.draw.day'));
        $parts = explode(':', config('a3lwebinterface.lotto.draw.time'));
        $hour = $parts[0];
        $minute = $parts[1];
        if($now->dayOfWeek == config('a3lwebinterface.lotto.draw.day')) {
            $draw = $now->setTime($hour, $minute, 0);
        } else {
            $draw = $next->setTime($hour, $minute, 0);
        }
        if($draw->diffInSeconds(null, false) > 0) {
            $draw = $next->setTime($hour, $minute, 0);
        }
        return $draw;
    }

    public function getCorrectsByNumbers($numbers)
    {
        if(is_string($numbers)) $numbers = explode(',', $numbers);
        return count(array_intersect(explode(',', $this->numbers), $numbers));
    }

    public function getProfitByNumbers($numbers)
    {
        $correct = $this->getCorrectsByNumbers($numbers);
        return array_get(config('a3lwebinterface.lotto.profits'), $correct, 0) * $this->jackpot;
    }

    public function getNumbersSum()
    {
        return array_sum(explode(',', $this->numbers));
    }
}
