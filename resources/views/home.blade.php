<x-layout-app pageTitle="home">
    <div class="d-flex justify-content-center">
        <p class="text-center display-6 my-5 p-5 border border-primary rounded-4 shadow-sm"><i class="fa-solid fa-gear me-3"></i>RH MANGNT LAYOUT</p>
    </div>

    @php
        dump(auth()->user()->toArray())
    @endphp
</x-layout-app>
