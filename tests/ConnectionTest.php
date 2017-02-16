<?php

use Kodekraft\Connection;

/**
 * Class ConnectionTest
 */
class ConnectionTest extends TestCase
{
    /**
     * @test
     */
    public function connection()
    {
        $connection = DB::connection('riak');
        $this->assertInstanceOf(Connection::class, $connection);
    }

    /**
     * @test
     */
    public function reconnect()
    {
        $c1 = DB::connection('riak');
        $c2 = DB::connection('riak');
        $this->assertEquals(spl_object_hash($c1), spl_object_hash($c2));

        $c1 = DB::connection('riak');
        DB::purge('riak');
        $c2 = DB::connection('riak');
        $this->assertNotEquals(spl_object_hash($c1), spl_object_hash($c2));
    }
}