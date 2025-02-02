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
        try {
            //Centros disponibles
            $centros = Centro::select('id', 'nombre', 'localidad')->where('active', 1)->get();
            //Fechas de dias registrados
            $dias = Dia::select('fecha')->get();

            return Inertia::render('Users/Admin/Dias/FormDays', ['centros' => $centros, 'fechas' => $dias]);
        } catch (Exception $er) {
            return redirect(route('admin.indexDias'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Validacion y asignacion del dia
    public function store(Request $request)
    {
        try {
            //Fecha recibida al formato yyyy/MM/dd en la zona horaria del servidor
            $fechaRecibida = Carbon::parse($request->input('day'))->setTimezone(config('app.timezone'))->format('Y-m-d');

            //Fechas mínima y máxima en el mismo formato yyyy/MM/dd
            $fechaMinima = Carbon::now()->startOfDay()->format('Y-m-d');
            $fechaMaxima = Carbon::now()->addYear()->startOfDay()->format('Y-m-d');

            // Validar que la fecha no sea sábado (6) ni domingo (0)
            $diaSemana = Carbon::parse($fechaRecibida)->dayOfWeek;
            if ($diaSemana === 6 || $diaSemana === 0) {
                return redirect()->back()->withErrors('No se pueden asignar días de trabajo en sábados o domingos.');
            }

            //Sobrescribe el valor de 'day' en el request
            $request->merge(['day' => $fechaRecibida]);

            $request->validate([
                'day' => 'required|date_format:Y-m-d|before:' . $fechaMaxima . '|after_or_equal:' . $fechaMinima,
                'center' => 'required|exists:centros,id',
                'notification' => 'required|boolean'
            ]);

            $dia = new Dia();
            $dia->centro_id = $request->center;
            $dia->fecha = $request->day;
            $dia->save();

            if ($request->notification) {
                $responsable = Responsable::where('centro_id', $dia->centro_id)
                    ->select('user_id')
                    ->first();

                if ($responsable) {
                    $fechaFormateada = Carbon::parse($dia->fecha)->format('d/m/Y');
                    $mensaje = 'Se ha asignado el dia ' . $fechaFormateada . ' para trabajar en su centro';
                    NotificacioneController::enviarNotificacion($responsable->user_id, $mensaje);
                }
            }

            //Se redirije con el mensaje indicativo
            return redirect(route('admin.indexDias'))->with('msg', 'Día asignado correctamente');
        } catch (Exception $er) {
            return redirect(route('admin.indexDias'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Vista de los dias asignados
    public function list()
    {
        try {
            $hoy = Carbon::today();
            //Dias asignados mas los nombres y localidades de su correspondiente centro
            $dias = Dia::select('dias.id', 'dias.fecha', 'centros.nombre', 'centros.localidad')
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->where('dias.fecha', '>', $hoy)
                ->orderBy('dias.fecha')
                ->get();

            return Inertia::render('Users/Admin/Dias/TableDays', ['dias' => $dias]);
        } catch (Exception $er) {
            return redirect(route('admin.indexDias'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Vista de formulario de modificación de dias
    public function delete(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|exists:dias,id',
                'notification' => 'required|boolean'
            ]);

            $dia = Dia::find($request->id);

            if ($dia) {
                $fechaFormateada = Carbon::parse($dia->fecha)->format('d/m/Y');

                if ($request->notification) {
                    //Se obtiene el responsable del centro al que pertenece el dia y se manda la notificación
                    $responsableCentro = Responsable::where('centro_id', $dia->centro_id)
                        ->join('centros', 'centro_id', '=', 'centros.id')
                        ->select('user_id')
                        ->first();

                    if ($responsableCentro) {
                        $msjRespon = 'El día asignado a fecha ' . $fechaFormateada . ' ha sido eliminado';
                        NotificacioneController::enviarNotificacion($responsableCentro->user_id, $msjRespon);
                    }

                    $nombreCentro = Centro::select('nombre', 'localidad')->where('id', $dia->centro_id)->first();

                    //Se obtienen los clientes afectados por la eliminación del dia y se les manda la notificación
                    $clientesAfectados = Reserva::where('dia_id', $dia->id)
                        ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                        ->join('users', 'clientes.user_id', '=', 'users.id')
                        ->select('users.id')
                        ->distinct()
                        ->get();

                    if ($clientesAfectados->count() > 0) {
                        $msjClientes = 'El día ' . $fechaFormateada . ' donde tenía una reserva en ' . $nombreCentro->nombre . ' (' . $nombreCentro->localidad . '), ha sido eliminado.';
                        foreach ($clientesAfectados as $cliente) {
                            NotificacioneController::enviarNotificacion($cliente->id, $msjClientes);
                        }
                    }
                }


                //Se elimina el dia
                $dia->delete();

                return redirect(route('admin.listDias'))->with('msg', 'Día eliminado correctamente');
            } else {
                return redirect(route('admin.indexDias'))->withErrors('No se encontró el día indicado');
            }
        } catch (Exception $er) {
            return redirect(route('admin.indexDias'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Obtencion y mostrado de formulario del dia a modificar
    public function mod($id)
    {
        try {
            $hoy = Carbon::today();

            $dia = Dia::where('id', $id)->where('fecha', '>', $hoy)->first();

            //Si existe el dia, renderiza el formulario con los datos del dia asignado
            if ($dia) {
                $diasNoDisponibles = Dia::select('fecha')->get();

                return Inertia::render('Users/Admin/Dias/ModFormDays', ["datos" => $dia, 'fechas' => $diasNoDisponibles]);
            }

            //Si no existe dicho id, vuelve a la tabla
            return redirect()->route('admin.listDias');
        } catch (Exception $er) {
            return redirect(route('index.adminDias'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Actualizacion del dia asignaddo
    public function update(Request $request)
    {
        try {
            //Fecha recibida al formato yyyy/MM/dd en la zona horaria del servidor
            $fechaRecibida = Carbon::parse($request->input('day'))->setTimezone(config('app.timezone'))->format('Y/m/d');

            //Fechas mínima y máxima en el mismo formato yyyy/MM/dd
            $fechaMinima = Carbon::now()->addDay()->startOfDay()->format('Y/m/d');
            $fechaMaxima = Carbon::now()->addYear()->startOfDay()->format('Y/m/d');

            // Validar que la fecha no sea sábado (6) ni domingo (0)
            $diaSemana = Carbon::parse($fechaRecibida)->dayOfWeek;
            if ($diaSemana === 6 || $diaSemana === 0) {
                return redirect()->back()->withErrors('No se pueden asignar días de trabajo en sábados o domingos.');
            }

            //Se sobrescribe el valor de 'day' en el request
            $request->merge(['day' => $fechaRecibida]);

            $request->validate([
                'id' => 'required|exists:dias,id',
                'day' => 'required|date_format:Y/m/d|before:' . $fechaMaxima . '|after_or_equal:' . $fechaMinima,
                'notification' => 'required|boolean'
            ]);

            $dia = Dia::find($request->id);

            if ($dia) {
                $fechaAntiguaFormateada = Carbon::parse($dia->fecha)->format('d/m/Y');

                $dia->fecha = $request->day;
                $dia->save();

                if ($request->notification) {

                    $fechaFormateada = Carbon::parse($dia->fecha)->format('d/m/Y');

                    //Se obtiene el responsable del centro al que pertenece el dia y se manda la notificación
                    $responsableCentro = Responsable::where('centro_id', $dia->centro_id)
                        ->join('centros', 'centro_id', '=', 'centros.id')
                        ->select('user_id')
                        ->first();

                    if ($responsableCentro) {
                        $msjRespon = 'El día asignado para el ' . $fechaAntiguaFormateada . ' ha sido modificado para la fecha ' . $fechaFormateada;
                        NotificacioneController::enviarNotificacion($responsableCentro->user_id, $msjRespon);
                    }

                    $nombreCentro = Centro::select('nombre', 'localidad')->where('id', $dia->centro_id)->first();

                    //Se obtienen los clientes afectados por la modificación del dia y se les manda la notificación
                    $clientesAfectados = Reserva::where('dia_id', $dia->id)
                        ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                        ->join('users', 'clientes.user_id', '=', 'users.id')
                        ->select('users.id')
                        ->distinct()
                        ->get();

                    if ($clientesAfectados->count() > 0) {
                        $msjClientes = 'El día ' . $fechaAntiguaFormateada . ' donde tenía una reserva en ' . $nombreCentro->nombre . ' (' . $nombreCentro->localidad . '), ha sido modificado para la fecha ' . $fechaFormateada;
                        foreach ($clientesAfectados as $cliente) {
                            NotificacioneController::enviarNotificacion($cliente->id, $msjClientes);
                        }
                    }
                }

                return redirect(route('admin.listDias'))->with('msg', 'Día modificado correctamente');
            } else {
                return redirect(route('index.adminDias'))->withErrors('No se encontró el día indicado');
            }
        } catch (Exception $er) {
            return redirect(route('index.adminDias'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }
}
