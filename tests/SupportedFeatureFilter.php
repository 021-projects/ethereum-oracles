<?php

namespace Tests;

enum SupportedFeatureFilter
{
    case Supported;
    case NotSupported;

    public function shouldRemove(bool $isHavingFeature): bool
    {
        return match ($this) {
            self::Supported => ! $isHavingFeature,
            self::NotSupported => $isHavingFeature
        };
    }
}