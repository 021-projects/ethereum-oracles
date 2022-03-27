<?php

namespace O21\EthereumOracles\OffChain;

use O21\EthereumOracles\FeeStats\Feature;
use O21\EthereumOracles\FeeStats\ResponseKeys;
use O21\EthereumOracles\FeeStats\Stats;
use O21\EthereumOracles\OracleApi;

class EthGasStation extends OracleApi
{
    private const STATS_ENDPOINT = '/json/ethgasAPI.json';

    private ResponseKeys $statsKeys;

    protected function setUp(): void
    {
        $this->statsKeys = new ResponseKeys(
            slow: 'safeLow',
            standard: 'average',
            blockNumber: 'blockNum'
        );
    }

    protected function getOracleFeeStats(array $features): Stats
    {
        return $this->parseStatsResponse(
            $this->getStatsResponse(self::STATS_ENDPOINT),
            $features,
            $this->statsKeys,
            static fn (float $value) => $value / 10
        );
    }

    protected function getDefaultHttpOptions(): array
    {
        return [
            'base_uri' => 'https://ethgasstation.info'
        ];
    }

    protected function getSupportedFeatures(): array
    {
        return Feature::all();
    }
}