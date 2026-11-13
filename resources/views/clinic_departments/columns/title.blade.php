<div class="d-flex flex-column">
    <a href="{{ route('clinic-departments.show', $row->id) }}" class="text-decoration-none fw-bolder text-gray-800 text-hover-primary mb-1 fs-6">
        {{ $row->title }}
    </a>
    <span class="text-muted fs-7">{{ $row->slug }}</span>
</div>
