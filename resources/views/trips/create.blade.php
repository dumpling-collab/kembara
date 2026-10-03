<x-layouts.app title="Rencanakan Perjalanan" :bare="true">
    <div class="mx-auto flex max-w-3xl items-center justify-between px-6 pt-8">
        <img src="{{ asset('images/brand/logo.png') }}" alt="Kembara" class="h-10">
        <a href="{{ route('home') }}" class="text-sm font-bold text-ink-muted">✕ Batalkan</a>
    </div>

    <form method="POST" action="{{ route('trips.store') }}"
          class="mx-auto my-12 max-w-2xl space-y-6 rounded-3xl bg-surface p-10 shadow-soft">
        @csrf
        <h1 class="text-4xl font-bold">Rencanakan Perjalanan</h1>

        <div>
            <label class="mb-2 block text-sm font-bold" for="name">Nama Trip</label>
            <input id="name" name="name" value="{{ old('name') }}" class="field" placeholder="Weekend Hangout di Jaksel" required>
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-bold" for="start_date">Tanggal Mulai</label>
                <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}" class="field" required>
                @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold" for="end_date">Tanggal Selesai</label>
                <input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}" class="field" required>
                @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold" for="budget">Estimasi Budget (Total)</label>
            <div class="flex items-center gap-3">
                <span class="font-bold text-ink-muted">Rp</span>
                <input id="budget" type="number" min="0" step="1000" name="budget" value="{{ old('budget') }}" class="field" placeholder="500000" required>
            </div>
            @error('budget') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="text-right">
            <button class="btn-brand">Lanjut Pilih Tempat Destinasi →</button>
        </div>
    </form>
</x-layouts.app>
