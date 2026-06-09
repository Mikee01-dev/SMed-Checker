<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SMedCheckerSeeder extends Seeder
{
    public function run(): void
    {
        $jenisPerilaku = [
            ['kode' => 'JPK1', 'nama' => 'Salience', 'deskripsi' => 'Terus-menerus memikirkan media sosial'],
            ['kode' => 'JPK2', 'nama' => 'Mood Modification', 'deskripsi' => 'Perasaan bahagia/senang saat bermain media sosial'],
            ['kode' => 'JPK3', 'nama' => 'Conflict', 'deskripsi' => 'Konflik dengan aktivitas nyata (tidur terganggu, interaksi tatap muka berkurang)'],
            ['kode' => 'JPK4', 'nama' => 'Withdrawal Symptoms', 'deskripsi' => 'Rasa sedih, cemas, atau emosional jika tidak bermain medsos'],
            ['kode' => 'JPK5', 'nama' => 'Tolerance', 'deskripsi' => 'Kebutuhan durasi dan platform yang terus bertambah'],
            ['kode' => 'JPK6', 'nama' => 'Relapse', 'deskripsi' => 'Kondisi sulit berhenti ketika sudah bermain media sosial'],
        ];
        DB::table('jenis_perilaku')->insert($jenisPerilaku);

        $gejala = [
            ['kode' => 'G01', 'deskripsi' => 'Menggunakan media sosial lebih dari 6 jam dalam 1 hari (Kecuali digunakan untuk bekerja)'],
            ['kode' => 'G02', 'deskripsi' => 'Selalu berpikir untuk menggunakan media sosial'],
            ['kode' => 'G03', 'deskripsi' => 'Sering mengalami rasa sedih dan cemas yang berlebihan ketika tidak menggunakan media sosial'],
            ['kode' => 'G04', 'deskripsi' => 'Lebih sering berinteraksi menggunakan media sosial daripada berinteraksi secara langsung (tatap muka)'],
            ['kode' => 'G05', 'deskripsi' => 'Jika sudah bermain media sosial susah berhenti'],
            ['kode' => 'G06', 'deskripsi' => 'Lebih banyak waktu yang digunakan untuk bermain media sosial ketimbang melakukan kegiatan-kegiatan lain'],
            ['kode' => 'G07', 'deskripsi' => 'Saat diajak berinteraksi tidak nyambung (berimajinasi terlalu tinggi)'],
            ['kode' => 'G08', 'deskripsi' => 'Sulit berkonsentrasi saat berinteraksi atau mengerjakan sesuatu karena memikirkan bermain media sosial'],
            ['kode' => 'G09', 'deskripsi' => 'Perasaan bahagia dan senang ketika bermain media sosial'],
            ['kode' => 'G10', 'deskripsi' => 'Membutuhkan waktu yang lebih lama dibandingkan dengan hari sebelumnya agar kamu merasa puas saat bermain media sosial'],
            ['kode' => 'G11', 'deskripsi' => 'Waktu tidur berkurang karena lebih banyak dihabiskan bermain media sosial'],
            ['kode' => 'G12', 'deskripsi' => 'Merasa lebih up to date jika mengetahui informasi terkini dari media sosial'],
            ['kode' => 'G13', 'deskripsi' => 'Sering mengunggah foto, video apapun dan dimanapun pada media sosial'],
            ['kode' => 'G14', 'deskripsi' => 'Sering mempublikasikan status, berita, atau kejadian apapun dan dimanapun'],
            ['kode' => 'G15', 'deskripsi' => 'Memiliki imajinasi mendapat notifikasi dari akun media sosial'],
            ['kode' => 'G16', 'deskripsi' => 'Melakukan banyak aktivitas di media sosial'],
            ['kode' => 'G17', 'deskripsi' => 'Merasa haus akan suka, komen, dan pujian pada media sosial'],
            ['kode' => 'G18', 'deskripsi' => 'Yang pada awalnya bermain media sosial hanya 1 platform dalam 1 jam, namun semakin lama semakin bertambah pula platform media sosial yang digunakan'],
            ['kode' => 'G19', 'deskripsi' => 'Jika tidak bermain media sosial mudah emosional'],
            ['kode' => 'G20', 'deskripsi' => 'Merasa lebih komunikatif dengan keluarga dan teman melalui media sosial'],
        ];
        DB::table('gejala')->insert($gejala);

        $tingkatKecanduan = [
            [
                'kode' => 'T01',
                'nama' => 'Kecanduan Rendah',
                'deskripsi' => 'Anda menunjukkan gejala awal kecanduan media sosial. Masih dalam tahap ringan dan dapat diperbaiki.',
                'solusi' => '1. Batasi waktu penggunaan media sosial maksimal 2 jam per hari
                             2. Gunakan aplikasi pengingat waktu
                             3. Mulai kegiatan offline seperti olahraga atau membaca buku
                             4. Matikan notifikasi media sosial yang tidak penting'
            ],
            [
                'kode' => 'T02',
                'nama' => 'Kecanduan Sedang',
                'deskripsi' => 'Anda sudah menunjukkan kecanduan media sosial tingkat sedang. Perlu tindakan lebih serius.',
                'solusi' => '1. Lakukan digital detox secara bertahap
                             2. Jadwalkan waktu khusus untuk media sosial
                             3. Cari hobi baru yang tidak melibatkan gadget
                             4. Perbanyak interaksi sosial secara langsung
                             5. Konsultasi dengan psikolog jika diperlukan'
            ],
            [
                'kode' => 'T03',
                'nama' => 'Kecanduan Tinggi',
                'deskripsi' => 'Anda mengalami kecanduan media sosial tingkat berat. Segera lakukan penanganan profesional.',
                'solusi' => '1. Segera konsultasi dengan psikolog profesional
                             2. Lakukan terapi perilaku kognitif
                             3. Hapus sementara aplikasi media sosial
                             4. Cari dukungan dari keluarga dan teman terdekat
                             5. Ikuti program rehabilitasi digital jika memungkinkan'
            ],
        ];
        DB::table('tingkat_kecanduan')->insert($tingkatKecanduan);

        $gejalaIds = DB::table('gejala')->pluck('id', 'kode')->toArray();
        $tingkatIds = DB::table('tingkat_kecanduan')->pluck('id', 'kode')->toArray();

        $rule1Symptoms = ['G08', 'G05', 'G02', 'G12', 'G20'];
        
        $rule1 = DB::table('rules')->insertGetId([
            'kode' => 'R1',
            'tingkat_kecanduan_id' => $tingkatIds['T01'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($rule1Symptoms as $kode) {
            DB::table('rule_gejala')->insert([
                'rule_id' => $rule1,
                'gejala_id' => $gejalaIds[$kode],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $rule2Symptoms = ['G08', 'G16', 'G11', 'G12', 'G20', 'G13'];
        
        $rule2 = DB::table('rules')->insertGetId([
            'kode' => 'R2',
            'tingkat_kecanduan_id' => $tingkatIds['T02'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($rule2Symptoms as $kode) {
            DB::table('rule_gejala')->insert([
                'rule_id' => $rule2,
                'gejala_id' => $gejalaIds[$kode],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $rule3Symptoms = ['G01', 'G04', 'G07', 'G06', 'G03', 'G05', 'G16', 'G11', 'G19', 'G09', 'G10', 'G12', 'G13', 'G14', 'G15', 'G17', 'G18'];
        
        $rule3 = DB::table('rules')->insertGetId([
            'kode' => 'R3',
            'tingkat_kecanduan_id' => $tingkatIds['T03'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($rule3Symptoms as $kode) {
            DB::table('rule_gejala')->insert([
                'rule_id' => $rule3,
                'gejala_id' => $gejalaIds[$kode],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@smedchecker.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}