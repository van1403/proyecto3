@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Recuperar contraseña</h2>
    @if (session('status'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" class="w-full border p-2 rounded mb-4" required>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enviar enlace</button>
    </form>
</div>
@endsection
