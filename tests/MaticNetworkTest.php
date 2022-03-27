<?php

namespace Tests;

use O21\EthereumOracles\FeeStats\Feature;
use O21\EthereumOracles\OffChain\MaticNetwork;
use WeakMap;

class MaticNetworkTest extends ProviderTest
{
    protected function getSupportedFeatureTest(): WeakMap
    {
        $wm = new WeakMap;
        foreach (Feature::allExcept(Feature::Speed) as $feature) {
            $wm[$feature] = true;
        }
        $wm[Feature::Speed] = false;
        return $wm;
    }

    protected function getProviderClass(): string
    {
        return MaticNetwork::class;
    }
}