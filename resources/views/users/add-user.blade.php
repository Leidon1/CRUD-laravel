<!-- Modal for adding a new user -->
<div id="add-user-modal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            1
        </div>

        <!-- Modal content -->
        <div
            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex flex-row justify-between ">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200"
                        id="modal-title">
                        Add New User
                    </h3>
                    <button type="button" id="close-modal"
                            class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-full items-center text-white bg-red-500 hover:bg-red-800 w-10 h-10">
                        <i class="fa fa-times"></i></button>
                </div>

                <div class="mt-3 text-center sm:mt-0  sm:text-left">

                    <div class="mt-2">
                        <!-- Form fields go here -->
                        <form method="POST" id="add-user-form" action="{{ route('users.store') }}">
                            @csrf

                            <div class="w-full flex justify-between gap-3">
                                <!-- Name -->
                                <div class="w-full md:w-1/2">
                                    <x-input-label for="name" :value="__('Name')"/>
                                    <x-text-input id="name" class="block mt-1 w-full rounded-full" type="text"
                                                  name="name" :value="old('name')"
                                                  autofocus autocomplete="name"/>
                                    <span id="name_error" class="text-red-500 text-xs"></span>
                                </div>

                                <!-- Last Name -->
                                <div class="w-full md:w-1/2">
                                    <x-input-label for="last_name" :value="__('Last Name')"/>
                                    <x-text-input id="last_name" class="block mt-1 w-full rounded-full" type="text"
                                                  name="last_name"
                                                  :value="old('last_name')"
                                                  autofocus autocomplete="last name"/>
                                    <span id="last_name_error" class="text-red-500 text-xs"></span>
                                </div>
                            </div>

                            <div class="flex justify-between gap-3">
                                <!-- Username -->
                                <div class="mt-4 w-full md:w-1/2 ">
                                    <x-input-label for="username" :value="__('Username')"/>
                                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                                                  :value="old('username')"
                                                  autocomplete="username"/>
                                    <div id="generated-username" class="text-gray-500"></div>
                                    <span id="username_error" class="text-red-500 text-xs"></span>
                                </div>

                                <!-- Email Address -->
                                <div class="mt-4 w-full md:w-1/2 ">
                                    <x-input-label for="email" :value="__('Email')"/>
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                                  :value="old('email')"
                                                  autocomplete="email"/>
                                    <span id="email_error" class="text-red-500 text-xs"></span>
                                </div>
                            </div>

                            <div class="flex justify-between gap-3">

                                <!-- Gender -->
                                <div class="mt-4 w-full md:w-1/2">
                                    <x-input-label for="gender" :value="__('Gender')"/>
                                    <x-select-input id="gender" name="gender" class="block mt-1 w-full rounded-full"
                                                    :value="old('gender')">
                                        <option value="" disabled selected class="hidden">Select gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="non-binary">Non-binary</option>
                                    </x-select-input>
                                    <span id="gender_error" class="text-red-500 text-xs"></span>
                                </div>
                                @php
                                    $countries = config('global.countries');
                                @endphp
                                    <!-- Country -->
                                <div class="mt-4 w-full md:w-1/2">
                                    <x-input-label for="country" :value="__('Country')"/>

                                    <x-select-input id="country" name="country" class="block mt-1 w-full rounded-full"
                                                    :value="old('country')">
                                        <option value="" disabled selected class="hidden">Select country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}">{{ $country }}</option>
                                        @endforeach
                                    </x-select-input>
                                    <span id="country_error" class="text-red-500 text-xs"></span>
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
                                                  :value="old('birthday')"
                                                  class="block w-full pl-10 pr-4 py-2.5 rounded-full focus:ring-blue-500 focus:border-blue-500 border border-gray-300 text-gray-900 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                  placeholder="Select date" autocomplete="off"/>
                                </div>
                                <span id="birthday_error" class="text-red-500 text-xs"></span>
                            </div>

                            <!-- Roles -->
                            <div class="flex justify-between gap-3">

                                <!-- Roles -->
                                <div class="mt-4 w-full md:w-1/2">
                                    <x-input-label for="role" :value="__('Role')"/>
                                    <x-select-input id="role" name="role" class="block mt-1 w-full rounded-full"
                                                    :value="old('role')">
                                        <option value="" disabled selected class="hidden">Select role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                        <option value="guest">Guest</option>
                                    </x-select-input>
                                    <span id="roles_error" class="text-red-500 text-xs"></span>
                                </div>

                                <!-- Team roles -->
                                <div class="mt-4 w-full md:w-1/2">
                                    <x-input-label for="sub_roles" :value="__('Team role')"/>
                                    <x-select-input id="sub_roles" name="sub_roles"
                                                    class="block mt-1 w-full rounded-full"
                                                    :value="old('sub_roles')">
                                        <option value="" disabled selected class="hidden">Select team role</option>
                                        <option value="Team Leader">Team leader</option>
                                        <option value="Senior">Senior</option>
                                        <option value="Junior">Junior</option>
                                    </x-select-input>
                                    <span id="sub_roles_error" class="text-red-500 text-xs"></span>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="flex justify-between gap-3">
                                <!-- Password -->
                                <div class="mt-4 w-full">
                                    <x-input-label for="password" :value="__('Password')"/>
                                    <x-text-input id="password" class="block mt-1 w-full" type="password"
                                                  name="password"
                                                  :value="old('password')"
                                                  autocomplete="new-password"/>
                                    <span id="password_error" class="text-red-500 text-xs"></span>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mt-4 w-full">
                                    <x-input-label for="password_confirmation" :value="__('Confirm password')"/>
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                                  :value="old('password_confirmation')"
                                                  name="password_confirmation" autocomplete="new-password"/>
                                    <span id="password_confirmation_error" class="text-red-500 text-xs"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="close-modal-btn"
                        class="w-full items-center inline-flex justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-slate-500 text-base font-medium text-white hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                    <i class="fa fa-times ml-2 text-xs"></i>
                </button>
                <button type="submit" form="add-user-form"
                        class="mt-3 w-full items-center inline-flex justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Save
                    <i class="fa fa-check ml-2 text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('name');
        const lastNameInput = document.getElementById('last_name');
        const usernameInput = document.getElementById('username');
        const generatedUsernameInfo = document.getElementById('generated-username');

        // Generate and display the username initially
        generateUsername();

        // Event listeners for input fields
        nameInput.addEventListener('blur', generateUsername);
        lastNameInput.addEventListener('blur', generateUsername);
        usernameInput.addEventListener('blur', validateUsername);

        // Function to generate the username based on name and last name
        function generateUsername() {
            const name = nameInput.value.trim();
            const lastName = lastNameInput.value.trim();

            if (name.length > 0 && lastName.length > 0) {
                fetch('/generate-username', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({name: name, last_name: lastName}) // Pass name and last name in the request body
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            // Handle error response from the server
                            console.error('Error:', data.error);
                        } else {
                            // Update the username input field with the fetched username
                            usernameInput.value = data.username;
                            generatedUsernameInfo.innerText = "Suggested username: " + data.username;
                        }
                    })
                    .catch(error => {
                        // Handle fetch error
                        console.error('Fetch error:', error);
                    });
            } else {
                usernameInput.value = "";
                generatedUsernameInfo.innerText = "";
            }
        }


        // Function to validate the username
        function validateUsername() {
            const username = usernameInput.value.trim();
            const name = nameInput.value.trim();
            const lastName = lastNameInput.value.trim();

            if (username.length > 0 && name.length > 0 && lastName.length > 0) {
                fetch('/check-username', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({name: name, last_name: lastName, username: username})
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            generatedUsernameInfo.innerText = data.error;
                        } else {
                            generatedUsernameInfo.innerText = username + " is available";
                        }
                    })
                    .catch(error => {
                        generatedUsernameInfo.innerText = "An error occurred while checking the username.";
                        console.error('Error:', error);
                    });
            } else {
                generatedUsernameInfo.innerText = "";
            }
        }
    });

</script>

