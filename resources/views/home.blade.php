<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta
        name="description"
        content="PeduLink menghubungkan orang-orang yang ingin berbagi dengan kampanye donasi yang membutuhkan dukungan."
    >

    <title>PeduLink — Berbagi Harapan, Menghubungkan Kebaikan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fafbf8] font-sans text-slate-800 antialiased">

    {{-- Navigation --}}
    <header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">

            <a href="/" class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-800 text-white">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        class="h-6 w-6"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21s-8-4.5-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.5-8 11-8 11Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h2l1.2-2.2L13 15l1.2-3H16"/>
                    </svg>
                </span>

                <span>
                    <span class="block text-xl font-bold tracking-tight text-slate-900">
                        Pedu<span class="text-emerald-700">Link</span>
                    </span>
                    <span class="block text-xs text-slate-500">
                        Menghubungkan kebaikan
                    </span>
                </span>
            </a>

            <nav class="hidden items-center gap-8 text-sm font-medium text-slate-600 md:flex">
                <a href="#kampanye" class="transition hover:text-emerald-800">
                    Kampanye
                </a>
                <a href="#cara-kerja" class="transition hover:text-emerald-800">
                    Cara Kerja
                </a>
            </nav>

            <a
                href="#kampanye"
                class="rounded-full bg-emerald-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900"
            >
                Mulai Berdonasi
            </a>
        </div>
    </header>

    <main>
        {{-- Hero --}}
        <section class="relative overflow-hidden">
            <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-emerald-100/70 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-20 h-80 w-80 rounded-full bg-amber-100/60 blur-3xl"></div>

            <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-5 py-20 md:py-28 lg:grid-cols-2 lg:px-8">

                <div>
                    <div class="mb-7 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-white px-4 py-2 text-sm font-medium text-emerald-800 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                        Satu langkah kecil, harapan yang besar
                    </div>

                    <h1 class="max-w-2xl text-4xl font-bold leading-tight tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                        Kebaikanmu bisa menjadi
                        <span class="text-emerald-800">harapan</span>
                        bagi sesama.
                    </h1>

                    <p class="mt-6 max-w-xl text-base leading-8 text-slate-600 sm:text-lg">
                        Temukan kampanye yang berarti bagimu, berikan dukungan,
                        dan bantu menghadirkan kesempatan yang lebih baik bagi
                        mereka yang membutuhkan.
                    </p>

                    <div class="mt-9 flex flex-wrap items-center gap-4">
                        <a
                            href="#kampanye"
                            class="inline-flex items-center gap-2 rounded-full bg-emerald-800 px-6 py-3.5 font-semibold text-white shadow-lg shadow-emerald-900/10 transition hover:-translate-y-0.5 hover:bg-emerald-900"
                        >
                            Jelajahi Kampanye
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 12h14m-6-6 6 6-6 6"/>
                            </svg>
                        </a>

                        <a
                            href="#cara-kerja"
                            class="rounded-full border border-slate-300 bg-white px-6 py-3.5 font-semibold text-slate-700 transition hover:border-emerald-700 hover:text-emerald-800"
                        >
                            Cara Kerja
                        </a>
                    </div>

                    <div class="mt-10 flex items-center gap-3 text-sm text-slate-500">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-800">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-5 w-5">
                                <rect x="4" y="10" width="16" height="11" rx="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 10V7a4 4 0 0 1 8 0v3m-4 5v2"/>
                            </svg>
                        </span>
                        Pembayaran diproses melalui Xendit
                    </div>
                </div>

                {{-- Feature panel --}}
                <div class="relative mx-auto w-full max-w-lg">
                    <div class="absolute -right-4 -top-4 h-24 w-24 rounded-3xl border border-emerald-200 bg-emerald-100/60"></div>
                    <div class="absolute -bottom-5 -left-5 h-28 w-28 rounded-full bg-amber-200/60"></div>

                    <div class="relative overflow-hidden rounded-[2rem] bg-emerald-950 p-7 text-white shadow-2xl shadow-emerald-950/15 sm:p-10">
                        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full border border-white/10"></div>
                        <div class="absolute -right-10 -top-10 h-44 w-44 rounded-full border border-white/10"></div>

                        <div class="relative">
                            <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-100">
                                PeduLink
                            </span>

                            <h2 class="mt-7 text-3xl font-semibold leading-snug sm:text-4xl">
                                Mengubah kepedulian menjadi tindakan.
                            </h2>

                            <p class="mt-4 leading-7 text-emerald-100/80">
                                Pilih tujuan yang ingin kamu dukung dan ikuti
                                proses donasi melalui langkah-langkah sederhana.
                            </p>

                            <div class="mt-9 space-y-5">
                                <div class="flex items-center gap-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/10 font-semibold text-emerald-100">
                                        01
                                    </span>
                                    <div>
                                        <p class="font-semibold">Pilih kampanye</p>
                                        <p class="mt-1 text-sm text-emerald-100/70">
                                            Temukan tujuan yang ingin kamu bantu.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/10 font-semibold text-emerald-100">
                                        02
                                    </span>
                                    <div>
                                        <p class="font-semibold">Tentukan donasi</p>
                                        <p class="mt-1 text-sm text-emerald-100/70">
                                            Isi informasi dan nominal dukungan.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/10 font-semibold text-emerald-100">
                                        03
                                    </span>
                                    <div>
                                        <p class="font-semibold">Selesaikan pembayaran</p>
                                        <p class="mt-1 text-sm text-emerald-100/70">
                                            Lanjutkan ke halaman pembayaran Xendit.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -right-2 top-1/2 hidden -translate-y-1/2 translate-x-1/3 rounded-2xl border border-slate-100 bg-white p-4 shadow-xl sm:block">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.8"
                                    class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3v18m9-9H3m15.4-6.4L5.6 18.4m12.8 0L5.6 5.6"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Mulai dari kepedulian</p>
                                <p class="mt-1 text-xs text-slate-500">Setiap dukungan berarti</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- How it works --}}
        <section id="cara-kerja" class="border-y border-slate-200/70 bg-white py-16">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-800">
                        Cara Kerja
                    </p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                        Berdonasi dengan langkah yang jelas
                    </h2>
                    <p class="mt-4 leading-7 text-slate-600">
                        PeduLink menghubungkan kampanye, donatur, dan proses
                        pembayaran dalam satu alur yang mudah dipahami.
                    </p>
                </div>

                <div class="mt-12 grid gap-5 md:grid-cols-3">
                    <article class="rounded-3xl border border-slate-200 bg-[#fafbf8] p-7">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-800">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-6 w-6">
                                <circle cx="11" cy="11" r="7"/>
                                <path stroke-linecap="round" d="m16 16 4 4"/>
                            </svg>
                        </span>
                        <h3 class="mt-5 text-lg font-bold text-slate-900">Temukan kampanye</h3>
                        <p class="mt-2 leading-7 text-slate-600">
                            Jelajahi kampanye aktif dan baca tujuan penggalangan dananya.
                        </p>
                    </article>

                    <article class="rounded-3xl border border-slate-200 bg-[#fafbf8] p-7">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-800">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 21s-8-4.5-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.5-8 11-8 11Z"/>
                            </svg>
                        </span>
                        <h3 class="mt-5 text-lg font-bold text-slate-900">Isi donasi</h3>
                        <p class="mt-2 leading-7 text-slate-600">
                            Tentukan nominal dan isi informasi yang diperlukan untuk transaksi.
                        </p>
                    </article>

                    <article class="rounded-3xl border border-slate-200 bg-[#fafbf8] p-7">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-100 text-sky-800">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8"
                                class="h-6 w-6">
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path stroke-linecap="round" d="M3 10h18m-13 5h4"/>
                            </svg>
                        </span>
                        <h3 class="mt-5 text-lg font-bold text-slate-900">Lakukan pembayaran</h3>
                        <p class="mt-2 leading-7 text-slate-600">
                            Selesaikan pembayaran melalui halaman checkout yang disediakan Xendit.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        {{-- Campaigns --}}
        <section id="kampanye" class="py-20 sm:py-24">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-800">
                            Temukan Tujuanmu
                        </p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                            Kampanye pilihan
                        </h2>
                        <p class="mt-4 max-w-2xl leading-7 text-slate-600">
                            Lihat kampanye aktif dan pilih tujuan yang ingin kamu dukung.
                        </p>
                    </div>

                    <span id="campaign-count" class="text-sm text-slate-500">
                        Memuat kampanye...
                    </span>
                </div>

                <div id="campaign-list" class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="animate-pulse rounded-3xl border border-slate-200 bg-white p-6">
                        <div class="h-4 w-24 rounded bg-slate-200"></div>
                        <div class="mt-5 h-7 w-3/4 rounded bg-slate-200"></div>
                        <div class="mt-4 h-4 rounded bg-slate-100"></div>
                        <div class="mt-2 h-4 w-5/6 rounded bg-slate-100"></div>
                        <div class="mt-8 h-11 rounded-xl bg-slate-200"></div>
                    </div>
                </div>

                <p class="mt-5 text-sm text-slate-500">
                    Informasi kampanye ditampilkan berdasarkan data dari API PeduLink.
                </p>
            </div>
        </section>

        {{-- Closing CTA --}}
        <section class="px-5 pb-20 lg:px-8">
            <div class="mx-auto max-w-7xl overflow-hidden rounded-[2rem] bg-emerald-900 px-7 py-12 text-white sm:px-12 sm:py-16">
                <div class="flex flex-col justify-between gap-8 md:flex-row md:items-center">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl font-bold leading-tight sm:text-4xl">
                            Mari hadirkan lebih banyak harapan.
                        </h2>
                        <p class="mt-4 leading-7 text-emerald-100/80">
                            Temukan kampanye yang berarti dan mulai dukunganmu melalui PeduLink.
                        </p>
                    </div>

                    <a href="#kampanye"
                        class="inline-flex shrink-0 items-center justify-center rounded-full bg-white px-6 py-3.5 font-semibold text-emerald-900 transition hover:bg-emerald-50">
                        Lihat Kampanye
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-5 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between lg:px-8">
            <p>
                <span class="font-bold text-slate-900">PeduLink</span>
                — Menghubungkan kebaikan.
            </p>
            <p>&copy; {{ date('Y') }} PeduLink. Dibuat untuk berbagi harapan.</p>
        </div>
    </footer>

    <script>
        const campaignList = document.getElementById('campaign-list');
        const campaignCount = document.getElementById('campaign-count');

        const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        })[char]);

        const formatRupiah = (amount) => new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(Number(amount) || 0);

        async function loadCampaigns() {
            try {
                const response = await fetch('/api/campaigns', {
                    headers: {
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('API kampanye gagal merespons.');
                }

                const result = await response.json();
                const campaigns = Array.isArray(result.data)
                    ? result.data.filter((campaign) => campaign.status === 'active')
                    : [];

                campaignCount.textContent = `${campaigns.length} kampanye aktif`;

                if (campaigns.length === 0) {
                    campaignList.innerHTML = `
                        <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-800">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-7 w-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-8-4.5-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.5-8 11-8 11Z"/>
                                </svg>
                            </div>
                            <h3 class="mt-5 text-lg font-bold text-slate-900">Belum ada kampanye aktif</h3>
                            <p class="mt-2 text-slate-500">Kampanye yang tersedia akan ditampilkan di sini.</p>
                        </div>
                    `;
                    return;
                }

                campaignList.innerHTML = campaigns.map((campaign, index) => {
                    const targetAmount = Number(campaign.target_amount) || 0;
                    const totalDonated = Number(campaign.total_donated) || 0;
                    const paidDonationCount = Number(campaign.paid_donations_count) || 0;

                    const progress = targetAmount > 0
                        ? Math.min(100, Math.round((totalDonated / targetAmount) * 100))
                        : 0;

                    return `
                    <article class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/5">
                        <div class="relative flex h-44 items-end overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-700 p-6">
                            <div class="absolute -right-8 -top-12 h-48 w-48 rounded-full border border-white/15"></div>
                            <div class="absolute -right-1 -top-5 h-32 w-32 rounded-full border border-white/15"></div>
                            <span class="relative rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-50">
                                Kampanye aktif
                            </span>
                            <span class="absolute bottom-5 right-6 text-5xl font-bold text-white/10">
                                ${String(index + 1).padStart(2, '0')}
                            </span>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold leading-snug text-slate-900">
                                ${escapeHtml(campaign.title)}
                            </h3>

                            <p class="mt-3 min-h-20 text-sm leading-7 text-slate-600">
                                ${escapeHtml(campaign.description)}
                            </p>

                            <div class="mt-6 border-t border-slate-100 pt-5">
                                <div class="flex items-end justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wider text-slate-500">
                                            Dana terkumpul
                                        </p>
                                        <p class="mt-1 text-lg font-bold text-emerald-800">
                                            ${formatRupiah(totalDonated)}
                                        </p>
                                    </div>

                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-bold text-emerald-800">
                                        ${progress}%
                                    </span>
                                </div>

                                <div
                                    class="mt-3 h-2.5 overflow-hidden rounded-full bg-slate-100"
                                    role="progressbar"
                                    aria-label="Progres dana terkumpul"
                                    aria-valuenow="${progress}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                >
                                    <div
                                        class="h-full rounded-full bg-emerald-700 transition-all"
                                        style="width: ${progress}%"
                                    ></div>
                                </div>

                                <div class="mt-2 flex items-center justify-between gap-3 text-xs text-slate-500">
                                    <span>Target: ${formatRupiah(targetAmount)}</span>
                                    <span>${paidDonationCount} donasi lunas</span>
                                </div>
                            </div>

                            <a
                                href="/campaigns/${encodeURIComponent(campaign.slug)}"
                                class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-800 px-4 py-3 font-semibold text-white transition hover:bg-emerald-900"
                            >
                                Lihat Kampanye
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </article>
                `;
                }).join('');
            } catch (error) {
                campaignCount.textContent = 'Kampanye tidak tersedia';

                campaignList.innerHTML = `
                    <div class="col-span-full rounded-3xl border border-red-200 bg-red-50 p-6 text-center">
                        <h3 class="font-semibold text-red-900">Gagal memuat kampanye</h3>
                        <p class="mt-2 text-sm text-red-700">
                            Periksa server Laravel dan endpoint GET /api/campaigns, lalu muat ulang halaman.
                        </p>
                    </div>
                `;
            }
        }

        loadCampaigns();
    </script>
</body>
</html>