<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_users_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('course_courses_id')->constrained('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('discount_discounts_id')->constrained('discounts')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('discount_percentage')->nullable();
            $table->string('payment_status')->default('waiting');
            $table->string('midtrans_url')->nullable();
            $table->string('midtrans_booking_code')->nullable();
            $table->unsignedInteger('total')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
};
