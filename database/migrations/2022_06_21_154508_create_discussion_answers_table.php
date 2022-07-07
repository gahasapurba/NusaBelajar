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
        Schema::create('discussion_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_users_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('discussion_discussions_id')->constrained('discussions')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('answer');
            $table->string('file')->nullable();
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
        Schema::dropIfExists('discussion_answers');
    }
};
