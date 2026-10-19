<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FINTEGRITA — Financial Integrity & Integrated Solutions</title>
    <meta name="description" content="FINTEGRITA menghadirkan ekosistem solusi keuangan, rekayasa teknologi, pelatihan, dan konsultasi berbasis data.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            900: '#0f172a',
                            800: '#1e293b',
                            700: '#334155',
                        },
                        accent: {
                            500: '#0d9488',
                            600: '#0f766e',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased selection:bg-teal-500 selection:text-slate-950">

    <!-- Top Announcement -->
    <div class="bg-slate-900 border-b border-slate-800 text-xs py-2 px-4 text-center text-slate-400">
        <span class="inline-block px-2 py-0.5 rounded bg-teal-500/10 border border-teal-500/30 text-teal-400 font-bold uppercase text-[10px] mr-2">Platform Release v1.0</span>
        Ekosistem Finansial & Software Bisnis Terintegrasi.
    </div>

    <!-- Header Navbar -->
    <header class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur-md border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-600 to-emerald-400 flex items-center justify-center font-black text-white text-xl shadow-lg shadow-teal-500/20">
                    F
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-white block">FINTEGRITA</span>
                    <span class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold block -mt-1">Financial & Tech Integrity</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-300">
                <a href="#solusi" class="hover:text-teal-400 transition">6 Lini Solusi</a>
                <a href="#ekosistem" class="hover:text-teal-400 transition">Ekosistem</a>
                <a href="#tentang" class="hover:text-teal-400 transition">Tentang Kami</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/portal" class="px-4 py-2 rounded-lg border border-slate-700 hover:border-slate-600 bg-slate-900 text-slate-200 text-sm font-semibold transition flex items-center gap-2">
                    <i class="fa-solid fa-user-lock text-xs text-sky-400"></i>
                    <span>Portal Pelanggan</span>
                </a>
                <a href="/admin" class="px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-400 text-slate-950 text-sm font-bold shadow-md shadow-teal-500/20 transition flex items-center gap-2">
                    <span>Admin ERP</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-20 pb-28 overflow-hidden">
        <div class="pointer-events-none absolute -top-40 -left-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute top-20 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-teal-400 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                <span>Know Your Numbers. Grow Your Business.</span>
            </div>

            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white max-w-4xl mx-auto leading-tight">
                Kelola Keuangan Lebih Baik. <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-300">Kembangkan Bisnis Terarah.</span>
            </h1>

            <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                FINTEGRITA menghadirkan solusi keuangan, teknologi rekayasa software, pelatihan bersertifikat, dan konsultasi berbasis data untuk UMKM, Koperasi, dan Organisasi.
            </p>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/portal" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-teal-500/25">
                    <span>Buka Portal Pelanggan</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>
                <a href="/admin" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-700 text-white font-semibold transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-shield-halved text-teal-400"></i>
                    <span>Masuk Dashboard Admin</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 6 Lini Bisnis Grid -->
    <section id="solusi" class="py-20 bg-slate-900/50 border-y border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-400">Struktur Ekosistem</span>
                <h2 class="text-3xl font-extrabold text-white">6 Lini Bisnis Terpadu</h2>
                <p class="text-slate-400 text-sm max-w-xl mx-auto">Dirancang untuk menjawab seluruh siklus pertumbuhan tata kelola finansial dan teknologi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- 1. Finance -->
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-teal-500/10 text-teal-400 border border-teal-500/20 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-calculator"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">FINTEGRITA Finance</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Aplikasi keuangan personal & UMKM, pembukuan harian, dan template laporan standar SAK EMKM.</p>
                </div>

                <!-- 2. Tech -->
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">FINTEGRITA Tech</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Pengembangan SIM Koperasi, portal lembaga resmi, kasir POS & QRIS dinamis, serta integrasi API kustom.</p>
                </div>

                <!-- 3. Intelligence -->
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">FINTEGRITA Intelligence</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Dashboard Business Intelligence (BI), visualisasi performa penjualan, dan otomasi pelaporan eksekutif.</p>
                </div>

                <!-- 4. Academy -->
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">FINTEGRITA Academy</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Pelatihan akuntansi UMKM, bimbingan teknis (Bimtek) lembaga, kursus tata kelola kasir, dan coding anak.</p>
                </div>

                <!-- 5. Advisory -->
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">FINTEGRITA Advisory</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Konsultasi pengelolaan keuangan, audit kesiapan laporan RAT Koperasi, dan evaluasi proses bisnis.</p>
                </div>

                <!-- 6. Knowledge -->
                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-rose-500/10 text-rose-400 border border-rose-500/20 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">FINTEGRITA Knowledge</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Pusat e-book akuntansi, worksheet manajemen arus kas, dan modul pembelajaran praktis berlisensi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-slate-800 bg-slate-950 text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                &copy; {{ date('Y') }} FINTEGRITA. All rights reserved. Built with Laravel 12 & Filament v3.
            </div>
            <div class="flex items-center gap-6 text-slate-400">
                <a href="/portal" class="hover:text-white transition">Portal Pelanggan</a>
                <a href="/admin" class="hover:text-white transition">Admin Panel</a>
                <a href="https://wa.me/6285172252910" target="_blank" class="hover:text-teal-400 transition">Kontak WhatsApp</a>
            </div>
        </div>
    </footer>

</body>
</html>
