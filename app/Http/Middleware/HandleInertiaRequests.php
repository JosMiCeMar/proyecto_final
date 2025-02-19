<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Helpers\TipoUsuario;

class HandleInertiaRequests extends Middleware
{

    use TipoUsuario;

    /**
     * La plantilla raíz que se carga en la primera visita a la página.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determina la versión actual de los archivos de activos.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define las propiedades que se comparten por defecto.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'tipo'=> $request->user()?$this->obtenerTipoUsuario($request->user()->id):null,
                'datos'=>$request->user()?$this->datosExtra($request->user()->id):null
            ],
        ];
    }
}
