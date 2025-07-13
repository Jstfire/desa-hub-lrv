@props(['kategori', 'q', 'kategoriBerita'])

<form action="{{ route('desa.berita', ['uri' => request()->route('uri')]) }}" method="GET">
    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <div class="relative flex-grow">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari berita..."
                class="w-full pl-10 pr-4 py-2 border rounded-lg bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <div class="relative">
            <select name="kategori" onchange="this.form.submit()"
                class="w-full md:w-48 appearance-none pl-4 pr-10 py-2 border rounded-lg bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">Semua Kategori</option>
                @foreach ($kategoriBerita as $item)
                    <option value="{{ $item->kategori }}" @if ($kategori == $item->kategori) selected @endif>
                        {{ ucfirst($item->kategori) }}
                    </option>
                @endforeach
            </select>
            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
        <button type="submit"
            class="bg-primary text-primary-foreground px-6 py-2 rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">Cari</button>
    </div>
</form>