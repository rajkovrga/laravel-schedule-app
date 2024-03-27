<?php

namespace App\Casts;

use Carbon\CarbonImmutable;
use DateTimeInterface;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class MultiTimestampRangeCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // {["2024-03-21 00:00:00+00","2024-03-29 00:00:00+00"]}

        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $mapped = array_map(fn($el) => '[' .
            $this->matchDate($el[0]) . ',' .
            $this->matchDate($el[1]) . ']', $value);

        return '{' . implode(',', $mapped) . '}';
    }

    private function matchDate($value): string
    {
        return match (true) {
            is_string($value) => $value,
            is_int($value) => CarbonImmutable::createFromTimestamp($value)->format('Y-m-d H:i:s'),
            $value instanceof DateTimeInterface => CarbonImmutable::createFromDate($value)->format('Y-m-d H:i:s'),
            default => throw new RuntimeException('Invalid type for $value'),
        };
    }
}
