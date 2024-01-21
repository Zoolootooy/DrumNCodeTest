<?php

use App\Enums\TaskStatus;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->enum('status', [array_column(TaskStatus::cases(), 'value')])->nullable(false)->default(TaskStatus::Todo->value);
            $table->unsignedTinyInteger('priority')->nullable()->default(1);
            $table->string('title')->nullable(false);
            $table->text('description')->nullable()->default(null);

            $table->foreignId('author_id')->nullable(false)->references('id')->on('users');
            $table->foreignId('parent_id')->nullable()->references('id')->on('tasks');

            $table->timestamps();
            $table->timestamp('completed_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
