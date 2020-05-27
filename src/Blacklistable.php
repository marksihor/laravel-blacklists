<?php

namespace MarksIhor\LaravelBlacklists;

use MarksIhor\LaravelBlacklists\Blacklist;

trait Blacklistable
{
    public function blacklists()
    {
        return $this->morphMany(Blacklist::class, 'blacklistable');
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

        return 'Added to blacklist';
    }

    public function removeFromBlacklist(string $type, string $value): string
    {
        if (!$this->checkIfInBlackList($type, $value)) return 'Not in blacklist.';

        $this->query($type, $value)->delete();

        return 'Removed from blacklist.';
    }

    public function checkIfInBlackList(string $type, string $value): bool
    {
        return $this->query($type, $value)->exists();
    }

    private function query(string $type, string $value)
    {
        return Blacklist::where([
            'blacklistable_id' => $this->id,
            'blacklistable_type' => $this->getMorphClass(),
            'type' => $type,
            'value' => $value
        ]);
    }
}