<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Status Donasi — PeduLink</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#fafbf8] font-sans text-slate-800 antialiased">

    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-5 py-5">
            <a href="/" class="text-xl font-bold tracking-tight text-slate-900">
                Pedu<span class="text-emerald-800">Link</span>
            </a>

            <a href="/#kampanye"
               class="text-sm font-semibold text-emerald-800 hover:text-emerald-950">
                Semua Kampanye
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-5 py-16">

        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

            @if ($donation->status === 'paid')
                <div class="bg-emerald-800 px-7 py-10 text-center text-white sm:px-12">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             class="h-9 w-9">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m5 12 4 4L19 6"/>
                        </svg>
                    </div>

                    <h1 class="mt-5 text-3xl font-bold">
                        Terima Kasih!
                    </h1>

                    <p class="mt-3 text-emerald-100">
                        Pembayaran donasi telah terkonfirmasi.
                    </p>
                </div>

            @elseif ($donation->status === 'expired')
                <div class="bg-amber-50 px-7 py-10 text-center sm:px-12">
                    <h1 class="text-3xl font-bold text-amber-900">
                        Invoice Kedaluwarsa
                    </h1>

                    <p class="mt-3 leading-7 text-amber-800">
                        Batas waktu pembayaran invoice ini telah berakhir.
                        Kamu dapat kembali ke kampanye untuk memulai donasi baru.
                    </p>
                </div>

            @elseif ($donation->status === 'failed')
                <div class="bg-red-50 px-7 py-10 text-center sm:px-12">
                    <h1 class="text-3xl font-bold text-red-900">
                        Donasi Belum Berhasil
                    </h1>

                    <p class="mt-3 leading-7 text-red-800">
                        Invoice tidak berhasil dibuat atau diproses.
                        Silakan kembali ke kampanye untuk mencoba lagi.
                    </p>
                </div>

            @else
                <div class="bg-sky-50 px-7 py-10 text-center sm:px-12">
                    <h1 class="text-3xl font-bold text-sky-950">
                        Menunggu Konfirmasi
                    </h1>

                    <p class="mt-3 leading-7 text-sky-900">
                        Status pembayaran belum terkonfirmasi.
                        Jika kamu baru saja membayar, tunggu beberapa saat
                        lalu periksa statusnya kembali.
                    </p>
                </div>
            @endif

            <div class="p-7 sm:p-10">
                <p class="text-sm font-bold uppercase tracking-widest text-emerald-800">
                    Ringkasan Donasi
                </p>

                <h2 class="mt-3 text-xl font-bold text-slate-900">
                    {{ $donation->campaign?->title ?? 'Kampanye PeduLink' }}
                </h2>

                <div class="mt-6 rounded-2xl border border-slate-200 bg-[#fafbf8] p-5">
                    <p class="text-sm text-slate-500">
                        Nominal donasi
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        Rp{{ number_format((int) $donation->amount, 0, ',', '.') }}
                    </p>

                    <div class="mt-5 flex items-center justify-between border-t border-slate-200 pt-4">
                        <span class="text-sm text-slate-500">
                            Status
                        </span>

                        @if ($donation->status === 'paid')
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-800">
                                Lunas
                            </span>
                        @elseif ($donation->status === 'expired')
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-800">
                                Kedaluwarsa
                            </span>
                        @elseif ($donation->status === 'failed')
                            <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">
                                Gagal
                            </span>
                        @else
                            <span class="rounded-full bg-sky-100 px-3 py-1 text-sm font-semibold text-sky-800">
                                Menunggu pembayaran
                            </span>
                        @endif
                    </div>

                    @if ($donation->paid_at)
                        <div class="mt-4 flex items-center justify-between border-t border-slate-200 pt-4">
                            <span class="text-sm text-slate-500">
                                Waktu pembayaran
                            </span>

                            <span class="text-right text-sm font-medium text-slate-800">
                                {{ $donation->paid_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                    @endif
                </div>

                @if ($verificationIssue)
                    <p class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900">
                        Status terbaru belum dapat diverifikasi ke Xendit.
                        Informasi di atas menunjukkan status terakhir yang
                        tersimpan di PeduLink. Periksa kembali beberapa saat lagi.
                    </p>
                @endif

                @if ($donation->status === 'pending' || $verificationIssue)
                    <a href="{{ url()->current() }}"
                       class="mt-6 flex w-full items-center justify-center rounded-xl border border-emerald-800 px-5 py-3 font-semibold text-emerald-800 transition hover:bg-emerald-50">
                        Periksa Status Kembali
                    </a>
                @endif

                <a href="{{ $donation->campaign
                    ? url('/campaigns/' . $donation->campaign->slug)
                    : url('/') }}"
                   class="mt-4 flex w-full items-center justify-center rounded-xl bg-emerald-800 px-5 py-3.5 font-semibold text-white transition hover:bg-emerald-900">
                    Kembali ke Kampanye
                </a>

                <p class="mt-5 text-center text-xs leading-5 text-slate-500">
                    Status pembayaran ditampilkan berdasarkan data
                    yang diperoleh backend dari Xendit.
                </p>
            </div>
        </section>

    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-5xl px-5 py-7 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} PeduLink — Menghubungkan kebaikan.
        </div>
    </footer>

</body>
</html>