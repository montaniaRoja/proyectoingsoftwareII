<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer; // Asegúrate de que la ruta del modelo sea correcta
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $customers = [
            [
                'no_doc' => '1001001',
                'nombre' => 'Juan Pérez',
                'correo' => 'juan.perez@example.com',
                'telefono' => '3111234567',
                'direccion' => 'Calle 10 #45-23',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001002',
                'nombre' => 'María Gómez',
                'correo' => 'maria.gomez@example.com',
                'telefono' => '3122345678',
                'direccion' => 'Cra 5 #12-34',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001003',
                'nombre' => 'Carlos López',
                'correo' => 'carlos.lopez@example.com',
                'telefono' => '3133456789',
                'direccion' => 'Av 30 #50-20',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001004',
                'nombre' => 'Ana Martínez',
                'correo' => 'ana.martinez@example.com',
                'telefono' => '3144567890',
                'direccion' => 'Cl 15 #22-10',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001005',
                'nombre' => 'Pedro Sánchez',
                'correo' => 'pedro.sanchez@example.com',
                'telefono' => '3155678901',
                'direccion' => 'Cra 9 #8-90',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001006',
                'nombre' => 'Lucía Torres',
                'correo' => 'lucia.torres@example.com',
                'telefono' => '3166789012',
                'direccion' => 'Calle 50 #20-30',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001007',
                'nombre' => 'Jorge Ramírez',
                'correo' => 'jorge.ramirez@example.com',
                'telefono' => '3177890123',
                'direccion' => 'Cl 60 #13-45',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001008',
                'nombre' => 'Elena Morales',
                'correo' => 'elena.morales@example.com',
                'telefono' => '3188901234',
                'direccion' => 'Av 68 #42-21',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001009',
                'nombre' => 'Luis Herrera',
                'correo' => 'luis.herrera@example.com',
                'telefono' => '3199012345',
                'direccion' => 'Cl 100 #23-12',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001010',
                'nombre' => 'Patricia Ríos',
                'correo' => 'patricia.rios@example.com',
                'telefono' => '3200123456',
                'direccion' => 'Cra 7 #45-67',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001011',
                'nombre' => 'Miguel Castro',
                'correo' => 'miguel.castro@example.com',
                'telefono' => '3211234567',
                'direccion' => 'Calle 70 #10-10',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001012',
                'nombre' => 'Sandra Ruiz',
                'correo' => 'sandra.ruiz@example.com',
                'telefono' => '3222345678',
                'direccion' => 'Cl 80 #50-50',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001013',
                'nombre' => 'Andrés Salazar',
                'correo' => 'andres.salazar@example.com',
                'telefono' => '3233456789',
                'direccion' => 'Cra 15 #33-33',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001014',
                'nombre' => 'Carmen Beltrán',
                'correo' => 'carmen.beltran@example.com',
                'telefono' => '3244567890',
                'direccion' => 'Av 26 #60-60',
                'creado_por' => 1
            ],
            [
                'no_doc' => '1001015',
                'nombre' => 'Ricardo Méndez',
                'correo' => 'ricardo.mendez@example.com',
                'telefono' => '3255678901',
                'direccion' => 'Cl 33 #77-77',
                'creado_por' => 1
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
