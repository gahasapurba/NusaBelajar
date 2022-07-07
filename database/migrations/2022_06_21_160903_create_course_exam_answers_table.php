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
        Schema::create('course_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_users_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('exam_course_exams_id')->constrained('course_exams')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('answer');
            $table->string('file')->nullable();
            $table->longText('review')->nullable();
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_rejected')->default(false);
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
        Schema::dropIfExists('course_exam_answers');
    }
};
