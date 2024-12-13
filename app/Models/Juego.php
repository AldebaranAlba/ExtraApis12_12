<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    protected $table = 'juegos';
    protected $fillable = [
        'palabra',
        'letras_usadas',
        'letras_correctas',
        'jugador_id'
    ];

    public function jugador(){
        return $this->belongsTo(User::class, 'id', 'jugador_id');
    }


}
