@extends('layouts.app')

@section('content')
<div class="container py-10">
    <h2 class="text-2xl font-bold text-blue-800 mb-4">Manajemen User Mobile</h2>
    <a href="{{ route('user.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah User</a>

    <table class="w-full mt-4 table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td class="p-2 border">{{ $user->name }}</td>
                <td class="p-2 border">{{ $user->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
