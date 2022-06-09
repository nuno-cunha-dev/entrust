<?php

namespace Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Mockery as m;
use PHPUnit_Framework_TestCase as TestCase;
use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\Helpers\EntrustRoleCacheEncoder;

class EntrustRoleCacheEncoderTest extends TestCase
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
            ->with('entrust.roles_table')
            ->andReturn('roles');
    }

    public function tearDown()
    {
        m::close();
    }

    public function testEncode()
    {
        $roleA = new EntrustRole();
        $roleA->setIdentifier(1);
        $roleA->name = 'Admin';

        $roleB = new EntrustRole();
        $roleB->setIdentifier(2);
        $roleB->name = 'User';

        $roles = new Collection([$roleA, $roleB]);

        $encoded = EntrustRoleCacheEncoder::encode($roles);
        $this->assertEquals('[{"id":1,"name":"Admin"},{"id":2,"name":"User"}]', $encoded);
    }

    public function testDecode()
    {
        $encoded = '[{"id":1,"name":"Admin"},{"id":2,"name":"User"}]';
        $roles = EntrustRoleCacheEncoder::decode($encoded);

        $this->assertEquals(2, $roles->count());
        $this->assertEquals(1, $roles->first()->getIdentifier());
        $this->assertEquals('Admin', $roles->first()->name);
        $this->assertEquals(2, $roles->last()->getIdentifier());
        $this->assertEquals('User', $roles->last()->name);
    }
}
