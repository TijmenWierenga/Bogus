<?php
namespace TijmenWierenga\Bogus\Storage;

use TijmenWierenga\Bogus\Collection\Collection;
use TijmenWierenga\Bogus\Exception\StorageException;

/**
 * Interface StorageAdapter
 * @package TijmenWierenga\Bogus
 */
interface StorageAdapter
{
    /**
     * Stores all items of the collection in database
     *
     * @param Collection $collection
     * @throws StorageException
     */
    public function save(Collection $collection): void;
}
