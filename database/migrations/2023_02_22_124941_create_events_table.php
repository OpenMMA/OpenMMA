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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('slug')->nullable()->unique();
            $table->text('description');
            $table->text('body');
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->foreignId('banner')->nullable()->constrained('images')->nullOnDelete();
            $table->boolean('registerable')->default(false);
            $table->boolean('enable_comments')->default(false);
            $table->integer('max_registrations')->default(0);
            $table->boolean('allow_externals')->default(false);
            $table->boolean('only_allow_groups')->default(false);
            $table->enum('status', ['draft', 'published', 'unlisted'])->default('draft');
            $table->enum('visibility', ['visible', 'protected', 'local', 'hidden', 'selection'])->default('visible');
            $table->timestamps();
        });

        $db_name = DB::connection()->getDatabaseName();
        foreach (['event_registration_allowed_for', 'event_visible_for'] as $table) {
            Schema::create($table.'_group', function (Blueprint $table) {
                $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
                $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
                $table->primary(['event_id', 'group_id']);
            });
            Schema::create($table.'_category', function (Blueprint $table) {
                $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
                $table->foreignId('category_id')->constrained('group_categories')->cascadeOnDelete();
                $table->primary(['event_id', 'category_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registration_allowed_for_group');
        Schema::dropIfExists('event_registration_allowed_for_category');
        Schema::dropIfExists('event_visible_for_group');
        Schema::dropIfExists('event_visible_for_category');
        Schema::dropIfExists('events');
    }
};
