<?php

namespace App\Models;

interface GeneradorCodigoInterfaz{

     /**
     * Genera un código aleatorio.
     * 
     * @return string El código generado.
     */
    public function generarCodigo();
}