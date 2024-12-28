<?php

declare(strict_types=1);

namespace App\Actions\V1\Names;

use App\Exceptions\MissingMethodException;
use Illuminate\Database\Eloquent\Model;

final readonly class StoreNamesAction
{
    /**
     * Stores name for model
     *
     * @param  Model  $model
     * @param  array  $attributes
     * @return void
     */
    public function __invoke(Model $model, array $attributes): void
    {
        if (!method_exists($model, 'names')) {
            MissingMethodException::throw($model::class, 'names');
        }

        foreach ($attributes as $key => $value) {
            $attributes[$key]['nameable_id'] = $model->getKey();
            $attributes[$key]['nameable_type'] = $model::class;
        }

        $model->names()->insert($attributes);
    }
}
