<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use App\Models\Cliente;
use App\Models\Dia;
use App\Models\Reserva;
use App\Models\Zona;
use Carbon\CarbonInterval;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class ReservaController extends Controller
{


    //-------------------FUNCIONES PARA CLIENTES---------------------
    public function indexReservaCliente()
    {
        return Inertia::render('Users/Client/Citas/Index');
    }

    public function createReservaCliente()
    {
        //Centros disponibles
        $centros = Centro::select('id', 'nombre', 'localidad')->where('active', 1)->get();

        //Fechas de dias disponibles que aún no han pasado
        $hoy = Carbon::now()->startOfDay()->format('Y-m-d');
        $dias = Dia::select('id', 'fecha', 'centro_id')
            ->where('fecha', '>', $hoy)
            ->get();

        //Zonas de tratamiento
        $zonas = Zona::select('id', 'nombre', 'precio')->where('active', 1)->get();

        return Inertia::render('Users/Client/Citas/FormCitation', ['centros' => $centros, 'fechas' => $dias, 'zonas' => $zonas]);
    }

    public function createHoraReservaCliente(Request $request)
    {

        $request->validate([
            'center' => 'required|integer|exists:centros,id',
            'date' => 'required|integer|exists:dias,id',
            'zone' => 'required|integer|exists:zonas,id',
        ]);

        //Instancias de los objetos seleccionados
        $centro = Centro::select('nombre', 'localidad')->where('id', $request->center)->first();
        $dia = Dia::find($request->date);
        $zona = Zona::find($request->zone);

        //Reservas del dia seleccionado
        $reservas = Reserva::select('hora_inicio', 'hora_fin')->where('dia_id', $dia->id)->get();

        $horasDisponibles = [];

        if (!$reservas->isEmpty()) {
            //Rango de horas de trabajo
            $horasTrabajo = $this->rangoHorasTrabajo();
            //Objeto con el intervalo del tiempo estimado en realizar el tratamiento
            $intervaloTratamiento = CarbonInterval::createFromFormat('H:i:s', $zona->tiempo_estimado);

            foreach ($horasTrabajo as $hora) {
                $horaObj = Carbon::createFromTimeString($hora);

                // Verificar si la hora está ocupada en alguna reserva
                $estaOcupada = $reservas->some(function ($reserva) use ($horaObj, $intervaloTratamiento) {
                    $inicioReservaObj = Carbon::createFromTimeString($reserva->hora_inicio);
                    $finReservaObj = Carbon::createFromTimeString($reserva->hora_fin);
                    //Obtencion de la hora SUBSTRAYENDO el tiempo estima del trabajo, para evitar solapamiento de citas
                    $inicioTiempoRestado = $inicioReservaObj->copy()->sub($intervaloTratamiento);

                    return $horaObj->betweenExcluded($inicioTiempoRestado, $finReservaObj);
                });

                // Si no está ocupada, agregar a las horas disponibles
                if (!$estaOcupada) {
                    $horasDisponibles[] = $horaObj->format('H:i');
                }
            }
        } else {
            $horasDisponibles = $this->rangoHorasTrabajo();
        }

        return Inertia::render('Users/Client/Citas/FormHourCitation', ['centro' => $centro, 'dia' => $dia, 'zona' => $zona, 'horasTrabajo' => $horasDisponibles]);
    }

    public function storeReservaCliente(Request $request)
    {
        $request->validate([
            'date' => 'required|integer|exists:dias,id',
            'zone' => 'required|integer|exists:zonas,id',
            'startHour' => 'required|date_format:H:i',
            'endHour' => 'required|date_format:H:i'
        ]);

        $cliente_id = Cliente::select('id')->where('user_id', Auth::id())->first();

        $reserva = new Reserva();
        $reserva->cliente_id = $cliente_id->id;
        $reserva->zona_id = $request->zone;
        $reserva->dia_id = $request->date;
        $reserva->hora_inicio = $request->startHour;
        $reserva->hora_fin = $request->endHour;

        try {
            $reserva->save();
            return redirect(route('client.indexCitas'))->with('msg', 'Cita reservada correctamente');
        } catch (Exception $er) {
            return redirect(route('client.indexCitas'))->withErrors('No se pudo completar la reserva, error: ' . $er->getMessage());
        }
    }

    public function listCliente()
    {

        $cliente_id = Cliente::select('id')->where('user_id', Auth::id())->first();

        $citas = Reserva::where('cliente_id', $cliente_id->id)
            ->join('zonas', 'reservas.zona_id', '=', 'zonas.id')
            ->join('dias', 'reservas.dia_id', '=', 'dias.id')
            ->join('centros', 'dias.centro_id', '=', 'centros.id')
            ->select(
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

        return Inertia::render('Users/Client/Citas/TableCitation', ['citas' => $citas]);
    }

    //Funcion privada para la obtención del rango de horas de trabajo
    private function rangoHorasTrabajo()
    {
        $horaInicio = Carbon::createFromTimeString('9:00');
        $horaDescanso = Carbon::createFromTimeString('13:30');
        $horaFinDescanso = $horaDescanso->copy()->addHours(2);
        $horaFin = Carbon::createFromTimeString('19:30');

        $rangoHorasTrabajo[] = $horaInicio->format('H:i');

        while ($horaInicio < $horaFin) {
            $horaInicio->addMinutes(15);

            if (!$horaInicio->betweenExcluded($horaDescanso, $horaFinDescanso)) {
                $rangoHorasTrabajo[] = $horaInicio->format('H:i');
            }
        }

        return $rangoHorasTrabajo;
    }
}
