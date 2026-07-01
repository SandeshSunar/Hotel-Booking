@extends('web.layouts.master')

@section('title', 'Gallery')

@section('content')
    <style>
        .gallery-heading {
            text-align: center;
            margin-bottom: 2rem;
            font-weight: bold;
        }

        .gallery-img-wrapper {
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
        }

        .gallery-img-trigger {
            display: block;
            padding: 0;
            border: 0;
            width: 100%;
            background: transparent;
        }

        .gallery-caption {
            margin-top: 0.75rem;
            font-weight: 600;
            text-align: center;
            color: #333;
            word-break: break-word;
        }

        .gallery-img-wrapper img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }

        .gallery-img-wrapper img:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .gallery-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .gallery-row .col-md-3 {
            margin-bottom: 1.5rem;
        }
    </style>

    <h1 class="gallery-heading">Our Gallery</h1>

    <div class="row gallery-row g-3 justify-content-center">
        @forelse($galleries as $gallery)
            @php
                $galleryTitle = $gallery->title ?: pathinfo($gallery->image_path, PATHINFO_FILENAME);
            @endphp
            <div class="col-md-3">
                <button type="button" class="gallery-img-trigger" data-bs-toggle="modal" data-bs-target="#galleryImageModal"
                    data-image="{{ asset('storage/' . $gallery->image_path) }}" data-title="{{ $galleryTitle }}">
                    <div class="gallery-img-wrapper">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $galleryTitle }}">
                    </div>
                </button>
                <div class="gallery-caption">{{ $galleryTitle }}</div>
            </div>
        @empty
            <p class="text-center">No images found.</p>
        @endforelse
    </div>

    <div class="modal fade" id="galleryImageModal" tabindex="-1" aria-labelledby="galleryImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryImageModalLabel">Gallery Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img id="galleryImageModalPreview" src="" alt="" class="w-100"
                        style="max-height: 75vh; object-fit: contain; background: #000;">
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const galleryModal = document.getElementById('galleryImageModal');
                const modalImage = document.getElementById('galleryImageModalPreview');
                const modalTitle = document.getElementById('galleryImageModalLabel');

                if (!galleryModal || !modalImage || !modalTitle) {
                    return;
                }

                galleryModal.addEventListener('show.bs.modal', function(event) {
                    const trigger = event.relatedTarget;

                    if (!trigger) {
                        return;
                    }

                    const imageUrl = trigger.getAttribute('data-image');
                    const imageTitle = trigger.getAttribute('data-title') || 'Gallery Image';

                    modalImage.src = imageUrl;
                    modalImage.alt = imageTitle;
                    modalTitle.textContent = imageTitle;
                });

                galleryModal.addEventListener('hidden.bs.modal', function() {
                    modalImage.src = '';
                    modalImage.alt = '';
                    modalTitle.textContent = 'Gallery Image';
                });
            });
        </script>
    @endpush
@endsection
