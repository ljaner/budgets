<?php


namespace App\Tests\Infrastructure;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BudgetApiTest extends WebTestCase
{
    public function testGetBudgetNotExists()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/budget/-1');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}