<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use App\Models\Cliente;
use App\Models\Dia;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Zona;
use Carbon\CarbonInterval;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class ReservaController extends Controller
{
    private const COMIENZO_JORNADA = "9:00";
    private const INICIO_DESCANSO = "14:00";
    private const FIN_DESCANSO = "16:00";
    private const FIN_JORNADA = "19:00";
    private const MAX_CITAS_DIA = 3;

    //-------------------FUNCIONES PARA ADMINISTRADOR-------------------------

    //Funcion para mostrar el índice de edición de reservas
    public function indexAdmin()
    {
        return Inertia::render('Users/Admin/Reservas/Index');
    }

    //Funcion para mostrar la tabla de selección de días
    public function listAdmin()
    {
        try {

            $dias = Dia::select('dias.id', 'dias.fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->where('fecha', '>=', Carbon::now()->startOfDay())
                ->orderBy('fecha')->get();

            return Inertia::render('Users/Admin/Reservas/TableDays', ['dias' => $dias]);
        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar la tabla de reservas del día seleccionado
    public function showAdmin($id)
    {
        try {
            //Busca el dia seleccionado y si no lo encuentra redirije al index indicando el error
            $dia = Dia::where('dias.id', $id)
                ->where('fecha', '>=', Carbon::now()->startOfDay())
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->select('dias.id', 'dias.fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                ->first();

            if (!$dia) {
                return redirect(route('admin.indexReservas'))->withErrors('Día de trabajo no encontrado');
            }

            //Reservas del dia seleccionado
            $reservas = Reserva::where('dia_id', $id)
                ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                ->join('users', 'clientes.user_id', '=', 'users.id')
                ->select(
                    'reservas.id',
                    'users.nombre as cliente_nombre',
                    'users.apellidos as cliente_apellidos',
                    'zonas.nombre as zona_nombre',
                    'hora_inicio',
                    'hora_fin'
                )
                ->get();

            $funcionReservas = $this->getReservasDia($reservas);
            $reservasManiana = $funcionReservas['manana'];
            $reservasTarde = $funcionReservas['tarde'];

            return Inertia::render(
                'Users/Admin/Reservas/ShowReservations',
                ['dia' => $dia, 'maniana' => $reservasManiana, 'tarde' => $reservasTarde, 'editable' => false, 'id_dia' => $id]
            );
        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Función para mostrar la tabla de reservas para su edición    
    public function formAdmin($id)
    {
        try {
            $dia = Dia::where('dias.id', $id)
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->select('dias.id', 'dias.fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                ->first();

            if (!$dia) {
                return redirect(route('admin.indexReservas'))->withErrors('Día de trabajo no encontrado');
            }

            //Reservas del dia seleccionado
            $reservas = Reserva::where('dia_id', $id)
                ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                ->join('users', 'clientes.user_id', '=', 'users.id')
                ->select(
                    'reservas.id',
                    'users.nombre as cliente_nombre',
                    'users.apellidos as cliente_apellidos',
                    'zonas.nombre as zona_nombre',
                    'hora_inicio',
                    'hora_fin'
                )
                ->get();

            $funcionReservas = $this->getReservasDia($reservas);
            $reservasManiana = $funcionReservas['manana'];
            $reservasTarde = $funcionReservas['tarde'];

            return Inertia::render(
                'Users/Admin/Reservas/ShowReservations',
                ['dia' => $dia, 'maniana' => $reservasManiana, 'tarde' => $reservasTarde, 'editable' => true, 'id_dia' => $id]
            );
        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para eliminar la reserva
    public function delAdmin(Request $request)
    {
        try {
            $request->validate(['id_reservation' => 'required|integer|exists:reservas,id']);

            $reserva = Reserva::find($request->id_reservation);

            if ($reserva) {
                $reserva->delete();
                return redirect()->back()->with('msg', 'Reserva eliminada correctamente');
            } else {
                return redirect()->back()->withErrors('No se encontró la reserva');
            }
        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar los horas disponibles para modificar la reserva seleccionada
    public function modAdmin($id_dia, $id_reserva)
    {
        try {
            //Busca el dia seleccionado y si no lo encuentra redirije al index indicando el error
            $dia = Dia::find($id_dia);
            if (!$dia) {
                return redirect(route('admin.indexReservas'))->withErrors('Día de trabajo no encontrado');
            }

            //Busca la reserva seleccionada, en el dia seleccionado y si no la encuentra redirije al index indicando el error
            $reserva = Reserva::where('id', $id_reserva)->where('dia_id', $id_dia)->first();
            if (!$reserva) {
                return redirect(route('admin.indexReservas'))->withErrors('Reserva no encontrada');
            }

            //Obtención de los datos necesarios para mostrar la vista
            $centro = Centro::select('nombre', 'localidad')->where('id', $dia->centro_id)->first();
            $zona = Zona::select('nombre', 'tiempo_estimado')->where('id', $reserva->zona_id)->first();
            $cliente = User::select('users.nombre', 'users.apellidos')
                ->join('clientes', 'users.id', '=', 'clientes.user_id')
                ->where('clientes.id', $reserva->cliente_id)->first();
            $reservas = Reserva::where('dia_id', $dia->id)->where('id', '!=', $reserva->id)->get();
            $horasDisponibles = $this->horasDisponibles($zona, $reservas);

            return Inertia::render('Users/Admin/Reservas/ModReservation', ['centro' => $centro, 'dia' => $dia, 'zona' => $zona, 'reserva' => $reserva, 'cliente' => $cliente, 'horasDisponibles' => $horasDisponibles]);
        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para modificar la reserva
    public function modHourAdmin(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:reservas,id',
                'dia' => 'required|integer|exists:dias,id',
                'startHour' => 'required|date_format:H:i',
            ]);

            $reserva = Reserva::where('id', $request->id)->where('dia_id', $request->dia)->first();

            if (!$reserva) {
                return redirect(route('admin.indexReservas'))->withErrors('No se encontró la reserva');
            }

            $horaFin = $this->setHoraFin($request->startHour, $reserva->zona_id);

            if (!$horaFin) {
                return redirect()->back()->withErrors('Error al implementar la hora final del tratamiento');
            }

            $reserva->update(['hora_inicio' => $request->startHour, 'hora_fin' => $horaFin]);
            return redirect(route('admin.formReservas', [$request->dia]))->with('msg', 'Cita modificada correctamente');

        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar la tabla de reservas pasadas
    public function listPastAdmin(){
        try {
            $dias = Dia::select('dias.id', 'dias.fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->where('fecha', '<', Carbon::now()->startOfDay())
                ->orderBy('fecha')->get();

            return Inertia::render('Users/Admin/Reservas/TablePastDays', ['dias' => $dias]);
        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar la tabla de reservas del día pasado seleccionado
    public function showPastAdmin($id)
    {
        try {
            //Busca el dia seleccionado y si no lo encuentra redirije al index indicando el error
            $dia = Dia::where('dias.id', $id)
                ->where('fecha', '<', Carbon::now()->startOfDay())
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->select('dias.id', 'dias.fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                ->first();

            if (!$dia) {
                return redirect(route('admin.indexReservas'))->withErrors('Día de trabajo no encontrado');
            }

            //Reservas del dia seleccionado
            $reservas = Reserva::where('dia_id', $id)
                ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                ->join('users', 'clientes.user_id', '=', 'users.id')
                ->select(
                    'reservas.id',
                    'users.nombre as cliente_nombre',
                    'users.apellidos as cliente_apellidos',
                    'zonas.nombre as zona_nombre',
                    'hora_inicio',
                    'hora_fin'
                )
                ->get();

            $funcionReservas = $this->getReservasDia($reservas);
            $reservasManiana = $funcionReservas['manana'];
            $reservasTarde = $funcionReservas['tarde'];

            return Inertia::render(
                'Users/Admin/Reservas/ShowReservations',
                ['dia' => $dia, 'maniana' => $reservasManiana, 'tarde' => $reservasTarde, 'editable' => false, 'id_dia' => $id]
            );
        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //-------------------FUNCIONES PARA RESPONSABLES-------------------------


    //Funcion para mostrar el índice de edición de reservas
    public function indexRespon()
    {
        return Inertia::render('Users/Responsable/Reservas/Index');
    }

    //Funcion para mostrar la tabla de selección de días
    public function listRespon()
    {
        try {
            $centro_id = Auth::user()->responsable->centro_id;

            if (!$centro_id) {
                return redirect(route('respon.indexReservas'))->withErrors('Centro no encontrado');
            }

            $dias = Dia::select('dias.id', 'dias.fecha')
                ->where('fecha', '>=', Carbon::now()->startOfDay())
                ->where('centro_id', $centro_id)
                ->orderBy('fecha')->get();

            return Inertia::render('Users/Responsable/Reservas/TableDays', ['dias' => $dias]);
        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar la tabla de reservas del día seleccionado
    public function showRespon($id)
    {
        try {

            $centro_id = Auth::user()->responsable->centro_id;

            if (!$centro_id) {
                return redirect(route('respon.indexReservas'))->withErrors('Centro no encontrado');
            }

            //Busca el dia seleccionado y si no lo encuentra redirije al index indicando el error
            $dia = Dia::where('dias.id', $id)
                ->where('fecha', '>=', Carbon::now()->startOfDay())
                ->where('centro_id', $centro_id)
                ->select('dias.id', 'dias.fecha')
                ->first();

            if (!$dia) {
                return redirect(route('respon.indexReservas'))->withErrors('Día de trabajo no encontrado');
            }

            //Reservas del dia seleccionado
            $reservas = Reserva::where('dia_id', $id)
                ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                ->join('users', 'clientes.user_id', '=', 'users.id')
                ->select(
                    'reservas.id',
                    'users.nombre as cliente_nombre',
                    'users.apellidos as cliente_apellidos',
                    'zonas.nombre as zona_nombre',
                    'hora_inicio',
                    'hora_fin'
                )
                ->get();

            $funcionReservas = $this->getReservasDia($reservas);
            $reservasManiana = $funcionReservas['manana'];
            $reservasTarde = $funcionReservas['tarde'];

            return Inertia::render(
                'Users/Responsable/Reservas/ShowReservations',
                ['dia' => $dia, 'maniana' => $reservasManiana, 'tarde' => $reservasTarde, 'editable' => false, 'id_dia' => $id]
            );
        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Función para mostrar la tabla de reservas para su edición    
    public function formRespon($id)
    {
        try {

            $centro_id = Auth::user()->responsable->centro_id;

            $dia = Dia::where('dias.id', $id)
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->where('centro_id', $centro_id)
                ->select('dias.id', 'dias.fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                ->first();

            if (!$dia) {
                return redirect(route('respon.indexReservas'))->withErrors('Día de trabajo no encontrado');
            }

            //Reservas del dia seleccionado
            $reservas = Reserva::where('dia_id', $id)
                ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                ->join('users', 'clientes.user_id', '=', 'users.id')
                ->select(
                    'reservas.id',
                    'users.nombre as cliente_nombre',
                    'users.apellidos as cliente_apellidos',
                    'zonas.nombre as zona_nombre',
                    'hora_inicio',
                    'hora_fin'
                )
                ->get();

            $funcionReservas = $this->getReservasDia($reservas);
            $reservasManiana = $funcionReservas['manana'];
            $reservasTarde = $funcionReservas['tarde'];

            return Inertia::render(
                'Users/Responsable/Reservas/ShowReservations',
                ['dia' => $dia, 'maniana' => $reservasManiana, 'tarde' => $reservasTarde, 'editable' => true, 'id_dia' => $id]
            );
        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para eliminar la reserva
    public function delRespon(Request $request)
    {
        try {
            $request->validate(['id_reservation' => 'required|integer|exists:reservas,id']);

            $reserva = Reserva::find($request->id_reservation);

            if ($reserva) {
                $reserva->delete();
                return redirect()->back()->with('msg', 'Reserva eliminada correctamente');
            } else {
                return redirect()->back()->withErrors('No se encontró la reserva');
            }
        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar los horas disponibles para modificar la reserva seleccionada
    public function modRespon($id_dia, $id_reserva)
    {
        try {

            $centro_id = Auth::user()->responsable->centro_id;

            //Busca el dia seleccionado y si no lo encuentra redirije al index indicando el error
            $dia = Dia::where()
                ->where('dias.id', $id_dia)
                ->where('centro_id', $centro_id)
                ->first();

            if (!$dia) {
                return redirect(route('respon.indexReservas'))->withErrors('Día de trabajo no encontrado');
            }

            //Busca la reserva seleccionada, en el dia seleccionado y si no la encuentra redirije al index indicando el error
            $reserva = Reserva::where('id', $id_reserva)->where('dia_id', $id_dia)->first();
            if (!$reserva) {
                return redirect(route('respon.indexReservas'))->withErrors('Reserva no encontrada');
            }

            //Obtención de los datos necesarios para mostrar la vista
            $centro = Centro::select('nombre', 'localidad')->where('id', $dia->centro_id)->first();
            $zona = Zona::select('nombre', 'tiempo_estimado')->where('id', $reserva->zona_id)->first();
            $cliente = User::select('users.nombre', 'users.apellidos')
                ->join('clientes', 'users.id', '=', 'clientes.user_id')
                ->where('clientes.id', $reserva->cliente_id)->first();
            $reservas = Reserva::where('dia_id', $dia->id)->where('id', '!=', $reserva->id)->get();
            $horasDisponibles = $this->horasDisponibles($zona, $reservas);

            return Inertia::render('Users/Responsable/Reservas/ModReservation', ['centro' => $centro, 'dia' => $dia, 'zona' => $zona, 'reserva' => $reserva, 'cliente' => $cliente, 'horasDisponibles' => $horasDisponibles]);
        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para modificar la reserva
    public function modHourRespon(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:reservas,id',
                'dia' => 'required|integer|exists:dias,id',
                'startHour' => 'required|date_format:H:i',
            ]);

            $reserva = Reserva::where('id', $request->id)->where('dia_id', $request->dia)->first();

            if (!$reserva) {
                return redirect(route('respon.indexReservas'))->withErrors('No se encontró la reserva');
            }

            $horaFin = $this->setHoraFin($request->startHour, $reserva->zona_id);

            if (!$horaFin) {
                return redirect()->back()->withErrors('Error al implementar la hora final del tratamiento');
            }

            $reserva->update(['hora_inicio' => $request->startHour, 'hora_fin' => $horaFin]);
            return redirect(route('respon.formReservas', [$request->dia]))->with('msg', 'Cita modificada correctamente');

        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar la tabla de reservas pasadas
    public function listPastRespon(){
        try {

            $centro_id = Auth::user()->responsable->centro_id;

            $dias = Dia::select('dias.id', 'dias.fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->where('fecha', '<', Carbon::now()->startOfDay())
                ->where('centro_id', $centro_id)
                ->orderBy('fecha')->get();

            return Inertia::render('Users/Responsable/Reservas/TablePastDays', ['dias' => $dias]);
        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar la tabla de reservas del día pasado seleccionado
    public function showPastRespon($id)
    {
        try {
            //Busca el dia seleccionado y si no lo encuentra redirije al index indicando el error
            $dia = Dia::where('dias.id', $id)
                ->where('fecha', '<', Carbon::now()->startOfDay())
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->select('dias.id', 'dias.fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                ->first();

            if (!$dia) {
                return redirect(route('respon.indexReservas'))->withErrors('Día de trabajo no encontrado');
            }

            //Reservas del dia seleccionado
            $reservas = Reserva::where('dia_id', $id)
                ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                ->join('users', 'clientes.user_id', '=', 'users.id')
                ->select(
                    'reservas.id',
                    'users.nombre as cliente_nombre',
                    'users.apellidos as cliente_apellidos',
                    'zonas.nombre as zona_nombre',
                    'hora_inicio',
                    'hora_fin'
                )
                ->get();

            $funcionReservas = $this->getReservasDia($reservas);
            $reservasManiana = $funcionReservas['manana'];
            $reservasTarde = $funcionReservas['tarde'];

            return Inertia::render(
                'Users/Responsable/Reservas/ShowReservations',
                ['dia' => $dia, 'maniana' => $reservasManiana, 'tarde' => $reservasTarde, 'editable' => false, 'id_dia' => $id]
            );
        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }


    //-------------------FUNCIONES PARA CLIENTES---------------------

    //Funcion para mostrar la vista de reservas
    public function indexCliente()
    {
        return Inertia::render('Users/Client/Reservas/Index');
    }

    //Funcion para mostrar el formulario de creacion de reserva
    public function createCliente()
    {
        try {

            //Centros disponibles
            $centros = Centro::select('id', 'nombre', 'localidad')->where('active', 1)->get();

            //Fechas de dias disponibles que aún no han pasado
            $hoy = Carbon::now()->startOfDay()->format('Y-m-d');
            $dias = Dia::select('id', 'fecha', 'centro_id')
                ->where('fecha', '>', $hoy)
                ->get();

            //Zonas de tratamiento
            $zonas = Zona::select('id', 'nombre', 'precio')->where('active', 1)->get();

            return Inertia::render('Users/Client/Reservas/FormReservation', ['centros' => $centros, 'fechas' => $dias, 'zonas' => $zonas]);
        } catch (Exception $er) {
            return redirect(route('client.indexCitas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar el formulario de creacion de reserva con la hora seleccionada
    public function createHoraCliente(Request $request)
    {
        try {
            $request->validate([
                'center' => 'required|integer|exists:centros,id',
                'date' => 'required|integer|exists:dias,id',
                'zone' => 'required|integer|exists:zonas,id',
            ]);

            //Id del cliente autenticado
            $cliente = Cliente::where('user_id', Auth::id())->first();

            //Instancias de los objetos seleccionados
            $centro = Centro::select('nombre', 'localidad')->where('id', $request->center)->first();
            $dia = Dia::find($request->date);
            $zona = Zona::find($request->zone);

            //Reservas del dia seleccionado
            $reservas = Reserva::where('dia_id', $dia->id)->get();

            //Comprobación de si el cliente ha superado el máximo de citas permitidas
            if ($this->maximoCitas($cliente->id, $reservas)) {
                return redirect()->back()->withErrors('Lo sentimos, ya has reservado el máximo de citas para este día');
            }

            $horasDisponibles = [];

            if (!$reservas->isEmpty()) {
                $horasDisponibles = $this->horasDisponibles($zona, $reservas);

                //En caso de no haber reservas previas, muestra todas las horas disponibles, evitando el proceso anterior
            } else {
                $horasDisponibles = $this->rangoHorasTrabajo($zona->tiempo_estimado);
            }

            return Inertia::render('Users/Client/Reservas/FormHourReservation', ['centro' => $centro, 'dia' => $dia, 'zona' => $zona, 'horasTrabajo' => $horasDisponibles]);
        } catch (Exception $er) {
            return redirect(route('client.indexCitas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //Funcion para almacenar la reserva
    public function storeCliente(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|integer|exists:dias,id',
                'zone' => 'required|integer|exists:zonas,id',
                'startHour' => 'required|date_format:H:i'
            ]);



            $cliente_id = Cliente::select('id')->where('user_id', Auth::id())->first();
            if (!$cliente_id) {
                return redirect(route('client.indexCitas'))->withErrors('Cliente no encontrado');
            }

            $horaFin = $this->setHoraFin($request->startHour, $request->zone);
            if (!$horaFin) {
                return redirect(route('client.indexCitas'))->withErrors('Error al asignar hora final');
            }

            $reserva = new Reserva();
            $reserva->cliente_id = $cliente_id->id;
            $reserva->zona_id = $request->zone;
            $reserva->dia_id = $request->date;
            $reserva->hora_inicio = $request->startHour;
            $reserva->hora_fin = $horaFin;


            $reserva->save();
            return redirect(route('client.indexCitas'))->with('msg', 'Cita reservada correctamente');
        } catch (Exception $er) {
            return redirect(route('client.indexCitas'))->withErrors('No se pudo completar la reserva, error: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar la tabla de reservas del cliente
    public function listCliente()
    {
        try {
            $cliente_id = Cliente::select('id')->where('user_id', Auth::id())->first();

            if (!$cliente_id) {
                return redirect()->back()->withErrors('Cliente no encontrado.');
            }


            $citas = Reserva::where('cliente_id', $cliente_id->id)
                ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                ->join('dias', 'reservas.dia_id', '=', 'dias.id')
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->select(
                    'reservas.id',
                    'zona_id',
                    'zonas.nombre as zona_nombre',
                    'centro_id',
                    'centros.nombre as centro_nombre',
                    'centros.localidad as centro_localidad',
                    'dias.fecha as fecha',
                    'hora_inicio',
                    'hora_fin'
                )
                ->where('dias.fecha', '>', Carbon::today())
                ->get();


            return Inertia::render('Users/Client/Reservas/TableReservation', ['citas' => $citas]);
        } catch (Exception $er) {
            return redirect(route('client.indexCitas'))->withErrors('Error: ' . $er->getMessage());
        }
    }

    //Funcion para mostrar el formulario de modificacion de la reserva
    public function modCliente($id)
    {
        try {
            $cliente = Cliente::select('id')->where('user_id', Auth::id())->first();

            if (!$cliente) {
                return redirect()->back()->withErrors('Cliente no encontrado.');
            }

            $reservaSeleccionada = Reserva::where('id', $id)
                ->where('cliente_id', $cliente->id)
                ->first();

            if (!$reservaSeleccionada) {
                return redirect()->back()->withErrors('No se encuentra la cita indicada');
            }

            $datos = Reserva::where('reservas.id', $reservaSeleccionada->id)
                ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                ->join('dias', 'reservas.dia_id', '=', 'dias.id')
                ->join('centros', 'dias.centro_id', '=', 'centros.id')
                ->select(
                    'reservas.id',
                    'zonas.nombre as zona_nombre',
                    'zonas.tiempo_estimado',
                    'centros.nombre as centro_nombre',
                    'centros.localidad as centro_localidad',
                    'dias.fecha as fecha',
                    'hora_inicio',
                    'hora_fin'
                )
                ->first();

            if (!$datos) {
                return redirect()->back()->withErrors('Datos de la reserva no encontrados');
            }

            $zona = Zona::find($reservaSeleccionada->zona_id);

            if (!$zona) {
                return redirect()->back()->withErrors('Zona no encontrada para la reserva');
            }

            $reservas = Reserva::select('hora_inicio', 'hora_fin')
                ->where('dia_id', $reservaSeleccionada->dia_id)
                ->where('id', '!=', $reservaSeleccionada->id)
                ->get();

            $horasDisponibles = $reservas->isEmpty()
                ? $this->rangoHorasTrabajo($zona->tiempo_estimado)
                : $this->horasDisponibles($zona, $reservas);

            return Inertia::render('Users/Client/Reservas/ModFormReservation', [
                'cita' => $datos,
                'horasDisponibles' => $horasDisponibles
            ]);
        } catch (Exception $e) {
            return redirect(route('client.indexCitas'))->withErrors('Error: ' . $e->getMessage());
        }
    }

    //Funcion para modificar la reserva
    public function modHoraCliente(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:reservas,id',
                'startHour' => 'required|date_format:H:i',
            ]);

            $reserva = Reserva::find($request->id);

            if ($reserva) {

                $horaFin = $this->setHoraFin($request->startHour, $reserva->zona_id);

                if ($horaFin) {
                    $reserva->update(['hora_inicio' => $request->startHour, 'hora_fin' => $horaFin]);
                    return redirect(route('client.tableCitas'))->with('msg', 'Cita modificada correctamente');
                } else {
                    return redirect()->back()->withErrors('Error al implementar la hora final del tratamiento');
                }
            } else {
                return redirect(route('client.indexCitas'))->withErrors('No se encontró la reserva');
            }
        } catch (Exception $er) {
            return redirect(route('client.indexCitas'))->withErrors('No se pudo completar la reserva, error: ' . $er->getMessage());
        }
    }

    //Funcion para eliminar la reserva
    public function deleteCliente(Request $request)
    {
        try {
            $request->validate(['id' => 'required|integer|exists:reservas,id']);

            $clienteId = Cliente::where('user_id', Auth::id())->value('id');

            if (!$clienteId) {
                return redirect(route('client.indexCitas'))->withErrors('No existe el cliente autenticado');
            }

            $reservaSeleccionada = Reserva::where('id', $request->id)->where('cliente_id', $clienteId)->first();

            if ($reservaSeleccionada) {
                $reservaSeleccionada->delete();
                return redirect()->back()->with('msg', 'Cita eliminada correctamente');
            } else {
                return redirect(route('client.tableCitas'))->withErrors('No existe la cita indicada');
            }
        } catch (Exception $er) {
            return redirect(route('client.indexCitas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    //----------------FUNCIONES PRIVADAS-------------------

    //Funcion privada para la obtención del rango de horas de trabajo, se tiene el cuenta el tiempo estimado para los descansos
    private function rangoHorasTrabajo($tiempo_estimado)
    {
        $intervaloTratamiento = CarbonInterval::createFromFormat('H:i:s', $tiempo_estimado);
        $horaInicio = Carbon::createFromTimeString(self::COMIENZO_JORNADA);
        $horaDescansoInicio = Carbon::createFromTimeString(self::INICIO_DESCANSO)->sub($intervaloTratamiento);
        $horaDescansoFin = Carbon::createFromTimeString(self::FIN_DESCANSO);
        $horaFin = Carbon::createFromTimeString(self::FIN_JORNADA);

        $rangoHorasTrabajo = [];
        $horaActual = $horaInicio->copy();

        while ($horaActual->lessThanOrEqualTo($horaFin)) {
            $horaFinTratamiento = $horaActual->copy()->add($intervaloTratamiento);

            if (
                !$horaActual->betweenExcluded($horaDescansoInicio, $horaDescansoFin) &&
                $horaFinTratamiento->lessThanOrEqualTo($horaFin)
            ) {
                $rangoHorasTrabajo[] = $horaActual->format('H:i');
            }

            $horaActual->addMinutes(15);
        }

        return $rangoHorasTrabajo;
    }

    //Funcion privada para la obtencion de las horas disponibles
    private function horasDisponibles($zona, $reservas)
    {
        $horasDisponibles = [];

        //Rango de horas de trabajo
        $horasTrabajo = $this->rangoHorasTrabajo($zona->tiempo_estimado);
        //Objeto con el intervalo del tiempo estimado en realizar el tratamiento
        $intervaloTratamiento = CarbonInterval::createFromFormat('H:i:s', $zona->tiempo_estimado);

        foreach ($horasTrabajo as $hora) {
            $horaObj = Carbon::createFromTimeString($hora);

            // Verifica si la hora está ocupada en alguna reserva
            $estaOcupada = $reservas->some(function ($reserva) use ($horaObj, $intervaloTratamiento) {
                $inicioReservaObj = Carbon::createFromTimeString($reserva->hora_inicio);
                $finReservaObj = Carbon::createFromTimeString($reserva->hora_fin);
                //Obtencion de la hora SUBSTRAYENDO el tiempo estimado, para evitar solapamiento de citas
                $inicioTiempoRestado = $inicioReservaObj->copy()->sub($intervaloTratamiento);

                return $horaObj->betweenExcluded($inicioTiempoRestado, $finReservaObj);
            });

            // Si no está ocupada, agregar a las horas disponibles
            if (!$estaOcupada) {
                $horasDisponibles[] = $horaObj->format('H:i');
            }
        }

        return $horasDisponibles;
    }

    //Función privada para obtener la información de todas las reservas, divididas en 2 arrays, mañana y tarde
    private function getReservasDia($reservas)
    {
        $horaDescansoInicio = Carbon::createFromTimeString(self::INICIO_DESCANSO);
        $horaDescansoFin = Carbon::createFromTimeString(self::FIN_DESCANSO);
        $horasTrabajo = $this->rangoHorasTrabajo('00:00:00'); //Se pasa por parametro un tiempo a 0 para obtener todas las horas de trabajo
        $arrayManana = [];
        $arrayTarde = [];

        foreach ($horasTrabajo as $hora) {
            $horaObj = Carbon::createFromTimeString($hora);

            // Verifica si la hora está ocupada en alguna reserva y retorna el objeto reserva si lo está
            $estaOcupada = $reservas->first(function ($reserva) use ($horaObj) {
                $inicioReservaObj = Carbon::createFromTimeString($reserva->hora_inicio);
                $finReservaObj = Carbon::createFromTimeString($reserva->hora_fin);

                return $horaObj->greaterThanOrEqualTo($inicioReservaObj) && $horaObj->lessThan($finReservaObj);
            });

            // Si no está ocupada, agregar a las horas disponibles en el array correspondiente
            if (!$estaOcupada && $horaObj->lessThanOrEqualTo($horaDescansoInicio)) {
                $arrayManana[] = $horaObj->format('H:i');
            } else if (!$estaOcupada && $horaObj->greaterThanOrEqualTo($horaDescansoFin)) {
                $arrayTarde[] = $horaObj->format('H:i');
            } else {
                // Si la reserva esta ocupada, añade al array correspondiente comprobando si se encuentra en este
                $horaFinReserva = Carbon::createFromTimeString($estaOcupada->hora_fin);
                if ($horaFinReserva->lessThanOrEqualTo($horaDescansoInicio) && !in_array($estaOcupada, $arrayManana)) {
                    $arrayManana[] = $estaOcupada;
                } else if ($horaFinReserva->greaterThanOrEqualTo($horaDescansoFin) && !in_array($estaOcupada, $arrayTarde)) {
                    $arrayTarde[] = $estaOcupada;
                }
            }
        }


        return ['manana' => $arrayManana, 'tarde' => $arrayTarde];
    }

    //Funcion privada para asignar la hora final del tratamiento
    private function setHoraFin($horaInicio, $idZona)
    {

        $horaInicioObj = Carbon::createFromTimeString($horaInicio);

        $zona = Zona::find($idZona);

        if ($zona) {
            $tiempoEstimado = CarbonInterval::createFromFormat('H:i:s', $zona->tiempo_estimado);
            return $horaInicioObj->copy()->add($tiempoEstimado)->format('H:i');
        } else {
            return false;
        }
    }

    //Funcion para comprobar si el usuario autenticado ha superado la cantidad de reservas permitidas
    private function maximoCitas($clienteId, $reservas)
    {
        $cantReservas = 0;

        foreach ($reservas as $reserva) {
            if ($reserva->cliente_id == $clienteId) {
                $cantReservas++;
            }
        }

        return $cantReservas >= self::MAX_CITAS_DIA;
    }
}
