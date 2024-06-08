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
        Schema::table('feedback', function($table) {
            $table->string('service_name')->after('description');
            $table->integer('rating')->after('service_name')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function($table) {
            $table->dropColumn('service_name');
            $table->dropColumn('rating');
        });
    }
};
