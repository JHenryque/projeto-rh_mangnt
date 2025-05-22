<x-layout-app pageTitle="home">
    <div class="d-flex pt-2">

        <div class="m-3 p-3">
            <h1>Dashboard</h1>
            <p>Welcome to the dashboard.</p>
        </div>

    @can('admin')
        <div class="text-center mt-5">O usuário que está logado e Admin</div>
    @else
        <div class="d-flex justify-content-center">
            <p class="text-center display-6 my-5 p-5 border border-primary rounded-4 shadow-sm"><i class="fa-solid fa-gear me-3"></i>RH MANGNT LAYOUT</p>
        </div>
    @endcan
    </div>



</x-layout-app>
