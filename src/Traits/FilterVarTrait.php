<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Traits;

trait FilterVarTrait
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
        $new = clone $this;
        $new->sanitizers[] = [$filter => $options];
        return $new;
    }
    
    public function __invoke(...$values): mixed
    {
        $response = [];
        foreach ($values as $value) {
            $sanitizer = (method_exists($this, 'getManipulator')) ? $this->getManipulator($value) : null;
            foreach ($this->sanitizers as $sanitizers) {
                foreach ($sanitizers as $function => $options) {
                    $function = empty($sanitizer) ? $function : [$sanitizer, $function];
                    $sanitizer = call_user_func_array($function, $options);
                }
            }
            $response[] = ($sanitizer instanceof ArrayManipulators) ? $sanitizer($value) : $sanitizer;
        }
        return (count(func_get_args()) == 1) ? current($response) : $response;
    }

}
