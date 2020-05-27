<?php

namespace MarksIhor\LaravelBlacklists;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $guarded = ['id'];

    protected $visible = ['type', 'value'];

    public function blacklistable()
    {
        return $this->morphTo();
    }
}