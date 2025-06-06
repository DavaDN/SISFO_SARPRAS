<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - SISFO SARPRAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="flex shadow-lg rounded-lg overflow-hidden w-[750px]">
        <!-- Sidebar kecil -->
        <div class="w-1/4 bg-blue-900 text-white flex items-center justify-center p-4 font-bold text-lg">
            SISFO<br>SARPRAS
        </div>

        <!-- Konten utama lebih besar -->
        <div class="w-3/4 bg-white p-8">
            <h2 class="text-2xl font-semibold mb-6">Register</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm mb-1">Nama</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Password</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Register</button>
                <p class="text-sm mt-4 text-center">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
