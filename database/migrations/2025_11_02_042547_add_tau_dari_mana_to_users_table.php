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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('tau_dari_mana', [
                'Google',
                'Facebook',
                'Instagram',
                'Twitter/X',
                'TikTok',
                'Teman/Keluarga',
                'Forum/Diskusi',
                'Iklan',
                'Media Sosial Lain',
                'Lainnya'
            ])->nullable()->after('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tau_dari_mana');
        });
    }
};
