<?php

namespace Tests;

use O21\EthereumOracles\FeeStats\Feature;
use O21\EthereumOracles\OffChain\Etherchain;
use O21\EthereumOracles\OffChain\EthGasStation;
use WeakMap;

class EthGasStationTest extends ProviderTest
{
    protected function getSupportedFeatureTest(): WeakMap
    {
        $wm = new WeakMap;
        foreach (Feature::all() as $feature) {
            $wm[$feature] = true;
        }
        return $wm;
    }

    protected function getProviderClass(): string
    {
        return EthGasStation::class;
    }
}