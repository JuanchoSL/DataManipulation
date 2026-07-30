<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Traits;

trait CallfuncTrait
{
    public function __invoke(...$datas): mixed
    {
        foreach ($datas as $key => $data) {
            foreach ($this->sanitizers as $function => $options) {
                if (is_iterable($options) && array_key_exists('multi', $options)) {
                    if (!is_iterable($data) || !is_iterable(current($data))) {
                        $data = [$data];
                    }
                    unset($options['multi']);
                }

                if (empty($options)) {
                    if (is_iterable($data) && is_numeric(key($data)) && is_iterable(current($data))) {
                        $data = call_user_func_array($function, $data);//merge
                    } else {
                        $data = call_user_func($function, $data);//combine y flip
                    }
                } elseif (is_iterable($options)) {
                    if (isset($options['first'])) {
                        $first = is_array($options['first']) ? $options['first'] : [$options['first']];
                        $data = call_user_func_array($function, array_merge($first, $data));
                        //$data = call_user_func_array($function, array_merge($options['first'], $data));
                    } else {
                        $data = call_user_func_array($function, array_merge([$data], $options));
                    }
                } else {
                    $data = call_user_func($function, $data, $options);
                }
            }
            $datas[$key] = $data;
        }
        $datas = (func_num_args() == 1) ? current($datas) : $datas;
        return $datas;
    }
}
