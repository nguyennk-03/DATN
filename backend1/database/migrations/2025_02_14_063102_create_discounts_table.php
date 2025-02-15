<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('discount_type', ['fixed', 'percentage']);
            $table->decimal('value', 10, 2);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('max_uses')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}