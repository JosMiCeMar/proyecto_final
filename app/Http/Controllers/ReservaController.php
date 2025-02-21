<?php

namespace App\Http\Controllers;

use App\Models\Administradore;
use App\Models\Centro;
use App\Models\Cliente;
use App\Models\Dia;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Zona;
use Carbon\CarbonInterval;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controlador de las reservas
 */
class ReservaController extends Controller
{
    //Constantes de la clase
    private const COMIENZO_JORNADA = "9:00";
    private const INICIO_DESCANSO = "14:00";
    private const FIN_DESCANSO = "16:00";
    private const FIN_JORNADA = "19:00";
    private const MAX_CITAS_DIA = 3;

    //-------------------FUNCIONES PARA ADMINISTRADOR-------------------------

    /**
     * Vista de las reservas para el administrador
     * @return Response 
    */
    public function indexAdmin(): Response
    {
        return Inertia::render('Users/Admin/Reservas/Index');
    }

    /**
     * Vista de la tabla de días de trabajo del administrador
     * @return Response|RedirectResponse 
     */
    public function listAdmin(): Response|RedirectResponse
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

    /**
     * Función para mostrar la tabla de reservas del día seleccionado del administrador
     * @param int $id Identificador del día
     * @return Response|RedirectResponse
     */
    public function showAdmin($id): Response|RedirectResponse
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
                    'users.telefono as cliente_telefono',
                    'clientes.condicion_especial',
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

    /**
     * Función para mostrar el formulario de edición de reservas del administrador
     * @param int $id Identificador del día
     * @return Response|RedirectResponse
     */   
    public function formAdmin($id): Response|RedirectResponse
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
                    'users.telefono as cliente_telefono',
                    'zonas.nombre as zona_nombre',
                    'clientes.condicion_especial',
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

    /**
     * Función para eliminar la reserva del administrador
     * @param Request $request Datos del formulario
     * @return RedirectResponse
     */
    public function delAdmin(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'id_reservation' => 'required|integer|exists:reservas,id',
                'notification' => 'required|boolean'
            ]);

            $reserva = Reserva::find($request->id_reservation);

            if ($reserva) {
                if ($request->notification) {
                    $datos = Reserva::where('reservas.id', $request->id_reservation)
                        ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                        ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                        ->join('users', 'clientes.user_id', '=', 'users.id')
                        ->join('dias', 'reservas.dia_id', '=', 'dias.id')
                        ->join('centros', 'dias.centro_id', '=', 'centros.id')
                        ->select('reservas.id', 'users.id as usuario_id', 'zonas.nombre as zona_nombre', 'dias.fecha as dia_fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                        ->first();

                    $fechaFormateada = Carbon::parse($datos->dia_fecha)->format('d/m/Y');

                    $mensaje = 'Se ha eliminado tu reserva de ' . $datos->zona_nombre . ' para el día ' . $fechaFormateada . ' en el centro ' . $datos->centro_nombre . ' (' . $datos->centro_localidad . ')';

                    NotificacioneController::enviarNotificacion($datos->usuario_id, $mensaje);
                }
                $reserva->delete();
                return redirect()->back()->with('msg', 'Reserva eliminada correctamente');
            } else {
                return redirect()->back()->withErrors('No se encontró la reserva');
            }
        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Función para mostrar los horas disponibles para modificar la reserva seleccionada del administrador
     * @param int $id_dia Identificador del día
     * @param int $id_reserva Identificador de la reserva
     * @return Response|RedirectResponse
     */
    public function modAdmin($id_dia, $id_reserva): Response|RedirectResponse
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

    /** 
     * Función para modificar la hora de una reserva seleccionada del administrador
     * @param Request $request Datos del formulario
     * @return RedirectResponse 
     */
    public function modHourAdmin(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:reservas,id',
                'dia' => 'required|integer|exists:dias,id',
                'startHour' => 'required|date_format:H:i',
                'notification' => 'required|boolean'
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

            if ($request->notification) {
                $datos = Reserva::where('reservas.id', $request->id)
                    ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                    ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                    ->join('users', 'clientes.user_id', '=', 'users.id')
                    ->join('dias', 'reservas.dia_id', '=', 'dias.id')
                    ->join('centros', 'dias.centro_id', '=', 'centros.id')
                    ->select('reservas.id', 'users.id as usuario_id', 'zonas.nombre as zona_nombre', 'dias.fecha as dia_fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                    ->first();

                $fechaFormateada = Carbon::parse($datos->dia_fecha)->format('d/m/Y');

                $mensaje = 'Su reserva de ' . $datos->zona_nombre . ' para el día ' . $fechaFormateada . ' en ' . $datos->centro_nombre . ' (' . $datos->centro_localidad . ') ha sido modificada para las ' . $request->startHour;

                NotificacioneController::enviarNotificacion($datos->usuario_id, $mensaje);
            }


            return redirect(route('admin.formReservas', [$request->dia]))->with('msg', 'Cita modificada correctamente');
        } catch (Exception $er) {
            return redirect(route('admin.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Función para mostrar la tabla de días pasados del administrador
     * @return Response|RedirectResponse 
     */
    public function listPastAdmin(): Response|RedirectResponse
    {
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

    /**
     * Función para mostrar la tabla de reservas del día seleccionado del administrador
     * @param int $id Identificador del día
     * @return Response|RedirectResponse
     */
    public function showPastAdmin($id): Response|RedirectResponse
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
                    'users.telefono as cliente_telefono',
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


    /**
     * Vista del index de reservas para el responsable
     * @return Response
     */
    public function indexRespon(): Response
    {
        return Inertia::render('Users/Responsable/Reservas/Index');
    }

    /**
     * Función para mostrar la tabla de días de trabajo del responsable
     * @return Response|RedirectResponse
     */
    public function listRespon(): Response|RedirectResponse
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

    /**
     *  Función para mostrar la tabla de reservas del día seleccionado del responsable
     * @param int $id Identificador del día
     * @return Response|RedirectResponse
     */
    public function showRespon($id): Response|RedirectResponse
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
                    'users.telefono as cliente_telefono',
                    'zonas.nombre as zona_nombre',
                    'clientes.condicion_especial',
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

    /**
     * Función para mostrar el formulario de edición de reservas del responsable
     * @param int $id Identificador del día
     * @return Response|RedirectResponse
     */   
    public function formRespon($id): Response|RedirectResponse
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
                    'users.telefono as cliente_telefono',
                    'zonas.nombre as zona_nombre',
                    'clientes.condicion_especial',
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

    /**
     * Función para eliminar la reserva del responsable
     * @param Request $request Datos del formulario
     * @return RedirectResponse
     */
    public function delRespon(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'id_reservation' => 'required|integer|exists:reservas,id',
                'notification' => 'required|boolean'
            ]);

            $reserva = Reserva::find($request->id_reservation);

            if ($reserva) {
                if ($request->notification) {

                    $datos = Reserva::where('reservas.id', $request->id_reservation)
                        ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                        ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                        ->join('users', 'clientes.user_id', '=', 'users.id')
                        ->join('dias', 'reservas.dia_id', '=', 'dias.id')
                        ->join('centros', 'dias.centro_id', '=', 'centros.id')
                        ->select('reservas.id', 'users.id as usuario_id', 'zonas.nombre as zona_nombre', 'dias.fecha as dia_fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                        ->first();

                    $fechaFormateada = Carbon::parse($datos->dia_fecha)->format('d/m/Y');

                    $mensaje = 'Se ha eliminado tu reserva de ' . $datos->zona_nombre . ' para el día ' . $fechaFormateada . ' en el centro ' . $datos->centro_nombre . ' (' . $datos->centro_localidad . ')';

                    NotificacioneController::enviarNotificacion($datos->usuario_id, $mensaje);

                    $admin = Administradore::first()->select('user_id')->first();

                    $mensajeAdmin = 'El responsable ha eliminado una reserva para el día ' . $fechaFormateada . ' en el centro ' . $datos->centro_nombre . ' (' . $datos->centro_localidad . ')';

                    NotificacioneController::enviarNotificacion($admin->user_id, $mensajeAdmin);
                }
                $reserva->delete();
                return redirect()->back()->with('msg', 'Reserva eliminada correctamente');
            } else {
                return redirect()->back()->withErrors('No se encontró la reserva');
            }
        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Función para mostrar los horas disponibles para modificar la reserva seleccionada del responsable
     * @param int $id_dia Identificador del día
     * @param int $id_reserva Identificador de la reserva
     * @return Response|RedirectResponse
     */
    public function modRespon($id_dia, $id_reserva): Response|RedirectResponse
    {
        try {

            $centro_id = Auth::user()->responsable->centro_id;

            //Busca el dia seleccionado y si no lo encuentra redirije al index indicando el error
            $dia = Dia::where('dias.id', $id_dia)
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

    /**
     * Función para modificar la hora de una reserva seleccionada del responsable
     * @param Request $request Datos del formulario
     * @return RedirectResponse
     */
    public function modHourRespon(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:reservas,id',
                'dia' => 'required|integer|exists:dias,id',
                'startHour' => 'required|date_format:H:i',
                'notification' => 'required|boolean'
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

            if ($request->notification) {
                $datos = Reserva::where('reservas.id', $request->id)
                    ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
                    ->join('clientes', 'reservas.cliente_id', '=', 'clientes.id')
                    ->join('users', 'clientes.user_id', '=', 'users.id')
                    ->join('dias', 'reservas.dia_id', '=', 'dias.id')
                    ->join('centros', 'dias.centro_id', '=', 'centros.id')
                    ->select('reservas.id', 'users.id as usuario_id', 'zonas.nombre as zona_nombre', 'dias.fecha as dia_fecha', 'centros.nombre as centro_nombre', 'centros.localidad as centro_localidad')
                    ->first();

                $fechaFormateada = Carbon::parse($datos->dia_fecha)->format('d/m/Y');

                $mensaje = 'Su reserva de ' . $datos->zona_nombre . ' para el día ' . $fechaFormateada . ' en ' . $datos->centro_nombre . ' (' . $datos->centro_localidad . ') ha sido modificada para las ' . $request->startHour;

                NotificacioneController::enviarNotificacion($datos->usuario_id, $mensaje);

                $admin = Administradore::first()->select('user_id')->first();

                $mensajeAdmin = 'El responsable ha modificado una reserva para el día ' . $fechaFormateada . ' en el centro ' . $datos->centro_nombre . ' (' . $datos->centro_localidad . ')';

                NotificacioneController::enviarNotificacion($admin->user_id, $mensajeAdmin);
            }

            return redirect(route('respon.formReservas', [$request->dia]))->with('msg', 'Cita modificada correctamente');
        } catch (Exception $er) {
            return redirect(route('respon.indexReservas'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Función para mostrar la tabla de días pasados del responsable
     * @return Response|RedirectResponse
     */
    public function listPastRespon(): Response|RedirectResponse
    {
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

    /**
     * Función para mostrar la tabla de reservas del día seleccionado del responsable
     * @param int $id Identificador del día
     * @return Response|RedirectResponse
     */
    public function showPastRespon($id): Response|RedirectResponse
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
                    'users.telefono as cliente_telefono',
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

    /**
     * Vista del index de reservas para el cliente
     * @return Response
     */
    public function indexCliente(): Response
    {
        return Inertia::render('Users/Client/Reservas/Index');
    }

    /**
     * Función para mostrar el formulario de creación de reserva para el cliente
     * @return Response|RedirectResponse
     */
    public function createCliente(): Response|RedirectResponse
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

    /**
     * Función para mostrar el formulario de seleccion de hora de reserva para el cliente
     * @param Request $request Datos del formulario
     * @return Response|RedirectResponse
     */
    public function createHoraCliente(Request $request): Response|RedirectResponse
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

    /**
     * Función para almacenar la reserva del cliente
     * @param Request $request Datos del formulario
     * @return RedirectResponse
     */
    public function storeCliente(Request $request): RedirectResponse
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

    /**
     * Función para mostrar la tabla de reservas del cliente
     * @return Response|RedirectResponse
     */
    public function listCliente(): Response|RedirectResponse
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

    /**
     * Función para mostrar el formulario de modificación de la reserva del cliente
     * @param int $id Identificador de la reserva
     * @return Response|RedirectResponse
     */
    public function modCliente($id): Response|RedirectResponse
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

    /**
     * Función para modificar la hora de la reserva del cliente
     * @param Request $request Datos del formulario
     * @return RedirectResponse
     */
    public function modHoraCliente(Request $request): RedirectResponse
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

    /**
     * Función para eliminar la reserva del cliente
     * @param Request $request Datos del formulario
     * @return RedirectResponse
     */
    public function deleteCliente(Request $request): RedirectResponse
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

    /**
     * Funcion privada para la obtención del rango de horas de trabajo, se tiene el cuenta el tiempo estimado para los descansos
     * @param string $tiempo_estimado Tiempo estimado para el tratamiento
     * @return array 
     */
    private function rangoHorasTrabajo($tiempo_estimado): array
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

    /**
     * Función privada para obtener las horas disponibles para la reserva
     * @param Zona $zona Zona de tratamiento
     * @param Collection $reservas Reservas del día
     * @return array
     */
    private function horasDisponibles($zona, $reservas): array
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

    /**
     * Función privada para obtener la información de todas las reservas, divididas en 2 arrays, mañana y tarde
     * @param Collection $reservas Reservas del día
     * @return array
     */
    private function getReservasDia($reservas): array
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

    /**
     * Función privada para obtener la hora de fin de la reserva
     * @param string $horaInicio Hora de inicio de la reserva
     * @param int $idZona Identificador de la zona
     * @return string|bool
     */
    private function setHoraFin($horaInicio, $idZona): string|bool
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

    /**
     * Función privada para comprobar si el cliente ha superado el máximo de citas permitidas
     * @param int $clienteId Identificador del cliente
     * @param Collection $reservas Reservas del día
     * @return bool
     */
    private function maximoCitas($clienteId, $reservas): bool
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
