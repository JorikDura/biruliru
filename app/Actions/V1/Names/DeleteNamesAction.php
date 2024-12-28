<?php

declare(strict_types=1);

namespace App\Actions\V1\Names;

use App\Exceptions\MissingMethodException;
use Illuminate\Database\Eloquent\Model;

final readonly class DeleteNamesAction
{
    /**
     * Deletes name of model
     *
     * @param  Model  $model
     * @param  array  $ids
     * @return void
     */
    public function __invoke(Model $model, array $ids): void
    {
        if (!method_exists($model, 'names')) {
            MissingMethodException::throw($model::class, 'names');
        }

        $names = $model->names()->whereIn('id', $ids)->get();

        if ($names->isNotEmpty()) {
            $model->names()->whereIn('id', $ids)->delete();
        }
    }

}
