<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - SISFO SARPRAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="flex shadow-lg rounded-lg overflow-hidden w-[700px]">
        <!-- Sidebar Lebih Kecil -->
        <div class="w-1/4 bg-blue-900 text-white flex items-center justify-center p-4 font-bold text-lg text-center">
            SISFO<br>SARPRAS
        </div>

        <!-- Main Content Lebih Besar -->
        <div class="w-3/4 bg-white p-8">
            <h2 class="text-2xl font-semibold mb-6">Login</h2>

            <!-- Alert error login -->
            @if (session('status'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                    {{ __('Email atau kata sandi salah.') }}
                </div>
            @endif

            @error('email')
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                    {{ __('Email atau kata sandi salah.') }}
                </div>
            @enderror

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm mb-1">Kata Sandi</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Masuk</button>
                <p class="text-sm mt-4 text-center">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
