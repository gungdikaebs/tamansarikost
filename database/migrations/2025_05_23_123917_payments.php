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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_tenant_id')->constrained('room_tenants')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('payment_photo')->nullable()->comment('Foto bukti pembayaran');
            $table->date('payment_date')->nullable();
            $table->enum('payment_status', ['pending', 'confirmed', 'failed'])->default('pending')->nullable();
            $table->string('payment_method')->nullable(); // e.g., "bank_transfer", "cash"
            $table->date('billing_period'); // Misal "2024-10"          a
            $table->decimal('penalty_fee', 10, 2)->default(0)->comment('Denda keterlambatan pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
