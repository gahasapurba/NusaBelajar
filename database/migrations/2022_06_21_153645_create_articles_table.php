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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_users_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_article_categories_id')->constrained('article_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('thumbnail');
            $table->string('file')->nullable();
            $table->string('quote')->nullable();
            $table->longText('review')->nullable();
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_rejected')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('view')->default(0);
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
        Schema::dropIfExists('articles');
    }
};
