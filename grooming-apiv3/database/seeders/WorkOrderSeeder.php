<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WorkOrderSeeder extends Seeder
{
    public function run()
    {
        $pets = DB::table('pets')->get();
        $receptionists = DB::table('users')->where('role', 'receptionist')->get();
        $groomers = DB::table('users')->where('role', 'groomer')->get();
        $services = DB::table('grooming_services')->get();

        $workOrders = [
            [
                'id' => Str::uuid(),
                'pet_id' => $pets->random()->id,
                'created_by_id' => $receptionists->random()->id,
                'assigned_to_id' => $groomers->random()->id,
                'status' => 'pending',
                'estimated_ready' => Carbon::now()->addHours(3),
                'ready_at' => null,
                'customer_notified' => false,
                'comments' => 'Cliente solicita corte no muy corto, mascota muy tranquila',
                'created_at' => Carbon::now()->subHours(1),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'id' => Str::uuid(),
                'pet_id' => $pets->random()->id,
                'created_by_id' => $receptionists->random()->id,
                'assigned_to_id' => $groomers->random()->id,
                'status' => 'in_progress',
                'estimated_ready' => Carbon::now()->addHours(2),
                'ready_at' => null,
                'customer_notified' => false,
                'comments' => 'Cuidado con las uñas, la mascota es un poco nerviosa',
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],
            [
                'id' => Str::uuid(),
                'pet_id' => $pets->random()->id,
                'created_by_id' => $receptionists->random()->id,
                'assigned_to_id' => $groomers->random()->id,
                'status' => 'completed',
                'estimated_ready' => Carbon::now()->subHour(),
                'ready_at' => Carbon::now()->subMinutes(15),
                'customer_notified' => true,
                'comments' => 'Servicio completado satisfactoriamente, mascota muy cooperativa',
                'created_at' => Carbon::now()->subHours(4),
                'updated_at' => Carbon::now()->subMinutes(15),
            ],
            [
                'id' => Str::uuid(),
                'pet_id' => $pets->random()->id,
                'created_by_id' => $receptionists->random()->id,
                'assigned_to_id' => $groomers->random()->id,
                'status' => 'pending',
                'estimated_ready' => Carbon::tomorrow()->addHours(2),
                'ready_at' => null,
                'customer_notified' => false,
                'comments' => 'Cita programada para mañana. Recordar corte especial para la raza.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'pet_id' => $pets->random()->id,
                'created_by_id' => $receptionists->random()->id,
                'assigned_to_id' => $groomers->random()->id,
                'status' => 'cancelled',
                'estimated_ready' => null,
                'ready_at' => null,
                'customer_notified' => true,
                'comments' => 'Cliente canceló por emergencia familiar',
                'created_at' => Carbon::yesterday(),
                'updated_at' => Carbon::yesterday()->addHours(2),
            ]
        ];

        foreach ($workOrders as $order) {
            DB::table('work_orders')->insert($order);
        }

        $insertedOrders = DB::table('work_orders')->get();
        
        foreach ($insertedOrders as $order) {
            $numServices = rand(1, 3);
            $selectedServices = $services->random($numServices);
            
            $orderIndex = 1;
            foreach ($selectedServices as $service) {
                DB::table('work_order_services')->insert([
                    'work_order_id' => $order->id,
                    'service_id' => $service->id,
                    'order_index' => $orderIndex++,
                ]);
            }
        }
    }
}