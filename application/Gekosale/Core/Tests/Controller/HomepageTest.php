<?php

namespace Gekosale\Core\Tests\Controller

class HomepageTest extends
{

    public function testIndex ()
    {
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Hello Fabien")')->count());
    }
}