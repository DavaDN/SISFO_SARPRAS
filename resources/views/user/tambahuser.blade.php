@extends('layouts.app')

@section('content')
<div class="container py-10">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">Tambah User Mobile</h1>

    <form action="{{ route('user.store') }}" method="POST" class="max-w-md space-y-4">
        @csrf
        <div>
            <label class="block mb-1 text-gray-700">Nama</label>
            <input name="name" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div>
            <label class="block mb-1 text-gray-700">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div>
            <label class="block mb-1 text-gray-700">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded" required>
        </div>
        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
