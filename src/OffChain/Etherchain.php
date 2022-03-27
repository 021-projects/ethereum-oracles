<?php

namespace O21\EthereumOracles\OffChain;

use O21\EthereumOracles\FeeStats\Feature;
use O21\EthereumOracles\FeeStats\ResponseKeys;
use O21\EthereumOracles\FeeStats\Stats;
use O21\EthereumOracles\OracleApi;
use O21\EthereumOracles\Utils;

class Etherchain extends OracleApi
{
    private const STATS_ENDPOINT = '/api/gasnow';

    private ResponseKeys $statsKeys;

    protected function setUp(): void
    {
        $this->statsKeys = new ResponseKeys(
            slow: 'data.slow',
            standard: 'data.standard',
            high: 'data.fast',
            instant: 'data.rapid'
        );
    }

    protected function getOracleFeeStats(array $features): Stats
    {
        return $this->parseStatsResponse(
            $this->getStatsResponse(self::STATS_ENDPOINT),
            $features,
            $this->statsKeys,
            [Utils::class, 'fromWeiToGwei']
        );
    }

    protected function getDefaultHttpOptions(): array
    {
        return [
            'base_uri' => 'https://etherchain.org'
        ];
    }

    protected function getSupportedFeatures(): array
    {
        return [Feature::Instant];
    }
}