<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Traits;

trait SanitizerStackedTrait
{
    /**
     * @var array<string,int|array<string,mixed>> $sanitizers
     */
    protected array $sanitizers = [];

    /**
     * @param int|array<string,mixed> $options
     */
    protected function sanitize(string $filter, int|array $options = 0): static
    {
        $this->sanitizers[$filter] = $options;
        return $this;
    }

}
