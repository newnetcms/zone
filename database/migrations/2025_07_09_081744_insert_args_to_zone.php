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
        Schema::table('zone_provinces', function (Blueprint $table) {
            $table->longText('args')->after('sort_order')->nullable();
        });

        Schema::table('zone_districts', function (Blueprint $table) {
            $table->longText('args')->after('sort_order')->nullable();
        });

        Schema::table('zone_townships', function (Blueprint $table) {
            $table->longText('args')->after('sort_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zone_townships', function (Blueprint $table) {
            $table->dropColumn('args');
        });

        Schema::table('zone_districts', function (Blueprint $table) {
            $table->dropColumn('args');
        });

        Schema::table('zone_provinces', function (Blueprint $table) {
            $table->dropColumn('args');
        });
    }
};
