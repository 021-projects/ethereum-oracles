<?php

namespace O21\EthereumOracles\FeeStats;

class ResponseKeys
{
    public function __construct(
        public readonly string $slow = 'slow',
        public readonly string $standard = 'standard',
        public readonly string $high = 'fast',
        public readonly string $instant = 'fastest',
        public readonly string $speed = 'speed',
        public readonly string $blockNumber = 'blockNumber'
    ) {}
}