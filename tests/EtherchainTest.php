<?php

namespace Tests;

use O21\EthereumOracles\FeeStats\Feature;
use O21\EthereumOracles\OffChain\Etherchain;
use WeakMap;

class EtherchainTest extends ProviderTest
{
    protected function getSupportedFeatureTest(): WeakMap
    {
        $wm = new WeakMap;
        $wm[Feature::Instant] = true;
        $wm[Feature::Speed] = false;
        return $wm;
    }

    protected function getProviderClass(): string
    {
        return Etherchain::class;
    }
}