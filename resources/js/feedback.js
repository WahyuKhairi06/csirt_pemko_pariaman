// Universal Center-Screen Animated Feedback Modal (Vanilla JS, ringan & bebas dependensi).
// Menangani feedback simpan, edit, hapus, salin, dan pengiriman pesan di Panel Admin (Filament) & Portal Publik.

(function () {
    if (window.__csirtFeedbackInitialized) {
        return;
    }
    window.__csirtFeedbackInitialized = true;

    let hideTimer = null;

    function getModalElements() {
        const overlay = document.getElementById('csirt-feedback-modal');
        if (!overlay) {
            return null;
        }

        return {
            overlay,
            card: overlay.querySelector('.csirt-fb-card'),
            title: overlay.querySelector('[data-csirt-fb-title]'),
            message: overlay.querySelector('[data-csirt-fb-message]'),
            closeBtn: overlay.querySelector('[data-csirt-fb-close]'),
        };
    }

    function normalizeTitleAndMessage(status, rawTitle, rawMessage) {
        let title = (rawTitle || '').trim();
        let message = (rawMessage || '').trim();

        const lowerTitle = title.toLowerCase();

        if (!title) {
            title = status === 'danger'
                ? 'Terjadi Kesalahan'
                : status === 'warning'
                    ? 'Perhatian'
                    : 'Berhasil Disimpan!';
        }

        // Perkaya pesan subjudul bila notifikasi bawaan hanya memiliki judul singkat
        if (!message) {
            if (lowerTitle === 'saved' || lowerTitle === 'disimpan' || lowerTitle.includes('berhasil disimpan') || lowerTitle.includes('disimpan')) {
                if (lowerTitle === 'saved') {
                    title = 'Berhasil Disimpan!';
                }
                message = 'Perubahan data Anda telah berhasil disimpan ke dalam sistem.';
            } else if (lowerTitle === 'created' || lowerTitle === 'dibuat' || lowerTitle.includes('berhasil dibuat')) {
                if (lowerTitle === 'created') {
                    title = 'Data Berhasil Dibuat!';
                }
                message = 'Data baru telah berhasil ditambahkan dan disimpan.';
            } else if (lowerTitle === 'deleted' || lowerTitle === 'dihapus' || lowerTitle.includes('berhasil dihapus')) {
                if (lowerTitle === 'deleted') {
                    title = 'Data Berhasil Dihapus';
                }
                message = 'Data yang dipilih telah dihapus dari sistem.';
            } else if (lowerTitle.includes('terkirim') || lowerTitle.includes('dikirim') || lowerTitle === 'sent') {
                message = 'Pesan atau formulir Anda telah berhasil dikirimkan.';
            } else if (status === 'success') {
                message = 'Tindakan Anda telah berhasil diproses oleh sistem.';
            }
        }

        return { title, message };
    }

    function hideCsirtFeedback() {
        const els = getModalElements();
        if (!els) {
            return;
        }

        if (hideTimer) {
            clearTimeout(hideTimer);
            hideTimer = null;
        }

        els.overlay.classList.remove('is-visible', 'is-animating');
        els.overlay.setAttribute('aria-hidden', 'true');
    }

    function showCsirtFeedback(options = {}) {
        const els = getModalElements();
        if (!els) {
            return;
        }

        const status = ['success', 'danger', 'warning', 'info'].includes(options.status)
            ? options.status
            : 'success';

        const { title, message } = normalizeTitleAndMessage(
            status,
            options.title,
            options.message
        );

        const duration = typeof options.duration === 'number'
            ? options.duration
            : 5000;

        if (hideTimer) {
            clearTimeout(hideTimer);
            hideTimer = null;
        }

        els.card.setAttribute('data-status', status);
        els.overlay.style.setProperty('--csirt-fb-duration', `${duration}ms`);
        els.title.textContent = title;

        if (message) {
            els.message.textContent = message;
            els.message.hidden = false;
        } else {
            els.message.textContent = '';
            els.message.hidden = true;
        }

        // Reset kelas animasi agar SVG ceklis menggambar ulang dari awal bila dipicu berurutan
        els.overlay.classList.remove('is-animating');
        void els.overlay.offsetWidth;

        els.overlay.setAttribute('aria-hidden', 'false');
        els.overlay.classList.add('is-visible', 'is-animating');

        hideTimer = setTimeout(() => {
            hideCsirtFeedback();
        }, duration);
    }

    window.showCsirtFeedback = showCsirtFeedback;
    window.hideCsirtFeedback = hideCsirtFeedback;

    window.addEventListener('csirt:feedback', (event) => {
        if (event && event.detail) {
            showCsirtFeedback(event.detail);
        }
    });

    // Tutup saat klik tombol OK atau area latar belakang (backdrop)
    document.addEventListener('click', (event) => {
        const closeBtn = event.target.closest('[data-csirt-fb-close]');
        if (closeBtn) {
            hideCsirtFeedback();
            return;
        }

        const overlay = document.getElementById('csirt-feedback-modal');
        if (overlay && event.target === overlay && overlay.classList.contains('is-visible')) {
            hideCsirtFeedback();
        }
    });

    // Tutup dengan tombol Escape
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            const overlay = document.getElementById('csirt-feedback-modal');
            if (overlay && overlay.classList.contains('is-visible')) {
                hideCsirtFeedback();
            }
        }
    });

    // Periksa flash session dari atribut data-* pada #csirt-feedback-modal (Portal Publik & umum)
    function checkInitialFlashFeedback() {
        const overlay = document.getElementById('csirt-feedback-modal');
        if (!overlay) {
            return;
        }

        const flashTitle = overlay.getAttribute('data-feedback-title');
        const flashMessage = overlay.getAttribute('data-feedback-message');
        const flashStatus = overlay.getAttribute('data-feedback-status') || 'success';

        if (flashTitle || flashMessage) {
            overlay.removeAttribute('data-feedback-title');
            overlay.removeAttribute('data-feedback-message');
            showCsirtFeedback({
                status: flashStatus,
                title: flashTitle || 'Berhasil!',
                message: flashMessage || '',
            });
        }
    }

    // Integrasi otomatis dengan notifikasi Filament (Simpan, Edit, Buat, Hapus, Kirim)
    function inspectFilamentNotificationNode(node) {
        if (!(node instanceof HTMLElement)) {
            return;
        }

        const notifications = node.matches('.fi-no-notification:not(.fi-inline)')
            ? [node]
            : Array.from(node.querySelectorAll?.('.fi-no-notification:not(.fi-inline)') || []);

        notifications.forEach((notif) => {
            if (notif.dataset.csirtFeedbackHandled === 'true') {
                return;
            }

            // Jika notifikasi memiliki tombol aksi khusus (misal Undo / Buka tautan), biarkan tampil apa adanya
            const hasActions = notif.querySelector('.fi-no-notification-actions a, .fi-no-notification-actions button');
            if (hasActions) {
                return;
            }

            notif.dataset.csirtFeedbackHandled = 'true';

            let status = 'success';
            if (notif.classList.contains('fi-status-danger')) {
                status = 'danger';
            } else if (notif.classList.contains('fi-status-warning')) {
                status = 'warning';
            } else if (notif.classList.contains('fi-status-info')) {
                status = 'info';
            }

            const titleEl = notif.querySelector('.fi-no-notification-title');
            const bodyEl = notif.querySelector('.fi-no-notification-body');

            const titleText = titleEl ? titleEl.textContent.trim() : '';
            const bodyText = bodyEl ? bodyEl.textContent.trim() : '';

            // Sembunyikan toast pojok secara visual tanpa menghapus elemen dari DOM
            notif.classList.add('csirt-fi-toast-intercepted');

            showCsirtFeedback({
                status,
                title: titleText,
                message: bodyText,
            });
        });
    }

    function initFeedbackObserver() {
        checkInitialFlashFeedback();
        inspectFilamentNotificationNode(document.body);

        if (window.__csirtFeedbackMutationObserver) {
            return;
        }

        const observer = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
                for (const addedNode of mutation.addedNodes) {
                    if (addedNode.nodeType === Node.ELEMENT_NODE) {
                        inspectFilamentNotificationNode(addedNode);
                    }
                }
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
        });

        window.__csirtFeedbackMutationObserver = observer;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFeedbackObserver);
    } else {
        initFeedbackObserver();
    }

    document.addEventListener('livewire:navigated', () => {
        checkInitialFlashFeedback();
        inspectFilamentNotificationNode(document.body);
    });
})();

