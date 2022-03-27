<?php

namespace Tests;

use O21\EthereumOracles\Utils;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    public function testFromWeiToGwei(): void
    {
        $this->assertEquals(
            '1',
            Utils::fromWeiToGwei('1000000000')
        );
    }
}