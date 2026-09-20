<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('body');
            $table->unsignedTinyInteger('position')->default(0)->after('icon');
        });
    }

    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->dropColumn(['icon', 'position']);
        });
    }
};
