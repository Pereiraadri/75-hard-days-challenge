<?php

use App\Models\Day;
use App\Models\Goal;
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
        Schema::create('day_goal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('day_id')->constrained();
            $table->foreignUuid('goal_id')->constrained();
            $table->boolean('completed')->default(false);
            $table->timestamps();
            $table->unique(['day_id', 'goal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_goal');
    }
};
