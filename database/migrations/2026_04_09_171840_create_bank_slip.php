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
        Schema::create('bank_slip', function (Blueprint $table) {
            $table->id();

            $table->string('person_name', 255);
            $table->string('person_city', 255);
            $table->string('person_uf', 2);
            $table->string('person_cpf_cnpj', 14);
            $table->string('person_address', 255);
            $table->string('person_zipcode', 8);

            $table->decimal('bill_amount', 10, 2);
            $table->date('bill_due_date')->default(now());
            $table->foreignId('payment_id')->constrained('payment')->onDelete('cascade');
            $table->foreignId('bank_id')->constrained('bank')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_slip');
    }
};
