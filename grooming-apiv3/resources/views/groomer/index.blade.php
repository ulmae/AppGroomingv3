@extends('layouts.app')

@section('title', 'Cola de Espera - Groomer')

@section('content')

<div class="space-y-4">
    @forelse($workOrders as $index => $order)
        <div class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow"
             onclick="window.location.href='{{ route('groomer.show', $order->id) }}'">
            <div class="flex">
                <div class="w-16 bg-purple-100 flex items-center justify-center">
                    <span class="text-2xl font-bold text-purple-600">{{ $index + 1 }}</span>
                </div>
                
                <div class="flex-1 p-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $order->pet->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $order->servicesList }}</p>
                        </div>
                        
                        <div class="w-16 h-16 ml-4">
                            <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-paw text-gray-400 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center mt-2">
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $order->statusClass }}">
                            {{ $order->statusDisplay }}
                        </span>
                        
                        @if($order->estimated_ready)
                            <span class="text-xs text-gray-500">
                                Est: {{ $order->estimated_ready->format('H:i') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No hay órdenes pendientes</h3>
            <p class="text-gray-500">Todas las órdenes han sido completadas</p>
        </div>
    @endforelse
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f3f4f6;
    }
</style>
@endpush