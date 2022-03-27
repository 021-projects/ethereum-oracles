<?php

namespace Tests;

use O21\EthereumOracles\FeeStats\Feature;
use O21\EthereumOracles\OffChain\Blockscout;
use WeakMap;

class BlockscoutTest extends ProviderTest
{
    protected function getSupportedFeatureTest(): WeakMap
    {
        $wm = new WeakMap;
        foreach (Feature::all() as $feature) {
            $wm[$feature] = false;
        }
        return $wm;
    }

    protected function getProviderClass(): string
    {
        return Blockscout::class;
    }
}