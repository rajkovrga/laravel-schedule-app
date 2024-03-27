<?php

namespace App\ValueObject;

use Carbon\CarbonImmutable;

readonly class DateTimeRange
{
    public function __construct(
        public CarbonImmutable $lower,
        public CarbonImmutable $upper,
    ) {
    }
}