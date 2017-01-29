<?php
namespace TijmenWierenga\Bogus\Storage;


use TijmenWierenga\Bogus\Collection\Collection;

class LogStorageAdapter implements StorageAdapter
{
    public function save(Collection $collection): void
    {
        return;
    }
}
