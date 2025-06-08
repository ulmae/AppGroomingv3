<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkOrder;
use App\Models\User;

class GroomerController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::with(['pet.customer', 'assignedTo', 'services'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('groomer.index', compact('workOrders'));
    }

    public function show($id)
    {
        $workOrder = WorkOrder::with(['pet.customer', 'assignedTo', 'services', 'createdBy'])
            ->findOrFail($id);

        $otherOrders = WorkOrder::with(['pet.customer', 'assignedTo', 'services'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('groomer.show', compact('workOrder', 'otherOrders'));
    }

    public function complete(Request $request, $id)
    {
        $workOrder = WorkOrder::findOrFail($id);
        
        $workOrder->update([
            'status' => 'completed',
            'ready_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Orden marcada como completada'
        ]);
    }

    public function addNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $workOrder = WorkOrder::findOrFail($id);
        
        $existingComments = $workOrder->comments ? $workOrder->comments . "\n\n" : '';
        $newComment = "Nota del groomer (" . now()->format('d/m/Y H:i') . "): " . $request->notes;
        
        $workOrder->update([
            'comments' => $existingComments . $newComment
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nota agregada exitosamente'
        ]);
    }
}