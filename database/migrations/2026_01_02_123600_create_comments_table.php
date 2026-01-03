<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('news_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        // 返信（親コメントID）。コメント本文は parent_id = null
        $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();

        $table->text('body');
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
