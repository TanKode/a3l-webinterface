<?php

namespace App;

use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    public function getRevisions($limit = 100)
    {
        $histories = [];
        foreach ($this->revisionHistory()->orderBy('created_at', 'desc')->limit($limit)->get() as $history) {
            $field = $history->key;
            $old = $history->old_value;
            $oldValue = $old;
            $new = $history->new_value;
            $newValue = $new;
            if (is_numeric($history->new_value) && is_numeric($history->old_value)) {
                $type = 'numeric';
                $old *= 1;
                $new *= 1;
                $diff = $new - $old;
                $diffValue = $diff;
            } elseif (str_contains($field, 'licenses')) {
                $type = 'array';
                $old = \Formatter::decodeDBArray($old);
                $new = \Formatter::decodeDBArray($new);
                $old = array_combine(array_column($old, 0), array_column($old, 1));
                $new = array_combine(array_column($new, 0), array_column($new, 1));
                $diff = array_diff_assoc($new, $old);
                if (count($diff)) {
                    $oldValue = [];
                    $newValue = [];
                    foreach ($diff as $key => $value) {
                        $oldValue[$key] = array_get($old, $key);
                        $newValue[$key] = array_get($new, $key);
                    }
                    $oldValue = json_encode($oldValue);
                    $newValue = json_encode($newValue);
                    $diffValue = json_encode($diff);
                } else {
                    $diff = null;
                    $oldValue = null;
                    $newValue = null;
                    $diffValue = null;
                }
            } else {
                $type = 'string';
                $diff = '';
                $diffValue = '';
            }
            $histories[] = [
                'user' => $history->userResponsible(),
                'field' => $field,
                'old' => $old,
                'old_value' => $oldValue,
                'new' => $new,
                'new_value' => $newValue,
                'diff' => $diff,
                'diff_value' => $diffValue,
                'type' => $type,
                'created_at' => $history->created_at,
            ];
        }

        return $histories;
    }
}
