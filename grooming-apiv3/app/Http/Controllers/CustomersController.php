<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Pet;

class CustomersController extends Controller
{

    public function index()
    {
        $customers = Customer::withCount('pets')
                           ->orderBy('full_name')
                           ->get();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|unique:customers,email'
        ]);

        Customer::create([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);

        return redirect()->route('customers.index')
                        ->with('success', 'Cliente agregado exitosamente');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|unique:customers,email,' . $id
        ]);

        $customer->update([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);

        return redirect()->route('customers.index')
                        ->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            
            $petsCount = $customer->pets()->count();
            
            if ($petsCount > 0) {
                return response()->json([
                    'error' => "No se puede eliminar el cliente porque tiene {$petsCount} mascota(s) registrada(s)"
                ], 400);
            }

            $customer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cliente eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar el cliente: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $customer = Customer::with('pets')->findOrFail($id);
        return response()->json($customer);
    }
}