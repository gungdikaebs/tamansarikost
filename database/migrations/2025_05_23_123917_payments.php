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
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->integer('amount');
            $table->date('payment_date');
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('payment_method'); // e.g., bank transfer, cash
            $table->string('billing_period'); // e.g., '2025-05', '2025-06'
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
