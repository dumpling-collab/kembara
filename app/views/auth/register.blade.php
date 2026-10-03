<x-auth-shell tab="register">
    <h1 class="text-3xl font-extrabold leading-tight sm:text-4xl">
        Mulai Petualanganmu<br>dengan<br><span class="text-brand">Kembara!</span>
    </h1>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label for="username" class="mb-1.5 block text-sm font-bold">Username</label>
            <input id="username" name="username" value="{{ old('username') }}" class="field rounded-md"
            required autofocus autocomplete="username">
            @error('username') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="mb-1.5 block text-sm font-bold">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="field rounded-md"
            required autocomplete="email">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-bold">Password</label>
            <input id="password" type="password" name="password" class="field rounded-md"
                   required autocomplete="new-password">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2 text-center">
            <button class="btn-brand px-10 shadow-soft">Mulai Menjelajah</button>
        </div>
    </form>

    <p class="mt-8 text-center text-sm text-ink-muted">
        Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-navy">Masuk Disini!</a>
    </p>
</x-auth-shell>