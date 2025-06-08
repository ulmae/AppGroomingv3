@extends('layouts.app')

@section('title', 'Recepcionistas - Tu Veterinaria')

@section('content')
<div class="receptionist-dashboard">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-900">Recepcionistas</h3>
        <button type="button" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors"
                onclick="openAddOrderModal()">
            <i class="fas fa-plus"></i>
            <span>Agregar Nueva Orden</span>
        </button>
    </div>

    <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Caninos ingresados</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-yellow-800 mb-2">{{ $pendingOrders }}</div>
                <div class="text-yellow-700 font-medium">Caninos para baño</div>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-blue-800 mb-2">{{ $inProgressOrders }}</div>
                <div class="text-blue-700 font-medium">Caninos para corte</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-green-800 mb-2">{{ $readyOrders }}</div>
                <div class="text-green-700 font-medium">Caninos para baño y corte</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900">LISTA DE CANINOS</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dueño</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicios</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario estimado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($workOrders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-semibold text-gray-900">{{ $order->pet->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->pet->customer->full_name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $order->servicesList }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->pet->customer->phone_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($order->status === 'completed' && $order->ready_at)
                                    {{ $order->ready_at->format('g:iA') }}
                                @elseif($order->estimated_ready)
                                    {{ $order->estimated_ready->format('g:iA') }} - {{ $order->estimated_ready->addHour()->format('g:iA') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $order->statusClass }}">
                                    {{ $order->statusDisplay }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if(!in_array($order->status, ['completed', 'cancelled']))
                                    <button type="button" 
                                            class="text-red-600 hover:text-red-900 font-medium flex items-center space-x-1"
                                            onclick="confirmCancelOrder('{{ $order->id }}', '{{ $order->pet->name }}')">
                                        <i class="fas fa-times"></i>
                                        <span>Cancelar</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No hay órdenes registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>




<div id="addOrderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-lg font-bold text-gray-900">Agregar Nueva Orden de Grooming</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeAddOrderModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="addOrderForm" action="{{ route('receptionist.add-order') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                    <select id="customer_id" name="customer_id" class="w-full p-2 border border-gray-300 rounded-lg" required>
                        <option value="">Seleccionar cliente...</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="pet_id" class="block text-sm font-medium text-gray-700 mb-1">Mascota</label>
                    <select id="pet_id" name="pet_id" class="w-full p-2 border border-gray-300 rounded-lg" required disabled>
                        <option value="">Primero selecciona un cliente...</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="assigned_to_id" class="block text-sm font-medium text-gray-700 mb-1">Asignar a</label>
                    <select id="assigned_to_id" name="assigned_to_id" class="w-full p-2 border border-gray-300 rounded-lg" required>
                        <option value="">Seleccionar groomer...</option>
                        @foreach($groomers as $groomer)
                            <option value="{{ $groomer->id }}">{{ $groomer->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="estimated_ready" class="block text-sm font-medium text-gray-700 mb-1">Hora estimada de finalización</label>
                    <input type="datetime-local" id="estimated_ready" name="estimated_ready" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Servicios</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach($services as $service)
                        <div class="flex items-center">
                            <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" id="service_{{ $service->id }}" class="mr-2">
                            <label for="service_{{ $service->id }}" class="text-sm text-gray-700">
                                {{ $service->name }} ({{ $service->duration_min }} min)
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <label for="comments" class="block text-sm font-medium text-gray-700 mb-1">Comentarios (opcional)</label>
                <textarea id="comments" name="comments" class="w-full p-2 border border-gray-300 rounded-lg" rows="3" placeholder="Comentarios especiales para la orden..."></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400" onclick="closeAddOrderModal()">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Crear Orden
                </button>
            </div>
        </form>
    </div>
</div>




<div id="cancelOrderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-lg font-bold text-gray-900">Confirmar Cancelación</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeCancelModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="mb-4">
            <p class="text-gray-700 mb-2">¿Está seguro que desea cancelar la orden para <strong id="cancelPetName"></strong>?</p>
            <p class="text-sm text-gray-500">Esta acción no se puede deshacer.</p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400" onclick="closeCancelModal()">
                No, mantener orden
            </button>
            <button type="button" id="confirmCancelBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Sí, cancelar orden
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

let currentOrderToCancel = null;


function openAddOrderModal() {
    document.getElementById('addOrderModal').classList.remove('hidden');
}

function closeAddOrderModal() {
    document.getElementById('addOrderModal').classList.add('hidden');
    document.getElementById('addOrderForm').reset();
    document.getElementById('pet_id').disabled = true;
    document.getElementById('pet_id').innerHTML = '<option value="">Primero selecciona un cliente...</option>';
}

function confirmCancelOrder(orderId, petName) {
    currentOrderToCancel = orderId;
    document.getElementById('cancelPetName').textContent = petName;
    document.getElementById('cancelOrderModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelOrderModal').classList.add('hidden');
    currentOrderToCancel = null;
}


document.getElementById('customer_id').addEventListener('change', function() {
    const customerId = this.value;
    const petSelect = document.getElementById('pet_id');
    
    if (customerId) {
        fetch(`/receptionist/customers/${customerId}/pets`)
            .then(response => response.json())
            .then(pets => {
                petSelect.innerHTML = '<option value="">Seleccionar mascota...</option>';
                pets.forEach(pet => {
                    petSelect.innerHTML += `<option value="${pet.id}">${pet.name}</option>`;
                });
                petSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                petSelect.innerHTML = '<option value="">Error al cargar mascotas</option>';
            });
    } else {
        petSelect.innerHTML = '<option value="">Primero selecciona un cliente...</option>';
        petSelect.disabled = true;
    }
});


document.getElementById('confirmCancelBtn').addEventListener('click', function() {
    if (currentOrderToCancel) {
        fetch(`/receptionist/orders/${currentOrderToCancel}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); 
            } else {
                alert('Error al cancelar la orden: ' + (data.error || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cancelar la orden');
        })
        .finally(() => {
            closeCancelModal();
        });
    }
});


document.addEventListener('click', function(event) {
    const addModal = document.getElementById('addOrderModal');
    const cancelModal = document.getElementById('cancelOrderModal');
    
    if (event.target === addModal) {
        closeAddOrderModal();
    }
    
    if (event.target === cancelModal) {
        closeCancelModal();
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    now.setHours(now.getHours() + 1);
    const minDateTime = now.toISOString().slice(0, 16);
    document.getElementById('estimated_ready').min = minDateTime;
});
</script>
@endpush