<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClinicDepartmentRequest;
use App\Http\Requests\UpdateClinicDepartmentRequest;
use App\Models\ClinicDepartment;
use App\Repositories\ClinicDepartmentRepository;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClinicDepartmentController extends AppBaseController
{
    /** @var ClinicDepartmentRepository */
    private $clinicDepartmentRepository;

    public function __construct(ClinicDepartmentRepository $clinicDepartmentRepo)
    {
        $this->clinicDepartmentRepository = $clinicDepartmentRepo;
    }

    public function index(): View
    {
        return view('clinic_departments.index');
    }

    public function create(): View
    {
        return view('clinic_departments.create');
    }

    public function store(CreateClinicDepartmentRequest $request): RedirectResponse
    {
        $input = $request->all();
        $this->clinicDepartmentRepository->store($input);

        Flash::success('Clinic Department saved successfully.');

        return redirect(route('clinic-departments.index'));
    }

    public function show(ClinicDepartment $clinicDepartment): View|RedirectResponse
    {
        if (empty($clinicDepartment)) {
            Flash::error('Clinic Department not found.');

            return redirect(route('clinic-departments.index'));
        }

        return view('clinic_departments.show', compact('clinicDepartment'));
    }

    public function edit(ClinicDepartment $clinicDepartment): View|RedirectResponse
    {
        if (empty($clinicDepartment)) {
            Flash::error('Clinic Department not found.');

            return redirect(route('clinic-departments.index'));
        }

        return view('clinic_departments.edit', compact('clinicDepartment'));
    }

    public function update(ClinicDepartment $clinicDepartment, UpdateClinicDepartmentRequest $request): RedirectResponse
    {
        if (empty($clinicDepartment)) {
            Flash::error('Clinic Department not found.');

            return redirect(route('clinic-departments.index'));
        }

        $this->clinicDepartmentRepository->updateClinicDepartment($request->all(), $clinicDepartment->id);

        Flash::success('Clinic Department updated successfully.');

        return redirect(route('clinic-departments.index'));
    }

    public function destroy(ClinicDepartment $clinicDepartment): JsonResponse
    {
        try {
            $clinicDepartment->clearMediaCollection(ClinicDepartment::PATH);
            $clinicDepartment->clearMediaCollection(ClinicDepartment::GALLERY_PATH);
            $clinicDepartment->delete();

            return $this->sendSuccess('Clinic Department deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function deleteGalleryImage(ClinicDepartment $clinicDepartment, $mediaId): JsonResponse
    {
        try {
            // Check if it's numeric Spatie Media ID
            if (is_numeric($mediaId)) {
                $media = $clinicDepartment->getMedia(ClinicDepartment::GALLERY_PATH)->firstWhere('id', (int) $mediaId);
                if ($media) {
                    $media->delete();

                    return $this->sendSuccess('Gallery image deleted successfully.');
                }
            }

            // Check if it's stored in JSON gallery_images column
            if (Str::startsWith($mediaId, 'path_')) {
                $idx = (int) Str::after($mediaId, 'path_');
                $gallery = $clinicDepartment->gallery_images ?? [];
                if (isset($gallery[$idx])) {
                    unset($gallery[$idx]);
                    $clinicDepartment->gallery_images = array_values($gallery);
                    $clinicDepartment->save();

                    return $this->sendSuccess('Gallery image deleted successfully.');
                }
            }

            return $this->sendError('Image not found.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function activeDeActiveStatus($id): JsonResponse
    {
        $clinicDepartment = ClinicDepartment::find($id);

        if (empty($clinicDepartment)) {
            return $this->sendError('Clinic Department not found.');
        }

        $clinicDepartment->is_active = ! $clinicDepartment->is_active;
        $clinicDepartment->save();

        return $this->sendSuccess('Status updated successfully.');
    }
}
