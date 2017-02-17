<?php
namespace TijmenWierenga\Bogus\Storage;

use TijmenWierenga\Bogus\Collection\Collection;

/**
 * Class InMemoryStorageAdapter
 *
 * @author  Tijmen Wierenga <tijmen@devmob.com>
 */
class InMemoryStorageAdapter implements StorageAdapter
{
    /**
     * @param Collection $collection
     */
    public function save(Collection $collection): void
    {
        return;
    }
}
