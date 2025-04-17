<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('listing_id');
            $table->timestamp('transaction_date')->useCurrent();
            $table->string('payment_method', 20)->default('on delivery');
            $table->string('payment_status', 20)->default('pending');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('buyer_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('seller_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('listing_id')
                ->references('id')
                ->on('listings')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}; 