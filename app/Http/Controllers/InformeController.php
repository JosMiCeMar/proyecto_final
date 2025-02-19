<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Centro;
use App\Models\Dia;
use App\Models\Reserva;
use App\Models\Responsable;
use App\Models\Zona;
use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

/**
 * Controlador de los informes
 */
class InformeController extends Controller
{
    // Fecha mínima para la generación de informes
    private const FECHA_MINIMA_INFORME = "2015-1-1";


    //---------CONTROLADORES ADMINISTRADOR------------
   
    /**
     * Vista del index de informes para el administrador
     * @return Response
     */
    public function adminIndexInforme(): Response
    {
        return Inertia::render('Users/Admin/Informes/Index');
    }

    /**
     * Vista del informe del último mes para el administrador
     * @return Response|RedirectResponse
     */
    public function adminInformeUltimoMes(): Response|RedirectResponse
    {
        try {
            // Obtener la fecha actual, primer y último día del mes, nombre del mes y año del mes anterior
            $hoy = Carbon::now();
            $primerDiaMesAnterior = $hoy->copy()->subMonth()->startOfMonth();
            $ultimoDiaMesAnterior = $hoy->copy()->subMonth()->endOfMonth();
            $mes = $primerDiaMesAnterior->copy()->isoFormat('MMMM');
            $anio = $primerDiaMesAnterior->copy()->year;

            // Obtener todos datos necesarios para el informe
            $tratamientos = Dia::select(
                'centros.nombre as nombre_centro',
                'zonas.nombre as nombre_zona',
                'zonas.precio as precio_zona',
                'zonas.tiempo_estimado as tiempo_zona',
                'dias.fecha as dias'
            )
                ->join('reservas', 'dias.id', 'reservas.dia_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->join('centros', 'dias.centro_id', 'centros.id')
                ->where('dias.fecha', '>=', $primerDiaMesAnterior)
                ->where('dias.fecha', '<=', $ultimoDiaMesAnterior)
                ->get();

            return Inertia::render('Users/Admin/Informes/LastMonthReport', ['mes' => $mes, 'anio' => $anio, 'tratamientos' => $tratamientos]);
        } catch (Exception $er) {
            return redirect()->route('admin.indexInforme')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Vista del informe general para el administrador
     * @return Response|RedirectResponse
     */
    public function adminInformeGeneral(): Response|RedirectResponse
    {
        try {
            // Obtener la fecha actual
            $hoy = Carbon::today();

            // Obtener todos datos necesarios para el informe
            $tratamientos = Dia::select(
                'centros.nombre as nombre_centro',
                'zonas.nombre as nombre_zona',
                'zonas.precio as precio_zona',
                'zonas.tiempo_estimado as tiempo_zona',
                'dias.fecha as dias'
            )
                ->join('reservas', 'dias.id', 'reservas.dia_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->join('centros', 'dias.centro_id', 'centros.id')
                ->where('dias.fecha', '<', $hoy)
                ->get();

            return Inertia::render('Users/Admin/Informes/GeneralReport', ['tratamientos' => $tratamientos]);
        } catch (Exception $er) {
            return redirect()->route('admin.indexInforme')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Vista del formulario de informe personalizado para el administrador
     * @return Response|RedirectResponse
     */
    public function adminFormularioPersonalizado(): Response|RedirectResponse
    {
        try {

            $zonas = Zona::select("id", "nombre")->where('active', '1')->orderBy("nombre")->get();
            if (!$zonas) {
                return redirect(route('admin.indexInforme'))->withErrors('Error: No se encontraron zonas de tratamiento en la bbdd.');
            }

            $centros = Centro::select("id", "nombre", "localidad")->where('active', '1')->orderBy("nombre")->get();
            if (!$centros) {
                return redirect(route('admin.indexInforme'))->withErrors('Error: No se encontraron centros asociados en la bbdd.');
            }

            return Inertia::render('Users/Admin/Informes/FormCustomReport', ['zonas' => $zonas, 'centros' => $centros]);
        } catch (Exception $er) {
            return redirect()->route('admin.indexInforme')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Vista del informe personalizado para el administrador
     * @param Request $request Datos del formulario
     * @return Response|RedirectResponse
     */
    public function adminInformePersonalizado(Request $request): Response|RedirectResponse
    {
        try {
            $fechaMinima = Carbon::create(self::FECHA_MINIMA_INFORME)->startOfDay()->format('Y-m-d');;
            $hoy = Carbon::today()->startOfDay()->format('Y-m-d');;

            $request->validate([
                'dateStart' => 'required|date|after_or_equal:' . $fechaMinima . '|before_or_equal:' . $hoy,
                'dateEnd' => 'required|date|after_or_equal:' . $fechaMinima . '|before_or_equal:' . $hoy,
                'zones' => 'required|array',
                'zones.*' => 'integer|exists:zonas,id',
                'centers' => 'required|array',
                'centers.*' => 'integer|exists:centros,id',
                'period' => 'required|boolean'
            ]);

            $tratamientos = Reserva::join('dias', 'reservas.dia_id', 'dias.id')
                ->join('centros', 'centros.id', 'dias.centro_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->where('dias.fecha', '<=', $request->dateEnd)
                ->where('dias.fecha', '>=', $request->dateStart)
                ->whereIn('centros.id', $request->centers)
                ->whereIn('zonas.id', $request->zones)
                ->select(
                    'zonas.nombre as zona_nombre',
                    'zonas.precio as zona_precio',
                    'zonas.tiempo_estimado as zona_tiempo',
                    'dias.fecha',
                    'centros.nombre as centro_nombre',
                    'centros.localidad as centro_localidad'
                )
                ->orderBy('dias.fecha', 'desc')
                ->get();

            return Inertia::render('Users/Admin/Informes/CustomReport', ['tratamientos' => $tratamientos, 'periodo' => $request->period]);
        } catch (Exception $er) {
            return redirect()->route('admin.indexInforme')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }


    //---------CONTROLADORES RESPONSABLE------------
    /**
     * Vista del index de informes para el responsable
     * @return Response
     */
    public function responIndexInforme(): Response
    {
        return Inertia::render('Users/Responsable/Informes/Index');
    }

    /**
     * Vista del informe del último mes para el responsable
     * @return Response|RedirectResponse
     */
    public function responInformeUltimoMes(): Response|RedirectResponse
    {
        try {
            //Obtener el id del centro asociado del responsable
            $id_centro = Responsable::where('user_id', Auth::id())->first()->centro_id;

            if (!$id_centro) {
                return redirect()->route('respon.indexInforme')->withErrors('No se encontró el identificador del centro');
            }

            // Obtener la fecha actual, primer y último día del mes, nombre del mes y año del mes anterior
            $hoy = Carbon::now();
            $primerDiaMesAnterior = $hoy->copy()->subMonth()->startOfMonth();
            $ultimoDiaMesAnterior = $hoy->copy()->subMonth()->endOfMonth();
            $mes = $primerDiaMesAnterior->copy()->isoFormat('MMMM');
            $anio = $primerDiaMesAnterior->copy()->year;

            // Obtener todos datos necesarios para el informe
            $tratamientos = Dia::select(
                'zonas.nombre as nombre_zona',
                'zonas.precio as precio_zona',
                'zonas.tiempo_estimado as tiempo_zona',
                'dias.fecha as dias'
            )
                ->join('reservas', 'dias.id', 'reservas.dia_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->where('dias.fecha', '>=', $primerDiaMesAnterior)
                ->where('dias.fecha', '<=', $ultimoDiaMesAnterior)
                ->where('dias.centro_id', $id_centro)
                ->get();

            return Inertia::render('Users/Responsable/Informes/LastMonthReport', ['mes' => $mes, 'anio' => $anio, 'tratamientos' => $tratamientos]);
        } catch (Exception $er) {
            return redirect()->route('respon.indexInforme')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Vista del informe general para el responsable
     * @return Response|RedirectResponse
     */
    public function responInformeGeneral(): Response|RedirectResponse
    {
        try {
            //Obtener el id del centro asociado del responsable
            $id_centro = Responsable::where('user_id', Auth::id())->first()->centro_id;

            if (!$id_centro) {
                return redirect()->route('respon.indexInforme')->withErrors('No se encontró el identificador del centro');
            }

            // Obtener la fecha actual
            $hoy = Carbon::today();

            // Obtener todos datos necesarios para el informe
            $tratamientos = Dia::select(
                'centros.nombre as nombre_centro',
                'zonas.nombre as nombre_zona',
                'zonas.precio as precio_zona',
                'zonas.tiempo_estimado as tiempo_zona',
                'dias.fecha as dias'
            )
                ->join('reservas', 'dias.id', 'reservas.dia_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->join('centros', 'dias.centro_id', 'centros.id')
                ->where('dias.fecha', '<', $hoy)
                ->where('dias.centro_id', $id_centro)
                ->get();

            return Inertia::render('Users/Responsable/Informes/GeneralReport', ['tratamientos' => $tratamientos]);
        } catch (Exception $er) {
            return redirect()->route('respon.indexInforme')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Vista del formulario de informe personalizado para el responsable
     * @return Response|RedirectResponse
     */
    public function responFormularioPersonalizado(): Response|RedirectResponse
    {
        try {
            $zonas = Zona::select("id", "nombre")->where('active', '1')->orderBy("nombre")->get();
            if (!$zonas) {
                return redirect(route('admin.indexInforme'))->withErrors('Error: No se encontraron zonas de tratamiento en la bbdd.');
            }

            return Inertia::render('Users/Responsable/Informes/FormCustomReport', ['zonas' => $zonas]);
        } catch (Exception $er) {
            return redirect()->route('respon.indexInforme')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Vista del informe personalizado para el responsable
     * @param Request $request Datos del formulario
     * @return Response|RedirectResponse
     */
    public function responInformePersonalizado(Request $request): Response|RedirectResponse
    {
        try {
             //Obtener el id del centro asociado del responsable
             $id_centro = Responsable::where('user_id', Auth::id())->first()->centro_id;

             if (!$id_centro) {
                 return redirect()->route('respon.indexInforme')->withErrors('No se encontró el identificador del centro');
             }

            $fechaMinima = Carbon::create(self::FECHA_MINIMA_INFORME)->startOfDay()->format('Y-m-d');;
            $hoy = Carbon::today()->startOfDay()->format('Y-m-d');;

            $request->validate([
                'dateStart' => 'required|date|after_or_equal:' . $fechaMinima . '|before_or_equal:' . $hoy,
                'dateEnd' => 'required|date|after_or_equal:' . $fechaMinima . '|before_or_equal:' . $hoy,
                'zones' => 'required|array',
                'zones.*' => 'integer|exists:zonas,id',
                'period' => 'required|boolean'
            ]);

            $tratamientos = Reserva::join('dias', 'reservas.dia_id', 'dias.id')
                ->join('centros', 'centros.id', 'dias.centro_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->where('dias.fecha', '<=', $request->dateEnd)
                ->where('dias.fecha', '>=', $request->dateStart)
                ->where('centros.id', $id_centro)
                ->whereIn('zonas.id', $request->zones)
                ->select(
                    'zonas.nombre as zona_nombre',
                    'zonas.precio as zona_precio',
                    'zonas.tiempo_estimado as zona_tiempo',
                    'dias.fecha',
                    'centros.nombre as centro_nombre',
                    'centros.localidad as centro_localidad'
                )
                ->orderBy('dias.fecha', 'desc')
                ->get();

            return Inertia::render('Users/Responsable/Informes/CustomReport', ['tratamientos' => $tratamientos, 'periodo' => $request->period]);
        } catch (Exception $er) {
            return redirect()->route('respon.indexInforme')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }


    //---------CONTROLADORES CLIENTE------------

    /**
     * Vista del index de informes para el cliente
     * @return Response
     */
    public function clienteIndexTratamientos(): Response
    {
        return Inertia::render('Users/Client/Tratamientos/Index');
    }

    /**
     * Vista de los últimos 5 tratamientos para el cliente
     * @return Response|RedirectResponse
     */
    public function clienteUltimosTratamientos(): Response|RedirectResponse
    {
        try {
            $hoy = Carbon::today();

            $cliente = Cliente::where('user_id', Auth::id())->first();

            if (!$cliente) {
                return redirect()->route('client.indexTratamientos')->withErrors('No se encontró el identificador de cliente');
            }

            $tratamientos = Reserva::where('cliente_id', $cliente->id)
                ->join('dias', 'reservas.dia_id', 'dias.id')
                ->join('centros', 'centros.id', 'dias.centro_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->where('dias.fecha', '<', $hoy)
                ->select(
                    'zonas.nombre as zona_nombre',
                    'zonas.precio as zona_precio',
                    'dias.fecha',
                    'centros.nombre as centro_nombre',
                    'centros.localidad as centro_localidad'

                )
                ->orderBy('dias.fecha', 'desc')
                ->limit(5)
                ->get();

            if (!$tratamientos) {
                return redirect()->route('client.indexTratamientos')->withErrors('No se encontró ningún tratamiento');
            }


            return Inertia::render('Users/Client/Tratamientos/LastTreatment', ['tratamientos' => $tratamientos]);
        } catch (Exception $er) {
            return redirect()->route('client.indexTratamientos')->withErrors('Error al mostrar los últimos tratamientos: ' . $er->getMessage());
        }
    }

    /**
     * Vista de todos los tratamientos para el cliente
     * @return Response|RedirectResponse
     */
    public function clienteInformeTratamientos(): Response|RedirectResponse
    {
        try {
            $hoy = Carbon::today();

            $cliente = Cliente::where('user_id', Auth::id())->first();

            if (!$cliente) {
                return redirect()->route('client.indexTratamientos')->withErrors('No se encontró el identificador de cliente');
            }

            $tratamientos = Reserva::where('cliente_id', $cliente->id)
                ->join('dias', 'reservas.dia_id', 'dias.id')
                ->join('centros', 'centros.id', 'dias.centro_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->where('dias.fecha', '<', $hoy)
                ->select(
                    'zonas.nombre as zona_nombre',
                    'zonas.precio as zona_precio',
                    'dias.fecha',
                    'centros.nombre as centro_nombre',
                    'centros.localidad as centro_localidad'

                )
                ->orderBy('dias.fecha', 'desc')
                ->get();

            if ($tratamientos->isEmpty()) {
                return redirect()->route('client.indexTratamientos')->withErrors('No se encontró ningún tratamiento');
            }

            return Inertia::render('Users/Client/Tratamientos/ReportsTreatment', ['tratamientos' => $tratamientos]);
        } catch (Exception $er) {
            return redirect()->route('client.indexTratamientos')->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Vista del formulario de informe personalizado para el cliente
     * @return Response|RedirectResponse
     */
    public function clienteFormularioPersonalizado(): Response|RedirectResponse
    {
        try {

            $zonas = Zona::select("id", "nombre")->where('active', '1')->orderBy("nombre")->get();
            if (!$zonas) {
                return redirect(route('client.indexTratamientos'))->withErrors('Error: No se encontraron zonas de tratamiento en la bbdd.');
            }

            $centros = Centro::select("id", "nombre", "localidad")->where('active', '1')->orderBy("nombre")->get();
            if (!$centros) {
                return redirect(route('client.indexTratamientos'))->withErrors('Error: No se encontraron centros asociados en la bbdd.');
            }

            return Inertia::render('Users/Client/Tratamientos/FormCustomReport', ['zonas' => $zonas, 'centros' => $centros]);
        } catch (Exception $er) {
            return redirect(route('client.indexTratamientos'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }

    /**
     * Vista del informe personalizado para el cliente
     * @param Request $request Datos del formulario
     * @return Response|RedirectResponse
     */
    public function clienteInformePersonalizado(Request $request): Response|RedirectResponse
    {
        try {
            $fechaMinima = Carbon::create(self::FECHA_MINIMA_INFORME)->startOfDay()->format('Y-m-d');;
            $hoy = Carbon::today()->startOfDay()->format('Y-m-d');;

            $request->validate([
                'dateStart' => 'required|date|after_or_equal:' . $fechaMinima . '|before_or_equal:' . $hoy,
                'dateEnd' => 'required|date|after_or_equal:' . $fechaMinima . '|before_or_equal:' . $hoy,
                'zones' => 'required|array',
                'zones.*' => 'integer|exists:zonas,id',
                'centers' => 'required|array',
                'centers.*' => 'integer|exists:centros,id',
                'period' => 'required|boolean'
            ]);

            $cliente = Cliente::where('user_id', Auth::id())->first();

            if (!$cliente) {
                return redirect()->route('client.indexTratamientos')->withErrors('No se encontró el identificador de cliente');
            }

            $tratamientos = Reserva::where('cliente_id', $cliente->id)
                ->join('dias', 'reservas.dia_id', 'dias.id')
                ->join('centros', 'centros.id', 'dias.centro_id')
                ->join('zonas', 'reservas.zona_id', 'zonas.id')
                ->where('dias.fecha', '<=', $request->dateEnd)
                ->where('dias.fecha', '>=', $request->dateStart)
                ->whereIn('centros.id', $request->centers)
                ->whereIn('zonas.id', $request->zones)
                ->select(
                    'zonas.nombre as zona_nombre',
                    'zonas.precio as zona_precio',
                    'dias.fecha',
                    'centros.nombre as centro_nombre',
                    'centros.localidad as centro_localidad'
                )
                ->orderBy('dias.fecha', 'desc')
                ->get();

            return Inertia::render('Users/Client/Tratamientos/CustomReportsTreatment', ['tratamientos' => $tratamientos, 'periodo' => $request->period]);
        } catch (Exception $er) {
            return redirect(route('client.indexTratamientos'))->withErrors('Error inesperado: ' . $er->getMessage());
        }
    }
}
