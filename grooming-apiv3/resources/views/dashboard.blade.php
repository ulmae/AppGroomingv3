<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tu Veterinaria</title>
</head>
<body>
    <div style="padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1>Tu Veterinaria Dashboard</h1>
            
            <div>
                <span>Bienvenido, {{ Auth::user()->full_name }} ({{ ucfirst(Auth::user()->role) }})</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 15px;">
                    @csrf
                    <button 
                        type="submit" 
                        style="padding: 5px 10px; background-color: #dc3545; color: white; border: none; cursor: pointer;"
                    >
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
        
        <div style="padding: 20px; background-color: #f8f9fa; border: 1px solid #dee2e6;">
            <p>¡Bienvenido al sistema de gestión de tu veterinaria!</p>
            <p>Aquí podrás gestionar las citas, clientes y servicios de grooming.</p>
        </div>
    </div>
</body>
</html>