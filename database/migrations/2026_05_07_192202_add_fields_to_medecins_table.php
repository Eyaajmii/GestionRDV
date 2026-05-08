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
        Schema::table('medecins', function (Blueprint $table) {
            $table->string('categorie')->nullable();
            $table->integer('experience')->nullable();
            $table->enum('statut_dispo', ['disponible', 'indisponible'])
                  ->default('disponible');

            $table->boolean('first_login')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->dropColumn([
                'categorie',
                'experience',
                'statut_dispo',
                'first_login'
            ]);
        });
    }
};
