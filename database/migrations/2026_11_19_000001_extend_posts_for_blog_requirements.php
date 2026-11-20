<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->date('activity_date')->nullable()->after('excerpt')->index();
            $table->string('authors', 255)->nullable()->after('body');
            $table->string('image_path')->nullable()->after('authors');
        });

        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('caption', 180)->nullable();
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();
            $table->index(['post_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_images');
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['activity_date']);
            $table->dropColumn(['activity_date', 'authors', 'image_path']);
        });
    }
};
