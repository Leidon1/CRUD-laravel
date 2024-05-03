<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row space-x-2 items-center justify-start">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Users table') }}
            </h2>
            <button type="button" id="add-user-btn"
                    class=" inline-flex justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-slate-500 text-base font-medium text-white hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:ml-3 sm:w-auto sm:text-sm">
                Add
                user
            </button>
        </div>
    </x-slot>

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
                            <form id="add-user-form">
                                <!-- Form fields go here -->
                            @include('users.add-user')
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="close-modal-btn"
                            class="w-full inline-flex justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-slate-500 text-base font-medium text-white hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                    <button type="submit" form="add-user-form"
                            class="mt-3 w-full inline-flex justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Add User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="example" class="display overflow-x-scroll" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Birthday</th>
                            <th>Country</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Profile Photo</th>
                            <th>Last Login</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "processing": true,
            "scrollX": true,
            "data": {!! $users !!},
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "last_name"},
                {"data": "username"},
                {"data": "email"},
                {"data": "birthday"},
                {"data": "country"},
                {"data": "role"},
                {"data": "created_at"},
                {"data": "profile_photo"},
                {"data": "last_login"},
            ],

        });
        $('')

        $('#add-user-form').submit(function (event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('users.store') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        $('#add-user-form')[0].reset();
                        $('#add-user-modal').addClass('hidden');
                        // Append the new user data to the DataTable
                        $('#example').DataTable().row.add({
                            "id": response.user.id,
                            "name": response.user.name,
                            "last_name": response.user.last_name,
                            "username": response.user.username,
                            "email": response.user.email,
                            "birthday": response.user.birthday,
                            "country": response.user.country,
                            "role": response.user.role,
                            "created_at": response.user.created_at,
                            "profile_photo": response.user.profile_photo,
                        }).draw(false);

                        Toastify({
                            text: "User added successfully!",
                            duration: 3000, // Display duration in milliseconds
                            gravity: "top", // Display position
                            position: 'center', // Toast position
                            style: {
                                background: 'linear-gradient(to right, #00b09b, #96c93d)',
                                borderRadius: '50px'
                            }
                        }).showToast();
                    } else {
                        $.each(response.errors, function (key, value) {
                            console.log(response.errors);
                            $('#' + key + '_error').text(value[0]);
                        });
                        Toastify({
                            text: 'Failed to register. Please check your inputs and try again.',
                            duration: 3000,
                            close: true,
                            gravity: 'bottom',
                            position: 'center',
                            style: {
                                background: 'linear-gradient(to right, red, #ffc371)', // Set the background color
                                borderRadius: '50px' // Set the border radius
                            }
                        }).showToast();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message
                    Toastify({
                        text: "An error occurred. Please try again.",
                        duration: 3000,
                        gravity: "top",
                        position: 'center',
                        backgroundColor: "#dc3545",
                    }).showToast();
                }
            });
        });
        $('#add-user-btn').click(function () {
            $('#add-user-modal').removeClass('hidden');
        });

        $('#close-modal-btn').click(function () {
            $('#add-user-modal').addClass('hidden');
        });
        $('#close-modal').click(function () {
            $('#add-user-modal').addClass('hidden');
        });
    });
</script>
