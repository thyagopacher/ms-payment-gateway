<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'email_id', 'file_name', 'file_path', 'file_type', 'file_size'
     */
    public function up(): void
    {
        Schema::create('email_attachment', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 255);
            $table->text('file_path');
            $table->string('file_type', 100);
            $table->integer('file_size')->unsigned();
            $table->timestamps();

            $table->foreignId('email_id');
            $table->foreign('email_id')->references('id')->on('email')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_attachment');
    }
};
