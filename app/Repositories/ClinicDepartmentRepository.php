<?php

namespace App\Repositories;

use App\Models\ClinicDepartment;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ClinicDepartmentRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'short_description',
        'details',
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return ClinicDepartment::class;
    }

    public function store($input)
    {
        try {
            if (empty($input['slug'])) {
                $input['slug'] = Str::slug($input['title']);
            }
            $input['is_active'] = isset($input['is_active']) ? 1 : 0;

            $clinicDepartment = ClinicDepartment::create($input);

            if (isset($input['image']) && ! empty($input['image'])) {
                $clinicDepartment->addMedia($input['image'])->toMediaCollection(
                    ClinicDepartment::PATH,
                    config('app.media_disc')
                );
            }

            if (isset($input['gallery_images']) && is_array($input['gallery_images'])) {
                foreach ($input['gallery_images'] as $galleryImg) {
                    if (! empty($galleryImg)) {
                        $clinicDepartment->addMedia($galleryImg)->toMediaCollection(
                            ClinicDepartment::GALLERY_PATH,
                            config('app.media_disc')
                        );
                    }
                }
            }

            return $clinicDepartment;
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateClinicDepartment($input, $id)
    {
        try {
            $input['is_active'] = isset($input['is_active']) ? 1 : 0;
            $clinicDepartment = $this->update($input, $id);

            if (isset($input['image']) && ! empty($input['image'])) {
                $clinicDepartment->clearMediaCollection(ClinicDepartment::PATH);
                $clinicDepartment->addMedia($input['image'])->toMediaCollection(
                    ClinicDepartment::PATH,
                    config('app.media_disc')
                );
            }

            if (isset($input['gallery_images']) && is_array($input['gallery_images'])) {
                foreach ($input['gallery_images'] as $galleryImg) {
                    if (! empty($galleryImg)) {
                        $clinicDepartment->addMedia($galleryImg)->toMediaCollection(
                            ClinicDepartment::GALLERY_PATH,
                            config('app.media_disc')
                        );
                    }
                }
            }

            return $clinicDepartment;
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
