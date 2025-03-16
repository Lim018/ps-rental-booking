<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->nullable();
            $table->foreignId('service_id')->constrained();
            $table->date('booking_date');
            $table->string('session_time');
            $table->decimal('base_price', 10, 2);
            $table->decimal('weekend_surcharge', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'paid', 'completed', 'cancelled'])->default('pending');
            $table->string('payment_token')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_url')->nullable();
            $table->string('pdf_url')->nullable();
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();$table->string('user_name');
            $table->string('user_phone');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
