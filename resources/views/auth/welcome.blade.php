<x-layout-guest pageTitle="WelCome!">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">
{{--         logo         --}}
                <div class="text-center mb-5">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" width="200px">
                </div>
{{--          Welcome message        --}}
                <div class="card p-5 text-center">
                    <p>Welcome, <strong>{{ $user->name }}</strong>!</p>
                    <p>Yout account has been successfully created.</p>
                    <p>You can now <a href="{{ route('login') }}">Login</a> to your account.</p>
                </div>
            </div>
        </div>
    </div>

</x-layout-guest>
