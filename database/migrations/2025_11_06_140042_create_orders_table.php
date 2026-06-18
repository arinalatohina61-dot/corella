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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->default('pending');
            $table->string('cancel')->nullable();
            $table->string('code');
            $table->string('pay_url')->nullable();
            $table->string('external_order_id')->nullable();
            $table->enum('status', ['новый', 'ожидает оплаты', 'в процессе', 'завершенный', 'отмененный'])
                ->default('новый');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
