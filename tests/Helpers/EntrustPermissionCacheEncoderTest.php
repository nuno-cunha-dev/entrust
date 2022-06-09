<?php

namespace Helpers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Mockery as m;
use PHPUnit_Framework_TestCase as TestCase;
use Zizaco\Entrust\EntrustPermission;
use Zizaco\Entrust\Helpers\EntrustPermissionCacheEncoder;

class EntrustPermissionCacheEncoderTest extends TestCase
{
    private $facadeMocks = array();

    public function setUp()
    {
        parent::setUp();

        $app = m::mock('app')->shouldReceive('instance')->getMock();

        $this->facadeMocks['config'] = m::mock('config');

        Config::setFacadeApplication($app);
        Config::swap($this->facadeMocks['config']);
        Config::shouldReceive('get')
            ->with('entrust.permissions_table')
            ->andReturn('roles');
    }

    public function tearDown()
    {
        m::close();
    }

    public function testEncode()
    {
        $permissionA = new EntrustPermission();
        $permissionA->name = 'manage_a';

        $permissionB = new EntrustPermission();
        $permissionB->name = 'manage_b';

        $permissions = new Collection([$permissionA, $permissionB]);

        $encoded = EntrustPermissionCacheEncoder::encode($permissions);
        $this->assertEquals('[{"name":"manage_a"},{"name":"manage_b"}]', $encoded);
    }

    public function testDecode()
    {
        $encoded = '[{"name":"manage_a"},{"name":"manage_b"}]';
        $permissions = EntrustPermissionCacheEncoder::decode($encoded);

        $this->assertEquals(2, $permissions->count());
        $this->assertEquals('manage_a', $permissions->first()->name);
        $this->assertEquals('manage_b', $permissions->last()->name);
    }
}
