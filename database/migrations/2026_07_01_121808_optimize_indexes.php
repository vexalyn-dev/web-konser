<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Analyze tables for better query planning
        DB::statement('ANALYZE TABLE users');
        DB::statement('ANALYZE TABLE tickets');
        DB::statement('ANALYZE TABLE activity_logs');
    }

    public function down(): void
    {
        //
    }
};