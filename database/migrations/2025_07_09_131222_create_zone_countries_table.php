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
        Schema::create('zone_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('alpha2', 2)->nullable();         // VN
            $table->string('alpha3', 3)->nullable();         // VNM
            $table->string('numeric', 3)->nullable();        // 704
            $table->string('phone_code')->nullable();   // +84
            $table->string('currency')->nullable();     // VND
            $table->string('emoji_flag')->nullable();   // 🇻🇳
            $table->longText('args')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zone_countries');
    }
};
