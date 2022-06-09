<?php

namespace Zizaco\Entrust\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Zizaco\Entrust\EntrustPermission;

class EntrustPermissionCacheEncoder implements CacheEncoderInterface
{
    /**
     * This should return a string of the collection in the following format:
     * `[{"name":"manage_a"},{"name":"manage_b"}]
     *
     * {@inheritDoc}
     */
    public static function encode(Collection $collection)
    {
        /* @var EntrustPermission $permission */
        return json_encode($collection->map(function ($permission) {
            return [
                'name' => $permission->name
            ];
        }));
    }

    /**
     * {@inheritDoc}
     */
    public static function decode($string)
    {
        $permissionsAsArray = json_decode($string, true);

        $permissions = new Collection();
        foreach ($permissionsAsArray as $permissionAsArray) {
            $permission = new EntrustPermission();
            $permission->name = $permissionAsArray['name'];
            $permissions[] = $permission;
        }

        return $permissions;
    }
}
