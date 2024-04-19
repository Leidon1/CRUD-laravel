<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="flex justify-between gap-3">
            <!-- Name -->
            <div class="w-full md:w-1/2">
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" class="block mt-1 w-full rounded-full" type="text" name="name"
                              :value="old('name')" autofocus autocomplete="name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            <!-- Last Name -->
            <div class="w-full md:w-1/2">
                <x-input-label for="last_name" :value="__('Last Name')"/>
                <x-text-input id="last_name" class="block mt-1 w-full rounded-full" type="text" name="last_name"
                              :value="old('last_name')" autofocus autocomplete="last name"/>
                <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
            </div>
        </div>

        <div class="flex justify-between gap-3">
            <!-- Username -->
            <div class="mt-4 w-full md:w-1/2 ">
                <x-input-label for="username" :value="__('Username')"/>
                <x-text-input readonly id="username" class="block mt-1 w-full" type="text" name="username"
                              :value="old('username')"
                              autocomplete="username"/>
                <x-input-error :messages="$errors->get('username')" class="mt-2"/>
            </div>

            <!-- Email Address -->
            <div class="mt-4 w-full md:w-1/2 ">
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                              autocomplete="username"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>
        </div>

        <div class="flex justify-between gap-3">

            <!-- Gender -->
            <div class="mt-4 w-full md:w-1/2">
                <x-input-label for="gender" :value="__('Gender')"/>
                <x-select-input id="gender" name="gender" class="block mt-1 w-full rounded-lg">
                    <option value="" disabled selected class="hidden">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="non-binary">Non-binary</option>
                </x-select-input>
            </div>

            <!-- Country -->
            <div class="mt-4 w-full md:w-1/2">
                <x-input-label for="country" :value="__('Country')"/>

                <x-select-input id="country" name="country" class="block mt-1 w-full rounded-lg">
                    <option value="" disabled selected class="hidden">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('country')" class="mt-2"/>
            </div>
        </div>

        <!-- Birthday -->
        <div class="relative mt-4 w-full">
            <x-input-label for="date" :value="__('birthay')"/>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <x-text-input datepicker type="text" id="date" name="birthay"
                              class="block w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500 border border-gray-300 text-gray-900 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              placeholder="Select date" autocomplete="off"/>
            </div>

            <x-input-error :messages="$errors->get('birthay')" class="mt-2"/>
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 rounded-full">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const lastNameInput = document.getElementById('last_name');
            const usernameDisplay = document.getElementById('username');

            function updateUsernameDisplay() {
                const name = nameInput.value.trim();
                const lastName = lastNameInput.value.trim();
                if (name.length > 0 && lastName.length > 0) {
                    let baseUsername = name.toLowerCase() + lastName.charAt(0).toLowerCase();
                    usernameDisplay.value = baseUsername; // Display base username
                }
            }

            // Update the username display as the user types in their name or last name
            nameInput.addEventListener('input', updateUsernameDisplay);
            lastNameInput.addEventListener('input', updateUsernameDisplay);
        });
    </script>


</x-guest-layout>
