<?php

use App\Enums\PaymentStatus;
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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 12, 2);
            $table->enum('status', PaymentStatus::values())->default(PaymentStatus::PENDING)->index();
            $table->string('payment_method')->default('credit_card')->index();
            $table->date('paid_at')->nullable()->index();
            $table->date('due_date')->notNull()->index();

            $table->foreignId('person_id')->constrained('person')->onDelete('cascade')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
