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
        Schema::table('request_perizinan', function (Blueprint $table) {
            if (!Schema::hasColumn('request_perizinan', 'verification_status')) {
                $table->string('verification_status')->default('pending');
            }
            if (!Schema::hasColumn('request_perizinan', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable();
                $table->foreign('verified_by')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');
            }
            if (!Schema::hasColumn('request_perizinan', 'verified_at')) {
                $table->timestamp('verified_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_perizinan', function (Blueprint $table) {
            if (Schema::hasColumn('request_perizinan', 'verification_status')) {
                $table->dropColumn('verification_status');
            }
            if (Schema::hasColumn('request_perizinan', 'verified_by')) {
                $table->dropForeign(['verified_by']);
                $table->dropColumn('verified_by');
            }
            if (Schema::hasColumn('request_perizinan', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
        });
    }
};
