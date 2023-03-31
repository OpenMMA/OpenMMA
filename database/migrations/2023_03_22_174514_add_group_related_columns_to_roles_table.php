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
        Schema::table('roles', function (Blueprint $table) {
            $table->boolean('isBaseRole')
                  ->default(false)
                  ->after('title');
            $table->foreignId('group')
                  ->after('isBaseRole')
                  ->nullable() // TODO temporary to allow for roles outside groups for testing
                  ->constrained('groups')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['isBaseRole', 'group']);
        });
    }
};
