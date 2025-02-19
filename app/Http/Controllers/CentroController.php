<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Exception;

/**
 * Controlador de los centros asociados
 */
class CentroController extends Controller
{
    /**
     * Vista pública de los centros asociados
     * @return Response Vista de los centros asociados
     */
    public function all(): Response
    {
        try {
            $centros = Centro::where('active', 1)->get();
            return Inertia::render('Centros', ['centros' => $centros]);
        } catch (Exception $e) {
            return Inertia::render('Centros', ['centros' => []]);
        }
    }

    /**
     * Vista del menú de centros asociados para administradores
     * @return Response Vista del menú de centros asociados
     */
    public function index(): Response
    {
        return Inertia::render('Users/Admin/Centros/Index');
    }

    /**
     * Vista del formulario de creación de un nuevo centro asociado
     * @return Response Vista del formulario
     */
    public function create(): Response
    {
        return Inertia::render('Users/Admin/Centros/FormCenter');
    }

    /**
     * Almacenamiento de un nuevo centro asociado
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección a la vista de centros asociados o redirección con erro
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'tel' => 'required|regex:/^\d{9}$/',
                'province' => 'required|string|max:255',
                'town' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'web' => 'nullable|string|max:255|url',
                'location' => 'nullable|string|regex:/^https:\/\/www\.google\.com\/maps\/embed\?pb=[^"]+$/'
            ]);

            $centro = new Centro();
            $centro->nombre = $request->name;
            $centro->direccion = $request->address;
            $centro->provincia = $request->province;
            $centro->localidad = $request->town;
            $centro->telefono = $request->tel;
            $centro->email = $request->email;
            $centro->web = $request->web;
            $centro->ubicacion = $request->location;

            $centro->save();

            return redirect(route('admin.indexCenter'))->with('msg', 'Centro creado correctamente');
        } catch (Exception $e) {
            return redirect(route('admin.indexCenter'))->withErrors('Error inesperado:' . $e->getMessage());
        }
    }

    /**
     * Vista de la tabla de centros asociados
     * @return RedirectResponse|Response Vista de la tabla o redirección a la vista de centros asociados con error
     */
    public function list(): Response|RedirectResponse
    {
        try {
            $centros = Centro::select('id', 'nombre', 'direccion', 'localidad', 'provincia', 'telefono')->where('active', 1)->get();
            return Inertia::render('Users/Admin/Centros/TableCenter', ['centros' => $centros]);
        } catch (Exception $e) {
            return redirect(route('admin.indexCenter'))->withErrors('Error inesperado:' . $e->getMessage());
        }
    }

    /**
     * Vista del formulario de modificación de un centro asociado
     * @param int $id Identificador del centro asociado
     * @return RedirectResponse|Response Vista del formulario o redirección a la vista de centros asociados con error
     */
    public function mod($id): RedirectResponse|Response
    {
        try {
            $centro = Centro::where('id', $id)->where('active', true)->first();

            if ($centro) {
                return Inertia::render('Users/Admin/Centros/ModFormCenter', ["datos" => $centro]);
            }

            return redirect()->back();
        } catch (Exception $e) {
            return redirect(route('admin.indexCenter'))->withErrors('Error inesperado:' . $e->getMessage());
        }
    }

    /**
     * Actualización de un centro asociado
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección al indice de centros asociados o redirección con error
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:centros,id',
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'tel' => 'required|regex:/^\d{9}$/',
                'province' => 'required|string|max:255',
                'town' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'web' => 'nullable|string|max:255|url',
                'location' => 'nullable|string|regex:/^https:\/\/www\.google\.com\/maps\/embed\?pb=[^"]+$/'
            ]);

            $centro = Centro::find($request->id);

            if ($centro) {
                $centro->nombre = $request->name;
                $centro->direccion = $request->address;
                $centro->telefono = $request->tel;
                $centro->localidad = $request->town;
                $centro->provincia = $request->province;
                $centro->email = $request->email;
                $centro->web = $request->web;
                $centro->ubicacion = $request->location;

                $centro->save();

                return redirect(route('admin.listCenter'))->with('msg', 'Centro modificado correctamente');;
            }
        } catch (Exception $e) {
            return redirect(route('admin.indexCenter'))->withErrors('Error inesperado:' . $e->getMessage());
        }
    }

    /**
     * Desactivar un centro asociado
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección al indice de centros asociados o redirección con error
     */
    public function delete(Request $request): RedirectResponse
    {
        try {
            $request->validate(['id' => 'required|integer|exists:centros,id'], [
                'id.required' => 'El campo id es obligatorio.',
                'id.integer' => 'El campo id debe ser un número entero.',
                'id.exists' => 'El id proporcionado no existe en la tabla de centros.',
            ]);

            $centro = Centro::find($request->id);

            if ($centro) {
                $centro->active = 0;
                $centro->save();
                return redirect(route('admin.listCenter'))->with('msg', 'Centro eliminado correctamente');
            }
        } catch (Exception $e) {
            return redirect(route('admin.indexCenter'))->withErrors('Error inesperado:' . $e->getMessage());
        }
    }

    /**
     * Listado de centros asociados sin responsable
     * @return object Listado de centros asociados sin responsable
     */
    public static function centrosSinResponsable(): object
    {
        $centros = Centro::where('active', 1)->whereNotIn('id', function ($query) {
            $query->select('centro_id')->from('responsables');
        })->get();
        return $centros;
    }
}
