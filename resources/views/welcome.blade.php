<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'LocalWeb') }}</title>


    <!-- Fonts -->
    <link rel="icon" type="image/jpg" href="{{ asset('storage/profile-photos/icon/localweb1.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <img id="background" class="absolute opacity-5 -left-20 top-0 max-w-[877px]"
         src="https://laravel.com/assets/img/welcome/background.svg"/>
    <div
        class="relative min-h-screen flex flex-col text-center justify-center items-center selection:bg-[#FF2D20] selection:text-white">
        <div class="">
            <a href="/">
                <x-application-logo class="w-20 h-20 fit-current text-gray-500" />
            </a>
        </div>
        <h1 class="text-gray-300 tracking-widest text-2xl text-center"><span class="rounded-l-3xl px-3 py-2 bg-zinc-800">WELCOME</span> <span  class="px-3 py-2 bg-zinc-800">TO</span> <span  class="rounded-r-3xl px-3 py-2 bg-zinc-800">LOCALWEB</span></h1>

        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

            <header class="gap-2 py-10 ">

                @if (Route::has('login'))
                    <nav class="gap-3 flex justify-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-2  transition duration-300 hover:text-black/50 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/50 dark:hover:tracking-widest dark:focus-visible:ring-white transform hover:scale-105">
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="rounded-l-3xl tracking-widest bg-zinc-800 px-3 py-2 text-black transition hover:text-black/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white dark:text-white dark:hover:text-white/50 dark:hover:bg-zinc-700"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="rounded-r-3xl tracking-widest bg-zinc-800 px-3 py-2 text-black transition hover:text-black/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white dark:text-white dark:hover:text-white/50 dark:hover:bg-zinc-700"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

        </div>
    </div>
</div>
</body>
</html>
