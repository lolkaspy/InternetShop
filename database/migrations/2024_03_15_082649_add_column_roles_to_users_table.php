<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('role_id')->default(0);
            $table->index('role_id', 'user_role_idx');
            $table->foreign('role_id', 'user_role_fk')->on('roles')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign('user_role_fk');
        });

        // drop the actual columns
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');

        });
    }
};
