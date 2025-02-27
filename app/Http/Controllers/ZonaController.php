<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controlador de las zonas
 */

class ZonaController extends Controller
{
    /**
     * Muestra la vista del index de zonas
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Users/Admin/Zonas/Index');
    }

    /**
     * Muestra el formulario de creación de una zona
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Users/Admin/Zonas/FormZone');
    }

    /**
     * Almacena una zona en la base de datos
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|decimal:0,2|min:0|max:1000',
                'time' => 'required||date_format:H:i'
            ]);

            $zona = new Zona();
            $zona->nombre = $request->name;
            $zona->precio = $request->price;
            $zona->tiempo_estimado = $request->time;

            $zona->save();

            return redirect(route('admin.indexZona'))->with('msg', 'Zona creada correctamente');
        } catch (Exception $er) {
            return redirect(route('admin.indexZona'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Muestra la tabla de zonas
     *
     * @return Response|RedirectResponse
     */
    public function list(): Response|RedirectResponse
    {
        try {
            $zonas = Zona::select('id', 'nombre', 'precio', 'tiempo_estimado')->where('active', 1)->orderBy('nombre')->get();
            return Inertia::render('Users/Admin/Zonas/TableZones', ['zonas' => $zonas]);
        } catch (Exception $er) {
            return redirect(route('admin.indexZona'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Muestra el formulario de modificación de una zona
     *
     * @param int $id
     * @return Response|RedirectResponse
     */
    public function mod(int $id): Response|RedirectResponse
    {
        try {
            $zona = Zona::where('id', $id)->where('active', true)->first();

            if ($zona) {
                return Inertia::render('Users/Admin/Zonas/ModFormZone', ["datos" => $zona]);
            }

            return redirect()->back();
        } catch (Exception $er) {
            return redirect(route('admin.indexZona'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Actualiza una zona en la base de datos
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:zonas,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|decimal:0,2|min:0|max:1000',
                'time' => 'required||date_format:H:i'
            ]);

            $zona = Zona::find($request->id);

            if ($zona) {
                $zona->nombre = $request->name;
                $zona->precio = $request->price;
                $zona->tiempo_estimado = $request->time;

                $zona->save();
                return redirect(route('admin.indexZona'))->with('msg', 'Zona modificada correctamente');
            }
            // Si no existe la zona
            return redirect()->back();
        } catch (Exception $er) {
            return redirect(route('admin.indexZona'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Elimina una zona de la base de datos
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        try{
            $request->validate(['id' => 'required|integer|exists:zonas,id'], [
                'id.required' => 'El campo id es obligatorio.',
                'id.integer' => 'El campo id debe ser un número entero.',
                'id.exists' => 'El id proporcionado no existe en la tabla de zonas.',
            ]);
    
            $zona = Zona::find($request->id);
    
            if ($zona) {
                $zona->active = 0;
                $zona->save();
                return redirect(route('admin.listZona'))->with('msg', 'Zona eliminada correctamente');;
            }
    
            return redirect()->back();
        }catch(Exception $er){
            return redirect(route('admin.indexZona'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }
}
