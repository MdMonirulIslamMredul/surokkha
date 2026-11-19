<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClinicalDiagnosisRequest;
use App\Http\Requests\UpdateClinicalDiagnosisRequest;
use App\Models\ClinicalDiagnosis;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClinicalDiagnosisController extends AppBaseController
{
    public function index(Request $request): View
    {
        $query = ClinicalDiagnosis::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('subcategory')) {
            $query->where('subcategory', $request->subcategory);
        }

        if ($request->filled('status')) {
            $query->where('status', (int)$request->status);
        }

        $diagnoses = $query->orderBy('category')->orderBy('subcategory')->orderBy('name')->paginate(25);

        $categories = ClinicalDiagnosis::CATEGORIES;
        $totalCount = ClinicalDiagnosis::count();
        $activeCount = ClinicalDiagnosis::where('status', 1)->count();
        $categoryCount = ClinicalDiagnosis::distinct('category')->count('category');

        return view('clinical_diagnoses.index', compact(
            'diagnoses',
            'categories',
            'totalCount',
            'activeCount',
            'categoryCount'
        ));
    }

    public function create(): View
    {
        $categories = ClinicalDiagnosis::CATEGORIES;

        return view('clinical_diagnoses.create', compact('categories'));
    }

    public function store(CreateClinicalDiagnosisRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;

        ClinicalDiagnosis::create($input);

        Flash::success('Clinical Diagnosis added successfully.');

        return redirect(route('clinical-diagnoses.index'));
    }

    public function show(ClinicalDiagnosis $clinicalDiagnosis): View|RedirectResponse
    {
        return redirect(route('clinical-diagnoses.edit', $clinicalDiagnosis->id));
    }

    public function edit(ClinicalDiagnosis $clinicalDiagnosis): View
    {
        $categories = ClinicalDiagnosis::CATEGORIES;

        return view('clinical_diagnoses.edit', compact('clinicalDiagnosis', 'categories'));
    }

    public function update(ClinicalDiagnosis $clinicalDiagnosis, UpdateClinicalDiagnosisRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;

        $clinicalDiagnosis->update($input);

        Flash::success('Clinical Diagnosis updated successfully.');

        return redirect(route('clinical-diagnoses.index'));
    }

    public function destroy(ClinicalDiagnosis $clinicalDiagnosis): JsonResponse
    {
        $clinicalDiagnosis->delete();

        return $this->sendSuccess('Clinical Diagnosis deleted successfully.');
    }

    public function activeDeActiveStatus(ClinicalDiagnosis $clinicalDiagnosis): JsonResponse
    {
        $clinicalDiagnosis->update(['status' => ! $clinicalDiagnosis->status]);

        return $this->sendSuccess('Diagnosis status updated successfully.');
    }

    public function getDiagnosesJson(Request $request): JsonResponse
    {
        $query = ClinicalDiagnosis::where('status', true);

        if ($request->filled('q')) {
            $query->search($request->q);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $diagnoses = $query->orderBy('category')->orderBy('name')->get();

        $grouped = [];
        foreach ($diagnoses as $diag) {
            $groupName = $diag->category . ($diag->subcategory ? ' - ' . $diag->subcategory : '');
            $grouped[$groupName][] = [
                'id' => $diag->id,
                'name' => $diag->name,
                'code' => $diag->code,
                'category' => $diag->category,
                'subcategory' => $diag->subcategory,
            ];
        }

        return $this->sendResponse($grouped, 'Clinical diagnoses retrieved successfully.');
    }
}

