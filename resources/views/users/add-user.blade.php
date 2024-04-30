<form method="POST" id="add-user-form" action="{{ route('users.store') }}">
    @csrf

    <div class="w-full flex justify-between gap-3">
        <!-- Name -->
        <div class="w-full md:w-1/2">
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" class="block mt-1 w-full rounded-full" type="text" name="name"
                          required autofocus autocomplete="name"/>
        </div>

        <!-- Last Name -->
        <div class="w-full md:w-1/2">
            <x-input-label for="last_name" :value="__('Last Name')"/>
            <x-text-input id="last_name" class="block mt-1 w-full rounded-full" type="text" name="last_name"
                          required autofocus autocomplete="last name"/>
        </div>
    </div>

    <div class="flex justify-between gap-3">
        <!-- Username -->
        <div class="mt-4 w-full md:w-1/2 ">
            <x-input-label for="username" :value="__('Username')"/>
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                          required autocomplete="username"/>
            <div id="generated-username" class="text-gray-500"></div>
        </div>

        <!-- Email Address -->
        <div class="mt-4 w-full md:w-1/2 ">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          required autocomplete="email"/>
        </div>
    </div>

    <div class="flex justify-between gap-3">

        <!-- Gender -->
        <div class="mt-4 w-full md:w-1/2">
            <x-input-label for="gender" :value="__('Gender')"/>
            <x-select-input id="gender" name="gender" class="block mt-1 w-full rounded-full">
                <option value="" disabled selected class="hidden">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="non-binary">Non-binary</option>
            </x-select-input>
        </div>
{{--        @php--}}
{{--            $countries = config('global.countries');--}}
{{--        @endphp--}}
        <!-- Country -->
        <div class="mt-4 w-full md:w-1/2">
            <x-input-label for="country" :value="__('Country')"/>

            <x-select-input id="country" name="country" class="block mt-1 w-full rounded-full">
                <option value="" disabled selected class="hidden">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country }}">{{ $country }}</option>
                @endforeach
            </x-select-input>
        </div>
    </div>

    <!-- Birthday -->
    <div class="relative mt-4 w-full">
        <x-input-label for="date" :value="__('Birthday')"/>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                </svg>
            </div>
            <x-text-input datepicker type="text" id="birthday" name="birthday"
                          class="block w-full pl-10 pr-4 py-2.5 rounded-full focus:ring-blue-500 focus:border-blue-500 border border-gray-300 text-gray-900 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                          placeholder="Select date" autocomplete="off"/>
        </div>

    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')"/>
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                      required autocomplete="new-password"/>
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm password')"/>
        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                      name="password_confirmation" required autocomplete="new-password"/>
    </div>


</form>
</form>
