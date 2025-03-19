<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frais extends Model
{
    protected $table = 'frais'; // Nom de votre table
    protected $fillable = ['idvisiteur', 'mois', 'idfrais', 'quantite']; // Champs autorisés pour l'assignation massive
} 