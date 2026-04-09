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
        Schema::create('pix', function (Blueprint $table) {
            $table->id();
            $table->string('pix_key')->unique();

            $table->string('status')->default('pending')->index();
            $table->decimal('amount', 12, 2);

            $table->foreignId('payment_id')->constrained('payment')->onDelete('cascade')->index();
            $table->foreignId('bank_id')->constrained('bank')->onDelete('cascade')->index()->comment('Banco emissor do Pix');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pix');
    }
};
