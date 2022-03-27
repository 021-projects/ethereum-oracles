<?php

namespace O21\EthereumOracles\OffChain;

use O21\EthereumOracles\FeeStats\ResponseKeys;
use O21\EthereumOracles\FeeStats\Stats;
use O21\EthereumOracles\OracleApi;

class Blockscout extends OracleApi
{
    private const STATS_ENDPOINT = '/eth/mainnet/api/v1/gas-price-oracle';

    private ResponseKeys $statsKeys;

    protected function setUp(): void
    {
        $this->statsKeys = new ResponseKeys(
            standard: 'average'
        );
    }

    protected function getOracleFeeStats(array $features): Stats
    {
        return $this->parseStatsResponse(
            $this->getStatsResponse(self::STATS_ENDPOINT),
            $features,
            $this->statsKeys
        );
    }

    protected function getDefaultHttpOptions(): array
    {
        return [
            'base_uri' => 'https://blockscout.com'
        ];
    }

    protected function getSupportedFeatures(): array
    {
        return [];
    }
}