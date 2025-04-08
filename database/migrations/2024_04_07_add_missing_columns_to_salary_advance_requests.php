<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('salary_advance_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('salary_advance_requests', 'rejected_by')) {
                $table->foreignId('rejected_by')->nullable()->constrained('employees');
            }
            if (!Schema::hasColumn('salary_advance_requests', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable();
            }
            if (!Schema::hasColumn('salary_advance_requests', 'is_deduct_from_salary')) {
                $table->boolean('is_deduct_from_salary')->default(true);
            }
            if (!Schema::hasColumn('salary_advance_requests', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('employees');
            }
        });
    }

    public function down()
    {
        Schema::table('salary_advance_requests', function (Blueprint $table) {
            $table->dropForeign(['rejected_by']);
            $table->dropColumn('rejected_by');
            $table->dropColumn('rejected_at');
            $table->dropColumn('is_deduct_from_salary');
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
}; 