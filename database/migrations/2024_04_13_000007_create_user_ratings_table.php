<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->unsignedBigInteger('rated_user_id');
            $table->unsignedBigInteger('rated_by_user_id');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('set null');

            $table->foreign('rated_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('rated_by_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_ratings');
    }
}; 