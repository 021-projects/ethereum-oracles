<?php

namespace O21\EthereumOracles;

class Utils
{
    public static function fromWeiToGwei(string $wei): string
    {
        return bcdiv($wei, '1000000000');
    }
}