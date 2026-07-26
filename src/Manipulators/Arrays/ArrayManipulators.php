<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Manipulators\Arrays;

use JuanchoSL\DataManipulation\Traits\CallfuncTrait;
use JuanchoSL\DataManipulation\Traits\DelayedManipulationTrait;
use JuanchoSL\DataManipulation\Traits\InstantManipulationTrait;
use JuanchoSL\DataManipulation\Traits\SanitizerInmutableTrait;
use JuanchoSL\DataManipulation\Traits\SanitizerStackedTrait;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class ArrayManipulators implements LoggerAwareInterface
{

    use CallfuncTrait, SanitizerStackedTrait, LoggerAwareTrait;

    public function slice(int $offset, ?int $length = null, bool $preserve_keys = false): static
    {
        return $this->sanitize('array_slice', func_get_args());
        return $this->sanitize('array_slice', ['merge' => func_get_args()]);
    }

    public function chunk(int $length, bool $preserve_keys = false): static
    {
        return $this->sanitize('array_chunk', func_get_args());
        return $this->sanitize('array_chunk', ['merge' => func_get_args()]);
    }

    public function column(int|string|null $column_key, int|string|null $index_key = null): static
    {
        return $this->sanitize('array_column', array_merge(['multi' => true], func_get_args()));
        return $this->sanitize('array_column', func_get_args());
    }

    public function combine(array $keys): static
    {
        return $this->sanitize('array_combine', func_get_args())->flip();
    }

    public function countValuesRepetitions(): static
    {
        return $this->sanitize('array_count_values');
    }

    public function merge(): static
    {
        return $this->sanitize('array_merge');
    }

    public function fillByKey(array $keys, mixed $value): static
    {
        return $this->sanitize('array_fill_keys', func_get_args());
    }

    public function fillKeys(mixed $value): static
    {
        return $this->sanitize('array_fill_keys', func_get_args());
    }

    public function filter(?callable $callback = null): static
    {
        return $this->sanitize('array_filter', func_get_args());
    }

    public function map(?callable $callback = null): static
    {
        return $this->sanitize('array_map', ['first' => func_get_args(), 'multi' => true]);
    }

    public function flip(): static
    {
        return $this->sanitize('array_flip');
        return $this->sanitize('array_flip', ['iterable' => true]);
    }

    public function unique(): static
    {
        return $this->sanitize('array_unique');
        return $this->sanitize('array_unique', ['iterable' => true]);
    }

    public function sum(): static
    {
        return $this->sanitize('array_sum');
    }

    public function product(): static
    {
        return $this->sanitize('array_product');
    }

    public function min(): static
    {
        return $this->sanitize('min');
    }

    public function max(): static
    {
        return $this->sanitize('max');
    }

    public function keyToCase(int $to_case = CASE_LOWER): static
    {
        return $this->sanitize('array_change_key_case', func_get_args());
    }
}
