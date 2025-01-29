<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use App\Models\Dia;
use App\Models\Reserva;
use App\Models\Responsable;
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
        $dias = Dia::select('fecha')->get();

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
            'day' => 'required|date_format:Y-m-d|before:' . $fechaMaxima . '|after_or_equal:' . $fechaMinima,
            'center' => 'required|exists:centros,id'
        ]);

        try {
            $dia = new Dia();
            $dia->centro_id = $request->center;
            $dia->fecha = $request->day;
            $dia->save();
            //Se redirije con el mensaje indicativo
            return redirect(route('admin.indexDias'))->with('msg', 'Día asignado correctamente');
        } catch (Exception $er) {
            return redirect(route('admin.indexDias'))->withErrors($er->getMessage(), 'msg');
        }
    }

    //Vista de los dias asignados
    public function list()
    {
        $hoy = Carbon::today();
        //Dias asignados mas los nombres y localidades de su correspondiente centro
        $dias = Dia::select('dias.id', 'dias.fecha', 'centros.nombre', 'centros.localidad')
            ->join('centros', 'dias.centro_id', '=', 'centros.id')
            ->where('dias.fecha', '>', $hoy)
            ->orderBy('dias.fecha')
            ->get();

        return Inertia::render('Users/Admin/Dias/TableDays', ['dias' => $dias]);
    }

    //Vista de formulario de modificación de dias
    public function delete(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:dias,id',
            'notifications' => 'required|boolean'
        ]);

        $dia = Dia::find($request->id);

        if ($dia) {
            //Si se ha marcado la casilla de notificaciones, manda las notificaciones correspondientes
            if ($request->notifications) {

                $fechaFormateada = Carbon::parse($dia->fecha)->format('d/m/Y');

                //Se obtiene el responsable del centro al que pertenece el dia y se manda la notificación
                $responsableCentro = Responsable::where('centro_id', $dia->centro_id)
                    ->join('centros', 'centro_id', '=', 'centros.id')
                    ->select('user_id', 'centros.nombre as nombre_centro')
                    ->first();

                if ($responsableCentro) {
                    $msjRespon = 'El día asignado a fecha ' . $fechaFormateada . ' ha sido eliminado';
                    NotificacioneController::enviarNotificacion($responsableCentro->user_id, $msjRespon, 'admin.listDias');
                }

                //Se obtienen los clientes afectados por la eliminación del dia y se les manda la notificación
                $clientesAfectados = Reserva::where('dia_id', $dia->id)
                    ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                    ->join('users', 'clientes.user_id', '=', 'users.id')
                    ->select('users.id')
                    ->distinct()
                    ->get();

            

                if ($clientesAfectados->count() > 0) {
                    $msjClientes = 'El día ' . $fechaFormateada . ' donde tenía una reserva en el centro ' . $responsableCentro->nombre_centro . ', ha sido eliminado.' ;
                    foreach ($clientesAfectados as $cliente) {
                        NotificacioneController::enviarNotificacion($cliente->id, $msjClientes, 'admin.listDias');
                    }
                }
            }

            //Se elimina el dia
            $dia->delete();

            return redirect(route('admin.listDias'))->with('msg', 'Día eliminado correctamente');
        }
        return redirect(route('admin.indexDias'))->with('msg', 'Día eliminado correctamente');
    }

    //Obtencion y mostrado de formulario del dia a modificar
    public function mod($id)
    {
        $hoy = Carbon::today();

        $dia = Dia::where('id', $id)->where('fecha', '>', $hoy)->first();

        //Si existe el dia, renderiza el formulario con los datos del dia asignado
        if ($dia) {
            $centros = Centro::select('id', 'nombre', 'localidad')->where('active', 1)->get();
            $diasNoDisponibles = Dia::select('fecha')->where('id', '!=', $id)->get();

            return Inertia::render('Users/Admin/Dias/ModFormDays', ["datos" => $dia, 'centros' => $centros, 'fechas' => $diasNoDisponibles]);
        }

        //Si no existe dicho id, vuelve a la tabla
        return redirect()->route('admin.listDias');
    }

    //Actualizacion del dia asignaddo
    public function update(Request $request)
    {

        //Fecha recibida al formato yyyy/MM/dd en la zona horaria del servidor
        $fechaRecibida = Carbon::parse($request->input('day'))->setTimezone(config('app.timezone'))->format('Y/m/d');

        //Fechas mínima y máxima en el mismo formato yyyy/MM/dd
        $fechaMinima = Carbon::now()->addDay()->startOfDay()->format('Y/m/d');
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

            return redirect(route('admin.listDias'))->with('msg', 'Día modificado correctamente');
        }

        return redirect()->back();
    }
}
