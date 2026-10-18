<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();

            $table->string('title', 150);
            $table->string('slug', 180)->unique();
            $table->text('description');

            // Target dana dalam Rupiah
            $table->unsignedBigInteger('target_amount');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // draft, active, completed, cancelled
            $table->string('status', 20)
                ->default('draft')
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};