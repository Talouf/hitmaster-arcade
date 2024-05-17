<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddIpAddressToSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Vérifie si la colonne 'ip_address' existe déjà avant de l'ajouter
        if (!Schema::hasColumn('sessions', 'ip_address')) {
            Schema::table('sessions', function (Blueprint $table) {
                $table->string('ip_address', 45)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Supprime la colonne 'ip_address' uniquement si elle existe
        if (Schema::hasColumn('sessions', 'ip_address')) {
            Schema::table('sessions', function (Blueprint $table) {
                $table->dropColumn('ip_address');
            });
        }
    }
}


