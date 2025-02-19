<?php

namespace App\Helpers;

use App\Models\Administradore;
use App\Models\Cliente;
use App\Models\Responsable;

/**
 * Trait TipoUsuario
 * 
 * Proporciona métodos para obtener el tipo de usuario y datos extra relacionados.
 */
trait TipoUsuario{

    /**
     * Obtiene el tipo de usuario según su ID.
     *
     * @param int $id_usuario ID del usuario en la base de datos.
     * @return string|null Retorna 'admin', 'responsable' o 'cliente' si se encuentra el usuario, de lo contrario null.
     */
    public static function obtenerTipoUsuario($id_usuario) {
        $admin = Administradore::where('user_id', $id_usuario)->first();
        if ($admin) return 'admin';

        $responsable = Responsable::where('user_id', $id_usuario)->first();
        if ($responsable) return 'responsable';

        $cliente = Cliente::where('user_id', $id_usuario)->first();
        if ($cliente) return 'cliente';

        return null; // Retorno explícito en caso de no encontrar coincidencias
    }

    /**
     * Obtiene datos adicionales para usuarios de tipo responsable y cliente.
     *
     * @param int $id_usuario ID del usuario en la base de datos.
     * @return array|null Retorna un array con los datos adicionales o null si el usuario no es responsable ni cliente.
     */
    public static function datosExtra($id_usuario) {
        $responsable = Responsable::where('user_id', $id_usuario)->first();
        if ($responsable) {
            return ['centro' => $responsable->centro_id];
        }

        $cliente = Cliente::where('user_id', $id_usuario)->first();
        if ($cliente) {
            return ['condicion' => $cliente->condicion_especial, 'fecha_nac' => $cliente->fecha_nacimiento];
        }

        return null; // Retorno explícito en caso de no encontrar coincidencias
    }
}