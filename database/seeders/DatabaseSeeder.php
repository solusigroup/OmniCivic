<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use App\Models\ChartOfAccount;
use App\Models\Program;
use App\Models\Division;
use App\Models\FundSource;
use App\Models\Journal;
use App\Models\JournalDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Branches
        $dpp = Branch::create([
            'name' => 'Dewan Pimpinan Pusat (DPP)',
            'code' => 'DPP-PUSAT',
            'tier' => 'dpp',
            'parent_id' => null,
            'identity_settings' => [
                'party_name' => 'Partai OmniCivic',
                'branch_display_name' => 'Dewan Pimpinan Pusat (DPP)',
                'address' => 'Jl. Kebangsaan No. 1, Jakarta Pusat',
                'phone' => '021-5551234',
                'email' => 'dpp@omnicivic.id',
            ]
        ]);

        $dpdJatim = Branch::create([
            'name' => 'DPD Jawa Timur',
            'code' => 'DPD-JATIM',
            'tier' => 'dpd',
            'parent_id' => $dpp->id,
            'identity_settings' => [
                'party_name' => 'Partai OmniCivic',
                'branch_display_name' => 'Dewan Pimpinan Daerah (DPD) Jawa Timur',
                'address' => 'Jl. Pemuda No. 45, Surabaya',
                'phone' => '031-7778888',
                'email' => 'jatim@omnicivic.id',
            ]
        ]);

        $dpcSurabaya = Branch::create([
            'name' => 'DPC Kota Surabaya',
            'code' => 'DPC-SURABAYA',
            'tier' => 'dpc',
            'parent_id' => $dpdJatim->id,
            'identity_settings' => [
                'party_name' => 'Partai OmniCivic',
                'branch_display_name' => 'Dewan Pimpinan Cabang (DPC) Kota Surabaya',
                'address' => 'Jl. Basuki Rahmat No. 12, Surabaya',
                'phone' => '031-6665555',
                'email' => 'surabaya@omnicivic.id',
            ]
        ]);

        $pacGenteng = Branch::create([
            'name' => 'PAC Kec. Genteng',
            'code' => 'PAC-GENTENG',
            'tier' => 'pac',
            'parent_id' => $dpcSurabaya->id,
            'identity_settings' => [
                'party_name' => 'Partai OmniCivic',
                'branch_display_name' => 'Pimpinan Anak Cabang (PAC) Kecamatan Genteng',
                'address' => 'Jl. Genteng Kali No. 8, Surabaya',
                'phone' => '031-4443333',
                'email' => 'genteng@omnicivic.id',
            ]
        ]);

        // 2. Seed Chart of Accounts
        $coas = [
            // Assets
            ['code' => '101', 'name' => 'Kas Utama', 'type' => 'asset', 'restriction_type' => 'unrestricted', 'is_cash_or_bank' => true, 'normal_balance' => 'debit'],
            ['code' => '102', 'name' => 'Bank Jatim', 'type' => 'asset', 'restriction_type' => 'unrestricted', 'is_cash_or_bank' => true, 'normal_balance' => 'debit'],
            ['code' => '103', 'name' => 'Kas Hibah Pemerintah', 'type' => 'asset', 'restriction_type' => 'temporarily_restricted', 'is_cash_or_bank' => true, 'normal_balance' => 'debit'],
            // Liabilities
            ['code' => '201', 'name' => 'Utang Operasional', 'type' => 'liability', 'restriction_type' => 'unrestricted', 'is_cash_or_bank' => false, 'normal_balance' => 'credit'],
            // Equity (Net Assets)
            ['code' => '301', 'name' => 'Aset Neto Tidak Terikat', 'type' => 'equity', 'restriction_type' => 'unrestricted', 'is_cash_or_bank' => false, 'normal_balance' => 'credit'],
            ['code' => '302', 'name' => 'Aset Neto Terikat Temporer', 'type' => 'equity', 'restriction_type' => 'temporarily_restricted', 'is_cash_or_bank' => false, 'normal_balance' => 'credit'],
            // Revenue
            ['code' => '401', 'name' => 'Sumbangan Anggota', 'type' => 'revenue', 'restriction_type' => 'unrestricted', 'is_cash_or_bank' => false, 'normal_balance' => 'credit'],
            ['code' => '402', 'name' => 'Bantuan Keuangan APBD/APBN', 'type' => 'revenue', 'restriction_type' => 'temporarily_restricted', 'is_cash_or_bank' => false, 'normal_balance' => 'credit'],
            ['code' => '403', 'name' => 'Sumbangan Donatur', 'type' => 'revenue', 'restriction_type' => 'unrestricted', 'is_cash_or_bank' => false, 'normal_balance' => 'credit'],
            // Expenses
            ['code' => '501', 'name' => 'Beban Gaji & Kepegawaian', 'type' => 'expense', 'restriction_type' => 'unrestricted', 'is_cash_or_bank' => false, 'normal_balance' => 'debit'],
            ['code' => '502', 'name' => 'Beban Kampanye & Sosialisasi', 'type' => 'expense', 'restriction_type' => 'unrestricted', 'is_cash_or_bank' => false, 'normal_balance' => 'debit'],
            ['code' => '503', 'name' => 'Beban Bakti Sosial & Kemasyarakatan', 'type' => 'expense', 'restriction_type' => 'unrestricted', 'is_cash_or_bank' => false, 'normal_balance' => 'debit'],
        ];

        $coaModels = [];
        foreach ($coas as $coa) {
            $coaModels[$coa['code']] = ChartOfAccount::create($coa);
        }

        // 3. Seed Programs
        $progBaksos = Program::create(['code' => 'P-01', 'name' => 'Bakti Sosial Ramadhan', 'is_active' => true]);
        $progKampanye = Program::create(['code' => 'P-02', 'name' => 'Kampanye Pemilu', 'is_active' => true]);

        // 4. Seed Divisions
        $divYouth = Division::create(['code' => 'D-01', 'name' => 'Divisi Pemuda & Olahraga', 'is_active' => true]);
        $divHumas = Division::create(['code' => 'D-02', 'name' => 'Divisi Hubungan Masyarakat', 'is_active' => true]);

        // 5. Seed Fund Sources
        $fsApbd = FundSource::create(['code' => 'FS-01', 'name' => 'APBD Provinsi Jawa Timur', 'type' => 'government', 'is_active' => true]);
        $fsIuran = FundSource::create(['code' => 'FS-02', 'name' => 'Iuran Anggota DPD', 'type' => 'member_contribution', 'is_active' => true]);
        $fsCsr = FundSource::create(['code' => 'FS-03', 'name' => 'Hibah CSR Mitra', 'type' => 'donation', 'is_active' => true]);

        // Call RoleSeeder first
        $this->call(RoleSeeder::class);

        // 6. Seed Test Users (all mapped to DPD Jawa Timur for validation demo, except Super Admin)
        $usersData = [
            [
                'name' => 'Staff Operator',
                'email' => 'staff@omnicivic.id',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'branch_id' => $dpdJatim->id,
                'status' => 'active',
            ],
            [
                'name' => 'Bendahara Reviewer',
                'email' => 'bendahara@omnicivic.id',
                'password' => Hash::make('password'),
                'role' => 'bendahara',
                'branch_id' => $dpdJatim->id,
                'status' => 'active',
            ],
            [
                'name' => 'Ketua Approver',
                'email' => 'ketua@omnicivic.id',
                'password' => Hash::make('password'),
                'role' => 'ketua',
                'branch_id' => $dpdJatim->id,
                'status' => 'active',
            ],
            [
                'name' => 'Super Administrator',
                'email' => 'admin@omnicivic.id',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'branch_id' => $dpp->id,
                'status' => 'active',
            ],
        ];

        $userModels = [];
        foreach ($usersData as $ud) {
            $user = User::create($ud);
            $user->assignRole($ud['role']);
            $userModels[$ud['role']] = $user;
        }

        // 7. Seed Journals (Exactly Matching Hero Card Mockup metrics for DPD Jawa Timur)
        // Kas Konsolidasi: Rp 4.820.000.000 (Approved: Bank Jatim 1.5M + Kas Utama 3.32M)
        // Sumbangan Terikat: Rp 1,5 Milyar (Bantuan Keuangan APBD)
        // Persetujuan Pending: 1 Jurnal Pending (Draft/Reviewed)
        
        // Jurnal 1: Kas Masuk Bantuan APBD (Approved) - Rp 1.500.000.000
        $j1 = Journal::create([
            'branch_id' => $dpdJatim->id,
            'transaction_type' => 'cash_in',
            'transaction_date' => Carbon::now()->subDays(10),
            'reference_number' => 'CI-001',
            'description' => 'Penerimaan Bantuan Keuangan Partai Politik APBD Jatim Tahap I',
            'status' => 'approved',
            'created_by' => $userModels['staff']->id,
            'reviewed_by' => $userModels['bendahara']->id,
            'approved_by' => $userModels['ketua']->id,
            'reviewed_at' => Carbon::now()->subDays(9),
            'approved_at' => Carbon::now()->subDays(8),
        ]);
        
        JournalDetail::create([
            'journal_id' => $j1->id,
            'account_id' => $coaModels['102']->id, // Bank Jatim
            'debit' => 1500000000.00,
            'credit' => 0.00,
            'fund_source_id' => $fsApbd->id,
            'division_id' => $divHumas->id,
        ]);
        JournalDetail::create([
            'journal_id' => $j1->id,
            'account_id' => $coaModels['402']->id, // Bantuan Keuangan APBD/APBN
            'debit' => 0.00,
            'credit' => 1500000000.00,
            'fund_source_id' => $fsApbd->id,
            'division_id' => $divHumas->id,
        ]);

        // Jurnal 2: Kas Masuk Sumbangan Anggota (Approved) - Rp 3.320.000.000
        $j2 = Journal::create([
            'branch_id' => $dpdJatim->id,
            'transaction_type' => 'cash_in',
            'transaction_date' => Carbon::now()->subDays(5),
            'reference_number' => 'CI-002',
            'description' => 'Penerimaan Iuran dan Sumbangan Anggota DPD Jatim',
            'status' => 'approved',
            'created_by' => $userModels['staff']->id,
            'reviewed_by' => $userModels['bendahara']->id,
            'approved_by' => $userModels['ketua']->id,
            'reviewed_at' => Carbon::now()->subDays(4),
            'approved_at' => Carbon::now()->subDays(3),
        ]);

        JournalDetail::create([
            'journal_id' => $j2->id,
            'account_id' => $coaModels['101']->id, // Kas Utama
            'debit' => 3320000000.00,
            'credit' => 0.00,
            'fund_source_id' => $fsIuran->id,
        ]);
        JournalDetail::create([
            'journal_id' => $j2->id,
            'account_id' => $coaModels['401']->id, // Sumbangan Anggota
            'debit' => 0.00,
            'credit' => 3320000000.00,
            'fund_source_id' => $fsIuran->id,
        ]);

        // Jurnal 3: Kas Keluar Operasional (Reviewed / Pending Approval)
        $j3 = Journal::create([
            'branch_id' => $dpdJatim->id,
            'transaction_type' => 'cash_out',
            'transaction_date' => Carbon::now()->subDays(2),
            'reference_number' => 'CO-001',
            'description' => 'Pengeluaran Pembayaran Gaji Staf Kantor DPD',
            'status' => 'reviewed',
            'created_by' => $userModels['staff']->id,
            'reviewed_by' => $userModels['bendahara']->id,
            'reviewed_at' => Carbon::now()->subDay(),
        ]);

        JournalDetail::create([
            'journal_id' => $j3->id,
            'account_id' => $coaModels['501']->id, // Beban Gaji
            'debit' => 50000000.00,
            'credit' => 0.00,
        ]);
        JournalDetail::create([
            'journal_id' => $j3->id,
            'account_id' => $coaModels['101']->id, // Kas Utama
            'debit' => 0.00,
            'credit' => 50000000.00,
        ]);

        // Jurnal 4: Kas Keluar Baksos (Draft / Pending Review)
        $j4 = Journal::create([
            'branch_id' => $dpdJatim->id,
            'transaction_type' => 'cash_out',
            'transaction_date' => Carbon::now()->subDay(),
            'reference_number' => 'CO-002',
            'description' => 'Pengeluaran Draf Dana Penunjang Baksos Ramadhan 1447H',
            'status' => 'draft',
            'created_by' => $userModels['staff']->id,
        ]);

        JournalDetail::create([
            'journal_id' => $j4->id,
            'account_id' => $coaModels['503']->id, // Beban Baksos
            'debit' => 20000000.00,
            'credit' => 0.00,
            'program_id' => $progBaksos->id,
            'division_id' => $divYouth->id,
        ]);
        JournalDetail::create([
            'journal_id' => $j4->id,
            'account_id' => $coaModels['101']->id, // Kas Utama
            'debit' => 0.00,
            'credit' => 20000000.00,
            'program_id' => $progBaksos->id,
            'division_id' => $divYouth->id,
        ]);
    }
}
