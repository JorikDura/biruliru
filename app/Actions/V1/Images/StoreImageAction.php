<?php

declare(strict_types=1);

namespace App\Actions\V1\Images;

use App\Exceptions\MissingMethodException;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use ReflectionException;

final readonly class StoreImageAction
{
    /**
     * Stores model image
     *
     * @throws ReflectionException
     */
    public function __invoke(User $user, UploadedFile $file, ?Model $model = null): Image
    {
        $model ??= $user;

        if (!method_exists($model, 'image') && !method_exists($model, 'deleteImage')) {
            MissingMethodException::throw($model::class, 'image');
        }

        $model->deleteImage();

        return Image::create(
            file: $file,
            model: $model,
            user: $user
        );
    }
}
