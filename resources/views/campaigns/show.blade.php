<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Kampanye — PeduLink</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#fafbf8] font-sans text-slate-800 antialiased">

    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 lg:px-8">
            <a href="/" class="text-xl font-bold tracking-tight text-slate-900">
                Pedu<span class="text-emerald-800">Link</span>
            </a>

            <a href="/#kampanye"
               class="text-sm font-semibold text-emerald-800 hover:text-emerald-950">
                &larr; Semua Kampanye
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-12 lg:px-8">

        <div id="campaign-loading"
             class="rounded-3xl border border-slate-200 bg-white p-10 text-center text-slate-500">
            Memuat detail kampanye...
        </div>

        <div id="campaign-error"
             class="hidden rounded-3xl border border-red-200 bg-red-50 p-8 text-center">
            <h1 class="text-xl font-bold text-red-900">
                Kampanye tidak ditemukan
            </h1>

            <p class="mt-2 text-sm text-red-700">
                Kampanye mungkin tidak tersedia atau sudah tidak aktif.
            </p>

            <a href="/#kampanye"
               class="mt-6 inline-flex rounded-xl bg-emerald-800 px-5 py-3 font-semibold text-white hover:bg-emerald-900">
                Kembali ke Kampanye
            </a>
        </div>

        <article id="campaign-detail"
                 class="hidden overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

            <div class="bg-gradient-to-br from-emerald-950 via-emerald-800 to-teal-700 px-7 py-14 text-white sm:px-12 sm:py-20">
                <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider">
                    Kampanye Aktif
                </span>

                <h1 id="campaign-title"
                    class="mt-6 max-w-3xl text-3xl font-bold leading-tight sm:text-5xl">
                </h1>

                <p class="mt-4 text-sm text-emerald-100">
                    Bersama menghadirkan kesempatan yang lebih baik.
                </p>
            </div>

            <div class="grid gap-10 p-7 sm:p-12 lg:grid-cols-[1fr_340px]">

                <section>
                    <p class="text-sm font-bold uppercase tracking-widest text-emerald-800">
                        Tentang Kampanye
                    </p>

                    <p id="campaign-description"
                       class="mt-5 whitespace-pre-line text-base leading-8 text-slate-600">
                    </p>

                    <div class="mt-10 border-t border-slate-100 pt-6">
                        <h2 class="text-lg font-bold text-slate-900">
                            Informasi Kampanye
                        </h2>

                        <dl class="mt-5 grid gap-5 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm text-slate-500">
                                    Target Penggalangan Dana
                                </dt>
                                <dd id="campaign-target"
                                    class="mt-2 text-xl font-bold text-emerald-800">
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm text-slate-500">
                                    Status
                                </dt>
                                <dd id="campaign-status"
                                    class="mt-2 font-semibold text-emerald-800">
                                </dd>
                            </div>
                        </dl>
                    </div>
                </section>

                <aside class="h-fit rounded-2xl border border-slate-200 bg-[#fafbf8] p-6">
                    <p class="text-sm font-semibold text-slate-500">
                        Kamu bisa menjadi bagian dari perubahan
                    </p>

                    <h2 class="mt-3 text-2xl font-bold text-slate-900">
                        Siap membantu?
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Lanjutkan ke proses donasi untuk menentukan nominal
                        dan informasi donatur.
                    </p>

                    <a href="#form-donasi"
                       class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-emerald-800 px-5 py-3.5 font-semibold text-white transition hover:bg-emerald-900">
                        Donasi Sekarang
                    </a>

                    <p class="mt-4 text-center text-xs leading-5 text-slate-500">
                        Pembayaran diproses melalui Xendit.
                    </p>
                </aside>

            </div>
        </article>

        <section
            id="form-donasi"
            class="hidden mt-8 rounded-3xl border border-slate-200 bg-white p-7 sm:p-10"
        >
            <div class="mx-auto max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-widest text-emerald-800">
                    Mulai Berbagi
                </p>

                <h2 class="mt-3 text-2xl font-bold text-slate-950 sm:text-3xl">
                    Formulir Donasi
                </h2>

                <p class="mt-3 leading-7 text-slate-600">
                    Isi informasi berikut untuk melanjutkan donasi.
                    Kamu akan diarahkan ke halaman pembayaran Xendit.
                </p>

                <p
                    id="donation-campaign-name"
                    class="mt-4 rounded-xl bg-emerald-50 p-4 font-semibold text-emerald-900"
                ></p>

                <div
                    id="donation-error"
                    class="hidden mt-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"
                    role="alert"
                    aria-live="polite"
                ></div>

                <form id="donation-form" class="mt-8 space-y-6">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="donor-name"
                                class="mb-2 block text-sm font-semibold text-slate-700">
                                Nama lengkap *
                            </label>
                            <input
                                id="donor-name"
                                name="donor_name"
                                type="text"
                                maxlength="100"
                                autocomplete="name"
                                required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/10"
                                placeholder="Masukkan nama"
                            >
                        </div>

                        <div>
                            <label for="donor-email"
                                class="mb-2 block text-sm font-semibold text-slate-700">
                                Email (opsional)
                            </label>
                            <input
                                id="donor-email"
                                name="donor_email"
                                type="email"
                                maxlength="255"
                                autocomplete="email"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/10"
                                placeholder="nama@email.com"
                            >
                        </div>

                        <div>
                            <label for="donor-phone"
                                class="mb-2 block text-sm font-semibold text-slate-700">
                                Nomor telepon (opsional)
                            </label>
                            <input
                                id="donor-phone"
                                name="donor_phone"
                                type="tel"
                                maxlength="20"
                                autocomplete="tel"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/10"
                                placeholder="08xxxxxxxxxx"
                            >
                        </div>

                        <div>
                            <label for="donation-amount"
                                class="mb-2 block text-sm font-semibold text-slate-700">
                                Nominal donasi (IDR) *
                            </label>
                            <input
                                id="donation-amount"
                                name="amount"
                                type="number"
                                min="1"
                                step="1"
                                value="10000"
                                required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/10"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="donation-message"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Pesan atau doa (opsional)
                        </label>
                        <textarea
                            id="donation-message"
                            name="message"
                            rows="4"
                            maxlength="2000"
                            class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-700/10"
                            placeholder="Tuliskan pesan untuk penerima manfaat..."
                        ></textarea>
                    </div>

                    <label class="flex items-start gap-3 text-sm text-slate-600">
                        <input
                            type="checkbox"
                            name="is_anonymous"
                            class="mt-1 h-4 w-4 rounded border-slate-300 accent-emerald-800"
                        >
                        <span>
                            <span class="font-semibold text-slate-800">
                                Donasi sebagai anonim
                            </span>
                            <span class="mt-1 block">
                                Nama tidak ditampilkan secara publik sebagai donatur.
                            </span>
                        </span>
                    </label>

                    <button
                        id="donation-submit"
                        type="submit"
                        class="w-full rounded-xl bg-emerald-800 px-6 py-4 font-semibold text-white transition hover:bg-emerald-900 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        Lanjut ke Pembayaran
                    </button>

                    <p class="text-center text-xs leading-5 text-slate-500">
                        Invoice dibuat melalui Xendit. Pembayaran belum dianggap
                        berhasil sampai statusnya dikonfirmasi oleh Xendit.
                    </p>
                </form>
            </div>
        </section>

    </main>

    <footer class="mt-12 border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-5 py-8 text-sm text-slate-500 lg:px-8">
            &copy; {{ date('Y') }} PeduLink — Menghubungkan kebaikan.
        </div>
    </footer>

    <script>
        const slug = @json($slug);

        const loading = document.getElementById('campaign-loading');
        const errorBox = document.getElementById('campaign-error');
        const detail = document.getElementById('campaign-detail');

        const donationSection = document.getElementById('form-donasi');
        const donationForm = document.getElementById('donation-form');
        const donationError = document.getElementById('donation-error');
        const donationSubmit = document.getElementById('donation-submit');

        let currentCampaign = null;

        const formatRupiah = (amount) => new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(Number(amount) || 0);

        async function loadCampaign() {
            try {
                const response = await fetch('/api/campaigns', {
                    headers: {
                        Accept: 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil data kampanye.');
                }

                const result = await response.json();
                const campaigns = Array.isArray(result.data)
                    ? result.data
                    : [];

                const campaign = campaigns.find((item) =>
                    item.slug === slug && item.status === 'active'
                );

                if (!campaign) {
                    throw new Error('Kampanye tidak ditemukan.');
                }

                currentCampaign = campaign;

                document.getElementById('campaign-title').textContent =
                    campaign.title ?? '';

                document.getElementById('campaign-description').textContent =
                    campaign.description ?? 'Belum ada deskripsi kampanye.';

                document.getElementById('campaign-target').textContent =
                    formatRupiah(campaign.target_amount);

                document.getElementById('campaign-status').textContent =
                    campaign.status === 'active' ? 'Aktif' : 'Tidak aktif';

                document.getElementById('donation-campaign-name').textContent =
                    campaign.title ?? '';

                loading.classList.add('hidden');
                detail.classList.remove('hidden');
                donationSection.classList.remove('hidden');
            } catch (error) {
                loading.classList.add('hidden');
                detail.classList.add('hidden');
                donationSection.classList.add('hidden');
                errorBox.classList.remove('hidden');
            }
        }

        donationForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            donationError.textContent = '';
            donationError.classList.add('hidden');

            if (!currentCampaign) {
                donationError.textContent = 'Data kampanye belum tersedia.';
                donationError.classList.remove('hidden');
                return;
            }

            const formData = new FormData(donationForm);
            const amount = Number(formData.get('amount'));

            if (!Number.isSafeInteger(amount) || amount < 1) {
                donationError.textContent = 'Nominal donasi harus berupa bilangan bulat positif.';
                donationError.classList.remove('hidden');
                return;
            }

            const payload = {
                campaign_id: currentCampaign.id,
                donor_name: String(formData.get('donor_name') ?? '').trim(),
                donor_email:
                    String(formData.get('donor_email') ?? '').trim() || null,
                donor_phone:
                    String(formData.get('donor_phone') ?? '').trim() || null,
                amount,
                message:
                    String(formData.get('message') ?? '').trim() || null,
                is_anonymous: formData.has('is_anonymous'),
            };

            donationSubmit.disabled = true;
            donationSubmit.textContent = 'Membuat invoice...';

            try {
                const response = await fetch('/api/donations', {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json().catch(() => null);

                if (!response.ok) {
                    const firstValidationError = result?.errors
                        ? Object.values(result.errors).flat()[0]
                        : null;

                    throw new Error(
                        firstValidationError ||
                        result?.message ||
                        'Donasi gagal diproses. Silakan coba lagi.'
                    );
                }

                const paymentUrl = result?.data?.payment_url;

                if (!paymentUrl) {
                    throw new Error(
                        'Invoice tidak menyertakan URL pembayaran. Periksa transaksi sebelum mencoba ulang.'
                    );
                }

                window.location.assign(paymentUrl);
            } catch (error) {
                donationError.textContent =
                    error.message || 'Terjadi kesalahan saat memproses donasi.';

                donationError.classList.remove('hidden');

                donationSubmit.disabled = false;
                donationSubmit.textContent = 'Lanjut ke Pembayaran';
            }
        });

        loadCampaign();
    </script>

</body>
</html>