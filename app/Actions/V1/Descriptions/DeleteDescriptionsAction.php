<?php

declare(strict_types=1);

namespace App\Actions\V1\Descriptions;

use App\Exceptions\MissingMethodException;
use Illuminate\Database\Eloquent\Model;

final readonly class DeleteDescriptionsAction
{
    /**
     * Deletes descriptions of model
     *
     * @param  Model  $model
     * @param  array  $ids
     * @return void
     */
    public function __invoke(Model $model, array $ids): void
    {
        if (!method_exists($model, 'descriptions')) {
            MissingMethodException::throw($model::class, 'descriptions');
        }

        $descriptions = $model->descriptions()->whereIn('id', $ids)->get();

        if ($descriptions->isNotEmpty()) {
            $model->descriptions()->whereIn('id', $ids)->delete();
        }
    }
}
