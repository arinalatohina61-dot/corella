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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('recipient_name'); // Получатель
            $table->string('phone'); // Телефон для доставки
            $table->string('city'); // Город
            $table->string('address'); // Адрес доставки
            $table->string('postal_code')->nullable(); // Индекс
            $table->text('delivery_notes')->nullable(); // Комментарий к доставке
            $table->enum('delivery_method', ['courier', 'pickup', 'post']); // Способ доставки
            $table->decimal('delivery_cost', 10, 2)->default(0); // Стоимость доставки
            $table->dateTime('delivery_date')->nullable(); // Желаемая дата доставки
            $table->enum('delivery_status', ['новый', 'в процессе', 'завершенный', 'отмененный'])->default('новый');
            $table->string('tracking_number')->nullable(); // Трек-номер
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
