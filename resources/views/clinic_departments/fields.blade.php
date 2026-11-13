<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-5">
            {{ Form::label('title', 'Department Name:', ['class' => 'form-label required']) }}
            {{ Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => 'e.g. Orthopedic Physiotherapy', 'id' => 'departmentTitle']) }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-5">
            {{ Form::label('slug', 'Slug (URL):', ['class' => 'form-label']) }}
            {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Leave empty to auto-generate', 'id' => 'departmentSlug']) }}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group mb-5">
            {{ Form::label('short_description', 'Short Description (Card Summary):', ['class' => 'form-label']) }}
            {{ Form::textarea('short_description', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Brief 1-2 sentence overview for cards and search listings...']) }}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group mb-5">
            {{ Form::label('details', 'Department Details (Rich Content):', ['class' => 'form-label']) }}
            <div class="text-muted fs-7 mb-2">Decorate department text with headings, bold, bullet points, colors, tables, and images using the editor below:</div>
            {{ Form::textarea('details', null, ['class' => 'form-control', 'id' => 'departmentDetails', 'rows' => 12]) }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-5" io-image-input="true">
            {{ Form::label('image', 'Featured Department Image:', ['class' => 'form-label']) }}
            <div class="d-block">
                <?php
                $defaultImg = isset($clinicDepartment) && $clinicDepartment->image_url ? $clinicDepartment->image_url : asset('web_front/images/services/medicine.png');
                ?>
                <div class="image-picker">
                    <div class="image previewImage" id="deptPreviewImage"
                         style="background-image: url('{{ $defaultImg }}'); width: 140px; height: 140px; background-size: cover; background-position: center; border-radius: 8px; border: 1px solid #e4e6ef;">
                        <span class="picker-edit rounded-circle text-gray-500 fs-small" title="Change Image">
                            <label>
                                <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                {{ Form::file('image', ['id' => 'deptImageInput', 'class' => 'image-upload d-none document-file', 'accept' => '.png, .jpg, .jpeg, .webp']) }}
                            </label>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-text text-muted mt-2">Allowed file types: png, jpg, jpeg, webp.</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-5 d-flex flex-column">
            {{ Form::label('is_active', 'Department Status:', ['class' => 'form-label']) }}
            <div class="form-check form-switch mt-2">
                <input class="form-check-input w-35px h-20px is-active" name="is_active" type="checkbox"
                       value="1" {{ (!isset($clinicDepartment) || $clinicDepartment->is_active) ? 'checked' : '' }}>
                <span class="ms-2 text-gray-700">Active / Visible on Frontend</span>
            </div>
        </div>
    </div>

    <!-- Multiple Gallery Images Upload Section -->
    <div class="col-md-12">
        <div class="card bg-light border border-dashed border-primary p-6 mb-5 rounded-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="fw-bold text-gray-900 mb-1">
                        <i class="fa-solid fa-images text-primary me-2"></i> Department Photo Gallery (Multiple Images)
                    </h5>
                    <p class="text-muted fs-7 mb-0">Upload multiple photos showcasing treatments, patient therapy sessions, clinic equipment, and doctors in this department.</p>
                </div>
                <div>
                    <label for="deptGalleryInput" class="btn btn-primary btn-sm px-4">
                        <i class="fa-solid fa-cloud-arrow-up me-2"></i> Select Multiple Photos
                    </label>
                    <input type="file" name="gallery_images[]" id="deptGalleryInput" class="d-none" multiple accept=".png, .jpg, .jpeg, .webp">
                </div>
            </div>

            <div class="alert alert-secondary py-2 px-3 mb-3 fs-7 text-muted d-flex align-items-center">
                <i class="fa-solid fa-circle-info text-primary me-2 fs-6"></i>
                <span>You can select multiple photos at once (hold <kbd>Ctrl</kbd> or <kbd>Shift</kbd> while picking files). Supported formats: PNG, JPG, JPEG, WEBP (Max 10MB each).</span>
            </div>

            <!-- Real-time Preview for Newly Picked Files -->
            <div id="newGalleryPreviewSection" class="d-none mt-2">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <h6 class="fw-bold text-gray-800 mb-0">
                        <i class="fa-solid fa-circle-check text-success me-1"></i> New Photos Ready to Upload (<span id="newFilesCount">0</span> selected)
                    </h6>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0" id="btnClearNewGallery">
                        <i class="fa-solid fa-xmark me-1"></i> Clear All Selected
                    </button>
                </div>
                <div class="row g-3" id="newGalleryPreviewContainer"></div>
            </div>

            <!-- Existing Uploaded Gallery Photos (In Edit Mode) -->
            @if(isset($clinicDepartment) && count($clinicDepartment->gallery_items) > 0)
                <div class="existing-gallery-section mt-4 pt-4 border-top">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-gray-800 mb-0">
                            <i class="fa-solid fa-photo-film text-info me-2"></i> Current Department Photos (<span id="existingCount">{{ count($clinicDepartment->gallery_items) }}</span>)
                        </h6>
                        <span class="badge bg-light-danger text-danger fs-8">Click trash icon to delete individual photos</span>
                    </div>
                    <div class="row g-3" id="existingGalleryList">
                        @foreach($clinicDepartment->gallery_items as $item)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 gallery-item-card" id="gallery-card-{{ $item['id'] }}">
                                <div class="card h-100 border shadow-xs position-relative overflow-hidden">
                                    <div class="position-relative" style="height: 120px; background: #eef2f5;">
                                        <img src="{{ $item['url'] }}" class="w-100 h-100" style="object-fit: cover;" alt="Gallery image">
                                        <button type="button"
                                                class="btn btn-sm btn-icon btn-danger position-absolute top-0 end-0 m-2 rounded-circle shadow-sm btn-delete-gallery-img"
                                                data-id="{{ $item['id'] }}"
                                                data-url="{{ route('clinic-departments.deleteGalleryImage', [$clinicDepartment->id, $item['id']]) }}"
                                                title="Delete this image">
                                            <i class="fa-solid fa-trash fs-8"></i>
                                        </button>
                                    </div>
                                    <div class="p-2 bg-white text-center">
                                        <span class="d-block text-truncate fs-8 text-gray-600" title="{{ $item['name'] }}">{{ $item['name'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-end mt-5">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'btnDeptSave']) }}
        <a href="{{ route('clinic-departments.index') }}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#departmentDetails',
                license_key: 'gpl',
                height: 480,
                menubar: 'file edit view insert format tools table help',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample', 'directionality'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link image media | removeformat code fullscreen help',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #333; } h1,h2,h3,h4 { color: #1e293b; font-weight: 600; margin-top: 1rem; } ul { padding-left: 20px; } table { width: 100%; border-collapse: collapse; margin: 12px 0; } table th, table td { border: 1px solid #ddd; padding: 8px; }',
                branding: false,
                promotion: false,
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                }
            });
        }

        // Auto generate slug from title if empty
        const titleInput = document.getElementById('departmentTitle');
        const slugInput = document.getElementById('departmentSlug');
        if (titleInput && slugInput) {
            titleInput.addEventListener('blur', function () {
                if (!slugInput.value.trim()) {
                    slugInput.value = titleInput.value.toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                }
            });
        }

        // Primary Image input preview
        const imgInput = document.getElementById('deptImageInput');
        const preview = document.getElementById('deptPreviewImage');
        if (imgInput && preview) {
            imgInput.addEventListener('change', function (e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.style.backgroundImage = 'url(' + e.target.result + ')';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // Multiple Gallery Images Handler with Live Previews & Removal
        const galleryInput = document.getElementById('deptGalleryInput');
        const newPreviewSection = document.getElementById('newGalleryPreviewSection');
        const newPreviewContainer = document.getElementById('newGalleryPreviewContainer');
        const newFilesCount = document.getElementById('newFilesCount');
        const btnClearNewGallery = document.getElementById('btnClearNewGallery');

        let dt = new DataTransfer();

        function renderNewGalleryPreviews() {
            if (!newPreviewContainer) return;
            newPreviewContainer.innerHTML = '';

            if (dt.files.length === 0) {
                if (newPreviewSection) newPreviewSection.classList.add('d-none');
                return;
            }

            if (newPreviewSection) newPreviewSection.classList.remove('d-none');
            if (newFilesCount) newFilesCount.innerText = dt.files.length;

            Array.from(dt.files).forEach((file, index) => {
                const col = document.createElement('div');
                col.className = 'col-lg-2 col-md-3 col-sm-4 col-6';

                const card = document.createElement('div');
                card.className = 'card h-100 border shadow-xs position-relative overflow-hidden';

                const imgWrapper = document.createElement('div');
                imgWrapper.className = 'position-relative';
                imgWrapper.style.height = '120px';
                imgWrapper.style.backgroundColor = '#f1f5f9';

                const img = document.createElement('img');
                img.className = 'w-100 h-100';
                img.style.objectFit = 'cover';
                img.src = URL.createObjectURL(file);
                img.alt = file.name;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-sm btn-icon btn-danger position-absolute top-0 end-0 m-2 rounded-circle shadow-sm';
                removeBtn.title = 'Remove this file';
                removeBtn.innerHTML = '<i class="fa-solid fa-xmark fs-8"></i>';
                removeBtn.addEventListener('click', function () {
                    removeFileFromDt(index);
                });

                imgWrapper.appendChild(img);
                imgWrapper.appendChild(removeBtn);

                const footer = document.createElement('div');
                footer.className = 'p-2 bg-white text-center';
                const sizeKb = Math.round(file.size / 1024);
                footer.innerHTML = `<span class="d-block text-truncate fs-8 text-gray-800 fw-medium" title="${file.name}">${file.name}</span>
                                    <span class="fs-9 text-muted">${sizeKb} KB</span>`;

                card.appendChild(imgWrapper);
                card.appendChild(footer);
                col.appendChild(card);
                newPreviewContainer.appendChild(col);
            });
        }

        function removeFileFromDt(indexToRemove) {
            const newDt = new DataTransfer();
            Array.from(dt.files).forEach((file, i) => {
                if (i !== indexToRemove) {
                    newDt.items.add(file);
                }
            });
            dt = newDt;
            galleryInput.files = dt.files;
            renderNewGalleryPreviews();
        }

        if (galleryInput) {
            galleryInput.addEventListener('change', function () {
                if (this.files && this.files.length > 0) {
                    Array.from(this.files).forEach(file => {
                        dt.items.add(file);
                    });
                    this.files = dt.files;
                    renderNewGalleryPreviews();
                }
            });
        }

        if (btnClearNewGallery) {
            btnClearNewGallery.addEventListener('click', function () {
                dt = new DataTransfer();
                if (galleryInput) galleryInput.files = dt.files;
                renderNewGalleryPreviews();
            });
        }

        // Delete Existing Gallery Image via AJAX
        document.querySelectorAll('.btn-delete-gallery-img').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const btn = this;
                const cardId = btn.getAttribute('data-id');
                const deleteUrl = btn.getAttribute('data-url');
                const card = document.getElementById('gallery-card-' + cardId);

                if (!confirm('Are you sure you want to delete this gallery photo?')) {
                    return;
                }

                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

                const csrfToken = document.querySelector('meta[name="csrf-token"]') ?
                    document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (card) {
                            card.style.transition = 'all 0.3s ease';
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.8)';
                            setTimeout(() => {
                                card.remove();
                                const countSpan = document.getElementById('existingCount');
                                if (countSpan) {
                                    const currentCount = parseInt(countSpan.innerText) || 1;
                                    countSpan.innerText = Math.max(0, currentCount - 1);
                                }
                            }, 300);
                        }
                        if (typeof displaySuccessMessage === 'function') {
                            displaySuccessMessage(data.message || 'Gallery image deleted successfully.');
                        } else if (typeof toastr !== 'undefined') {
                            toastr.success(data.message || 'Gallery image deleted successfully.');
                        }
                    } else {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-trash fs-8"></i>';
                        alert(data.message || 'Failed to delete image.');
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-trash fs-8"></i>';
                    console.error(err);
                    alert('Error deleting image.');
                });
            });
        });

        // Trigger tinymce save on form submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function () {
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }
            });
        }
    });
</script>
