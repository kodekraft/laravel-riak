<?php

class ConnectionTest extends TestCase
{
    public function testConnection()
    {
        $connection = DB::connection('riak');
        $this->assertInstanceOf('Riakuent\Connection', $connection);
    }

    public function testReconnect()
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