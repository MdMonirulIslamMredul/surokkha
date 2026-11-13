<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ClinicDepartment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = 'clinic_departments';

    public const PATH = 'clinic_departments';
    public const GALLERY_PATH = 'clinic_departments_gallery';

    public const ACTIVE = 1;
    public const INACTIVE = 0;

    public $fillable = [
        'title',
        'slug',
        'short_description',
        'details',
        'image',
        'gallery_images',
        'is_active',
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'short_description' => 'string',
        'details' => 'string',
        'image' => 'string',
        'gallery_images' => 'array',
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_url', 'gallery_items', 'gallery_urls'];

    public static $rules = [
        'title' => 'required|max:255',
        'short_description' => 'nullable',
        'details' => 'nullable',
        'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:10240',
        'gallery_images.*' => 'nullable|mimes:jpeg,png,jpg,webp|max:10240',
    ];

    public static function formatMediaUrl(?string $url): string
    {
        if (empty($url)) {
            return '';
        }
        if (Str::startsWith($url, 'http://localhost/')) {
            return asset(Str::after($url, 'http://localhost/'));
        }
        if (Str::startsWith($url, 'https://localhost/')) {
            return asset(Str::after($url, 'https://localhost/'));
        }

        return $url;
    }

    public function getImageUrlAttribute()
    {
        $media = $this->getMedia(self::PATH)->first() ?? $this->media->first();
        if (! empty($media)) {
            return self::formatMediaUrl($media->getFullUrl());
        }

        if (! empty($this->image)) {
            if (Str::startsWith($this->image, ['http://', 'https://'])) {
                return self::formatMediaUrl($this->image);
            }

            return asset($this->image);
        }

        return asset('web_front/images/services/medicine.png');
    }

    /**
     * Get list of gallery items with ID and URLs for Admin CRUD display & deletion
     */
    public function getGalleryItemsAttribute(): array
    {
        $items = [];

        // 1. Spatie MediaLibrary collection
        $mediaItems = $this->getMedia(self::GALLERY_PATH);
        if ($mediaItems->isNotEmpty()) {
            foreach ($mediaItems as $media) {
                $items[] = [
                    'id' => $media->id,
                    'url' => self::formatMediaUrl($media->getFullUrl()),
                    'name' => $media->file_name,
                    'size' => $media->human_readable_size,
                    'type' => 'media',
                ];
            }

            return $items;
        }

        // 2. Custom JSON array paths (fallback if no Spatie media exists)
        if (is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $idx => $path) {
                if (!empty($path)) {
                    $url = Str::startsWith($path, ['http://', 'https://']) ? self::formatMediaUrl($path) : asset($path);
                    $items[] = [
                        'id' => 'path_' . $idx,
                        'url' => $url,
                        'name' => basename($path),
                        'size' => '',
                        'type' => 'path',
                    ];
                }
            }
        }

        return $items;
    }

    /**
     * Get array of all gallery image URLs (Spatie Media + JSON paths + fallback title-matched files)
     */
    public function getGalleryUrlsAttribute(): array
    {
        $urls = [];

        // 1. Spatie Media
        $mediaItems = $this->getMedia(self::GALLERY_PATH);
        if ($mediaItems->isNotEmpty()) {
            foreach ($mediaItems as $media) {
                $urls[] = self::formatMediaUrl($media->getFullUrl());
            }

            return array_values(array_unique($urls));
        }

        // 2. JSON column (fallback if no Spatie media exists)
        if (is_array($this->gallery_images) && count($this->gallery_images) > 0) {
            foreach ($this->gallery_images as $path) {
                if (!empty($path)) {
                    $urls[] = Str::startsWith($path, ['http://', 'https://']) ? self::formatMediaUrl($path) : asset($path);
                }
            }

            if (!empty($urls)) {
                return array_values(array_unique($urls));
            }
        }

        // 3. If no custom gallery uploaded, fallback to relevant clinic files matching department title
        if (empty($urls) && \Illuminate\Support\Facades\File::exists(public_path('uploads/clinic_departments'))) {
            $cleanTitle = strtolower($this->title);
            $files = \Illuminate\Support\Facades\File::files(public_path('uploads/clinic_departments'));
            foreach ($files as $file) {
                $fname = $file->getFilename();
                $lfname = strtolower($fname);
                $matched = false;
                if ($cleanTitle == 'autism care' && str_contains($lfname, 'special child care')) {
                    $matched = true;
                } elseif ($cleanTitle == 'special child care' && str_contains($lfname, 'special child care')) {
                    $matched = true;
                } elseif ($cleanTitle == 'orthopedic physiotherapy' && (str_contains($lfname, 'whatsapp') || str_contains($lfname, 'orthopedic'))) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'women') && str_contains($lfname, 'women')) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'reflexology') && str_contains($lfname, 'reflexology')) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'dry needling') && str_contains($lfname, 'dry needling')) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'massage') && str_contains($lfname, 'massage')) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'nutrition') && str_contains($lfname, 'nutrition')) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'home care') && str_contains($lfname, 'home care')) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'geriatric') && str_contains($lfname, 'geriatric')) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'neurological') && str_contains($lfname, 'neurological')) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'pediatric') && str_contains($lfname, 'pediatric')) {
                    $matched = true;
                } elseif (str_contains($cleanTitle, 'sports') && str_contains($lfname, 'sports physiotherapy')) {
                    $matched = true;
                }
                if ($matched) {
                    $urls[] = asset('uploads/clinic_departments/' . $fname);
                }
            }
        }

        return array_values(array_unique($urls));
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $slug = Str::slug($model->title);
                $originalSlug = $slug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $model->id ?? 0)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }
                $model->slug = $slug;
            }
        });
    }
}
