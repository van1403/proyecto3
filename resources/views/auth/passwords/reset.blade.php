@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Restablecer contraseña</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label>Email:</label>
        <input type="email" name="email" class="w-full border p-2 rounded mb-4" required>
        <label>Nueva contraseña:</label>
        <input type="password" name="password" class="w-full border p-2 rounded mb-4" required>
        <label>Confirmar contraseña:</label>
        <input type="password" name="password_confirmation" class="w-full border p-2 rounded mb-4" required>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Actualizar contraseña</button>
    </form>
</div>
@endsection
