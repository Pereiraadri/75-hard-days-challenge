<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const REPLACED_STATUSES = [
        'in_progress' => 'running',
        'completed' => 'finished',
        'cancelled' => 'finished',
    ];

    private const RESTORED_STATUSES = [
        'running' => 'in_progress',
        'finished' => 'completed',
    ];

    private const ORIGINAL_STATUSES = ['created', 'in_progress', 'completed', 'cancelled'];

    public function up(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->string('status')->default('created')->change();
        });

        foreach (self::REPLACED_STATUSES as $original => $replacement) {
            DB::table('challenges')->where('status', $original)->update(['status' => $replacement]);
        }
    }

    public function down(): void
    {
        foreach (self::RESTORED_STATUSES as $current => $original) {
            DB::table('challenges')->where('status', $current)->update(['status' => $original]);
        }

        Schema::table('challenges', function (Blueprint $table) {
            $table->enum('status', self::ORIGINAL_STATUSES)->default('created')->change();
        });
    }
};
