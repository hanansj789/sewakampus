// Pratinjau foto sebelum diunggah. Dipakai form buat listing dan form tambah foto.
document.addEventListener('change', function (event) {
    const input = event.target.closest('[data-photo-input]');
    if (!input) {
        return;
    }

    const selector = input.getAttribute('data-photo-preview');
    const preview = selector ? document.querySelector(selector) : null;
    if (!preview) {
        return;
    }

    const file = input.files && input.files[0];
    if (!file || !file.type.startsWith('image/')) {
        preview.hidden = true;
        preview.removeAttribute('src');
        return;
    }

    preview.src = URL.createObjectURL(file);
    preview.hidden = false;
});
