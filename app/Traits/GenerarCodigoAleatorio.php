<?php

namespace App\Traits;


//Constante para definir el tamaño del código
define('LONGITUD_CODIGO', 8);

/**
 * Genera un código aleatorio alfanumérico.
 * 
 * @return string El código generado.
 */
trait GenerarCodigoAleatorio
{
    /**
     * Genera un código aleatorio alfanumérico.
     * 
     * @return string El código generado.
     */
    public function crearCodigo()
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $salida = '';

        for ($i = 0; $i < LONGITUD_CODIGO; $i++) {
            $salida .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return $salida;
    }
}
