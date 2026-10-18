<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            // Relasi dengan kampanye dan donatur
            $table->foreignId('campaign_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('donor_id')
                ->constrained()
                ->restrictOnDelete();

            // Informasi transaksi
            $table->unsignedBigInteger('amount');
            $table->char('currency', 3)->default('IDR');
            $table->text('message')->nullable();
            $table->boolean('is_anonymous')->default(false);

            // Status pembayaran
            $table->string('status', 20)
                ->default('pending')
                ->index();

            // Referensi invoice Xendit
            $table->string('external_id')->unique();
            $table->string('xendit_invoice_id')
                ->nullable()
                ->unique();
            $table->text('xendit_invoice_url')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};