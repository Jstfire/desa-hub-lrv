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

    const typeCategoryEl = document.getElementById('modalTypeCategory');
    if (data.type && data.category) {
        typeCategoryEl.textContent = `${data.type} / ${data.category}`;
        typeCategoryEl.parentElement.style.display = 'flex';
    } else {
        typeCategoryEl.parentElement.style.display = 'none';
    }

    const dateEl = document.getElementById('modalDate');
    if (data.date) {
        dateEl.textContent = data.date;
        dateEl.parentElement.style.display = 'flex';
    } else {
        dateEl.parentElement.style.display = 'none';
    }

    const authorEl = document.getElementById('modalAuthor');
    if (data.author) {
        authorEl.textContent = data.author;
        authorEl.parentElement.style.display = 'flex';
    } else {
        authorEl.parentElement.style.display = 'none';
    }

    const viewsEl = document.getElementById('modalViews');
    if (data.viewCount !== undefined && data.viewCount !== null) {
        viewsEl.textContent = `${data.viewCount} kali dilihat`;
        viewsEl.parentElement.style.display = 'flex';
    } else {
        viewsEl.parentElement.style.display = 'none';
    }

    const sourceContainer = document.getElementById('source-container');
    const sourceLink = document.getElementById('modalSourceLink');
    if (data.sourceUrl) {
        sourceLink.href = data.sourceUrl;
        sourceContainer.style.display = 'flex';
    } else {
        sourceContainer.style.display = 'none';
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