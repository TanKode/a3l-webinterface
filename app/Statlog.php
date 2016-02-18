<?php
namespace App;

class Statlog extends Model
{
    protected $table = 'statlogs';

    protected $fillable = [
        'player_count',
        'cop_count',
        'medic_count',
        'atac_count',
        'player_money',
        'vehicle_count',
        'gang_count',
        'gang_money',
        'user_count',
    ];
    protected $hidden = [];

    public static function newLog()
    {
        return self::create([
            'player_count' => Player::count(),
            'cop_count' => Player::cop()->count(),
            'medic_count' => Player::medic()->count(),
            'atac_count' => Player::atac()->count(),
            'player_money' => Player::sum(\DB::raw('cash + bankacc')),
            'vehicle_count' => Vehicle::alive()->count(),
            'gang_count' => Gang::count(),
            'gang_money' => Gang::sum('bank'),
            'user_count' => User::confirmed()->count(),
        ]);
    }
}
