<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('no_telp_perusahaan');
            $table->string('logo_perusahaan');
            $table->text('alamat_perusahaan');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('email_perusahaan');
            $table->string('instagram_perusahaan')->nullable();
            $table->string('facebook_perusahaan')->nullable();
            $table->string('twitter_perusahaan')->nullable();
            $table->string('linkedin_perusahaan')->nullable();
            $table->string('slug');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
