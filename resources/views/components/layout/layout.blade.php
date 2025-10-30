<x-layout.header />
<main>

    <x-partials.navbar />
    <x-partials.sidebar />
    <div class="sm:ml-64 mt-16">
        {{ $slot }}
    </div>
</main>
<x-layout.footer />
