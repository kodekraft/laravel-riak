<?php

use Ramsey\Uuid\Uuid;

class ModelTest extends TestCase
{
    public function testNewModel()
    {
        $market = new Market();
        $this->assertInstanceOf(\Riakuent\Connection::class, $market->getConnection());
        $this->assertInstanceOf(\Riakuent\Eloquent\Model::class, $market);
    }

    public function testInsert()
    {
        $market = new Market();
        $market->marketId = Uuid::uuid4()->toString();
        $market->eventId = Uuid::uuid4()->toString();
        $market->name = 'Match Betting Live';

        $market->save();

        $this->assertEquals(true, $market->exists);
    }
}