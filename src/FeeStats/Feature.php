<?php

namespace O21\EthereumOracles\FeeStats;

enum Feature: string
{
    case Instant = 'instant';
    case BlockNumber = 'blockNumber';
    case Speed = 'speed';

    public static function all(): array
    {
        return [
            self::Instant,
            self::BlockNumber,
            self::Speed
        ];
    }

    public static function allExcept(...$except): array
    {
        return array_filter(
            self::all(),
            static fn(Feature $feat) => ! in_array($feat, $except, true)
        );
    }
}