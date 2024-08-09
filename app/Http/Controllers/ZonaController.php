<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ZonaController extends Controller
{
    //

    public function index(){
        return Inertia::render('Users/Admin/Zonas/Index');
    }

    public function create(){
        return Inertia::render('Users/Admin/Zonas/FormZone');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|decimal:0,2|min:0.5|max:10000',
            'time' => 'required||date_format:H:i'
        ]);

        $zona = new Zona();
        $zona->nombre = $request->name;
        $zona->precio= $request->price;
        $zona->tiempo_estimado= $request->time;

        $zona->save();

        return redirect(route('admin.indexZona'));
    }

    public function list(){
        $zonas = Zona::select('id', 'nombre', 'precio', 'tiempo_estimado')->where('active', 1)->orderBy('nombre')->get();
        return Inertia::render('Users/Admin/Zonas/TableZones', ['zonas' => $zonas]);
    }

    public function mod($id){
        $zona = Zona::where('id',$id)->where('active',true)->first();

        if ($zona) {
           return Inertia::render('Users/Admin/Zonas/ModFormZone', ["datos" => $zona]);

        }

        return redirect()->back();
    }

    public function update(Request $request){
        $request->validate([
            'id'=>'required|integer|exists:zonas,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|decimal:0,2|min:0.5|max:10000',
            'time' => 'required||date_format:H:i'
        ]);

        $zona=Zona::find($request->id);

        if($zona){
            $zona->nombre=$request->name;
            $zona->precio=$request->price;
            $zona->tiempo_estimado=$request->time;

            $zona->save();
            return redirect(route('admin.listZona'));
        }

        return redirect()->back();
    }

    public function delete(Request $request){
        $request->validate(['id' => 'required|integer|exists:zonas,id'], [
            'id.required' => 'El campo id es obligatorio.',
            'id.integer' => 'El campo id debe ser un número entero.',
            'id.exists' => 'El id proporcionado no existe en la tabla de zonas.',
        ]);

        $zona = Zona::find($request->id);

        if ($zona) {
            $zona->active = 0;
            $zona->save();
            return redirect(route('admin.listZona'));
        }

        return redirect()->back();
        
    }
}
