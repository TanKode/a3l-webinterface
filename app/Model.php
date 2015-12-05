<?php
namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Venturecraft\Revisionable\RevisionableTrait;

class Model extends EloquentModel
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
}