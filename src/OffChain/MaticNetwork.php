<?php

namespace O21\EthereumOracles\OffChain;

use O21\EthereumOracles\FeeStats\Feature;
use O21\EthereumOracles\FeeStats\ResponseKeys;
use O21\EthereumOracles\FeeStats\Stats;
use O21\EthereumOracles\OracleApi;

class MaticNetwork extends OracleApi
{
    private ResponseKeys $statsKeys;

    protected function setUp(): void
    {
        $this->statsKeys = new ResponseKeys(
            slow: 'safeLow'
        );
    }

    protected function getOracleFeeStats(array $features): Stats
    {
        return $this->parseStatsResponse(
            $this->getStatsResponse('/'),
            $features,
            $this->statsKeys
        );
    }

    protected function getDefaultHttpOptions(): array
    {
        return [
            'base_uri' => 'https://gasstation-mainnet.matic.network'
        ];
    }

    protected function getSupportedFeatures(): array
    {
        return Feature::allExcept(Feature::Speed);
    }
}