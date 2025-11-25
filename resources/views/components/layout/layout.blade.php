<x-layout.header />
<main>

    <x-partials.navbar />
    <x-partials.sidebar />
    <div class="px-4 mt-20">
        {{ $slot }}
    </div>
</main>
<x-layout.footer />
