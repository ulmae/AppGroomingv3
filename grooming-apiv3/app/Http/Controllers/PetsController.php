<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Pet;
use Illuminate\Support\Facades\DB;

class PetsController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::orderBy('full_name')->get();
        $selectedCustomer = null;
        $pets = collect();

        if ($request->has('customer_id') && $request->customer_id) {
            $selectedCustomer = Customer::findOrFail($request->customer_id);
            $pets = Pet::where('customer_id', $request->customer_id)
                      ->orderBy('name')
                      ->get();
        }

        return view('pets.index', compact('customers', 'selectedCustomer', 'pets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name' => 'required|string|max:100',
            'species' => 'nullable|string|max:50',
            'breed' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date|before_or_equal:today',
            'weight_kg' => 'nullable|numeric|min:0|max:999.99',
            'notes' => 'nullable|string|max:1000'
        ]);

        Pet::create([
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'species' => $request->species,
            'breed' => $request->breed,
            'birth_date' => $request->birth_date,
            'weight_kg' => $request->weight_kg,
            'notes' => $request->notes,
        ]);

        return redirect()->route('pets.index', ['customer_id' => $request->customer_id])
                        ->with('success', 'Mascota agregada exitosamente');
    }


    public function destroy($id)
    {
        try {
            $pet = Pet::findOrFail($id);

            $hasWorkOrders = $pet->workOrders()->exists();
            
            if ($hasWorkOrders) {
                return response()->json([
                    'error' => 'No se puede eliminar la mascota porque tiene órdenes de trabajo asociadas'
                ], 400);
            }

            $customerId = $pet->customer_id;
            $pet->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mascota eliminada exitosamente',
                'customer_id' => $customerId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar la mascota: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $pet = Pet::with('customer')->findOrFail($id);
        return response()->json($pet);
    }

    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'species' => 'nullable|string|max:50',
            'breed' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date|before_or_equal:today',
            'weight_kg' => 'nullable|numeric|min:0|max:999.99',
            'notes' => 'nullable|string|max:1000'
        ]);

        $pet->update([
            'name' => $request->name,
            'species' => $request->species,
            'breed' => $request->breed,
            'birth_date' => $request->birth_date,
            'weight_kg' => $request->weight_kg,
            'notes' => $request->notes,
        ]);

        return redirect()->route('pets.index', ['customer_id' => $pet->customer_id])
                        ->with('success', 'Mascota actualizada!');
    }
}