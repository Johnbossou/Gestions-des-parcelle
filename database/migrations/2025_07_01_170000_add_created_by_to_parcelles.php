<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToParcelles extends Migration
{
    public function up()
    {
        Schema::table('parcelles', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('utilisateurs')->onDelete('set null')->after('updated_by');
        });
    }

    public function down()
    {
        Schema::table('parcelles', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
}
