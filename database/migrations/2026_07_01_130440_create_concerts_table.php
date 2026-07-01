<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('concerts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('venue'); // Tempat konser
            $table->string('location'); // Alamat
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->dateTime('ticket_sales_start')->nullable();
            $table->dateTime('ticket_sales_end')->nullable();
            $table->integer('capacity')->default(0);
            $table->integer('tickets_sold')->default(0);
            $table->decimal('ticket_price', 12, 2)->default(0);
            $table->string('image')->nullable();
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->json('lineup')->nullable(); // Daftar artis/performers
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('start_date');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('concerts');
    }
};