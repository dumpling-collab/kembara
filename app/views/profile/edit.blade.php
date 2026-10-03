<x-layouts.app :bare="true">
    <div class="min-h-screen bg-[#dfeaf3] px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl">
            <div class="mb-6 flex items-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-navy/80 shadow-sm ring-1 ring-[#d5dfe9] transition hover:bg-slate-50">
                    <span aria-hidden="true">←</span>
                    Kembali
                </a>
            </div>

            <h1 class="text-[2.6rem] font-black leading-none tracking-[-0.06em] text-navy/80 sm:text-[4rem]">Account Settings</h1>
            <p class="mt-3 text-lg text-navy/80">Kelola profil, preferensi, dan keamanan Anda.</p>

            <div class="mt-8 grid gap-8 lg:grid-cols-[220px_minmax(0,1fr)]">
                <aside class="relative overflow-hidden rounded-4xl bg-white px-3 py-4 shadow-[0_18px_40px_rgba(24,49,120,0.08)] ring-1 ring-[#F2F2F2]">
                    <div class="flex items-center justify-center">
                        <div class="flex h-24 w-24 items-center justify-center rounded-full bg-[#ececec] ring-6 ring-[#f6f6f6]">
                            <div class="flex h-[3.7rem] w-[3.7rem] items-center justify-center rounded-[1.2rem] bg-white ring-1 ring-[#edf0f3]">
                                <img src="{{ asset('images/brand/bara.png') }}" alt="Bara" class="h-12 w-12 object-contain">
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <h2 class="text-[1.7rem] font-black leading-none text-navy/80">{{ auth()->user()->username ?? auth()->user()->name }}</h2>
                        <p class="mt-2 text-base font-medium text-navy/80">Kembara Explorer</p>
                    </div>
                </aside>

                <div class="space-y-7">
                    <section class="rounded-4xl bg-white/75 p-7 shadow-[0_18px_40px_rgba(24,49,120,0.08)] ring-1 ring-[#dfe7ee] backdrop-blur-sm">
                        <h2 class="text-[2.1rem] font-black leading-none text-navy/80">Edit Profile</h2>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-7 space-y-5">
                            @csrf
                            @method('patch')

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label for="username" class="mb-2 block text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#5d6984]">Username</label>
                                    <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" class="w-full rounded-xl border border-[#dfe7ee] bg-[#f5f7fa] px-4 py-3 text-base text-navy/80 placeholder:text-[#8c98ad] focus:border-navy/80 focus:outline-none focus:ring-2 focus:ring-navy/10" required>
                                    @error('username')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="city" class="mb-2 block text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#5d6984]">City</label>
                                    <input id="city" name="city" type="text" value="{{ old('city', $user->city ?? '') }}" class="w-full rounded-xl border border-[#dfe7ee] bg-[#f5f7fa] px-4 py-3 text-base text-navy/80 placeholder:text-[#8c98ad] focus:border-navy/80 focus:outline-none focus:ring-2 focus:ring-navy/10" placeholder="Jakarta">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="mb-2 block text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#5d6984]">Email Address</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border border-[#dfe7ee] bg-[#f5f7fa] px-4 py-3 text-base text-navy/80 placeholder:text-[#8c98ad] focus:border-navy/80 focus:outline-none focus:ring-2 focus:ring-navy/10" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="mb-2 block text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#5d6984]">Phone Number</label>
                                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone ?? '') }}" class="w-full rounded-xl border border-[#dfe7ee] bg-[#f5f7fa] px-4 py-3 text-base text-navy/80 placeholder:text-[#8c98ad] focus:border-navy/80 focus:outline-none focus:ring-2 focus:ring-navy/10" placeholder="081234567890">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="bio" class="mb-2 block text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#5d6984]">Bio</label>
                                    <textarea id="bio" name="bio" rows="4" class="w-full rounded-xl border border-[#dfe7ee] bg-[#f5f7fa] px-4 py-3 text-base text-navy/80 placeholder:text-[#8c98ad] focus:border-navy/80 focus:outline-none focus:ring-2 focus:ring-navy/10" placeholder="Namaku ...">{{ old('bio', $user->bio ?? '') }}</textarea>
                                    @error('bio')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-navy/80 px-7 py-3 text-base font-bold text-white shadow-[0_10px_25px_rgba(24,49,120,0.25)] transition hover:opacity-95">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </section>

                    <section class="rounded-4xl bg-white/75 p-7 shadow-[0_18px_40px_rgba(24,49,120,0.08)] ring-1 ring-[#dfe7ee] backdrop-blur-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-[2.1rem] font-black leading-none text-navy/80">Metode Pembayaran</h3>
                            <button type="button" class="inline-flex items-center gap-2 rounded-full border border-[#1fae74] bg-[#e8fff5] px-4 py-2 text-sm font-semibold text-[#1fae74] transition hover:bg-[#ddf9ee]">
                                <span class="text-lg leading-none">+</span>
                                Add Payment
                            </button>
                        </div>

                        <div class="mt-5 rounded-2xl border border-dashed border-[#dfe7ee] bg-[#f5f7fa] p-6 text-center text-sm text-[#65758d]">
                            Tambahkan metode pembayaran mu
                        </div>
                    </section>

                    <section class="rounded-4xl bg-white/75 p-7 shadow-[0_18px_40px_rgba(24,49,120,0.08)] ring-1 ring-[#dfe7ee] backdrop-blur-sm">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="text-[2.1rem] font-black leading-none text-navy/80">Keamanan Akun</h3>
                        </div>

                        <div class="mt-6 grid gap-5 lg:grid-cols-[1fr_auto] lg:items-center">
                            <div>
                                <p class="text-lg font-bold text-navy/80">Change Password</p>
                                <p class="mt-1 text-sm text-[#607090]">Current Password</p>
                            </div>

                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="peer sr-only" checked>
                                <div class="relative h-6 w-11 rounded-full bg-[#1fae74] after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all peer-checked:after:translate-x-5"></div>
                                <span class="ml-3 text-sm font-semibold text-navy/80">Two-Factor Authentication</span>
                            </label>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-4">
                            @csrf
                            @method('put')

                            <div>
                                <label for="current_password" class="mb-2 block text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#5d6984]">Current Password</label>
                                <input id="current_password" name="current_password" type="password" class="w-full rounded-xl border border-[#dfe7ee] bg-[#f5f7fa] px-4 py-3 text-base text-navy/80 focus:border-navy/80 focus:outline-none focus:ring-2 focus:ring-navy/10" required>
                            </div>

                            <div>
                                <label for="password" class="mb-2 block text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#5d6984]">New Password</label>
                                <input id="password" name="password" type="password" class="w-full rounded-xl border border-[#dfe7ee] bg-[#f5f7fa] px-4 py-3 text-base text-navy/80 focus:border-navy/80 focus:outline-none focus:ring-2 focus:ring-navy/10" required>
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-2 block text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#5d6984]">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-xl border border-[#dfe7ee] bg-[#f5f7fa] px-4 py-3 text-base text-navy/80 focus:border-navy/80 focus:outline-none focus:ring-2 focus:ring-navy/10" required>
                            </div>

                            <div class="flex justify-start pt-2">
                                <button type="submit" class="rounded-xl bg-[#e7ebf2] px-5 py-3 text-sm font-bold text-navy/80 transition hover:bg-[#dfe7f1]">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="mt-10 flex justify-center pb-5">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-[#d74a64] bg-white px-6 py-3 text-base font-bold text-[#d74a64] shadow-sm transition hover:bg-red-50">
                        <span aria-hidden="true">↪</span>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
