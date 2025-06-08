@extends('layouts.app')

@section('title', 'Gestión de Mascotas - Tu Veterinaria')

@section('content')
<div class="pets-management">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-900">Gestión de Mascotas</h3>
    </div>

    <!-- Customer Selection Section -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900">Seleccionar Cliente</h4>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('pets.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Cliente</label>
                    <select id="customer_id" name="customer_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-vet-blue focus:border-vet-blue" onchange="this.form.submit()">
                        <option value="">Seleccionar cliente...</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->full_name }} - {{ $customer->phone_number }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    @if($selectedCustomer)
        <!-- Customer Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h4 class="text-lg font-semibold text-blue-900 mb-2">Cliente Seleccionado</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-blue-800">Nombre:</span>
                    <span class="text-blue-700">{{ $selectedCustomer->full_name }}</span>
                </div>
                <div>
                    <span class="font-medium text-blue-800">Teléfono:</span>
                    <span class="text-blue-700">{{ $selectedCustomer->phone_number }}</span>
                </div>
                <div>
                    <span class="font-medium text-blue-800">Email:</span>
                    <span class="text-blue-700">{{ $selectedCustomer->email ?: 'No registrado' }}</span>
                </div>
            </div>
        </div>

        <!-- Add Pet Button -->
        <div class="flex justify-end mb-4">
            <button type="button" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors"
                    onclick="openAddPetModal()">
                <i class="fas fa-plus"></i>
                <span>Agregar Nueva Mascota</span>
            </button>
        </div>

        <!-- Pets Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900">
                    Mascotas de {{ $selectedCustomer->full_name }} ({{ $pets->count() }})
                </h4>
            </div>
            
            @if($pets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especie</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raza</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Nacimiento</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso (kg)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pets as $pet)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-semibold text-gray-900">{{ $pet->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pet->species ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pet->breed ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($pet->birth_date)
                                            {{ $pet->birth_date->format('d/m/Y') }}
                                            <span class="text-gray-500">({{ $pet->birth_date->age }} años)</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pet->weight_kg ? number_format($pet->weight_kg, 1) . ' kg' : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                        <button type="button" 
                                                class="text-blue-600 hover:text-blue-900 font-medium"
                                                onclick="editPet('{{ $pet->id }}')">
                                            <i class="fas fa-edit mr-1"></i>Editar
                                        </button>
                                        <button type="button" 
                                                class="text-red-600 hover:text-red-900 font-medium"
                                                onclick="confirmDeletePet('{{ $pet->id }}', '{{ $pet->name }}')">
                                            <i class="fas fa-trash mr-1"></i>Eliminar
                                        </button>
                                    </td>
                                </tr>
                                @if($pet->notes)
                                    <tr class="bg-gray-50">
                                        <td colspan="6" class="px-6 py-2 text-sm text-gray-600">
                                            <strong>Notas:</strong> {{ $pet->notes }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">
                    <i class="fas fa-paw text-4xl mb-4 text-gray-300"></i>
                    <p class="text-lg">Este cliente no tiene mascotas registradas</p>
                    <p class="text-sm">Haz clic en "Agregar Nueva Mascota" para comenzar</p>
                </div>
            @endif
        </div>
    @else
        <!-- No Customer Selected -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
            <i class="fas fa-users text-4xl mb-4 text-gray-400"></i>
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Selecciona un Cliente</h4>
            <p class="text-gray-600">Elige un cliente de la lista desplegable para ver y gestionar sus mascotas</p>
        </div>
    @endif
</div>

<!-- Modal para Agregar/Editar Mascota -->
<div id="petModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h5 id="petModalTitle" class="text-lg font-bold text-gray-900">Agregar Nueva Mascota</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closePetModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="petForm" method="POST">
            @csrf
            <input type="hidden" id="petMethod" name="_method" value="POST">
            <input type="hidden" name="customer_id" value="{{ request('customer_id') }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="petName" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Mascota *</label>
                    <input type="text" id="petName" name="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label for="petSpecies" class="block text-sm font-medium text-gray-700 mb-1">Especie</label>
                    <select id="petSpecies" name="species" class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="">Seleccionar especie...</option>
                        <option value="Perro">Perro</option>
                        <option value="Gato">Gato</option>
                        <option value="Conejo">Conejo</option>
                        <option value="Ave">Ave</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="petBreed" class="block text-sm font-medium text-gray-700 mb-1">Raza</label>
                    <input type="text" id="petBreed" name="breed" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Ej: Golden Retriever">
                </div>
                <div>
                    <label for="petBirthDate" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                    <input type="date" id="petBirthDate" name="birth_date" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="petWeight" class="block text-sm font-medium text-gray-700 mb-1">Peso (kg)</label>
                    <input type="number" id="petWeight" name="weight_kg" step="0.1" min="0" max="999.99" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Ej: 15.5">
                </div>
                <div class="flex items-end">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Completa la información disponible
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="petNotes" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                <textarea id="petNotes" name="notes" class="w-full p-2 border border-gray-300 rounded-lg" rows="3" placeholder="Información adicional sobre la mascota (alergias, comportamiento, etc.)"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400" onclick="closePetModal()">
                    Cancelar
                </button>
                <button type="submit" id="petSubmitBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Agregar Mascota
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Confirmación para Eliminar -->
<div id="deletePetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-lg font-bold text-gray-900">Confirmar Eliminación</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeDeleteModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="mb-4">
            <p class="text-gray-700 mb-2">¿Está seguro que desea eliminar a <strong id="deletePetName"></strong>?</p>
            <p class="text-sm text-red-600 mb-2">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Esta acción no se puede deshacer.
            </p>
            <p class="text-xs text-gray-500">
                Nota: No se puede eliminar una mascota que tenga órdenes de trabajo asociadas.
            </p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400" onclick="closeDeleteModal()">
                Cancelar
            </button>
            <button type="button" id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPetToDelete = null;
let isEditMode = false;
let currentPetId = null;

function openAddPetModal() {
    isEditMode = false;
    document.getElementById('petModalTitle').textContent = 'Agregar Nueva Mascota';
    document.getElementById('petSubmitBtn').textContent = 'Agregar Mascota';
    document.getElementById('petMethod').value = 'POST';
    document.getElementById('petForm').action = '{{ route("pets.store") }}';
    document.getElementById('petModal').classList.remove('hidden');
}

function closePetModal() {
    document.getElementById('petModal').classList.add('hidden');
    document.getElementById('petForm').reset();
    isEditMode = false;
    currentPetId = null;
}

function editPet(petId) {
    isEditMode = true;
    currentPetId = petId;
    
    fetch(`/pets/${petId}`)
        .then(response => response.json())
        .then(pet => {
            document.getElementById('petModalTitle').textContent = 'Editar Mascota';
            document.getElementById('petSubmitBtn').textContent = 'Actualizar Mascota';
            document.getElementById('petMethod').value = 'PUT';
            document.getElementById('petForm').action = `/pets/${petId}`;
            
            document.getElementById('petName').value = pet.name || '';
            document.getElementById('petSpecies').value = pet.species || '';
            document.getElementById('petBreed').value = pet.breed || '';
            document.getElementById('petBirthDate').value = pet.birth_date || '';
            document.getElementById('petWeight').value = pet.weight_kg || '';
            document.getElementById('petNotes').value = pet.notes || '';
            
            document.getElementById('petModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los datos de la mascota');
        });
}

function confirmDeletePet(petId, petName) {
    currentPetToDelete = petId;
    document.getElementById('deletePetName').textContent = petName;
    document.getElementById('deletePetModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deletePetModal').classList.add('hidden');
    currentPetToDelete = null;
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (currentPetToDelete) {
        fetch(`/pets/${currentPetToDelete}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `{{ route('pets.index') }}?customer_id={{ request('customer_id') }}`;
            } else {
                alert('Error: ' + (data.error || 'No se pudo eliminar la mascota'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar la mascota');
        })
        .finally(() => {
            closeDeleteModal();
        });
    }
});

document.addEventListener('click', function(event) {
    const petModal = document.getElementById('petModal');
    const deleteModal = document.getElementById('deletePetModal');
    
    if (event.target === petModal) {
        closePetModal();
    }
    
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('petBirthDate').max = today;
});
</script>
@endpush