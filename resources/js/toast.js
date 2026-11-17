const icons = {
    success: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>',
    error: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 8v5m0 3h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3l-7.5-13a2 2 0 0 0-3.4-.1Z"/></svg>',
    warning: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 8v5m0 3h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3l-7.5-13a2 2 0 0 0-3.4-.1Z"/></svg>',
    info: '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/></svg>',
};

const titles = {
    success: 'Berhasil',
    error: 'Gagal',
    warning: 'Perhatian',
    info: 'Info',
};

const durations = { success: 3000, info: 3000, error: 5000, warning: 5000 };
const systems = Array.from(document.querySelectorAll('[data-notification-system]'));
const activeToasts = [];
let currentDialog = null;

function toastText(value) {
    return String(value == null ? '' : value).trim();
}

function removeToast(toast, immediate) {
    if (!toast || toast.dataset.closing === 'true') return;
    toast.dataset.closing = 'true';
    clearTimeout(toast._timer);
    if (toast._removeListeners) toast._removeListeners();
    const index = activeToasts.indexOf(toast);
    if (index !== -1) activeToasts.splice(index, 1);
    if (immediate || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        toast.remove();
        return;
    }
    toast.classList.add('is-leaving');
    window.setTimeout(() => toast.remove(), 220);
}

function startToastTimer(toast) {
    if (toast.dataset.closing === 'true' || toast._paused) return;
    toast._startedAt = Date.now();
    toast._timer = window.setTimeout(() => removeToast(toast, false), toast._remaining);
    const progress = toast.querySelector('.rb-toast__progress');
    if (progress) {
        progress.style.transition = 'none';
        progress.style.transform = `scaleX(${toast._remaining / toast._duration})`;
        requestAnimationFrame(() => {
            progress.style.transition = `transform ${toast._remaining}ms linear`;
            progress.style.transform = 'scaleX(0)';
        });
    }
}

function pauseToastTimer(toast) {
    if (toast.dataset.closing === 'true' || toast._paused) return;
    toast._paused = true;
    clearTimeout(toast._timer);
    toast._remaining = Math.max(0, toast._remaining - (Date.now() - toast._startedAt));
    const progress = toast.querySelector('.rb-toast__progress');
    if (progress) {
        const transform = getComputedStyle(progress).transform;
        const scale = transform === 'none' ? toast._remaining / toast._duration : Number(transform.split('(')[1].split(',')[0]);
        progress.style.transition = 'none';
        progress.style.transform = `scaleX(${Number.isFinite(scale) ? scale : toast._remaining / toast._duration})`;
    }
}

function resumeToastTimer(toast) {
    if (!toast._paused || toast.dataset.closing === 'true') return;
    toast._paused = false;
    startToastTimer(toast);
}

function showToast(type, title, message) {
    if (!icons[type]) type = 'info';
    title = toastText(title) || titles[type];
    message = toastText(message);
    if (!message) return;

    const key = `${type}\u0000${title}\u0000${message}`;
    const duplicate = activeToasts.find((toast) => toast.dataset.toastKey === key)
        || systems.some((system) => Array.from(system.querySelectorAll('.rb-toast')).some((toast) => toast.dataset.toastKey === key));
    if (duplicate) return duplicate;

    systems.forEach((system) => {
        const stack = system.querySelector('.rb-toast-stack');
        if (!stack) return;

        while (activeToasts.length >= 3) removeToast(activeToasts[0], true);
        while (stack.children.length >= 3) {
            const oldest = stack.firstElementChild;
            if (oldest.dataset.closing === 'true') oldest.remove();
            else removeToast(oldest, true);
        }

        const toast = document.createElement('article');
        toast.className = `rb-toast rb-toast--${type}`;
        toast.dataset.toastKey = key;
        toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
        toast.setAttribute('aria-live', type === 'error' ? 'assertive' : 'polite');
        toast._duration = durations[type];
        toast._remaining = toast._duration;
        toast.innerHTML = `
            <span class="rb-toast__icon">${icons[type]}</span>
            <span class="rb-toast__content">
                <strong class="rb-toast__title"></strong>
                <span class="rb-toast__message"></span>
            </span>
            <button type="button" class="rb-toast__close" aria-label="Tutup notifikasi">&times;</button>
            <span class="rb-toast__progress" aria-hidden="true"></span>`;
        toast.querySelector('.rb-toast__title').textContent = title;
        toast.querySelector('.rb-toast__message').textContent = message;
        stack.append(toast);
        activeToasts.push(toast);

        const close = () => removeToast(toast, false);
        const pause = () => pauseToastTimer(toast);
        const resume = () => resumeToastTimer(toast);
        toast.querySelector('.rb-toast__close').addEventListener('click', close);
        toast.addEventListener('mouseenter', pause);
        toast.addEventListener('mouseleave', resume);
        toast.addEventListener('focusin', pause);
        toast.addEventListener('focusout', resume);
        toast.addEventListener('touchstart', pause, { passive: true });
        toast.addEventListener('touchend', resume, { passive: true });
        toast._removeListeners = () => {
            toast.removeEventListener('mouseenter', pause);
            toast.removeEventListener('mouseleave', resume);
            toast.removeEventListener('focusin', pause);
            toast.removeEventListener('focusout', resume);
            toast.removeEventListener('touchstart', pause);
            toast.removeEventListener('touchend', resume);
        };
        requestAnimationFrame(() => toast.classList.add('is-visible'));
        startToastTimer(toast);
    });
}

function installInlineErrors(system) {
    let errors;
    try {
        errors = JSON.parse(system.dataset.inlineErrors || '{}');
    } catch (error) {
        console.error('Gagal membaca pesan validasi.', error);
        return;
    }

    Object.entries(errors).forEach(([name, messages]) => {
        const message = Array.isArray(messages) ? messages[0] : messages;
        if (!message) return;
        const loginFeedback = document.querySelector('[data-login-feedback]');
        if (name === 'email' && loginFeedback && loginFeedback.dataset.loginError) return;
        const fieldNames = new Set([
            name,
            name.replace(/\.(\d+)(?=\.|$)/g, '[$1]').replace(/\.(\w+)/g, '[$1]'),
        ]);
        const fields = Array.from(fieldNames).flatMap((fieldName) => {
            const escapedName = window.CSS && CSS.escape ? CSS.escape(fieldName) : fieldName.replace(/["\\]/g, '\\$&');
            return Array.from(document.querySelectorAll(`[name="${escapedName}"], [name="${escapedName}[]"]`));
        });
        fields.forEach((field) => {
            if (field.type === 'hidden') return;
            field.classList.add('rb-input-invalid');
            field.setAttribute('aria-invalid', 'true');
            let ancestor = field.parentElement;
            let hasExistingMessage = false;
            for (let depth = 0; ancestor && depth < 4; depth++, ancestor = ancestor.parentElement) {
                if (Array.from(ancestor.querySelectorAll('.text-red-600, .rb-inline-error'))
                    .some((existing) => existing.textContent.includes(message))) {
                    hasExistingMessage = true;
                    break;
                }
            }
            if (hasExistingMessage) return;

            const error = document.createElement('p');
            error.className = 'rb-inline-error';
            error.innerHTML = '<svg viewBox="0 0 16 16" aria-hidden="true"><circle cx="8" cy="8" r="6.5"/><path d="M8 4.5v4m0 2h.01"/></svg>';
            const text = document.createElement('span');
            text.textContent = message;
            error.append(text);
            field.insertAdjacentElement('afterend', error);
        });
    });
}

systems.forEach((system) => {
    installInlineErrors(system);
    try {
        const messages = JSON.parse(system.dataset.flashMessages || '[]');
        messages.forEach((message) => {
            if (system.dataset.toastTheme === 'customer'
                && message.type === 'success'
                && document.querySelector('.rb-success-screen')) {
                return;
            }
            const normalizedMessage = toastText(message.message).replace(/\s+/g, ' ');
            document.querySelectorAll('[role="status"], [role="alert"], .rb-success-message, .menu-catalog__notice, .categories-page__notice, .tables-page__notice, .text-green-600').forEach((notice) => {
                if (toastText(notice.textContent).replace(/\s+/g, ' ') === normalizedMessage) notice.hidden = true;
            });
            showToast(message.type, message.title, message.message);
        });
    } catch (error) {
        console.error('Gagal membaca pesan notifikasi.', error);
    }
});

window.toast = {
    success: (title, message) => showToast('success', title, message),
    error: (title, message) => showToast('error', title, message),
    warning: (title, message) => showToast('warning', title, message),
    info: (title, message) => showToast('info', title, message),
};

function installLoginFeedback() {
    const feedback = document.querySelector('[data-login-feedback]');
    const rawError = feedback && toastText(feedback.dataset.loginError);
    if (!rawError) return;

    const form = document.querySelector('[data-login-form]');
    const password = document.querySelector('#password');
    const match = rawError.match(/(\d+)\s*(seconds?|detik|minutes?|menit)/i);
    const isThrottled = /too many|attempts|percobaan/i.test(rawError);
    const seconds = match
        ? Number(match[1]) * (/minutes?|menit/i.test(match[2]) ? 60 : 1)
        : 0;

    if (password) password.value = '';
    if (form) form.classList.add('is-shaking');

    if (isThrottled) {
        let remaining = seconds;
        const updateMessage = () => {
            feedback.textContent = remaining > 0
                ? `Terlalu banyak percobaan. Coba lagi dalam ${remaining} detik.`
                : 'Waktu tunggu selesai. Kamu bisa coba login lagi.';
        };
        updateMessage();
        feedback.hidden = false;
        window.toast.error(
            'Login dibatasi',
            seconds > 0
                ? `Terlalu banyak percobaan. Coba lagi dalam ${seconds} detik.`
                : 'Terlalu banyak percobaan. Coba lagi nanti.'
        );
        if (remaining > 0) {
            const countdown = window.setInterval(() => {
                remaining -= 1;
                updateMessage();
                if (remaining <= 0) window.clearInterval(countdown);
            }, 1000);
        }
    } else {
        feedback.textContent = 'Email atau password salah';
        feedback.hidden = false;
        window.toast.error('Login gagal', 'Email atau password salah');
    }

    form?.addEventListener('animationend', () => form.classList.remove('is-shaking'), { once: true });
}

function loginUrl() {
    return systems[0]?.dataset.loginUrl || '/login';
}

function installSessionExpiry() {
    const expiredPage = document.querySelector('[data-session-expired]');
    if (expiredPage) {
        window.toast.warning('Sesi berakhir', 'Sesi berakhir, silakan login lagi');
        window.setTimeout(() => {
            window.location.replace(expiredPage.dataset.loginUrl || loginUrl());
        }, 1800);
        return;
    }

    try {
        if (window.sessionStorage.getItem('rb-session-expired') === '1') {
            window.sessionStorage.removeItem('rb-session-expired');
            window.toast.warning('Sesi berakhir', 'Sesi berakhir, silakan login lagi');
        }
    } catch (error) {
        console.warn('Penanda sesi berakhir tidak dapat dibaca.', error);
    }
}

installLoginFeedback();
installSessionExpiry();

if (typeof window.fetch === 'function') {
    const nativeFetch = window.fetch.bind(window);
    window.fetch = async (...args) => {
        const response = await nativeFetch(...args);
        const request = args[0] instanceof Request ? args[0].url : String(args[0]);
        const sameOrigin = new URL(request, window.location.href).origin === window.location.origin;
        if (sameOrigin && [401, 419].includes(response.status)) {
            const target = new URL(loginUrl(), window.location.href);
            if (target.pathname === window.location.pathname) {
                window.toast.warning('Sesi berakhir', 'Sesi berakhir, silakan login lagi');
            } else {
                let canPersistExpiry = true;
                try {
                    window.sessionStorage.setItem('rb-session-expired', '1');
                } catch (error) {
                    console.warn('Penanda sesi berakhir tidak dapat disimpan.', error);
                    canPersistExpiry = false;
                }
                if (canPersistExpiry) {
                    window.location.assign(target.href);
                } else {
                    window.toast.warning('Sesi berakhir', 'Sesi berakhir, silakan login lagi');
                    window.setTimeout(() => window.location.assign(target.href), 1800);
                }
            }
        }
        return response;
    };
}

window.confirmDialog = function ({ judul = 'Konfirmasi', pesan = 'Lanjutkan aksi ini?', aksi = 'Lanjutkan', tipe = 'default' } = {}) {
    return new Promise((resolve) => {
        const backdrop = document.querySelector('[data-confirm-backdrop]');
        if (!backdrop) {
            resolve(false);
            return;
        }
        if (currentDialog) currentDialog(false);

        const dialog = backdrop.querySelector('.rb-confirm-dialog');
        const cancel = backdrop.querySelector('[data-confirm-cancel]');
        const action = backdrop.querySelector('[data-confirm-action]');
        const previousFocus = document.activeElement;
        backdrop.querySelector('#rb-confirm-title').textContent = toastText(judul);
        backdrop.querySelector('#rb-confirm-message').textContent = toastText(pesan);
        action.textContent = toastText(aksi) || 'Lanjutkan';
        action.classList.toggle('is-danger', tipe === 'danger' || tipe === 'hapus');
        backdrop.hidden = false;
        document.body.classList.add('rb-dialog-open');
        action.focus();

        let settled = false;
        const finish = (confirmed) => {
            if (settled) return;
            settled = true;
            backdrop.hidden = true;
            document.body.classList.remove('rb-dialog-open');
            backdrop.removeEventListener('click', onBackdrop);
            dialog.removeEventListener('keydown', onKeydown);
            cancel.removeEventListener('click', onCancel);
            action.removeEventListener('click', onAction);
            currentDialog = null;
            if (previousFocus && typeof previousFocus.focus === 'function') previousFocus.focus();
            resolve(confirmed);
        };
        const onCancel = () => finish(false);
        const onAction = () => finish(true);
        const onBackdrop = (event) => {
            if (event.target === backdrop) finish(false);
        };
        const onKeydown = (event) => {
            if (event.key === 'Escape') {
                event.preventDefault();
                finish(false);
                return;
            }
            if (event.key !== 'Tab') return;
            const focusable = Array.from(dialog.querySelectorAll('button:not(:disabled), [href], input:not(:disabled), [tabindex]:not([tabindex="-1"])'));
            if (!focusable.length) {
                event.preventDefault();
                dialog.focus();
                return;
            }
            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        };
        cancel.addEventListener('click', onCancel);
        action.addEventListener('click', onAction);
        backdrop.addEventListener('click', onBackdrop);
        dialog.addEventListener('keydown', onKeydown);
        currentDialog = finish;
    });
};

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !event.defaultPrevented && !document.querySelector('[data-confirm-backdrop]:not([hidden])')) {
        const toast = activeToasts[activeToasts.length - 1];
        if (toast) removeToast(toast, false);
    }
});

document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-confirm-message')) return;
    if (form.dataset.confirmBypass === 'true') {
        delete form.dataset.confirmBypass;
        return;
    }

    event.preventDefault();
    if (form.dataset.confirmPending === 'true') return;
    form.dataset.confirmPending = 'true';
    const submitter = event.submitter;

    window.confirmDialog({
        judul: form.dataset.confirmTitle || 'Konfirmasi',
        pesan: form.dataset.confirmMessage,
        aksi: form.dataset.confirmAction || 'Lanjutkan',
        tipe: form.dataset.confirmType || 'default',
    }).then((confirmed) => {
        delete form.dataset.confirmPending;
        if (!confirmed) return;
        form.dataset.confirmBypass = 'true';
        if (submitter) form.requestSubmit(submitter);
        else form.requestSubmit();
    });
}, true);

document.addEventListener('submit', (event) => {
    if (event.defaultPrevented) return;
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || form.dataset.noLoading === 'true') return;
    const button = event.submitter || form.querySelector('button[type="submit"], input[type="submit"]');
    if (!button || button.disabled) return;
    button.disabled = true;
    button.setAttribute('aria-busy', 'true');
    button.dataset.originalContent = button.innerHTML;
    button.innerHTML = '<span class="rb-button-spinner" aria-hidden="true"></span><span>Memproses...</span>';
});

window.addEventListener('pageshow', (event) => {
    if (!event.persisted) return;
    activeToasts.slice().forEach((toast) => removeToast(toast, true));
});
