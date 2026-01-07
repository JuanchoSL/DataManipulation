<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Manipulators\Arrays;

use JuanchoSL\DataManipulation\Traits\CallfuncTrait;

class ArrayManipulators
{

    use CallfuncTrait;

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
        return $this->sanitize('array_column', func_get_args());
        return $this->sanitize('array_column', ['merge' => func_get_args()]);
    }

    //@TODO hay que invertir keys y values
    public function combine(array $keys): static
    {
        //$this->sanitize('array_combine', ['map' => $keys]);
        $this->sanitize('array_combine', $keys);
        return $this->flip();
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

    public function filter(): static
    {
        return $this->sanitize('array_filter');
    }

    public function flip(): static
    {
        return $this->sanitize('array_flip');
        return $this->sanitize('array_flip', ['iterable' => true]);
    }

    public function unique(): static
    {
        return $this->sanitize('array_unique', ['iterable' => true]);
        return $this->sanitize('array_unique');
    }

    public function sum(): static
    {
        return $this->sanitize('array_sum');
    }

    public function product(): static
    {
        return $this->sanitize('array_product');
    }

    public function keyToCase(int $to_case = CASE_LOWER): static
    {
        return $this->sanitize('array_change_key_case', func_get_args());
    }
}
