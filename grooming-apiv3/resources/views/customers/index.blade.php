@extends('layouts.app')

@section('title', 'Gestión de Clientes - Tu Veterinaria')

@section('content')
<div class="customers-management">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-900">Gestión de Clientes</h3>
        <button type="button" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors"
                onclick="openAddCustomerModal()">
            <i class="fas fa-plus"></i>
            <span>Agregar Nuevo Cliente</span>
        </button>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900">Lista de Clientes ({{ $customers->count() }})</h4>
        </div>
        
        @if($customers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Mascotas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Registro</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($customers as $customer)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-semibold text-gray-900">{{ $customer->full_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-2"></i>
                                        {{ $customer->phone_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($customer->email)
                                        <div class="flex items-center">
                                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                            {{ $customer->email }}
                                        </div>
                                    @else
                                        <span class="text-gray-500 italic">No registrado</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-paw text-gray-400 mr-2"></i>
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                            {{ $customer->pets_count }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $customer->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <button type="button" 
                                            class="text-blue-600 hover:text-blue-900 font-medium inline-flex items-center"
                                            onclick="editCustomer('{{ $customer->id }}')">
                                        <i class="fas fa-edit mr-1"></i>Modificar
                                    </button>
                                    <button type="button" 
                                            class="text-red-600 hover:text-red-900 font-medium inline-flex items-center"
                                            onclick="confirmDeleteCustomer('{{ $customer->id }}', '{{ $customer->full_name }}', {{ $customer->pets_count }})">
                                        <i class="fas fa-trash mr-1"></i>Borrar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-users text-4xl mb-4 text-gray-300"></i>
                <h4 class="text-lg font-semibold text-gray-700 mb-2">No hay clientes registrados</h4>
                <p class="text-gray-600 mb-4">Comienza agregando tu primer cliente</p>
                <button type="button" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
                        onclick="openAddCustomerModal()">
                    Agregar Primer Cliente
                </button>
            </div>
        @endif
    </div>
</div>




<div id="customerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h5 id="customerModalTitle" class="text-lg font-bold text-gray-900">Agregar Nuevo Cliente</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeCustomerModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="customerForm" method="POST">
            @csrf
            <input type="hidden" id="customerMethod" name="_method" value="POST">
            
            <div class="mb-4">
                <label for="customerFullName" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre Completo *
                </label>
                <input type="text" 
                       id="customerFullName" 
                       name="full_name" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       required
                       placeholder="Ej: Juan Carlos Pérez">
            </div>

            <div class="mb-4">
                <label for="customerPhone" class="block text-sm font-medium text-gray-700 mb-1">
                    Número de Teléfono *
                </label>
                <input type="tel" 
                       id="customerPhone" 
                       name="phone_number" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       required
                       placeholder="Ej: 2234-5678">
            </div>

            <div class="mb-6">
                <label for="customerEmail" class="block text-sm font-medium text-gray-700 mb-1">
                    Email (Opcional)
                </label>
                <input type="email" 
                       id="customerEmail" 
                       name="email" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       placeholder="Ej: juan.perez@email.com">
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-info-circle mr-1"></i>
                    El email es opcional pero útil para notificaciones
                </p>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors" 
                        onclick="closeCustomerModal()">
                    Cancelar
                </button>
                <button type="submit" 
                        id="customerSubmitBtn" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Agregar Cliente
                </button>
            </div>
        </form>
    </div>
</div>




<div id="deleteCustomerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-lg font-bold text-gray-900">Confirmar Eliminación</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeDeleteCustomerModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="mb-4">
            <p class="text-gray-700 mb-2">
                ¿Está seguro que desea eliminar al cliente <strong id="deleteCustomerName"></strong>?
            </p>
            <div id="deleteCustomerWarning" class="hidden">
                <p class="text-sm text-red-600 mb-2">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Este cliente tiene <span id="deleteCustomerPets"></span> mascota(s) registrada(s).
                </p>
                <p class="text-xs text-gray-500 mb-2">
                    No se puede eliminar un cliente que tenga mascotas asociadas.
                </p>
            </div>
            <p class="text-sm text-red-600">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Esta acción no se puede deshacer.
            </p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button type="button" 
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400" 
                    onclick="closeDeleteCustomerModal()">
                Cancelar
            </button>
            <button type="button" 
                    id="confirmDeleteCustomerBtn" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentCustomerToDelete = null;
let isEditMode = false;
let currentCustomerId = null;


function openAddCustomerModal() {
    isEditMode = false;
    document.getElementById('customerModalTitle').textContent = 'Agregar Nuevo Cliente';
    document.getElementById('customerSubmitBtn').textContent = 'Agregar Cliente';
    document.getElementById('customerMethod').value = 'POST';
    document.getElementById('customerForm').action = '{{ route("customers.store") }}';
    document.getElementById('customerModal').classList.remove('hidden');
}

function closeCustomerModal() {
    document.getElementById('customerModal').classList.add('hidden');
    document.getElementById('customerForm').reset();
    isEditMode = false;
    currentCustomerId = null;
}

function editCustomer(customerId) {
    isEditMode = true;
    currentCustomerId = customerId;
    
    fetch(`/customers/${customerId}/edit`)
        .then(response => response.json())
        .then(customer => {
            document.getElementById('customerModalTitle').textContent = 'Modificar Cliente';
            document.getElementById('customerSubmitBtn').textContent = 'Actualizar Cliente';
            document.getElementById('customerMethod').value = 'PUT';
            document.getElementById('customerForm').action = `/customers/${customerId}`;
            
            document.getElementById('customerFullName').value = customer.full_name || '';
            document.getElementById('customerPhone').value = customer.phone_number || '';
            document.getElementById('customerEmail').value = customer.email || '';
            
            document.getElementById('customerModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los datos del cliente');
        });
}

function confirmDeleteCustomer(customerId, customerName, petsCount) {
    currentCustomerToDelete = customerId;
    document.getElementById('deleteCustomerName').textContent = customerName;
    
    const warningDiv = document.getElementById('deleteCustomerWarning');
    const confirmBtn = document.getElementById('confirmDeleteCustomerBtn');
    
    if (petsCount > 0) {
        document.getElementById('deleteCustomerPets').textContent = petsCount;
        warningDiv.classList.remove('hidden');
        confirmBtn.disabled = true;
        confirmBtn.classList.add('opacity-50', 'cursor-not-allowed');
        confirmBtn.textContent = 'No se puede eliminar';
    } else {
        warningDiv.classList.add('hidden');
        confirmBtn.disabled = false;
        confirmBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        confirmBtn.textContent = 'Sí, eliminar';
    }
    
    document.getElementById('deleteCustomerModal').classList.remove('hidden');
}

function closeDeleteCustomerModal() {
    document.getElementById('deleteCustomerModal').classList.add('hidden');
    currentCustomerToDelete = null;
}

document.getElementById('confirmDeleteCustomerBtn').addEventListener('click', function() {
    if (currentCustomerToDelete && !this.disabled) {
        fetch(`/customers/${currentCustomerToDelete}`, {
            method: 'DELETE',
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
                alert('Error: ' + (data.error || 'No se pudo eliminar el cliente'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el cliente');
        })
        .finally(() => {
            closeDeleteCustomerModal();
        });
    }
});

document.addEventListener('click', function(event) {
    const customerModal = document.getElementById('customerModal');
    const deleteModal = document.getElementById('deleteCustomerModal');
    
    if (event.target === customerModal) {
        closeCustomerModal();
    }
    
    if (event.target === deleteModal) {
        closeDeleteCustomerModal();
    }
});

document.getElementById('customerPhone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 4) {
        value = value.substring(0, 4) + '-' + value.substring(4, 8);
    }
    e.target.value = value;
});
</script>
@endpush