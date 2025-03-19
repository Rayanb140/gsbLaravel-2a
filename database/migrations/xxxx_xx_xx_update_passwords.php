<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Modification de la colonne pour stocker des hachages plus longs
        Schema::table('visiteur', function (Blueprint $table) {
            // Augmenter la taille de la colonne mdp pour stocker des hachages bcrypt
            $table->string('mdp', 60)->change();
        });
        
        Schema::table('gestionnaire', function (Blueprint $table) {
            $table->string('mdp', 60)->change();
        });
        
        // 2. Mise à jour des mots de passe existants
        $visiteurs = DB::table('visiteur')->get();
        foreach ($visiteurs as $visiteur) {
            DB::table('visiteur')
                ->where('id', $visiteur->id)
                ->update(['mdp' => password_hash($visiteur->mdp, PASSWORD_DEFAULT)]);
        }
        
        $gestionnaires = DB::table('gestionnaire')->get();
        foreach ($gestionnaires as $gestionnaire) {
            DB::table('gestionnaire')
                ->where('id', $gestionnaire->id)
                ->update(['mdp' => password_hash($gestionnaire->mdp, PASSWORD_DEFAULT)]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Impossible de revenir en arrière sans perdre les mots de passe
        // car les hachages sont à sens unique
    }
}; 