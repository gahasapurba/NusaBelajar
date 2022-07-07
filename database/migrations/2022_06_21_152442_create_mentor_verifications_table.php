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
        Schema::create('mentor_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_users_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('profile_summary');
            $table->string('id_card');
            $table->string('selfie_with_id_card');
            $table->string('resume');
            $table->string('whatsapp_number')->unique();
            $table->string('facebook_profile_link')->nullable();
            $table->string('instagram_profile_link')->nullable();
            $table->string('linkedin_profile_link')->nullable();
            $table->string('bank_account_number');
            $table->string('bank_account_name');
            $table->string('bank_name');
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
        Schema::dropIfExists('mentor_verifications');
    }
};
