<?php

namespace O21\EthereumOracles\FeeStats;

class Stats
{
    /**
     * @param  float  $slow  - gas value in Gwei
     * @param  float  $standard  - gas value in Gwei
     * @param  float  $high  - gas value in Gwei
     * @param  float|null  $instant  - gas value in Gwei
     * @param  string|null  $speed
     * @param  int|null  $blockNumber
     */
    public function __construct(
        public readonly float $slow,
        public readonly float $standard,
        public readonly float $high,
        public readonly ?float $instant = null,
        public readonly ?string $speed = null,
        public readonly ?int $blockNumber = null
    ) {}
}