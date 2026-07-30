<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Manipulators\Arrays;

use JuanchoSL\DataManipulation\Traits\CallfuncMapTrait;
use JuanchoSL\DataManipulation\Traits\CallfuncTrait;
use JuanchoSL\DataManipulation\Traits\SanitizerStackedTrait;

class ArrayMapManipulators
{

    use CallfuncTrait, SanitizerStackedTrait;

    public function combine(array $keys): static
    {
        $this->sanitize('array_combine', $keys);
        return $this->flip();
    }

    public function filter(?callable $callback = null): static
    {
        return $this->sanitize('array_filter', func_get_args());
    }

    public function flip(): static
    {
        return $this->sanitize('array_flip');
    }

    public function unique(): static
    {
        return $this->sanitize('array_unique');
    }

    public function keyToCase(int $to_case = CASE_LOWER): static
    {
        return $this->sanitize('array_change_key_case', $to_case);
    }
}
