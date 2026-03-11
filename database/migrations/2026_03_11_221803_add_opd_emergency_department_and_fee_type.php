<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();

        $departmentId = DB::table('departments')->where('name', 'OPD Emergency')->value('id');

        if ($departmentId) {
            DB::table('departments')
                ->where('id', $departmentId)
                ->update([
                    'category' => 'OPD',
                    'daily_patient_limit' => 3000,
                    'updated_at' => $now,
                ]);
        } else {
            $departmentId = DB::table('departments')->insertGetId([
                'name' => 'OPD Emergency',
                'daily_patient_limit' => 3000,
                'category' => 'OPD',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $feeCategoryId = DB::table('fee_categories')
            ->where('name', 'OPD (Out Door Patient)')
            ->value('id');

        if (! $feeCategoryId) {
            $feeCategoryId = DB::table('fee_categories')->insertGetId([
                'name' => 'OPD (Out Door Patient)',
                'type' => 'OPD',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $existingFeeTypeId = DB::table('fee_types')
            ->where('fee_category_id', $feeCategoryId)
            ->where('type', 'Emergency Chit')
            ->value('id');

        if ($existingFeeTypeId) {
            DB::table('fee_types')
                ->where('id', $existingFeeTypeId)
                ->update([
                    'amount' => 10,
                    'hif' => 10,
                    'status' => 'Normal',
                    'updated_at' => $now,
                ]);
        } else {
            DB::table('fee_types')->insert([
                'fee_category_id' => $feeCategoryId,
                'type' => 'Emergency Chit',
                'amount' => 10,
                'hif' => 10,
                'status' => 'Normal',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left non-destructive for production safety.
    }
};
