@props(['tab' => 'login'])

<x-layouts.app :title="$tab === 'login' ? 'Login' : 'Sign Up'" :bare="true">
    <div class="grid min-h-screen overflow-hidden lg:h-screen lg:grid-cols-[minmax(340px,44%)_1fr]">

        {{-- Kiri: dua foto ditumpuk, foto bawah terpotong tepi layar --}}
        <div class="relative hidden lg:block">
            <img src="{{ asset('images/places/kota-tua.jpg') }}" alt="Kota Tua"
                class="absolute left-[8%] top-[5%] h-[52%] w-[62%] rotate-6 rounded-[28px] object-cover shadow-soft">
            <img src="{{ asset('images/places/monas.jpg') }}" alt="Monas"
                class="absolute left-[14%] top-[62%] h-[52%] w-[62%] -rotate-4 rounded-[28px] object-cover shadow-soft">
        </div>

        {{-- Kanan: kartu form melayang --}}
        <div class="flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-xl rounded-[28px] border border-white bg-white/70 p-8 shadow-soft backdrop-blur sm:p-12">
                <div class="mx-auto mb-8 flex w-fit rounded-full bg-navy p-1 text-sm font-bold shadow-soft">
                    <a href="{{ route('login') }}"
                    class="rounded-full px-8 py-2 {{ $tab === 'login' ? 'bg-white text-navy' : 'text-white' }}">Login</a>
                    <a href="{{ route('register') }}"
                    class="rounded-full px-8 py-2 {{ $tab === 'register' ? 'bg-white text-navy' : 'text-white' }}">Sign up</a>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</x-layouts.app>