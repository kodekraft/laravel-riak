<?php

use Ramsey\Uuid\Uuid;

/**
 * Class RelationsTest
 */
class RelationsTest extends TestCase
{
    public function testHasMany()
    {
        $market = Market::create([
            'marketId' => Uuid::uuid4()->toString(),
            'name'     => 'Match Betting Live',
        ]);

        Selection::create([
            'selectionId' => Uuid::uuid4()->toString(),
            'marketId'    => $market->marketId,
        ]);

        Selection::create([
            'selectionId' => Uuid::uuid4()->toString(),
            'marketId'    => $market->marketId,
        ]);

        $selections = $market->selections;

        $this->assertEquals(2, count($selections));
    }
}