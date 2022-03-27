<?php

namespace O21\EthereumOracles\Exceptions;

use Exception;
use O21\EthereumOracles\FeeStats\Feature;

class ProviderDoesNotSupportFeature extends Exception
{
    public function __construct(
        Feature $feature,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            "Error: this provider does not support selected feature: $feature->value",
            $code,
            $previous
        );
    }
}