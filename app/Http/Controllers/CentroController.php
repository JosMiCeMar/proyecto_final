<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CentroController extends Controller
{
    //Vista publica de todos los centros asociados
    public function all()
    {
        $centros = Centro::where('active', 1)->get();
        return Inertia::render('Centros', ['centros' => $centros]);
    }

    //Vista para el menu de gestion
    public function index()
    {
        return Inertia::render('Users/Admin/Centros/Index');
    }

    //Vista del formulario de creacion de centro asociado
    public function create()
    {
        return Inertia::render('Users/Admin/Centros/FormCenter');
    }

    //Validacion y creacion de nuevo centro asociado
    public function store(Request $request)
    {
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
        $centro->email=$request->email;
        $centro->web = $request->web;
        $centro->ubicacion = $request->location;

        $centro->save();

        return redirect(route('admin.indexCenter'));
    }

    //Vista de la tabla de centros activos para modificar o eliminar, parametro opcional para mostrado de mensaje (se usa en modificar y eliminar)
    public function list()
    {
            $centros = Centro::select('id', 'nombre', 'direccion', 'localidad', 'provincia', 'telefono')->where('active', 1)->get();
            return Inertia::render('Users/Admin/Centros/TableCenter', ['centros' => $centros]);
    }

    //Obtencion y mostrado de formulario del centro a modificar
    public function mod($id)
    {
        $centro = Centro::where('id',$id)->where('active',true)->first();

        if ($centro) {
           return Inertia::render('Users/Admin/Centros/ModFormCenter', ["datos" => $centro]);

        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'=>'required|integer|exists:centros,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255', 
            'tel' => 'required|regex:/^\d{9}$/', 
            'province' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'web' => 'nullable|string|max:255|url',
            'location' => 'nullable|string|regex:/^https:\/\/www\.google\.com\/maps\/embed\?pb=[^"]+$/'
        ]);

        $centro=Centro::find($request->id);

        if($centro){
            $centro->nombre=$request->name;
            $centro->direccion=$request->address;
            $centro->telefono=$request->tel;
            $centro->localidad=$request->town;
            $centro->provincia=$request->province;
            $centro->email=$request->email;
            $centro->web=$request->web;
            $centro->ubicacion=$request->location;
            
            $centro->save();

            return redirect(route('admin.listCenter'));
        }

        return redirect()->back();
    }

    //Desactivacion del centro asociado
    public function delete(Request $request)
    {
        $request->validate(['id' => 'required|integer|exists:centros,id'], [
            'id.required' => 'El campo id es obligatorio.',
            'id.integer' => 'El campo id debe ser un número entero.',
            'id.exists' => 'El id proporcionado no existe en la tabla de centros.',
        ]);

        $centro = Centro::find($request->id);

        if ($centro) {
            $centro->active = 0;
            $centro->save();
            return redirect(route('admin.listCenter'));
        }

        return redirect()->back();
    }

    //Metodo estatico para obtencion de los centros sin responsable asignado
    public static function centrosSinResponsable()
    {

        $centros = Centro::where('active', 1)->whereNotIn('id', function ($query) {
            $query->select('centro_id')->from('responsables');
        })->get();

        return $centros;
    }
}
