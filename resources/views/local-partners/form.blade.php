<x-layouts.app title="Ajukan Kerja Sama">
    <div class="mx-auto max-w-xl px-6 py-12">
        <a href="{{ route('local-partners.index') }}" class="text-sm font-bold text-navy">← Kembali</a>

        @if (session('status'))
            <p class="mt-4 rounded-xl bg-emerald-100 px-4 py-3 text-sm font-bold text-emerald-700">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('local-partners.store') }}"
              class="mt-6 space-y-5 rounded-[28px] bg-navy p-8 text-white shadow-soft sm:p-10">
            @csrf

            <div>
                <h1 class="text-2xl font-extrabold">Formulir Pengajuan Mitra UMKM</h1>
                <p class="mt-1 text-sm text-white/70">Isi data usahamu, tim Kembara akan meninjau pengajuanmu.</p>
            </div>

            @php
                $field = fn ($name) => old($name);
            @endphp

            <div>
                <label class="mb-1.5 block text-sm font-bold">Nama Usaha</label>
                <input name="business_name" value="{{ $field('business_name') }}" class="field text-navy!" required>
                @error('business_name') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-bold">Nama Pemilik / PIC</label>
                <input name="owner_name" value="{{ $field('owner_name') }}" class="field text-navy!" required>
                @error('owner_name') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-bold">Nomor WhatsApp</label>
                    <input name="whatsapp" value="{{ $field('whatsapp') }}" placeholder="08xxxxxxxxxx" class="field text-navy!" required>
                    @error('whatsapp') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-bold">Email</label>
                    <input type="email" name="email" value="{{ $field('email') }}" class="field text-navy!" required>
                    @error('email') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-bold">Kategori Usaha</label>
                <select name="category" class="field text-navy!" required>
                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-bold">Lokasi Usaha</label>
                <input name="location" value="{{ $field('location') }}" placeholder="Alamat lengkap usahamu" class="field text-navy!" required>
                @error('location') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-bold">Produk yang Ditawarkan</label>
                <textarea name="products" rows="2" class="field text-navy!" required>{{ $field('products') }}</textarea>
                @error('products') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-bold">Instagram / Website / Link Bisnis <span class="font-normal text-white/60">(opsional)</span></label>
                <input name="social_link" value="{{ $field('social_link') }}" placeholder="https://instagram.com/..." class="field text-navy!">
                @error('social_link') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-bold">Ceritakan Singkat Tentang Bisnis/Usahamu</label>
                <textarea name="description" rows="4" class="field text-navy!" required>{{ $field('description') }}</textarea>
                @error('description') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-brand w-full justify-center py-3!">Kirim Pengajuan Kerja Sama →</button>
        </form>
    </div>
</x-layouts.app>
