<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE apartments MODIFY price DECIMAL(15,2)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE apartments MODIFY price DECIMAL(10,2)');
    }
};
