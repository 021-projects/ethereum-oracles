<?php

namespace Tests;

use O21\EthereumOracles\Contracts\OracleApi;
use O21\EthereumOracles\Exceptions\ProviderDoesNotSupportFeature;
use O21\EthereumOracles\FeeStats\Feature;
use PHPUnit\Framework\TestCase;
use WeakMap;

abstract class ProviderTest extends TestCase
{
    protected OracleApi $api;

    protected function setUp(): void
    {
        $class = $this->getProviderClass();
        $this->api = new $class();
    }

    abstract protected function getSupportedFeatureTest(): WeakMap;

    abstract protected function getProviderClass(): string;

    public function testSupportedFeatures(): void
    {
        $featureTest = $this->getSupportedFeatureTest();
        if (! $featureTest->count()) {
            $this->markTestSkipped('Provider does not support any feature.');
        }

        foreach ($featureTest as $feature => $have) {
            if ($have) {
                $this->assertTrue($this->api->isSupportsFeeStatsFeature($feature));
            } else {
                $this->assertFalse($this->api->isSupportsFeeStatsFeature($feature));
            }
        }
    }

    public function testGettingStatsWithInvalidFeatures(): void
    {
        $notSupportedFeatures = $this->filteredSupportedFeatureTest(SupportedFeatureFilter::NotSupported);
        if (! $notSupportedFeatures->count()) {
            $this->markTestSkipped('Provider supports all features.');
        }

        $this->expectException(ProviderDoesNotSupportFeature::class);
        $this->api->getFeeStats(...weak_map_keys($notSupportedFeatures));
    }

    public function testGettingStats(): void
    {
        $stats = $this->api->getFeeStats();

        $this->assertIsFloat($stats->slow);
        $this->assertIsFloat($stats->standard);
        $this->assertIsFloat($stats->high);

        $supportedFeatures = $this->filteredSupportedFeatureTest(SupportedFeatureFilter::Supported);
        foreach ($supportedFeatures as $feature => $have) {
            match ($feature) {
                Feature::Instant => $this->assertIsFloat($stats->instant),
                Feature::BlockNumber => $this->assertIsInt($stats->blockNumber),
                Feature::Speed => $this->assertIsString($stats->speed)
            };
        }
    }

    protected function filteredSupportedFeatureTest(SupportedFeatureFilter $filter): WeakMap
    {
        $featureTest = $this->getSupportedFeatureTest();

        $iterator = (clone $featureTest)->getIterator();
        foreach ($iterator as $feature => $have) {
            if ($filter->shouldRemove($have)) {
                $featureTest->offsetUnset($feature);
            }
        }

        return $featureTest;
    }
}