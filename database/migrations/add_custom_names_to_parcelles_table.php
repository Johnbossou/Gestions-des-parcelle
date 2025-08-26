<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parcelles', function (Blueprint $table) {
            $table->string('agent_name')->nullable()->after('agent');
            $table->string('responsable_name')->nullable()->after('responsable_id');
        });
    }

    public function down(): void
    {
        Schema::table('parcelles', function (Blueprint $table) {
            $table->dropColumn(['agent_name', 'responsable_name']);
        });
    }
};
