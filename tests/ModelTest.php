<?php

/**
 * Class ModelTest
 */
class ModelTest extends TestCase
{
    /**
     * @test
     */
    public function newModel()
    {
        $user = new User();
        $this->assertInstanceOf(Kodekraft\Connection::class, $user->getConnection());
        $this->assertInstanceOf(Kodekraft\Eloquent\Model::class, $user);
    }
}