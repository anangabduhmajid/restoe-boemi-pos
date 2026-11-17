<x-guest-layout>
    <section
        data-session-expired
        data-login-url="{{ route('login') }}"
        class="rounded-xl border border-[#E5D6C3] bg-white p-7 text-center shadow-sm">
        <h2 class="text-xl font-bold text-[#710014]">Sesi berakhir</h2>
        <p class="mt-3 text-sm text-[#76685E]">Sesi berakhir, silakan login lagi.</p>
        <a href="{{ route('login') }}"
            class="mt-6 inline-flex min-h-11 items-center rounded-lg bg-[#710014] px-5 text-sm font-bold text-white">
            Masuk lagi
        </a>
    </section>
</x-guest-layout>
