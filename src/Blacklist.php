<?php

namespace MarksIhor\LaravelBlacklists;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $guarded = ['id'];

    public function blacklistable()
    {
        return $this->morphTo();
    }
}