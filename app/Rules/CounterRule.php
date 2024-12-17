<?php

declare(strict_types=1);

namespace App\Rules;

use App\Exceptions\MissingMethodException;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ReflectionException;

final readonly class CounterRule implements ValidationRule
{
    public function __construct(
        private mixed $model,
        private string $relation,
        private int $max = 8
    ) {
    }

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure  $fail
     * @return void
     * @throws ReflectionException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!method_exists($this->model, $this->relation)) {
            MissingMethodException::throw($this->model, $this->relation);
        }

        $inputCount = count($value);
        $dbCount = $this->model->{$this->relation}->count();

        if ($this->max < ($inputCount + $dbCount)) {
            $fail("There's no $this->relation in $this->model");
        }
    }
}
