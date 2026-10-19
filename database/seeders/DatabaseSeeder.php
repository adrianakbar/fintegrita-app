<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\CashAccount;
use App\Models\Category;
use App\Models\FiscalPeriod;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin User
        User::firstOrCreate(
            ['email' => 'admin@fintegrita.com'],
            [
                'name' => 'Super Admin Fintegrita',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'phone' => '085172252910',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Direktur
        User::firstOrCreate(
            ['email' => 'director@fintegrita.com'],
            [
                'name' => 'Direktur Fintegrita',
                'password' => Hash::make('password'),
                'role' => 'director',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // 2. 6 Lini Bisnis FINTEGRITA
        $categories = [
            [
                'name' => 'FINTEGRITA Finance',
                'slug' => 'finance',
                'line_of_business' => 'finance',
                'description' => 'Solusi pencatatan keuangan personal, UMKM, pembukuan, dan template laporan.',
                'icon' => 'heroicon-o-banknotes',
                'sort_order' => 1,
            ],
            [
                'name' => 'FINTEGRITA Tech',
                'slug' => 'tech',
                'line_of_business' => 'tech',
                'description' => 'Rekayasa web, SIM koperasi, SIM sekolah, POS kasir, dan integrasi API enterprise.',
                'icon' => 'heroicon-o-cpu-chip',
                'sort_order' => 2,
            ],
            [
                'name' => 'FINTEGRITA Intelligence',
                'slug' => 'intelligence',
                'line_of_business' => 'intelligence',
                'description' => 'Dashboard kinerja bisnis, business intelligence, dan otomasi laporan terpadu.',
                'icon' => 'heroicon-o-chart-bar',
                'sort_order' => 3,
            ],
            [
                'name' => 'FINTEGRITA Academy',
                'slug' => 'academy',
                'line_of_business' => 'academy',
                'description' => 'Pelatihan akuntansi UMKM, bimtek lembaga, coding anak, dan literasi finansial.',
                'icon' => 'heroicon-o-academic-cap',
                'sort_order' => 4,
            ],
            [
                'name' => 'FINTEGRITA Advisory',
                'slug' => 'advisory',
                'line_of_business' => 'advisory',
                'description' => 'Konsultasi keuangan, audit pembukuan, evaluasi SOP proses bisnis, dan pendampingan.',
                'icon' => 'heroicon-o-user-group',
                'sort_order' => 5,
            ],
            [
                'name' => 'FINTEGRITA Knowledge',
                'slug' => 'knowledge',
                'line_of_business' => 'knowledge',
                'description' => 'E-book keuangan, modul panduan pembukuan, worksheet bisnis, dan materi berlisensi.',
                'icon' => 'heroicon-o-book-open',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Chart of Accounts (COA) Standar Fintegrita
        $coa = [
            // Aset (1)
            ['code' => '1-1001', 'name' => 'Kas Kecil Operasional', 'type' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '1-1002', 'name' => 'Bank Operasional BCA', 'type' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '1-1100', 'name' => 'Piutang Usaha Pelanggan', 'type' => 'asset', 'normal_balance' => 'debit'],
            
            // Kewajiban (2)
            ['code' => '2-1000', 'name' => 'Utang Usaha & Operasional', 'type' => 'liability', 'normal_balance' => 'credit'],
            ['code' => '2-1100', 'name' => 'Uang Muka Proyek (Liabilitas Kontrak)', 'type' => 'liability', 'normal_balance' => 'credit'],
            
            // Ekuitas (3)
            ['code' => '3-1000', 'name' => 'Modal Disetor', 'type' => 'equity', 'normal_balance' => 'credit'],
            ['code' => '3-2000', 'name' => 'Laba Ditahan (Retained Earnings)', 'type' => 'equity', 'normal_balance' => 'credit'],
            
            // Pendapatan (4)
            ['code' => '4-1000', 'name' => 'Pendapatan Produk Digital & Lisensi', 'type' => 'revenue', 'normal_balance' => 'credit'],
            ['code' => '4-2000', 'name' => 'Pendapatan Jasa Rekayasa Sistem (Tech)', 'type' => 'revenue', 'normal_balance' => 'credit'],
            ['code' => '4-3000', 'name' => 'Pendapatan Pelatihan (Academy)', 'type' => 'revenue', 'normal_balance' => 'credit'],
            ['code' => '4-4000', 'name' => 'Pendapatan Konsultasi & Advisory', 'type' => 'revenue', 'normal_balance' => 'credit'],
            
            // Beban / Pengeluaran (5)
            ['code' => '5-1000', 'name' => 'Beban Server, Cloud, & Domain', 'type' => 'expense', 'normal_balance' => 'debit'],
            ['code' => '5-2000', 'name' => 'Beban Operasional & Kantor', 'type' => 'expense', 'normal_balance' => 'debit'],
            ['code' => '5-3000', 'name' => 'Beban Honorarium & Gaji Staf', 'type' => 'expense', 'normal_balance' => 'debit'],
            ['code' => '5-4000', 'name' => 'Beban Pemasaran & Sales', 'type' => 'expense', 'normal_balance' => 'debit'],
        ];

        foreach ($coa as $account) {
            Account::firstOrCreate(['code' => $account['code']], $account);
        }

        // 4. Cash Account
        $bankAccount = Account::where('code', '1-1002')->first();
        if ($bankAccount) {
            CashAccount::firstOrCreate(
                ['account_id' => $bankAccount->id],
                [
                    'name' => 'Bank BCA Fintegrita',
                    'bank_name' => 'BCA',
                    'account_number' => '1234567890',
                    'account_holder' => 'Fintegrita Management',
                    'current_balance' => 0,
                    'is_active' => true,
                ]
            );
        }

        // 5. Fiscal Period Tahun 2026
        FiscalPeriod::firstOrCreate(
            ['year' => 2026, 'period_number' => 10],
            [
                'name' => 'Oktober 2026',
                'start_date' => '2026-10-01',
                'end_date' => '2026-10-31',
                'is_closed' => false,
            ]
        );
    }
}
