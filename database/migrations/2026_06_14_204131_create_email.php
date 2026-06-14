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
        Schema::create('email', function (Blueprint $table) {
            $table->id();
            $table->string('to', 255)->index('idx_email_to');
            $table->string('subject', 255)->default('New Email')->index('idx_email_subject');
            $table->text('body');
            $table->string('status', 50)->default('pending')->index('idx_email_status');
            $table->text('error_message')->nullable();
            $table->dateTime('read_at')->nullable()->index('idx_email_read_at');
            $table->timestamps();

            $table->index(['to', 'subject', 'status'], 'idx_email_to_subject_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email');
    }
};
