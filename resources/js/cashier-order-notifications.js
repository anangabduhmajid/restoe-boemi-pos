const cashierShell = document.querySelector('[data-cashier-notifications]');

if (cashierShell) {
    const pollUrl = cashierShell.dataset.pollUrl;
    let lastOrderId = Number(cashierShell.dataset.initialOrderId) || 0;
    let isPolling = false;
    let audioContext = null;
    let soundEnabled = false;
    let soundReady = false;
    const processedOrderIds = new Set();

    const notificationContainer = document.getElementById('cashier-order-notifications');
    const notificationStatus = document.getElementById('cashier-notification-status');
    const soundToggle = document.getElementById('cashier-sound-toggle');
    const pendingBadge = document.getElementById('cashier-payment-pending-count');
    const pendingCount = document.getElementById('cashier-pending-count');
    const pendingTotal = document.getElementById('cashier-pending-total');
    const paymentList = document.querySelector('[data-cashier-payment-list]');

    try {
        soundEnabled = window.localStorage.getItem('rb_cashier_order_sound') === 'true';
    } catch (error) {
        console.warn('Unable to read the cashier sound preference.', error);
    }

    const moneyFormatter = new Intl.NumberFormat('id-ID', {
        maximumFractionDigits: 0,
    });

    function formatMoney(value) {
        const amount = Number(value);
        return `Rp${moneyFormatter.format(Number.isFinite(amount) ? amount : 0)}`;
    }

    function formatOrderTime(value) {
        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return 'Waktu tidak tersedia';
        }

        return new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }).format(date);
    }

    function updateSoundButton() {
        if (!soundToggle) {
            return;
        }

        const label = soundEnabled
            ? (soundReady ? 'Suara: Aktif' : 'Aktifkan Suara')
            : 'Suara: Mati';

        soundToggle.textContent = label;
        soundToggle.setAttribute('aria-pressed', String(soundEnabled));
        soundToggle.title = soundEnabled && !soundReady
            ? 'Klik untuk mengizinkan browser memutar suara notifikasi'
            : 'Aktifkan atau nonaktifkan suara notifikasi';
    }

    function playTone() {
        const oscillator = audioContext.createOscillator();
        const volume = audioContext.createGain();
        const startAt = audioContext.currentTime;

        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(880, startAt);
        oscillator.frequency.setValueAtTime(660, startAt + 0.12);
        volume.gain.setValueAtTime(0.0001, startAt);
        volume.gain.exponentialRampToValueAtTime(0.16, startAt + 0.025);
        volume.gain.exponentialRampToValueAtTime(0.0001, startAt + 0.32);

        oscillator.connect(volume);
        volume.connect(audioContext.destination);
        oscillator.start(startAt);
        oscillator.stop(startAt + 0.33);
    }

    async function prepareSound() {
        const AudioContextConstructor = window.AudioContext || window.webkitAudioContext;

        if (!AudioContextConstructor) {
            throw new Error('Browser ini tidak mendukung Web Audio API.');
        }

        if (!audioContext) {
            audioContext = new AudioContextConstructor();
        }

        if (audioContext.state === 'suspended') {
            await audioContext.resume();
        }

        if (audioContext.state !== 'running') {
            throw new Error('Browser belum mengizinkan pemutaran audio.');
        }

        soundReady = true;
        updateSoundButton();
    }

    async function playNotificationSound() {
        if (!soundEnabled) {
            return false;
        }

        try {
            await prepareSound();
            playTone();
            return true;
        } catch (error) {
            soundReady = false;
            updateSoundButton();
            console.warn('Cashier notification sound could not be played.', error);
            return false;
        }
    }

    async function toggleSound() {
        if (soundEnabled && soundReady) {
            soundEnabled = false;

            try {
                window.localStorage.setItem('rb_cashier_order_sound', 'false');
            } catch (error) {
                console.warn('Unable to save the cashier sound preference.', error);
            }

            updateSoundButton();
            return;
        }

        soundEnabled = true;

        try {
            window.localStorage.setItem('rb_cashier_order_sound', 'true');
        } catch (error) {
            console.warn('Unable to save the cashier sound preference.', error);
        }

        try {
            await prepareSound();
            playTone();
            if (notificationStatus) {
                notificationStatus.textContent = 'Suara notifikasi aktif';
            }
        } catch (error) {
            soundReady = false;
            updateSoundButton();
            if (notificationStatus) {
                notificationStatus.textContent = 'Klik Aktifkan Suara untuk mengizinkan audio';
            }
            console.warn('Cashier notification audio is blocked by the browser.', error);
        }
    }

    function createElement(tag, className, text) {
        const element = document.createElement(tag);
        element.className = className;

        if (text !== undefined) {
            element.textContent = text;
        }

        return element;
    }

    function createToast(order) {
        const toast = createElement('article', 'cashier-order-toast');
        const header = createElement('div', 'cashier-order-toast__header');
        const label = createElement('span', 'cashier-order-toast__label', 'PESANAN BARU');
        const close = createElement('button', 'cashier-order-toast__close', '×');
        const title = createElement('h2', 'cashier-order-toast__number', order.order_number);
        const details = createElement('dl', 'cashier-order-toast__details');
        const customer = createElement('div', '');
        const table = createElement('div', '');
        const type = createElement('div', '');
        const total = createElement('div', '');
        const time = createElement('p', 'cashier-order-toast__time', formatOrderTime(order.ordered_at));
        const link = createElement('a', 'cashier-order-toast__link', 'Buka detail pesanan');
        const audioHint = createElement('p', 'cashier-order-toast__audio-hint');

        close.type = 'button';
        close.setAttribute('aria-label', 'Tutup notifikasi pesanan');
        close.addEventListener('click', () => toast.remove());

        header.append(label, close);
        toast.append(header, title);

        const addDetail = (container, term, value, isHighlighted = false) => {
            const heading = createElement('dt', 'cashier-order-toast__term', term);
            const content = createElement(
                'dd',
                isHighlighted ? 'cashier-order-toast__value is-highlighted' : 'cashier-order-toast__value',
                value
            );
            container.append(heading, content);
        };

        addDetail(customer, 'Customer', order.customer_name || 'Pelanggan');
        addDetail(
            table,
            'Meja',
            order.order_type === 'dine_in' ? (order.table_number || '-') : '-'
        );
        addDetail(
            type,
            'Jenis pesanan',
            order.order_type === 'dine_in' ? 'DINE IN' : 'TAKEAWAY',
            true
        );
        addDetail(total, 'Total', formatMoney(order.total), true);
        details.append(customer, table, type, total);

        link.href = order.detail_url;
        time.setAttribute('datetime', order.ordered_at);

        toast.append(details, time, link, audioHint);
        notificationContainer.prepend(toast);

        while (notificationContainer.children.length > 3) {
            notificationContainer.lastElementChild.remove();
        }

        window.setTimeout(() => toast.remove(), 20000);

        if (!soundEnabled || !soundReady) {
            audioHint.textContent = 'Aktifkan suara melalui tombol di header agar notifikasi berbunyi.';
        } else {
            playNotificationSound().then((played) => {
                audioHint.textContent = played
                    ? ''
                    : 'Browser memblokir audio. Klik Aktifkan Suara di header.';
                audioHint.hidden = played;
                if (!played && notificationStatus) {
                    notificationStatus.textContent = 'Klik Aktifkan Suara untuk mengizinkan audio';
                }
            });
        }
    }

    function createPaymentRow(order) {
        const row = document.createElement('tr');
        row.className = 'transition hover:bg-[#FCFAF7]';
        row.dataset.orderId = String(order.id);

        const addCell = (text, className) => {
            const cell = createElement('td', className, text);
            row.append(cell);
            return cell;
        };

        addCell(order.order_number, 'whitespace-nowrap px-6 py-4 font-semibold');
        addCell(order.customer_name || 'Pelanggan', 'whitespace-nowrap px-6 py-4');

        const typeCell = createElement('td', 'whitespace-nowrap px-6 py-4');
        const typeLabel = createElement(
            'span',
            'rounded-full bg-[#F5EFE6] px-3 py-1 text-xs font-medium',
            order.order_type === 'dine_in' ? 'Dine In' : 'Takeaway'
        );
        typeCell.append(typeLabel);

        if (order.order_type === 'dine_in') {
            typeCell.append(createElement(
                'p',
                'mt-1 text-xs text-[#88796D]',
                `Meja ${order.table_number || '-'}`
            ));
        }

        row.append(typeCell);

        const methodLabels = {
            cash: 'Tunai',
            transfer: 'Transfer Bank',
            qris: 'QRIS',
            debit: 'Kartu Debit',
        };
        const method = order.requested_payment_method;
        const methodCell = createElement('td', 'whitespace-nowrap px-6 py-4');

        methodCell.append(method
            ? createElement(
                'span',
                'rounded-full bg-[#F5EFE6] px-3 py-1.5 text-xs font-semibold text-[#710014]',
                methodLabels[method] || method.toUpperCase()
            )
            : createElement('span', 'text-xs text-[#88796D]', 'Belum ditentukan'));
        row.append(methodCell);

        addCell(formatMoney(order.total), 'whitespace-nowrap px-6 py-4 font-semibold');
        addCell(formatOrderTime(order.ordered_at), 'whitespace-nowrap px-6 py-4 text-[#88796D]');

        const actionCell = createElement('td', 'whitespace-nowrap px-6 py-4 text-right');
        const detailLink = createElement(
            'a',
            'inline-flex rounded-lg bg-[#710014] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#570010]',
            'Proses Pembayaran'
        );
        detailLink.href = order.detail_url;
        actionCell.append(detailLink);
        row.append(actionCell);

        return row;
    }

    function insertPaymentOrder(order) {
        if (!paymentList || paymentList.dataset.cashierPaymentsPage !== '1') {
            return;
        }

        const searchTerm = (paymentList.dataset.cashierPaymentsSearch || '').trim().toLocaleLowerCase('id-ID');
        const searchMatches = !searchTerm
            || order.order_number.toLocaleLowerCase('id-ID').includes(searchTerm)
            || (order.customer_name || '').toLocaleLowerCase('id-ID').includes(searchTerm);

        if (!searchMatches || paymentList.querySelector(`[data-order-id="${Number(order.id)}"]`)) {
            return;
        }

        const emptyRow = paymentList.querySelector('[data-empty-payment-row]');
        if (emptyRow) {
            emptyRow.remove();
        }

        paymentList.prepend(createPaymentRow(order));

        while (paymentList.querySelectorAll('tr[data-order-id]').length > 10) {
            paymentList.querySelector('tr[data-order-id]:last-of-type')?.remove();
        }
    }

    function updatePendingSummary(data) {
        const count = Number(data.pending_count) || 0;

        if (pendingCount) {
            pendingCount.textContent = moneyFormatter.format(count);
        }

        if (pendingTotal) {
            pendingTotal.textContent = formatMoney(data.pending_total);
        }

        if (pendingBadge) {
            pendingBadge.textContent = count > 99 ? '99+' : String(count);
            pendingBadge.hidden = count === 0;
            pendingBadge.setAttribute('aria-label', `${count} pesanan belum dibayar`);
        }
    }

    async function pollForOrders() {
        if (isPolling || document.visibilityState === 'hidden') {
            return;
        }

        isPolling = true;

        try {
            const url = new URL(pollUrl, window.location.origin);
            url.searchParams.set('after_id', String(lastOrderId));

            const response = await fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
                cache: 'no-store',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                throw new Error(`Polling request failed with status ${response.status}.`);
            }

            const data = await response.json();

            if (
                !Number.isInteger(Number(data.latest_id))
                || !Array.isArray(data.orders)
                || !Number.isFinite(Number(data.pending_count))
            ) {
                throw new Error('Polling response has an invalid format.');
            }

            updatePendingSummary(data);

            data.orders.forEach((order) => {
                const id = Number(order.id);

                if (!Number.isInteger(id) || processedOrderIds.has(id)) {
                    return;
                }

                processedOrderIds.add(id);
                insertPaymentOrder(order);
                createToast(order);
                window.toast.info(
                    'Pesanan baru',
                    `Pesanan baru dari ${order.customer_name || 'Pelanggan'}`
                );
            });

            lastOrderId = Number(data.latest_id);

            if (notificationStatus) {
                notificationStatus.textContent = 'Notifikasi real-time aktif';
                notificationStatus.removeAttribute('title');
            }
        } catch (error) {
            if (notificationStatus) {
                notificationStatus.textContent = 'Notifikasi terputus; mencoba kembali';
                notificationStatus.title = error.message;
            }
            console.error('Cashier order notification polling failed.', error);
        } finally {
            isPolling = false;
        }
    }

    if (soundToggle) {
        soundToggle.addEventListener('click', toggleSound);
    }

    updateSoundButton();
    pollForOrders();

    const pollingInterval = window.setInterval(pollForOrders, 4000);
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            pollForOrders();
        }
    });
    window.addEventListener('pagehide', () => window.clearInterval(pollingInterval), { once: true });
}
