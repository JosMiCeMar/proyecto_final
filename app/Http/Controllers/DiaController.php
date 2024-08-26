<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use App\Models\Dia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DiaController extends Controller
{
    //Vista para el menu de gestion
    public function index()
    {
        return Inertia::render('Users/Admin/Dias/Index');
    }

    //Vista del formulario de asignacion de dia
    public function create()
    {
        //Centros disponibles
        $centros = Centro::select('id', 'nombre', 'localidad')->where('active', 1)->get();
        //Fechas de dias registrados
        $dias = Dia::select('fecha')->where('active', 1)->get();

        return Inertia::render('Users/Admin/Dias/FormDays', ['centros' => $centros, 'fechas' => $dias]);
    }

    //Validacion y asignacion del dia
    public function store(Request $request)
    {
        //Fecha recibida al formato yyyy/MM/dd en la zona horaria del servidor
        $fechaRecibida = Carbon::parse($request->input('day'))->setTimezone(config('app.timezone'))->format('Y-m-d');

        //Fechas mínima y máxima en el mismo formato yyyy/MM/dd
        $fechaMinima = Carbon::now()->startOfDay()->format('Y-m-d');
        $fechaMaxima = Carbon::now()->addYear()->startOfDay()->format('Y-m-d');

        //Sobrescribe el valor de 'day' en el request
        $request->merge(['day' => $fechaRecibida]);

        $request->validate([
            'day' => 'required|date_format:Y-m-d|before:' . $fechaMaxima . '|after_or_equal:' . $fechaMinima ,
            'center' => 'required|exists:centros,id'
        ]);

        try {
            $dia = new Dia();
            $dia->centro_id = $request->center;
            $dia->fecha = $request->day;
            $dia->save();
            //Aunque se retorne con un error, no lo es, es un mensaje informativo
            return redirect(route('admin.indexDias'))->withErrors('Día asignado correctamente', 'msg');
        } catch (Exception $er) {
            return redirect(route('admin.indexDias'))->withErrors($er->getMessage(), 'msg');
        }
    }

    //Vista de los dias asignados
    public function list()
    {
        //Dias asignados mas los nombres y localidades de su correspondiente centro
        $dias = Dia::select('dias.id', 'dias.fecha', 'centros.nombre', 'centros.localidad')
            ->join('centros', 'dias.centro_id', '=', 'centros.id')->orderBy('dias.fecha')
            ->where('dias.active', 1)
            ->get();

        return Inertia::render('Users/Admin/Dias/TableDays', ['dias' => $dias]);
    }

    //Vista de formulario de modificación de dias
    public function delete(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:dias,id'
        ]);

        $dia = Dia::find($request->id);

        if ($dia) {
            $dia->active = 0;
            $dia->save();
            return redirect(route('admin.listDias'))->withErrors('Día eliminado correctamente', 'msg');
        }
        return redirect()->back();
    }

    //Obtencion y mostrado de formulario del dia a modificar
    public function mod($id)
    {
        $dia = Dia::where('id', $id)->where('active', 1)->first();

        //Si existe el dia, renderiza el formulario con los datos del dia asignado
        if ($dia) {
            $centros = Centro::select('id', 'nombre', 'localidad')->where('active', 1)->get();
            $diasDisponibles = Dia::select('fecha')->where('active', 1)->get();

            return Inertia::render('Users/Admin/Dias/ModFormDays', ["datos" => $dia, 'centros' => $centros, 'fechas' => $diasDisponibles]);
        }

        //Si no existe dicho id, vuelve a la tabla
        return redirect()->back();
    }

    //Actualizacion del dia asignaddo
    public function update(Request $request)
    {

        //Fecha recibida al formato yyyy/MM/dd en la zona horaria del servidor
        $fechaRecibida = Carbon::parse($request->input('day'))->setTimezone(config('app.timezone'))->format('Y/m/d');

        //Fechas mínima y máxima en el mismo formato yyyy/MM/dd
        $fechaMinima = Carbon::now()->startOfDay()->format('Y/m/d');
        $fechaMaxima = Carbon::now()->addYear()->startOfDay()->format('Y/m/d');

        //Se sobrescribe el valor de 'day' en el request
        $request->merge(['day' => $fechaRecibida]);

        $request->validate([
            'id' => 'required|exists:dias,id',
            'day' => 'required|date_format:Y/m/d|before:' . $fechaMaxima . '|after_or_equal:' . $fechaMinima,
            'center' => 'required|exists:centros,id'
        ]);

        $dia = Dia::find($request->id);

        if ($dia) {
            $dia->fecha = $request->day;
            $dia->centro_id = $request->center;
            $dia->save();

            return redirect(route('admin.listDias'))->withErrors('Día modificado correctamente', 'msg');
        }

        return redirect()->back();
    }
}
