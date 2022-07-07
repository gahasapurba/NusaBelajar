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
        Schema::create('articles_article_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_articles_id')->constrained('articles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tag_article_tags_id')->constrained('article_tags')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('articles_article_tags');
    }
};
