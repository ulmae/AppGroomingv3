<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkOrder;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\GroomingService;
use App\Models\User;

class ReceptionistController extends Controller
{

    public function index()
    {
        $pendingOrders = WorkOrder::where('status', 'pending')->count();
        $inProgressOrders = WorkOrder::where('status', 'in_progress')->count();
        $readyOrders = WorkOrder::where('status', 'completed')->count();

        $workOrders = WorkOrder::with(['pet.customer', 'assignedTo', 'services'])
            ->whereIn('status', ['pending', 'in_progress', 'completed'])
            ->orderBy('created_at', 'desc')
            ->get();

        $customers = Customer::orderBy('full_name')->get();
        $groomers = User::where('role', 'groomer')->where('active', true)->orderBy('full_name')->get();
        $services = GroomingService::orderBy('name')->get();

        return view('dashboard.receptionist', compact(
            'pendingOrders',
            'inProgressOrders', 
            'readyOrders',
            'workOrders',
            'customers',
            'groomers',
            'services'
        ));
    }

    public function addOrder(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'pet_id' => 'required|exists:pets,id',
            'assigned_to_id' => 'required|exists:users,id',
            'estimated_ready' => 'required|date',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:grooming_services,id',
            'comments' => 'nullable|string|max:1000'
        ]);

        $workOrder = WorkOrder::create([
            'pet_id' => $request->pet_id,
            'created_by_id' => Auth::id(),
            'assigned_to_id' => $request->assigned_to_id,
            'status' => 'pending',
            'estimated_ready' => $request->estimated_ready,
            'comments' => $request->comments,
        ]);

        foreach ($request->service_ids as $index => $serviceId) {
            $workOrder->services()->attach($serviceId, ['order_index' => $index]);
        }

        return redirect()->route('receptionist.dashboard')
                        ->with('success', 'Orden creada exitosamente');
    }

    public function cancelOrder(Request $request, $id)
    {
        $workOrder = WorkOrder::findOrFail($id);
        
        if (in_array($workOrder->status, ['completed', 'cancelled'])) {
            return response()->json(['error' => 'No se puede cancelar esta orden'], 400);
        }

        $workOrder->update(['status' => 'cancelled']);

        return response()->json(['success' => true]);
    }

    public function getPetsByCustomer($customerId)
    {
        $pets = Pet::where('customer_id', $customerId)->orderBy('name')->get();
        return response()->json($pets);
    }
}