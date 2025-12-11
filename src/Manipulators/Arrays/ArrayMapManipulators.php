<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Manipulators\Arrays;

use JuanchoSL\DataManipulation\Traits\CallfuncMapTrait;

class ArrayMapManipulators
{

    use CallfuncMapTrait;

    public function combine(array $keys): static
    {
        $this->sanitize('array_combine', $keys);
        return $this->flip();
    }

    public function filter(): static
    {
        return $this->sanitize('array_filter');
    }

    public function flip(): static
    {
        return $this->sanitize('array_flip');
    }

    public function unique(): static
    {
        return $this->sanitize('array_unique');
    }
}
