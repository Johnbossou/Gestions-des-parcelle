<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Dans la migration
public function up()
{
    Schema::table('utilisateurs', function (Blueprint $table) {
        if (Schema::hasColumn('utilisateurs', 'role')) {
            $table->dropColumn('role');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            //
        });
    }
};
