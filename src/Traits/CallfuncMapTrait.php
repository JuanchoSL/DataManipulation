<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Traits;

trait CallfuncMapTrait
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
        foreach ($datas as $key => $data) {
            foreach ($this->sanitizers as $function => $options) {
                if (empty($options)) {
                    $data = call_user_func($function, $data);
                } else {
                    $data = call_user_func($function, $data, $options);
                }
            }
            $datas[$key] = $data;
        }
        return (func_num_args() == 1) ? current($datas) : $datas;
    }

}
