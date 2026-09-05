<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('description');
            $t->decimal('target_amount', 14, 2);
            $t->decimal('current_amount', 14, 2)->default(0);
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->string('banner')->nullable();
            $t->enum('status', ['draft', 'active', 'completed', 'closed'])->default('draft');
            $t->timestamps();
        });

        Schema::create('volunteers', function (Blueprint $t) {
            $t->id();
            // users is created by a later migration, so add the foreign key separately.
            $t->unsignedBigInteger('user_id')->nullable();
            $t->string('skills')->nullable();
            $t->text('experience')->nullable();
            $t->string('availability')->nullable();
            $t->string('emergency_contact')->nullable();
            $t->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $t->timestamps();
        });

        Schema::create('children', function (Blueprint $t) {
            $t->id();
            $t->string('public_code')->unique();
            $t->unsignedTinyInteger('age')->nullable();
            $t->enum('gender', ['male', 'female', 'other'])->nullable();
            $t->string('education_status')->nullable();
            $t->text('interests')->nullable();
            $t->text('needs')->nullable();
            $t->text('success_story')->nullable();
            $t->boolean('active')->default(true);
            $t->timestamps();
        });

        Schema::create('expenses', function (Blueprint $t) {
            $t->id();
            $t->string('category');
            $t->string('description');
            $t->decimal('amount', 14, 2);
            $t->date('expense_date');
            $t->string('reference')->nullable();
            $t->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email');
            $t->string('subject');
            $t->text('message');
            $t->boolean('is_read')->default(false);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('children');
        Schema::dropIfExists('volunteers');
        Schema::dropIfExists('campaigns');
    }
};
