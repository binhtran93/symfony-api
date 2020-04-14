<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Test extends WebTestCase
{
    public function testA() {
        $client = static::createClient();
        $client->request('GET', '/songs');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());

    }
}
