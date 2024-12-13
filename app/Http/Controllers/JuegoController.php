<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use Illuminate\Http\Request;

class JuegoController extends Controller
{
    public function juego(Request $request){
        $palabras = ["correr","limpio","cometa","luchas","cremas","correr"];

        Juego::create([
            "palabra"=> $palabras(rand(0,count($palabras)))
        ]);

        return response()->json([
            "msg"=> "Juego creado correctamente"
        ],200);
    }

    public function enrolamiento(Request $request){
        $user = $request->user();

        $partida = Juego::find($request->input('id'),$request->input('id'));

        if(!$partida){
            return response()->json([
                "error"=>"Error, no se encontro la partida"
            ],404);
        }

        $partida->jugador_id = $user->id;
        $partida->save();

        return response()->json([
            "msg"=> "Te has unido al juego correcto"
        ]);
    }


    public function jugar(Request $request)
    {

        $user = $request->user();
        $palabra = $request->input("palabra");

        $intentos_restantes = env("INTENTOS");


        $palabra_usuario_dividida = str_split($palabra);

        $palabra_juego = Juego::Where('jugador_id', $user->id);
        $palabra_juego_dividida = str_split($palabra_juego);

        $asiertos = 0;


        if (count($palabra_usuario_dividida) != count($palabra_juego_dividida)) {
            return response()->json([
                "error" => "La longitud de la palabra no es adecuada (debe de ser de 6 letras)"
            ]);
        }

       for ($i = 0; $i < count($palabra_juego_dividida); $i++) {
           for ($j = 0; $j < count($palabra_usuario_dividida); $j++) {

               $palabra_juego->letras_usadas = $palabra_juego->letras_usadas + $palabra_usuario_dividida[$j];
               $palabra_juego->save();
               if ($palabra_usuario_dividida[$j] == $palabra_juego_dividida[$j]) {
                   $palabra_juego->letras_correctas = $palabra_juego->letras_correctas + $palabra_usuario_dividida[$j];
                   $palabra_juego->save();
                   $asiertos++;
               }
           }
       }



       if ($asiertos == 6) {
           return response()->json([
               "msg" => "Has ganado"
           ]);
       }

       

       return response()->json([
           "msg"=>"tienes las siguientes repuestas",
           "usadas"=> $palabra_juego->letras_usadas,
           "correctas"=> $palabra_juego->letras_correctas
       ]);
    }
}
