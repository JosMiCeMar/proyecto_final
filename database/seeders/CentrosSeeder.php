<?php

namespace Database\Seeders;

use App\Models\Centro;
use Illuminate\Database\Seeder;

/**
 * Seeder para la tabla centros.
 */
class CentrosSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     * @return void
     */
    public function run(): void
    {
        $datos = [
            [
                'nombre' => 'Depilaser MC',
                'direccion' => 'Calle Cardenal Cisneros 22',
                'telefono' => '654654654',
                'localidad' => 'Chillón',
                'provincia' => 'Ciudad Real',
                'email' => 'depilasermc@gmail.com',
                'ubicacion' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3109.544729018183!2d-4.873737815951818!3d38.79707009889373!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6b45dc17f1c9f7%3A0x2470b8b1079ed62a!2sC.%20Cardenal%20Cisneros%2C%2022%2C%2013412%20Chill%C3%B3n%2C%20Ciudad%20Real!5e0!3m2!1ses!2ses!4v1720796559362!5m2!1ses!2ses'
            ],
            [
                'nombre' => 'Centro de Ana',
                'direccion' => 'Calle Libertad 11',
                'telefono' => '612123123',
                'localidad' => 'Morón de la Frontera',
                'provincia' => 'Sevilla'
            ],
            [
                'nombre' => 'Lais Nails',
                'direccion' => 'Avenida Ramón y Cajal 15',
                'telefono' => '645456456',
                'localidad' => 'Almadén',
                'provincia' => 'Ciudad Real',
                'ubicacion' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d326.9457284541406!2d-4.831904676030467!3d38.776328763414284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6b444264d1ba2d%3A0x27282210c64fda09!2sAv.%20Ram%C3%B3n%20y%20Cajal%2C%2015%2C%2013400%20Almad%C3%A9n%2C%20Ciudad%20Real!5e0!3m2!1ses!2ses!4v1720801721689!5m2!1ses!2se'
            ],
            [
                'nombre' => 'Centro Estetica Montse Ruiz',
                'direccion' => 'Avenida Arrollo del Moro 5',
                'telefono' => '661661661',
                'localidad' => 'Córdoba',
                'provincia' => 'Córdoba',
                'web' => 'https://centroesteticamontseruiz.com/',
                'ubicacion' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25190.075214072367!2d-4.835666825683564!3d37.889309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6cdf5b00dad753%3A0x52026e2857049f4b!2sCentro%20Estetica%20Montse%20Ruiz!5e0!3m2!1ses!2ses!4v1740160398005!5m2!1ses!2ses'          
            ],
            [
                'nombre' => 'Peluquería caballeros Jose',
                'direccion' => 'Calle Pio XII 5',
                'telefono' => '666666666',
                'localidad' => 'Écija',
                'provincia' => 'Sevilla',
                'ubicacion' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3163.174801916934!2d-5.088110824438801!3d37.55094522502247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd12cbe15094ead7%3A0x2176a058a26f7fa!2sPeluquer%C3%ADa%20caballeros%20Jose!5e0!3m2!1ses!2ses!4v1740160208601!5m2!1ses!2ses'
            ],
            [
                'nombre' => 'Integral de la belleza',	
                'direccion' => 'Avenida de la Paz 21',
                'telefono' => '699699699',
                'localidad' => 'Carlota, La',
                'provincia' => 'Córdoba',
                'ubicacion' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3158.186821978394!2d-4.937087874433421!3d37.66831771828572!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6d30549ae2feb5%3A0x9d6eed7a795648fb!2sIntegral%20de%20la%20belleza!5e0!3m2!1ses!2ses!4v1740160282291!5m2!1ses!2ses'
            ],
            [
                'nombre' => 'Meye Sevilla Este ',	
                'direccion' => 'Avenida de las ciencias 15',
                'telefono' => '655655655',
                'localidad' => 'Sevilla',
                'provincia' => 'Sevilla',
                'web' => 'http://meye.es/',
                'ubicacion' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d50718.42717436234!2d-6.001230850831223!3d37.39215694716094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd126ef28cd70e3b%3A0xa989bff9b7e7f947!2sMeye%20Sevilla%20Este%20-%20Cl%C3%ADnica%20Est%C3%A9tica!5e0!3m2!1ses!2ses!4v1740160751618!5m2!1ses!2ses'
            ]
        ];

        foreach ($datos as $centro) {
            Centro::create($centro);
        }
    }
}
