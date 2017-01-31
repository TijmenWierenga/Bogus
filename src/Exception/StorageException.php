<?php
namespace TijmenWierenga\Bogus\Exception;


use MongoDB\Driver\Exception\Exception;
use RuntimeException;

class StorageException extends RuntimeException
{
    /**
     * StorageException constructor.
     * @param Exception $previousException
     */
    public function __construct(Exception $previousException)
    {
        parent::__construct("Failed storing the collection in storage", 0, $previousException);
    }
}