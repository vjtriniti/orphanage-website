<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('reference')->nullable()->unique()->after('id');
            $table->string('purpose')->nullable()->after('message');
            $table->string('campaign')->nullable()->after('purpose');
            $table->string('donation_type')->default('one_time')->after('campaign');
            $table->string('recurring_frequency')->nullable()->after('donation_type');
            $table->boolean('anonymous')->default(false)->after('recurring_frequency');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropUnique(['reference']);
            $table->dropColumn(['reference','purpose','campaign','donation_type','recurring_frequency','anonymous']);
        });
    }
};
