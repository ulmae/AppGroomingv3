<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroomingSystemSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            ['id' => Str::uuid(), 'full_name' => 'María González', 'phone_number' => '7234-5678', 'email' => 'maria.gonzalez@email.com'],
            ['id' => Str::uuid(), 'full_name' => 'Carlos Rodríguez', 'phone_number' => '7845-9123', 'email' => 'carlos.rodriguez@email.com'],
            ['id' => Str::uuid(), 'full_name' => 'Ana Patricia López', 'phone_number' => '7567-4321', 'email' => 'ana.lopez@email.com'],
            ['id' => Str::uuid(), 'full_name' => 'Roberto Martínez', 'phone_number' => '7888-7777', 'email' => 'roberto.martinez@email.com'],
            ['id' => Str::uuid(), 'full_name' => 'Sofía Hernández', 'phone_number' => '7234-1111', 'email' => null],
        ];

        foreach ($customers as $customer) {
            DB::table('customers')->insert(array_merge($customer, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }


        $users = [
            ['id' => Str::uuid(), 'full_name' => 'Laura Beatriz Vásquez', 'role' => 'receptionist', 'email' => 'laura.vasquez@grooming.com', 'password_hash' => bcrypt('password123')],
            ['id' => Str::uuid(), 'full_name' => 'Pedro Antonio Morales', 'role' => 'groomer', 'email' => 'pedro.morales@grooming.com', 'password_hash' => bcrypt('password123')],
            ['id' => Str::uuid(), 'full_name' => 'Carlos Eduardo Ramírez', 'role' => 'admin', 'email' => 'carlos.ramirez@grooming.com', 'password_hash' => bcrypt('password123')],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert(array_merge($user, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        $services = [
            ['name' => 'Baño Completo', 'description' => 'Baño con shampoo especial, secado y cepillado', 'duration_min' => 45],
            ['name' => 'Corte de Pelo', 'description' => 'Corte y arreglo de pelo según la raza', 'duration_min' => 60],
            ['name' => 'Limpieza de Oídos', 'description' => 'Limpieza profunda de oídos', 'duration_min' => 15],
            ['name' => 'Corte de Uñas', 'description' => 'Corte y limado de uñas', 'duration_min' => 20],
            ['name' => 'Paquete Completo', 'description' => 'Baño, corte, limpieza de oídos y uñas', 'duration_min' => 120],
        ];

        foreach ($services as $service) {
            DB::table('grooming_services')->insert($service);
        }

        $customer1 = DB::table('customers')->where('email', 'maria.gonzalez@email.com')->first();
        $customer2 = DB::table('customers')->where('email', 'carlos.rodriguez@email.com')->first();
        
        DB::table('pets')->insert([
            'id' => Str::uuid(),
            'customer_id' => $customer1->id,
            'name' => 'Max',
            'species' => 'Perro',
            'breed' => 'Golden Retriever',
            'birth_date' => '2022-03-15',
            'weight_kg' => 28.50,
            'notes' => 'Muy tranquilo, le gusta el agua',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}