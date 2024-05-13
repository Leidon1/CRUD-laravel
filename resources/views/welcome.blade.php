<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'LocalWeb') }}</title>


    <!-- Fonts -->
    <link rel="icon" type="image/jpg" href="{{ asset('storage/profile-photos/default/localweb1.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black  dark:text-white/50">
    <img id="background" class="absolute object-cover top-0  opacity-30"
         src="storage/profile-photos/default/1.jpg"/>
    <div
        class="relative min-h-screen flex flex-col text-center justify-center items-center selection:bg-[#FF2D20] selection:text-white">
        <div class="transition duration-300 w-24 h-24 mb-4 transform hover:scale-125">
            <a href="/">
                <x-application-logo class="w-24 h-24 text-gray-500 shadow-black bg-black bg-opacity-40 shadow-2xl rounded-l-full px-3 py-2 text-black ring-4 hover:text-black/50 focus:outline-none focus-visible:ring-white dark:focus-visible:ring-white dark:text-white/50 dark:hover:text-white dark:hover:tracking-widest dark:focus-visible:ring-white" />
            </a>
        </div>
        <h1 class="flex flex-col justify-center items-center md:flex-row text-gray-300 tracking-widest text-3xl font-bold text-center shadow-black shadow-2xl bg-opacity-40"><span class="rounded-l-3xl px-3 py-2 bg-black/20">WELCOME</span> <span  class="px-3 py-2 bg-black/20">TO</span> <span  class="rounded-r-3xl px-3 py-2 bg-black/20">LOCALWEB</span></h1>

        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

            <header class="gap-2 py-10 ">

                @if (Route::has('login'))
                    <nav class="gap-3 flex justify-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="shadow-black shadow-2xl bg-black bg-opacity-40 rounded-full px-3 py-2 text-black ring-4  transition duration-300 hover:text-black/50 focus:outline-none focus-visible:ring-white dark:focus-visible:ring-white dark:text-white/50  dark:hover:text-white dark:hover:tracking-widest dark:focus-visible:ring-white transform hover:scale-105">
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="shadow-black bg-black bg-opacity-40 shadow-2xl rounded-l-full px-3 py-2 text-black ring-4  transition duration-300 hover:text-black/50 focus:outline-none focus-visible:ring-white dark:focus-visible:ring-white dark:text-white/50  dark:hover:text-white dark:hover:tracking-widest dark:focus-visible:ring-white transform hover:scale-105"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="shadow-black bg-black bg-opacity-40 shadow-2xl rounded-r-full px-3 py-2 text-black ring-4  transition duration-300 hover:text-black/50 focus:outline-none focus-visible:ring-white dark:focus-visible:ring-white dark:text-white/50  dark:hover:text-white dark:hover:tracking-widest dark:focus-visible:ring-white transform hover:scale-105"
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
