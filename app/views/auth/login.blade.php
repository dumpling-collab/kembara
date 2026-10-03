<x-auth-shell tab="login">
    <h1 class="text-3xl font-extrabold leading-tight sm:text-4xl">
        Selamat Datang<br>Kembali,<br>Penjelajah!
    </h1>

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label for="username" class="mb-1.5 block text-sm font-bold">Username</label>
            <input id="username" name="username" value="{{ old('username') }}" class="field rounded-md"
            required autofocus autocomplete="username">
            @error('username') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-bold">Password</label>
            <input id="password" type="password" name="password" class="field rounded-md"
            required autocomplete="current-password">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2 text-center">
            <button class="btn-brand px-10 shadow-soft">Mulai Menjelajah Kembali</button>
        </div>
    </form>

    <div class="my-6 flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-ink-muted">
        <span class="h-px flex-1 bg-slate-200"></span> Atau masuk dengan <span class="h-px flex-1 bg-slate-200"></span>
    </div>

    {{-- Placeholder: aktifkan nanti dengan Laravel Socialite --}}
    <button type="button" disabled title="Segera hadir"
            class="flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white py-3 text-sm font-medium opacity-80">
        <span class="font-extrabold text-[#4285F4]">G</span> Google
    </button>

    <p class="mt-6 text-center text-sm text-ink-muted">
        Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-navy">Daftar di sini</a>
    </p>
</x-auth-shell>