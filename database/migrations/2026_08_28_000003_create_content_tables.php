<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->text('description');
            $t->dateTime('starts_at');
            $t->dateTime('ends_at')->nullable();
            $t->string('location')->nullable();
            $t->string('image')->nullable();
            $t->boolean('published')->default(false);
            $t->timestamps();
        });

        Schema::create('posts', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('excerpt')->nullable();
            $t->longText('content');
            $t->string('featured_image')->nullable();
            $t->string('seo_title')->nullable();
            $t->string('meta_description')->nullable();
            $t->enum('status', ['draft', 'published'])->default('draft');
            // users is created by a later migration, so add the foreign key separately.
            $t->unsignedBigInteger('author_id')->nullable();
            $t->timestamps();
        });

        Schema::create('galleries', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('description')->nullable();
            $t->string('cover_image')->nullable();
            $t->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $t) {
            $t->id();
            $t->foreignId('gallery_id')->constrained()->cascadeOnDelete();
            $t->string('path');
            $t->string('caption')->nullable();
            $t->boolean('published')->default(false);
            $t->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $t) {
            $t->id();
            $t->string('email')->unique();
            $t->boolean('active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('events');
    }
};
