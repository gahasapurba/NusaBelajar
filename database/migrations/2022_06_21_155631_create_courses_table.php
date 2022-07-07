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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_users_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_course_categories_id')->constrained('course_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->unsignedInteger('price');
            $table->longText('description');
            $table->string('thumbnail');
            $table->string('introduction_youtube_video_link')->unique();
            $table->string('telegram_group_link')->unique();
            $table->string('syllabus');
            $table->string('file')->nullable();
            $table->longText('review')->nullable();
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_rejected')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('enrolled_people')->default(0);
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
        Schema::dropIfExists('courses');
    }
};
