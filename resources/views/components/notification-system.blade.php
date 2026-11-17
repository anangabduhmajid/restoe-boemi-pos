@props(['theme' => 'admin'])

@php
    $flashMessages = [];
    $hasLoginError = request()->routeIs('login') && $errors->has('email');
    foreach ([
        'success' => ['success', 'Berhasil'],
        'error' => ['error', 'Gagal'],
        'warning' => ['warning', 'Perhatian'],
        'status' => ['info', 'Info'],
    ] as $key => [$type, $title]) {
        $message = session($key);
        if (is_string($message) && $message !== '') {
            $flashMessages[] = compact('type', 'title', 'message');
        }
    }

    $inlineErrors = $errors->getBag('default')->messages();
    if ($errors->any() && ! $hasLoginError) {
        $flashMessages[] = [
            'type' => 'error',
            'title' => 'Perlu dicek',
            'message' => 'Periksa lagi isian kamu',
        ];
    }
@endphp

<div
    data-notification-system
    data-toast-theme="{{ $theme }}"
    data-login-url="{{ route('login') }}"
    data-flash-messages="{{ json_encode($flashMessages, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}"
    data-inline-errors="{{ json_encode($inlineErrors, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}"
    class="rb-notification-system">
    <div class="rb-toast-stack" role="status" aria-live="polite" aria-atomic="false" aria-label="Notifikasi"></div>
    <div class="rb-dialog-backdrop" data-confirm-backdrop hidden>
        <section
            class="rb-confirm-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="rb-confirm-title"
            aria-describedby="rb-confirm-message"
            tabindex="-1">
            <h2 id="rb-confirm-title" class="rb-confirm-dialog__title"></h2>
            <p id="rb-confirm-message" class="rb-confirm-dialog__message"></p>
            <div class="rb-confirm-dialog__actions">
                <button type="button" class="rb-confirm-dialog__cancel" data-confirm-cancel>Batal</button>
                <button type="button" class="rb-confirm-dialog__action" data-confirm-action></button>
            </div>
        </section>
    </div>
</div>
