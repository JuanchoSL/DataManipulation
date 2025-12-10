<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Traits;

trait FilterVarTrait
{

    /**
     * @var array<int,int|array<string,mixed>> $sanitizers
     */
    protected array $sanitizers = [];

    /**
     * @param int|array<string,mixed> $options
     */
    protected function sanitize(int $filter, int|array $options = 0): static
    {
        $this->sanitizers[$filter] = $options;
        return $this;
    }

    public function __invoke(string ...$data): mixed
    {
        foreach ($data as $key => $value) {
            foreach ($this->sanitizers as $filter => $options) {
                if ($filter == FILTER_SANITIZE_NUMBER_INT) {
                    $value = number_format((float) $value, 0);
                }
                if (isset($options['callback'])) {
                    $value = call_user_func($options['callback'], $value);
                    unset($options['callback']);
                } else {
                }
                $value = filter_var($value, $filter, $options);
                $data[$key] = $value;
            }
        }
        return (count($data) == 1) ? current($data) : $data;
    }

}
