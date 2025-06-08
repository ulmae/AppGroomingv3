@extends('layouts.app')

@section('title', 'Detalle de Orden - Groomer')

@section('content')
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="flex">
        <div class="w-16 bg-purple-100 flex items-center justify-center rounded-l-lg">
            <span class="text-2xl font-bold text-purple-600">1</span>
        </div>
        
        <div class="flex-1 p-6">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $workOrder->pet->name }}</h2>
                    <p class="text-gray-600 mb-1">{{ $workOrder->servicesList }}</p>
                </div>
                
                <div class="w-20 h-20 ml-6">
                    <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-paw text-gray-400 text-2xl"></i>
                    </div>
                </div>
            </div>
<!--Removido porque haria estorbo en la vista movil-->
            <!--<div class="bg-gray-50 rounded-lg p-4 mb-4">
                <h3 class="font-semibold text-gray-900 mb-2">Información del Cliente</h3>
                <p class="text-sm text-gray-600 mb-1">
                    <strong>Dueño:</strong> {{ $workOrder->pet->customer->full_name }}
                </p>
                <p class="text-sm text-gray-600 mb-1">
                    <strong>Teléfono:</strong> {{ $workOrder->pet->customer->phone_number }}
                </p>
                @if($workOrder->pet->customer->email)
                    <p class="text-sm text-gray-600">
                        <strong>Email:</strong> {{ $workOrder->pet->customer->email }}
                    </p>
                @endif
            </div>-->
            
            @if($workOrder->pet->breed || $workOrder->pet->weight_kg)
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Detalles de la Mascota</h3>
                    @if($workOrder->pet->breed)
                        <p class="text-sm text-gray-600 mb-1">
                            <strong>Raza:</strong> {{ $workOrder->pet->breed }}
                        </p>
                    @endif
                    @if($workOrder->pet->weight_kg)
                        <p class="text-sm text-gray-600">
                            <strong>Peso:</strong> {{ $workOrder->pet->weight_kg }} kg
                        </p>
                    @endif
                </div>
            @endif
            
            @if($workOrder->comments || $workOrder->pet->notes)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <h3 class="font-semibold text-yellow-800 mb-2">
                        <i class="fas fa-sticky-note mr-2"></i>Notas Importantes
                    </h3>
                    @if($workOrder->comments)
                        <p class="text-sm text-yellow-700 mb-2">
                            <strong>Comentarios de la orden:</strong><br>
                            {{ $workOrder->comments }}
                        </p>
                    @endif
                    @if($workOrder->pet->notes)
                        <p class="text-sm text-yellow-700">
                            <strong>Notas de la mascota:</strong><br>
                            {{ $workOrder->pet->notes }}
                        </p>
                    @endif
                </div>
            @endif
            
            <div class="flex space-x-3 mt-6">
                <button type="button" 
                        class="flex-1 bg-white border border-gray-300 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-50 transition-colors"
                        onclick="openNotesModal()">
                    Notas
                </button>
                <button type="button" 
                        class="flex-1 bg-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-purple-700 transition-colors"
                        onclick="openCompleteModal()">
                    Completado
                </button>
            </div>
        </div>
    </div>
</div>

@if($otherOrders->count() > 0)
    <div class="space-y-4">
        @foreach($otherOrders as $index => $order)
            <div class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow"
                 onclick="window.location.href='{{ route('groomer.show', $order->id) }}'">
                <div class="flex">
                    <div class="w-16 bg-purple-100 flex items-center justify-center">
                        <span class="text-2xl font-bold text-purple-600">{{ $index + 2 }}</span>
                    </div>
                    
                    <div class="flex-1 p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $order->pet->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->servicesList }}</p>
                            </div>
                            
                            <div class="w-16 h-16 ml-4">
                                <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-paw text-gray-400 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<div id="notesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Agregar Notas</h3>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeNotesModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="notesForm">
            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notas del servicio
                </label>
                <textarea id="notes" name="notes" rows="4" 
                          class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                          placeholder="Escribe cualquier observación sobre el servicio..."></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400"
                        onclick="closeNotesModal()">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Guardar Notas
                </button>
            </div>
        </form>
    </div>
</div>

<div id="completeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-8 border w-96 shadow-lg rounded-lg bg-white text-center">
        <div class="mb-6">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $workOrder->pet->name }} ha sido marcado como completado</h3>
            <p class="text-gray-600 text-sm mb-4">
                Se notificará al dueño dentro de poco. Si necesitas agregar notas adicionales, puedes buscar a {{ $workOrder->pet->name }} en tu Historial de Órdenes.
            </p>
        </div>
        
        <div class="flex space-x-3">
            <button type="button" 
                    class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400"
                    onclick="goToHistory()">
                Ir a Historial
            </button>
            <button type="button" 
                    class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                    onclick="closeCompleteModal()">
                Cerrar
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openNotesModal() {
    document.getElementById('notesModal').classList.remove('hidden');
}

function closeNotesModal() {
    document.getElementById('notesModal').classList.add('hidden');
    document.getElementById('notesForm').reset();
}

function openCompleteModal() {
    fetch(`/groomer/orders/{{ $workOrder->id }}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('completeModal').classList.remove('hidden');
        } else {
            alert('Error al completar la orden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al completar la orden');
    });
}

function closeCompleteModal() {
    document.getElementById('completeModal').classList.add('hidden');
    window.location.href = '{{ route("groomer.dashboard") }}';
}

function goToHistory() {
    alert('Funcionalidad de historial por implementar');
    closeCompleteModal();
}

document.getElementById('notesForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const notes = document.getElementById('notes').value;
    if (!notes.trim()) {
        alert('Por favor escribe una nota');
        return;
    }
    
    fetch(`/groomer/orders/{{ $workOrder->id }}/notes`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ notes: notes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeNotesModal();
            location.reload();
        } else {
            alert('Error al guardar las notas');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar las notas');
    });
});

document.addEventListener('click', function(event) {
    const notesModal = document.getElementById('notesModal');
    const completeModal = document.getElementById('completeModal');
    
    if (event.target === notesModal) {
        closeNotesModal();
    }
    
    if (event.target === completeModal) {
        closeCompleteModal();
    }
});
</script>
@endpush

@push('styles')
<style>
    body {
        background-color: #f3f4f6;
    }
</style>
@endpush