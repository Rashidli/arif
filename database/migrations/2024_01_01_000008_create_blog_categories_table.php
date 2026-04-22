<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('blog_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_category_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->unique(['blog_category_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_category_translations');
        Schema::dropIfExists('blog_categories');
    }
};
