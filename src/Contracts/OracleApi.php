<?php

namespace O21\EthereumOracles\Contracts;

use O21\EthereumOracles\FeeStats\Feature;
use O21\EthereumOracles\FeeStats\Stats;

interface OracleApi
{
    /**
     * @param \O21\EthereumOracles\FeeStats\Feature ...$features
     * @return \O21\EthereumOracles\FeeStats\Stats
     */
    public function getFeeStats(...$features): Stats;

    public function isSupportsFeeStatsFeature(Feature $feature): bool;
}