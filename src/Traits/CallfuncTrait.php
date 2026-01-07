<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Traits;

trait CallfuncTrait
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

    public function __invoke(array ...$datas): mixed
    {
        if (false and func_num_args() > 1) {
            foreach ($datas as $index => $data) {
                $datas[$index] = $this($data);
            }
        } else {
            foreach ($this->sanitizers as $function => $options) {
                if (empty($options)) {
                    $datas = call_user_func_array($function, $datas);
                } elseif (isset($options['map'])) {
                    $datas = array_map($function, [$options['map']], [$datas]);
                } elseif (isset($options['iterable'])) {
                    $datas = call_user_func($function, $datas);
                } else {
                    $datas = call_user_func_array($function, array_merge($datas, $options));
                }
            }
        }
        return $datas;
    }
}
