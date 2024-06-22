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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // The user receiving the notification
            $table->string('type'); // The type of notification (e.g., 'follow', 'comment', 'like')
            $table->unsignedBigInteger('actor_id')->nullable(); // The user who triggered the notification
            $table->string('actor_name')->nullable(); // The name of the actor
            $table->text('data'); // JSON data to store additional information
            $table->boolean('read')->default(false); // Mark as read/unread
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('actor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
