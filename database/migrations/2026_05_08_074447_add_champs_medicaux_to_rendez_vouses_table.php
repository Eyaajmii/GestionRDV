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
        Schema::table('rendez_vouses', function (Blueprint $table) {
            $table->text('symptomes')->nullable()->after('motif');
            $table->integer('niveau_douleur')->nullable()->after('symptomes'); // 1-10
            $table->text('allergies')->nullable()->after('niveau_douleur');
            $table->text('medicaments_en_cours')->nullable()->after('allergies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rendez_vouses', function (Blueprint $table) {
            $table->dropColumn(['symptomes', 'niveau_douleur', 'allergies', 'medicaments_en_cours']);
        });
    }
};
