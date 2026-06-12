<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtiquetaController extends Controller
{
    public function imprimir(Equipamento $equipamento)
        {
            return view('equipamentos.etiqueta', compact('equipamento'));
        }
}
