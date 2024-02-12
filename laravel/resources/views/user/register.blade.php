<!-- resources/views/auth/register.blade.php -->
<form method="POST" action="{{ route('register') }}">
    @csrf
    <!-- Campos de formulario: nombre, email, password, confirmación de password -->
    <button type="submit">Register</button>
</form>
