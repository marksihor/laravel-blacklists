<?php

namespace MarksIhor\LaravelBlacklists;

use Illuminate\Support\Facades\Cache;
use MarksIhor\LaravelBlacklists\Blacklist;

trait Blacklistable
{
    public function blacklists()
    {
        return $this->morphMany(Blacklist::class, 'blacklistable');
    }

    public function getBlacklists()
    {
        return Cache::rememberForever($this->getUniqueCacheName(), function () {
            return $this->blacklists->toArray();
        });
    }

    public function addToBlacklist(string $type, string $value): string
    {
        if ($this->checkIfInBlackList($type, $value)) return 'Already in blacklist.';

        Blacklist::create([
            'blacklistable_id' => $this->id,
            'blacklistable_type' => $this->getMorphClass(),
            'type' => $type,
            'value' => $value
        ]);

        Cache::forget($this->getUniqueCacheName());
        Cache::forget($this->getUniqueCacheName($type, $value));

        return 'Added to blacklist';
    }

    public function removeFromBlacklist(string $type, string $value): string
    {
        if (!$this->checkIfInBlackList($type, $value)) return 'Not in blacklist.';

        $this->getQuery($type, $value)->delete();

        Cache::forget($this->getUniqueCacheName());
        Cache::forget($this->getUniqueCacheName($type, $value));

        return 'Removed from blacklist.';
    }

    public function checkIfInBlackList(string $type, string $value): bool
    {
        return Cache::rememberForever($this->getUniqueCacheName($type, $value), function () use ($type, $value) {
            return $this->getQuery($type, $value)->exists();
        });
    }

    private function getQuery(string $type, string $value)
    {
        return Blacklist::where([
            'blacklistable_id' => $this->id,
            'blacklistable_type' => $this->getMorphClass(),
            'type' => $type,
            'value' => $value
        ]);
    }

    private function getUniqueCacheName(?string $type = null, $value = null): string
    {
        return md5($this->getMorphClass() . '-' . $this->id . '-' . $type . '-' . $value);
    }
}