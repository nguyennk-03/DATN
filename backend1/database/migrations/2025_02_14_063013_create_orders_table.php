<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['Chờ xử lý', 'Đang xử lý', 'Đã giao', 'Hoàn tất', 'Đã hủy'])->default('Chờ xử lý');
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_status', ['Chờ thanh toán', 'Đã thanh toán', 'Thất bại'])->default('Chờ thanh toán');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}