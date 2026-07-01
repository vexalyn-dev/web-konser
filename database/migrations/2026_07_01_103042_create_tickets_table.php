<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code', 20)->unique();
            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->text('address');
            $table->string('city', 100);
            $table->string('identity_number', 50);
            $table->string('emergency_contact', 255);
            $table->string('emergency_phone', 20);
            $table->enum('status', ['unused', 'checked_in'])->default('unused');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk performa query
            $table->index('ticket_code');
            $table->index('email');
            $table->index('status');
            $table->index('city');
            $table->index('created_at');
            $table->index('checked_in_at');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};