<div class="row gx-10 mb-5">
    {{-- Category --}}
    <div class="col-md-6 mb-5">
        <label for="categorySelect" class="form-label required fs-6 fw-bolder text-gray-700">Category:</label>
        <select name="category" id="categorySelect" class="form-select" required>
            <option value="">-- Select Category --</option>
            @foreach($categories as $cat => $subs)
                <option value="{{ $cat }}" {{ (isset($clinicalDiagnosis) && $clinicalDiagnosis->category == $cat) ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Subcategory --}}
    <div class="col-md-6 mb-5">
        <label for="subcategorySelect" class="form-label fs-6 fw-bolder text-gray-700">Subcategory:</label>
        <input type="text" name="subcategory" id="subcategoryInput" class="form-control"
               list="subcategoryDatalist"
               value="{{ isset($clinicalDiagnosis) ? $clinicalDiagnosis->subcategory : old('subcategory') }}"
               placeholder="e.g. Spine & Back, Shoulder, Knee...">
        <datalist id="subcategoryDatalist">
            @foreach($categories as $cat => $subs)
                @foreach($subs as $sub)
                    <option value="{{ $sub }}">{{ $cat }} - {{ $sub }}</option>
                @endforeach
            @endforeach
        </datalist>
        <small class="text-muted">Type or select an existing subcategory.</small>
    </div>

    {{-- Diagnosis Name --}}
    <div class="col-md-8 mb-5">
        <label for="diagnosisName" class="form-label required fs-6 fw-bolder text-gray-700">Diagnosis Name (Dx):</label>
        <input type="text" name="name" id="diagnosisName" class="form-control" required
               value="{{ isset($clinicalDiagnosis) ? $clinicalDiagnosis->name : old('name') }}"
               placeholder="e.g. Lumbar Spondylosis, Cerebral Palsy, ACL Injury">
    </div>

    {{-- Code (Optional ICD / Short code) --}}
    <div class="col-md-4 mb-5">
        <label for="diagnosisCode" class="form-label fs-6 fw-bolder text-gray-700">Diagnosis Code / ICD (Optional):</label>
        <input type="text" name="code" id="diagnosisCode" class="form-control"
               value="{{ isset($clinicalDiagnosis) ? $clinicalDiagnosis->code : old('code') }}"
               placeholder="e.g. M51.2, G80.0">
    </div>

    {{-- Description --}}
    <div class="col-md-12 mb-5">
        <label for="diagnosisDescription" class="form-label fs-6 fw-bolder text-gray-700">Description / Clinical Notes:</label>
        <textarea name="description" id="diagnosisDescription" rows="4" class="form-control"
                  placeholder="Optional clinical notes, signs, symptoms, or typical physiotherapy management guidelines...">{{ isset($clinicalDiagnosis) ? $clinicalDiagnosis->description : old('description') }}</textarea>
    </div>

    {{-- Status --}}
    <div class="col-md-6 mb-5">
        <label class="form-label fs-6 fw-bolder text-gray-700">Status:</label>
        <div class="form-check form-switch mt-2">
            <input type="checkbox" name="status" class="form-check-input is-active" value="1"
                   {{ (!isset($clinicalDiagnosis) || $clinicalDiagnosis->status) ? 'checked' : '' }}>
            <label class="form-check-label text-gray-700 fw-bold">Active</label>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-3 mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-1"></i> {{ isset($clinicalDiagnosis) ? 'Update Diagnosis' : 'Save Diagnosis' }}
    </button>
    <a href="{{ route('clinical-diagnoses.index') }}" class="btn btn-secondary">
        Cancel
    </a>
</div>

