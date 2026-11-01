// Navigasi: dropdown desktop dan menu ponsel (docs/03, docs/07).
// Pola "disclosure": <button data-nav-toggle aria-controls="id" aria-expanded="false"> membuka/menutup panel #id.
//   - data-nav-group   : toggle dalam grup yang sama saling menutup.
//   - data-nav-autoclose: ditutup oleh Escape, klik di luar, dan perubahan ke layar lebar.
//   - data-nav-root    : wadah; menutup dropdown di dalamnya saat fokus keyboard keluar dari wadah.
// Berkas JS terpisah (bukan inline) agar lolos CSP script-src 'self'. Tidak bergantung pada hover.

const panelOf = (toggle) => document.getElementById(toggle.getAttribute('aria-controls'));
const isOpen = (toggle) => toggle.getAttribute('aria-expanded') === 'true';

function setOpen(toggle, open) {
    const panel = panelOf(toggle);
    if (!panel) {
        return;
    }
    toggle.setAttribute('aria-expanded', String(open));
    panel.hidden = !open;
}

function openAutoclose() {
    return [...document.querySelectorAll('[data-nav-toggle][data-nav-autoclose]')].filter(isOpen);
}

document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-nav-toggle]');

    if (toggle) {
        const willOpen = !isOpen(toggle);
        const group = toggle.dataset.navGroup;

        if (willOpen && group) {
            document.querySelectorAll(`[data-nav-toggle][data-nav-group="${group}"]`).forEach((other) => {
                if (other !== toggle) {
                    setOpen(other, false);
                }
            });
        }
        setOpen(toggle, willOpen);

        return;
    }

    // Klik di luar panel menutup dropdown/menu yang terbuka.
    openAutoclose().forEach((open) => {
        if (!panelOf(open)?.contains(event.target)) {
            setOpen(open, false);
        }
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
        return;
    }

    const open = openAutoclose();
    if (open.length === 0) {
        return;
    }

    // Kembalikan fokus ke tombol yang membuka panel tempat fokus berada.
    const active = document.activeElement;
    const owner = open.find((toggle) => toggle === active || panelOf(toggle)?.contains(active)) ?? open[0];

    open.forEach((toggle) => setOpen(toggle, false));
    owner.focus();
});

// Fokus keyboard keluar dari menu desktop: tutup dropdown.
document.addEventListener('focusout', (event) => {
    const root = event.target.closest('[data-nav-root]');

    if (!root || !event.relatedTarget || root.contains(event.relatedTarget)) {
        return;
    }

    root.querySelectorAll('[data-nav-toggle]').forEach((toggle) => setOpen(toggle, false));
});

// Menu ponsel tertutup bila layar melebar ke tampilan desktop.
window.matchMedia('(min-width: 1024px)').addEventListener('change', (query) => {
    if (query.matches) {
        document.querySelectorAll('[data-nav-toggle]').forEach((toggle) => setOpen(toggle, false));
    }
});
