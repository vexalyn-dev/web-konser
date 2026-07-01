<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ticket;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        // Create Admin User
        $this->command->info('👤 Creating admin user...');
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@concert.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'email_verified_at' => now(),
            'last_login_at' => now(),
        ]);

        // Create Check-In Staff User
        $this->command->info('👤 Creating staff user...');
        $staff = User::create([
            'name' => 'Staff Check In',
            'email' => 'staff@concert.com',
            'password' => Hash::make('password'),
            'role' => 'checkin_staff',
            'phone' => '081234567891',
            'email_verified_at' => now(),
            'last_login_at' => now(),
        ]);

        // Create Additional Staff
        User::create([
            'name' => 'John Staff',
            'email' => 'john@concert.com',
            'password' => Hash::make('password'),
            'role' => 'checkin_staff',
            'phone' => '081234567892',
            'email_verified_at' => now(),
        ]);

        // ============================================
        // FIX: Generate tickets dengan status UNUSED semua
        // ============================================
        $this->command->info('🎫 Creating sample tickets (all UNUSED)...');
        
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Bali', 'Yogyakarta', 'Semarang', 'Makassar', 'Palembang', 'Malang'];
        $genders = ['male', 'female'];
        $year = date('Y');
        
        // Generate 100 tiket dengan status UNUSED semua
        for ($i = 1; $i <= 100; $i++) {
            Ticket::create([
                'ticket_code' => sprintf('AGX-%s-%06d', $year, $i),
                'full_name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '08' . fake()->numerify('##########'),
                'gender' => fake()->randomElement($genders),
                'birth_date' => fake()->dateTimeBetween('1970-01-01', '2005-12-31'),
                'address' => fake()->address(),
                'city' => fake()->randomElement($cities),
                'identity_number' => fake()->numerify('##############'),
                'emergency_contact' => fake()->name(),
                'emergency_phone' => '08' . fake()->numerify('##########'),
                'status' => 'unused', // ✅ FIX: Semua unused
                'checked_in_at' => null, // ✅ FIX: Kosong
            ]);
        }

        // ============================================
        // Buat beberapa tiket khusus untuk testing
        // ============================================
        $this->command->info('🎫 Creating specific test tickets...');
        
        $testTickets = [
            [
                'ticket_code' => 'AGX-' . $year . '-TEST01',
                'full_name' => 'Budi Santoso (Test - Belum Check In)',
                'email' => 'budi@example.com',
                'phone' => '081234567801',
                'gender' => 'male',
                'birth_date' => '1990-05-15',
                'address' => 'Jl. Sudirman No. 123',
                'city' => 'Jakarta',
                'identity_number' => '3174012345678901',
                'emergency_contact' => 'Siti Santoso',
                'emergency_phone' => '081234567802',
                'status' => 'unused', // ✅ Belum digunakan
                'checked_in_at' => null,
            ],
            [
                'ticket_code' => 'AGX-' . $year . '-TEST02',
                'full_name' => 'Ani Wijaya (Test - Sudah Check In)',
                'email' => 'ani@example.com',
                'phone' => '081234567803',
                'gender' => 'female',
                'birth_date' => '1992-08-20',
                'address' => 'Jl. Gatot Subroto No. 45',
                'city' => 'Bandung',
                'identity_number' => '3273012345678902',
                'emergency_contact' => 'Budi Wijaya',
                'emergency_phone' => '081234567804',
                'status' => 'checked_in', // ✅ Sudah digunakan (untuk testing error)
                'checked_in_at' => now()->subHours(2),
            ],
            [
                'ticket_code' => 'AGX-' . $year . '-TEST03',
                'full_name' => 'Rudi Hermawan (Test - Belum Check In)',
                'email' => 'rudi@example.com',
                'phone' => '081234567805',
                'gender' => 'male',
                'birth_date' => '1988-12-10',
                'address' => 'Jl. Diponegoro No. 78',
                'city' => 'Surabaya',
                'identity_number' => '3578012345678903',
                'emergency_contact' => 'Dewi Hermawan',
                'emergency_phone' => '081234567806',
                'status' => 'unused', // ✅ Belum digunakan
                'checked_in_at' => null,
            ],
        ];

        foreach ($testTickets as $ticket) {
            Ticket::create($ticket);
        }

        // Create Activity Logs
        $this->command->info('📝 Creating activity logs...');
        
        $actions = ['login', 'create', 'update', 'check_in', 'export'];
        $descriptions = [
            'login' => 'User logged in',
            'create' => 'Created new ticket',
            'update' => 'Updated ticket information',
            'check_in' => 'Checked in ticket',
            'export' => 'Exported report data',
        ];

        for ($i = 0; $i < 20; $i++) {
            $action = $actions[array_rand($actions)];
            
            ActivityLog::create([
                'user_id' => $i % 2 === 0 ? $admin->id : $staff->id,
                'action' => $action,
                'description' => $descriptions[$action],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => now()->subHours(rand(1, 168)),
            ]);
        }

        $this->command->info('✅ Database seeding completed!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('   - Users: ' . User::count());
        $this->command->info('   - Tickets: ' . Ticket::count());
        $this->command->info('   - Tickets UNUSED: ' . Ticket::where('status', 'unused')->count());
        $this->command->info('   - Tickets CHECKED IN: ' . Ticket::where('status', 'checked_in')->count());
        $this->command->info('   - Activity Logs: ' . ActivityLog::count());
        $this->command->info('');
        $this->command->info('🎫 Test Tickets:');
        $this->command->info('   ✅ AGX-' . $year . '-TEST01 (Budi) - Status: UNUSED');
        $this->command->info('   ❌ AGX-' . $year . '-TEST02 (Ani)  - Status: CHECKED IN');
        $this->command->info('   ✅ AGX-' . $year . '-TEST03 (Rudi) - Status: UNUSED');
        $this->command->info('');
        $this->command->info('🔐 Login Credentials:');
        $this->command->info('   Admin: admin@concert.com / password');
        $this->command->info('   Staff: staff@concert.com / password');
        $this->command->info('');
    }
}