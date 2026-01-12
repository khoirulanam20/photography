<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tims', function (Blueprint $table) {
            $table->dropColumn([
                'gambar',
                'posisi',
                'instagram',
                'linkedin',
                'facebook',
                'whatsapp',
                'quote',
                'slug'
            ]);

            $table->text('alamat')->after('nama');
            $table->string('no_hp')->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tims', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'no_hp']);

            $table->string('gambar')->after('nama');
            $table->string('posisi')->after('gambar');
            $table->string('instagram')->nullable()->after('posisi');
            $table->string('linkedin')->nullable()->after('instagram');
            $table->string('facebook')->nullable()->after('linkedin');
            $table->string('whatsapp')->nullable()->after('facebook');
            $table->text('quote')->nullable()->after('whatsapp');
            $table->string('slug')->after('quote');
        });
    }
};
