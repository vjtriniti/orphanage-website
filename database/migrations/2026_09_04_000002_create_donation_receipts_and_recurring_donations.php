<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donation_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained()->cascadeOnDelete();
            $table->string('receipt_number')->unique();
            $table->timestamp('issued_at');
            $table->timestamps();
        });

        Schema::create('recurring_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email')->index();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('NGN');
            $table->string('frequency')->default('monthly');
            $table->string('provider')->nullable();
            $table->string('provider_subscription_code')->nullable()->index();
            $table->string('authorization_code')->nullable();
            $table->string('status')->default('active')->index();
            $table->timestamp('next_charge_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recurring_donations');
        Schema::dropIfExists('donation_receipts');
    }
};
