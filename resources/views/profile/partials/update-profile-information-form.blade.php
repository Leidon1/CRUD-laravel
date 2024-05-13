<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <div class="flex flex-col md:flex-row gap-5 mt-6">
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"
              class="mt-6 w-full space-y-6 flex flex-col md:flex-row gap-5 mt-6">
            @csrf
            @method('patch')
            <input type="file" id="profile_photo_input" name="profile_photo" style="display: none">

            <div class="w-full space-y-3 flex flex-col justify-center align-middle">
                <div class="flex flex-row w-full gap-5">
                    <div class="w-full">
                        <x-input-label for="name" :value="__('Name')"/>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                      :value="old('name', $user->name)"
                                      required autofocus autocomplete="name"/>
                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                    </div>
                    <div class="w-full">
                        <x-input-label for="last_name" :value="__('Last name')"/>
                        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                                      :value="old('last_name', $user->last_name)" required autofocus
                                      autocomplete="last_name"/>
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
                    </div>
                </div>

                <div class="flex flex-row w-full gap-5">
                    <div class="w-full">
                        <x-input-label for="gender" :value="__('Gender')"/>
                        <x-select-input id="gender" name="gender" class="block mt-1 w-full rounded-full">
                            <option value="" disabled class="hidden">Select Gender</option>
                            <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>
                                Female
                            </option>
                            <option
                                value="non-binary" {{ old('gender', $user->gender) === 'non-binary' ? 'selected' : '' }}>
                                Non-binary
                            </option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2"/>
                    </div>
                    <div class="w-full">
                        <x-input-label for="country" :value="__('Country')"/>
                        <x-select-input id="country" name="country" class="block mt-1 w-full rounded-full">
                            <option value="" disabled class="hidden">Select Country</option>
                            @foreach ($countries as $country)
                                <option
                                    value="{{ $country }}" {{ old('country', $user->country) === $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('country')" class="mt-2"/>
                    </div>
                </div>

                <div class="w-full">
                    <x-input-label for="date" :value="__('Birthday')"/>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <x-text-input datepicker type="text" id="date" name="birthday"
                                      :value="$user->birthday->format('m-d-Y')"
                                      class="mt-1 block w-full pl-10 pr-4 py-2.5 rounded-full focus:ring-blue-500 focus:border-blue-500 border border-gray-300 text-gray-900 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Select date" autocomplete="off"/>
                    </div>

                    <x-input-error :messages="$errors->get('birthday')" class="mt-2"/>
                </div>


                <div>
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                  :value="old('email', $user->email)" required autocomplete="username"/>
                    <x-input-error class="mt-2" :messages="$errors->get('email')"/>

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification"
                                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="flex items-center gap-4 mt-5">
                    <x-primary-button id="submit-btn">{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Saved.') }}</p>
                    @endif

                </div>
            </div>
            <div class="w-full lg:w-1/2 mt-6">
                <!-- Hidden input element for selecting profile photo -->


                <!-- Profile photo display -->
                <img src="{{ asset( $user->profile_photo) }}" alt="{{ asset($user->name) }}'s photo"
                     class="w-full h-96 md:h-5/6 rounded-t-3xl cursor-pointer object-cover" id="profile-photo">
                <!-- Button to trigger profile photo selection -->
                <button id="change-photo-btn" type="button"
                        class="bg-slate-500 w-full hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-b-3xl">
                    Change profile photo
                </button>
            </div>
        </form>

        <div class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-75 z-50">
            <div class="relative w-full max-w-3xl">
                <button type="button" class="absolute top-4 right-4 text-white/50 hover:text-white">
                    <i class="fa fa-times"></i>
                </button>
                <img src="{{ asset($user->profile_photo) }}" class="object-cover rounded-2xl w-full" alt="{{ asset($user->name) }}'s photo">
            </div>
        </div>
    </div>

</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('change-photo-btn').addEventListener('click', function () {
            document.getElementById('profile_photo_input').click();
        });

        document.getElementById('profile_photo_input').addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.querySelector('.w-full img').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
        function openPhoto(){
            document.querySelector('.fixed.inset-0').classList.remove('hidden');
        }
        function closePhoto(){
            document.querySelector('.fixed.inset-0').classList.add('hidden');
        }
        // Add click event listener to the profile photo
        document.getElementById('profile-photo').addEventListener('click', function () {
            openPhoto();
        });

        // Add click event listener to the close button
        document.querySelector('.fixed.inset-0 button').addEventListener('click', function () {
            closePhoto();
        });
        document.querySelector('.fixed.inset-0').addEventListener('click', function (event) {
            // Check if the click target is the overlay itself
            if (event.target === this) {
                closePhoto();
            }
        });
    });
</script>

