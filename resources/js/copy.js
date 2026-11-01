// Tombol "Salin" untuk nilai kanal pelaporan dan fingerprint PGP: <button data-copy="teks">Salin</button>
// Berkas JS terpisah (bukan inline) agar lolos CSP script-src 'self'. Impor dari resources/js/app.js.
document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-copy]');
    if (!button) {
        return;
    }

    try {
        await navigator.clipboard.writeText(button.dataset.copy);
        const original = button.textContent;
        button.textContent = 'Tersalin';
        if (typeof window.showCsirtFeedback === 'function') {
            window.showCsirtFeedback({
                status: 'success',
                title: 'Berhasil Disalin!',
                message: 'Informasi telah disalin ke papan klip (clipboard).',
            });
        }
        setTimeout(() => {
            button.textContent = original;
        }, 2000);
    } catch (error) {
        // Clipboard tidak tersedia (mis. HTTP biasa): biarkan pengguna menyalin manual.
    }
});
