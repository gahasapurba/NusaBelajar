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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_users_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_event_categories_id')->constrained('event_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('location');
            $table->longText('google_map_link')->nullable();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->longText('description');
            $table->string('thumbnail');
            $table->string('file')->nullable();
            $table->longText('review')->nullable();
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_rejected')->default(false);
            $table->unsignedBigInteger('registered_people')->default(0);
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
        Schema::dropIfExists('events');
    }
};
