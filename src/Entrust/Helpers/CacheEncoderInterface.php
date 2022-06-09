<?php

namespace Zizaco\Entrust\Helpers;

use Illuminate\Database\Eloquent\Collection;

interface CacheEncoderInterface
{
    /**
     * This should return a string of the collection in the following format:
     * `[{"id":1,"name":"Admin"},{"id":2,"name":"User"}]`
     *
     * @param Collection $collection
     * @return false|string
     */
    public static function encode(Collection $collection);

    /**
     * Decode roles from a string
     *
     * @param string $string
     * @return Collection
     */
    public static function decode($string);
}
