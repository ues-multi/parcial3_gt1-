<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function vistaDashboard()
   {
        //Ejemplo #1
        $numero = rand(1, 10);
        $resultado = $this->evaluarNumero($numero);

        $valores = [1, 2, 3, 4, 5];
        $suma = $this->sumarValores($valores);
       return view('backend.admin.dashboard.vistadashboard', compact('numero', 'resultado', 'valores', 'suma'));
   }
   //Ejemplo #1
   private function evaluarNumero(int $num): string
   {
       return match (true) {
           $num < 4 => "Número bajo",
           $num < 7 => "Número medio",
           default => "Número alto",
       };
   }
    //Ejemplo #1
   private function sumarValores(array $valores): int
   {
       $suma = 0;
       foreach ($valores as $valor) {
           if ($valor == 3) continue; // Ignora el número 3
           $suma += $valor;
       }
       return $suma;
   }
}
