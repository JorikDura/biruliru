<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;
use ReflectionClass;
use ReflectionException;

final class Image extends Model
{
    use HasFactory;

    private const int DEFAULT_MIN_HEIGHT = 450;

    private const int DEFAULT_MIN_WIDTH = 450;

    private const int DEFAULT_NAME_SIZE = 6;

    private const string DEFAULT_PATH = 'images/';

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'original_path',
        'preview_path',
        'imageable_id',
        'imageable_type',
    ];

    /**
     * @throws ReflectionException
     */
    public static function create(
        UploadedFile $file,
        Model $model,
        User|int $user,
        ?string $path = null
    ): self {
        $image = InterventionImage::read($file);

        /** @var array{original: string, preview: string} $names */
        $names = self::transformName(
            path: $path,
            model: $model::class,
            image: $image,
            extension: $file->getClientOriginalExtension()
        );

        $model = self::query()->create([
            'user_id' => ($user instanceof User) ? $user->id : $user,
            'imageable_id' => $model->getKey(),
            'imageable_type' => $model::class,
            'original_path' => $names['original'],
            'preview_path' => $names['preview'],
        ]);

        self::storeImageToDisk(
            names: $names,
            image: $image,
        );

        return $model;
    }

    /**
     * @throws ReflectionException
     */
    public static function insert(
        array $files,
        Model $model,
        User|int $user,
        ?string $path = null,
    ): void {
        $result = [
            'data' => [],
            'images' => [],
        ];

        foreach ($files as $file) {
            $image = InterventionImage::read($file);

            $path ??= self::getPath($model::class);

            /** @var array{original: string, preview: string} $names */
            $names = self::transformName(
                path: $path,
                model: $model::class,
                image: $image,
                extension: $file->getClientOriginalExtension()
            );

            $result['data'][] = [
                'user_id' => ($user instanceof User) ? $user->id : $user,
                'imageable_id' => $model->getKey(),
                'imageable_type' => $model::class,
                'original_path' => $names['original'],
                'preview_path' => $names['preview'],
            ];
            $result['images'][] = $image;
        }

        self::query()->insert($result['data']);

        for ($i = 0, $iMax = count($result['images']); $i < $iMax; $i++) {
            self::storeImageToDisk(
                names: [
                    'original' => $result['data'][$i]['original_path'],
                    'preview' => $result['data'][$i]['preview_path'],
                ],
                image: $result['images'][$i]
            );
        }
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function image(): MorphTo
    {
        return $this->morphTo();
    }

    public function delete(): ?bool
    {
        $this->deleteImagesInStorage();

        return parent::delete();
    }

    public function deleteImagesInStorage(): void
    {
        Storage::disk('public')
            ->delete($this->original_path);

        if (!is_null($this->preview_path)) {
            Storage::disk('public')
                ->delete($this->preview_path);
        }
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'image_likes');
    }

    /**
     * @throws ReflectionException
     */
    private static function transformName(
        ?string $path,
        string $model,
        mixed $image,
        string $extension
    ): array {
        $name = Str::random(length: self::DEFAULT_NAME_SIZE).'-'.time();

        $path ??= self::getPath($model);

        return [
            'original' => "$path$name.$extension",
            'preview' => self::shouldScale($image)
                ? "$path$name-scaled.$extension"
                : null,
        ];
    }

    private static function shouldScale($image): bool
    {
        return ($image->height() > self::DEFAULT_MIN_HEIGHT)
            || ($image->width() > self::DEFAULT_MIN_WIDTH);
    }

    private static function storeImageToDisk(
        array $names,
        mixed $image
    ): void {
        Storage::disk('public')
            ->put(
                path: $names['original'],
                contents: $image->encodeByMediaType()
            );

        if (!is_null($names['preview'])) {
            $image = $image->scale(
                height: self::DEFAULT_MIN_HEIGHT,
                width: self::DEFAULT_MIN_WIDTH
            )->encodeByMediaType();

            Storage::disk('public')
                ->put(
                    path: $names['preview'],
                    contents: $image
                );
        }
    }

    /**
     * @throws ReflectionException
     */
    private static function getPath(string $type): string
    {
        return self::DEFAULT_PATH.Str::of(
            string: new ReflectionClass($type)->getShortName()
        )->plural()->lower()->toString().'/';
    }
}
