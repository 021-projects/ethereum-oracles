<?php

namespace O21\EthereumOracles;

use GuzzleHttp\Client;
use GuzzleHttp\Utils;
use O21\EthereumOracles\Exceptions\ProviderDoesNotSupportFeature;
use O21\EthereumOracles\FeeStats\Feature;
use O21\EthereumOracles\FeeStats\ResponseKeys;
use O21\EthereumOracles\FeeStats\Stats;
use O21\EthereumOracles\Support\Arr;

abstract class OracleApi implements \O21\EthereumOracles\Contracts\OracleApi
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new Client($this->getDefaultHttpOptions());
        $this->setUp();
    }

    protected function setUp(): void
    {
    }

    abstract protected function getOracleFeeStats(array $features): Stats;

    protected function parseStatsResponse(
        array $response,
        array $features,
        ResponseKeys $keys,
        ?callable $gasFormatter = null
    ): Stats {
        $featureArgs = $this->getFeatureArgsFromResponse(
            $response,
            $features,
            $keys
        );
        $gasFormatter ??= static fn ($value) => $value;

        return new Stats(
            $gasFormatter(Arr::get($response, $keys->slow)),
            $gasFormatter(Arr::get($response, $keys->standard)),
            $gasFormatter(Arr::get($response, $keys->high)),
            instant: $featureArgs[Feature::Instant->value] !== null
                ? $gasFormatter($featureArgs[Feature::Instant->value])
                : null,
            speed: $featureArgs[Feature::Speed->value],
            blockNumber: $featureArgs[Feature::BlockNumber->value]
        );
    }

    protected function getFeatureArgsFromResponse(
        array $response,
        array $features,
        ResponseKeys $keys
    ): array {
        $args = [];

        foreach (Feature::all() as $feature) {
            if ($this->shouldIncludeFeeStatFeature($feature, $features)) {
                $args[$feature->value] = match ($feature) {
                    Feature::Instant => Arr::get($response, $keys->instant),
                    Feature::BlockNumber => Arr::get($response, $keys->blockNumber),
                    Feature::Speed => Arr::get($response, $keys->speed)
                };
            } else {
                $args[$feature->value] = null;
            }
        }

        return $args;
    }

    protected function getStatsResponse(string $uri): array
    {
        return Utils::jsonDecode(
            $this->http->get($uri)->getBody(),
            true
        );
    }

    abstract protected function getDefaultHttpOptions(): array;

    /**
     * @return array<\O21\EthereumOracles\FeeStats\Feature>
     */
    abstract protected function getSupportedFeatures(): array;

    public function getFeeStats(...$features): Stats
    {
        $this->assertSupportFeatures($features);

        return $this->getOracleFeeStats($features);
    }

    protected function shouldIncludeFeeStatFeature(Feature $feature, array $features): bool
    {
        // by default include all available features
        return empty($features) || in_array($feature, $features, true);
    }

    protected function assertSupportFeatures(array $features): void
    {
        foreach ($features as $feature) {
            if (! $this->isSupportsFeeStatsFeature($feature)) {
                throw new ProviderDoesNotSupportFeature($feature);
            }
        }
    }

    public function isSupportsFeeStatsFeature(Feature $feature): bool
    {
        return in_array($feature, $this->getSupportedFeatures(), true);
    }
}