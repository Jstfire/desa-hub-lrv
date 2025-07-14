window.openGalleryModal = function (imageUrl, title, description, date, type, category, author, viewCount, sourceUrl) {
    // Validasi URL gambar
    if (!imageUrl || imageUrl.trim() === '') {
        console.warn('URL gambar tidak tersedia');
        return;
    }

    // Ambil elemen modal dan komponen
    const modal = document.getElementById('galleryModal');
    const modalImage = document.getElementById('modalImage');
    const spinner = document.getElementById('imageSpinner');

    // Tampilkan spinner dan sembunyikan gambar
    spinner.style.display = 'block';
    modalImage.style.display = 'none';
    modalImage.removeAttribute('src');

    // Buat gambar baru untuk preload
    const img = new Image();
    img.onload = function () {
        modalImage.src = this.src;
        modalImage.alt = title || 'Gallery Image';
        spinner.style.display = 'none';
        modalImage.style.display = 'block';
        updateMediaInfo(modalImage, imageUrl);
    };

    img.onerror = function () {
        modalImage.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDYwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI2MDAiIGhlaWdodD0iNDAwIiBmaWxsPSIjMzc0MTUxIi8+Cjx0ZXh0IHg9IjMwMCIgeT0iMjAwIiBmaWxsPSJ3aGl0ZSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE4IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+R2FtYmFyIFRpZGFrIERpdGVtdWthbjwvdGV4dD4KPC9zdmc+';
        modalImage.alt = 'Gambar tidak ditemukan';
        spinner.style.display = 'none';
        modalImage.style.display = 'block';
    };

    img.src = imageUrl;

    // Set informasi modal
    setModalInfo({
        title: title,
        description: description,
        date: date,
        type: type,
        category: category,
        author: author,
        viewCount: viewCount,
        sourceUrl: sourceUrl
    });

    // Tampilkan modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function setModalInfo(data) {
    document.getElementById('modalTitle').textContent = data.title || 'Tanpa Judul';
    document.getElementById('modalDescription').textContent = data.description || 'Tidak ada deskripsi tersedia.';

    // Set type and category
    const typeEl = document.getElementById('modalType');
    const categoryEl = document.getElementById('modalCategory');
    
    if (data.type) {
        typeEl.textContent = data.type;
        typeEl.style.display = 'inline-flex';
    } else {
        typeEl.style.display = 'none';
    }
    
    if (data.category) {
        categoryEl.textContent = data.category;
        categoryEl.style.display = 'inline-flex';
    } else {
        categoryEl.style.display = 'none';
    }

    // Set date
    const dateTextEl = document.getElementById('modalDateText');
    const dateContainerEl = document.getElementById('modalDate');
    if (data.date) {
        dateTextEl.textContent = data.date;
        dateContainerEl.style.display = 'flex';
    } else {
        dateContainerEl.style.display = 'none';
    }

    // Set author
    const authorTextEl = document.getElementById('modalAuthorText');
    const authorContainerEl = document.getElementById('modalAuthor');
    if (data.author) {
        authorTextEl.textContent = data.author;
        authorContainerEl.style.display = 'flex';
    } else {
        authorContainerEl.style.display = 'none';
    }

    // Set view count
    const viewsTextEl = document.getElementById('modalViewsText');
    const viewsContainerEl = document.getElementById('modalViews');
    if (data.viewCount !== undefined && data.viewCount !== null) {
        viewsTextEl.textContent = `${data.viewCount} kali`;
        viewsContainerEl.style.display = 'flex';
    } else {
        viewsContainerEl.style.display = 'none';
    }

    // Set source link
    const sourceContainerEl = document.getElementById('modalSource');
    const sourceLinkEl = document.getElementById('modalSourceLink');
    if (data.sourceUrl) {
        sourceLinkEl.href = data.sourceUrl;
        sourceContainerEl.style.display = 'flex';
    } else {
        sourceContainerEl.style.display = 'none';
    }
}

window.closeGalleryModal = function () {
    const modal = document.getElementById('galleryModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function updateMediaInfo(imageElement, imageUrl) {
    const resolutionElement = document.getElementById('imageResolution');
    const sizeElement = document.getElementById('imageSize');
    const formatElement = document.getElementById('imageFormat');

    // Update resolution
    if (imageElement.naturalWidth && imageElement.naturalHeight) {
        resolutionElement.textContent = `${imageElement.naturalWidth} × ${imageElement.naturalHeight} px`;
    } else {
        resolutionElement.textContent = 'Resolusi tidak diketahui';
    }

    // Extract format from URL
    const urlParts = imageUrl.split('.');
    const extension = urlParts[urlParts.length - 1].split('?')[0].toUpperCase();
    if (extension && ['JPG', 'JPEG', 'PNG', 'GIF', 'WEBP', 'SVG', 'BMP'].includes(extension)) {
        formatElement.textContent = extension;
    } else {
        formatElement.textContent = 'Tidak diketahui';
    }

    // Estimate file size
    if (imageElement.naturalWidth && imageElement.naturalHeight) {
        const pixels = imageElement.naturalWidth * imageElement.naturalHeight;
        let estimatedSize;

        switch (extension) {
            case 'PNG':
                estimatedSize = pixels * 4;
                break;
            case 'JPEG':
            case 'JPG':
                estimatedSize = pixels * 0.5;
                break;
            case 'GIF':
                estimatedSize = pixels * 1;
                break;
            case 'WEBP':
                estimatedSize = pixels * 0.3;
                break;
            default:
                estimatedSize = pixels * 3;
        }

        if (estimatedSize < 1024) {
            sizeElement.textContent = `~${Math.round(estimatedSize)} B`;
        } else if (estimatedSize < 1024 * 1024) {
            sizeElement.textContent = `~${Math.round(estimatedSize / 1024)} KB`;
        } else {
            sizeElement.textContent = `~${Math.round(estimatedSize / (1024 * 1024))} MB`;
        }
    } else {
        sizeElement.textContent = 'Tidak diketahui';
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Tutup modal saat klik backdrop
    const modal = document.getElementById('galleryModal');
    modal.addEventListener('click', function (e) {
        if (e.target === this) {
            closeGalleryModal();
        }
    });

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('galleryModal');
            if (!modal.classList.contains('hidden')) {
                closeGalleryModal();
            }
        }
    });
});