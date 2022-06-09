<?php

namespace Zizaco\Entrust\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Zizaco\Entrust\EntrustRole;

class EntrustRoleCacheEncoder implements CacheEncoderInterface
{
    /**
     * {@inheritDoc}
     */
    public static function encode(Collection $collection)
    {
        /* @var EntrustRole $role */
        return json_encode($collection->map(function ($role) {
            return [
                'id' => $role->getIdentifier(),
                'name' => $role->name
            ];
        }));
    }

    /**
     * {@inheritDoc}
     */
    public static function decode($string)
    {
        $rolesAsArray = json_decode($string, true);

        $roles = new Collection();
        foreach ($rolesAsArray as $roleAsArray) {
            $role = new EntrustRole();
            $role->setIdentifier($roleAsArray['id']);
            $role->name = $roleAsArray['name'];
            $roles[] = $role;
        }

        return $roles;
    }
}
