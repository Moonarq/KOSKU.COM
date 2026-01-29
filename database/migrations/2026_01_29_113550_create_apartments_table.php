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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('contact_person');
            $table->text('address');
            $table->text('description')->nullable();
            $table->json('facilities')->nullable();
            $table->text('rules')->nullable();
            $table->json('image')->nullable();
            $table->enum('gender', ['male', 'female', 'mixed'])->default('mixed');
            $table->string('type')->nullable();
            $table->string('room_size')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
