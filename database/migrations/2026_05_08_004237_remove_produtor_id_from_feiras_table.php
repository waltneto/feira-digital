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
        Schema::table('feiras', function (Blueprint $table) {
            $table->dropForeign(['produtor_id']);
            $table->dropColumn('produtor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feiras', function (Blueprint $table) {
            $table->unsignedBigInteger('produtor_id')->nullable()->after('id');
            $table->foreign('produtor_id')
                  ->references('id')
                  ->on('produtores')
                  ->onDelete('cascade');
        });
    }
};
