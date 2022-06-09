<?php

namespace Zizaco\Entrust\Helpers;

use Illuminate\Database\Eloquent\Collection;

interface CacheEncoderInterface
{
    /**
     * Encode a collection of models to a string.
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
