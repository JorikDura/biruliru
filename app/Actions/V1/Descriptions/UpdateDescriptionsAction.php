<?php

declare(strict_types=1);

namespace App\Actions\V1\Descriptions;

use App\Exceptions\MissingMethodException;
use Illuminate\Database\Eloquent\Model;

final readonly class UpdateDescriptionsAction
{
    /**
     * Updates descriptions for model
     *
     * @param  Model  $model
     * @param  array  $attributes
     * @return void
     */
    public function __invoke(Model $model, array $attributes): void
    {
        if (!method_exists($model, 'descriptions')) {
            MissingMethodException::throw($model::class, 'descriptions');
        }

        $toUpdate = [];

        foreach ($attributes as $key => $value) {
            $attributes[$key]['nameable_id'] = $model->getKey();
            $attributes[$key]['nameable_type'] = $model::class;

            if (array_key_exists('id', $attributes[$key])) {
                $toUpdate[] = $attributes[$key];
                unset($attributes[$key]);
            }
        }

        $model->descriptions()->insert($attributes);

        foreach ($toUpdate as $value) {
            $model->descriptions()
                ->findOrFail($value['id'])
                ->update([
                    'text' => $value['name'],
                    'language' => $value['language']
                ]);
        }
    }
}
