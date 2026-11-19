@extends('layouts.app')
@section('title')
    Clinical Diagnoses (Dx)
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-6">
            <div>
                <h1 class="mb-1 text-gray-800 fw-bolder">Clinical Diagnoses Library (Dx)</h1>
                <span class="text-muted fs-7">Manage conditions, classifications, and diagnostic terms for clinical consultations and prescriptions.</span>
            </div>
            <div>
                <a href="{{ route('clinical-diagnoses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> New Diagnosis
                </a>
            </div>
        </div>

        {{-- Metric Stats Cards --}}
        <div class="row g-5 mb-6">
            <div class="col-md-4">
                <div class="card card-flush h-100 bg-light-primary border border-primary border-dashed">
                    <div class="card-body d-flex align-items-center p-5">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-primary text-white fs-2">
                                <i class="fa-solid fa-notes-medical text-white"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-2hx fw-bolder text-primary">{{ $totalCount }}</div>
                            <div class="fs-6 fw-bold text-gray-600">Total Diagnoses (Dx)</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flush h-100 bg-light-success border border-success border-dashed">
                    <div class="card-body d-flex align-items-center p-5">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-success text-white fs-2">
                                <i class="fa-solid fa-check-circle text-white"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-2hx fw-bolder text-success">{{ $activeCount }}</div>
                            <div class="fs-6 fw-bold text-gray-600">Active Conditions</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flush h-100 bg-light-info border border-info border-dashed">
                    <div class="card-body d-flex align-items-center p-5">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-info text-white fs-2">
                                <i class="fa-solid fa-folder-tree text-white"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-2hx fw-bolder text-info">{{ $categoryCount }}</div>
                            <div class="fs-6 fw-bold text-gray-600">Specialty Categories</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Search Card --}}
        <div class="card mb-6 shadow-sm border border-gray-200">
            <div class="card-body p-5">
                <form method="GET" action="{{ route('clinical-diagnoses.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-bold text-gray-700">Search Diagnosis:</label>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search by diagnosis name, subcategory, or code..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-bold text-gray-700">Filter by Category:</label>
                            <select name="category" class="form-select">
                                <option value="">-- All Categories --</option>
                                @foreach($categories as $cat => $subs)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fs-7 fw-bold text-gray-700">Status:</label>
                            <select name="status" class="form-select">
                                <option value="">-- All Status --</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                            <a href="{{ route('clinical-diagnoses.index') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Diagnoses Table Card --}}
        <div class="card shadow-sm border border-gray-200">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-hover table-striped align-middle gs-4 gy-4 mb-0">
                        <thead class="bg-light">
                            <tr class="fw-bolder text-gray-700 fs-7 text-uppercase">
                                <th class="ps-4" style="width: 5%;">#</th>
                                <th style="width: 30%;">Diagnosis Name (Dx)</th>
                                <th style="width: 25%;">Category</th>
                                <th style="width: 20%;">Subcategory</th>
                                <th style="width: 8%;">Code</th>
                                <th style="width: 6%;">Status</th>
                                <th class="text-end pe-4" style="width: 6%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $badgeColors = [
                                    'Orthopedic & Musculoskeletal Conditions' => 'badge-light-primary text-primary',
                                    'Neurological Conditions' => 'badge-light-dark text-dark',
                                    'Pediatric Physiotherapy Conditions' => 'badge-light-warning text-warning',
                                    'Geriatric Physiotherapy Conditions' => 'badge-light-info text-info',
                                    'Sports Injury & Sports Rehabilitation' => 'badge-light-success text-success',
                                    'Women\'s Health & Gynaecological Physiotherapy' => 'badge-light-danger text-danger',
                                    'Cardiopulmonary & Respiratory Physiotherapy' => 'badge-light-danger text-danger',
                                    'Pain & Functional Rehabilitation' => 'badge-light-secondary text-secondary',
                                ];
                            @endphp
                            @forelse($diagnoses as $diag)
                                <tr>
                                    <td class="ps-4 text-muted fs-7">
                                        {{ $loop->iteration + ($diagnoses->currentPage() - 1) * $diagnoses->perPage() }}
                                    </td>
                                    <td>
                                        <div class="fw-bolder text-gray-800 fs-6">{{ $diag->name }}</div>
                                        @if($diag->description)
                                            <div class="text-muted fs-8">{{ \Illuminate\Support\Str::limit($diag->description, 60) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $badgeColors[$diag->category] ?? 'badge-light-primary text-primary' }} fs-8 fw-bold">
                                            {{ $diag->category }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-gray-700 fw-semibold fs-7">
                                            {{ $diag->subcategory ?: '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($diag->code)
                                            <span class="badge badge-light fs-8">{{ $diag->code }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input diag-status-toggle"
                                                   data-id="{{ $diag->id }}"
                                                   {{ $diag->status ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('clinical-diagnoses.edit', $diag->id) }}"
                                               class="btn btn-icon btn-sm btn-light-primary"
                                               title="Edit Diagnosis">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-icon btn-sm btn-light-danger delete-diag-btn"
                                                    data-id="{{ $diag->id }}"
                                                    data-name="{{ $diag->name }}"
                                                    title="Delete Diagnosis">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10 text-muted">
                                        <i class="fa-solid fa-notes-medical fs-2x mb-3 text-muted d-block"></i>
                                        No diagnoses found matching your search.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($diagnoses->hasPages())
                    <div class="p-4 border-top">
                        {{ $diagnoses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Script for Toggle & Delete --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Status Switch AJAX
            $(document).on('change', '.diag-status-toggle', function () {
                const id = $(this).data('id');
                const checkbox = $(this);
                $.ajax({
                    url: '/clinical-diagnoses/' + id + '/active-deactive',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        if (typeof displaySuccessMessage === 'function') {
                            displaySuccessMessage(res.message);
                        }
                    },
                    error: function () {
                        checkbox.prop('checked', !checkbox.prop('checked'));
                        if (typeof displayErrorMessage === 'function') {
                            displayErrorMessage('Failed to update diagnosis status.');
                        }
                    }
                });
            });

            // Delete Diagnosis AJAX
            $(document).on('click', '.delete-diag-btn', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                if (confirm('Are you sure you want to delete diagnosis "' + name + '"?')) {
                    $.ajax({
                        url: '/clinical-diagnoses/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            location.reload();
                        },
                        error: function () {
                            alert('Failed to delete diagnosis.');
                        }
                    });
                }
            });
        });
    </script>
@endsection

