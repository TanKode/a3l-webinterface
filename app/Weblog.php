<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Weblog extends Model
{
    protected $table = 'weblog';

    protected $fillable = ['*'];
    protected $hidden = [''];

}
