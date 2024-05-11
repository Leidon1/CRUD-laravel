<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row space-x-2 items-center justify-start">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Users table') }}
            </h2>
            @can('view-button')
                <button type="button" id="add-user-btn"
                        class=" inline-flex items-center justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-slate-500 text-base font-medium text-white hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Add
                    user
                    <i class="fa fa-user-plus ml-1 text-xs"></i>
                </button>
            @endcan
        </div>
    </x-slot>

    @include('users.add-user')
    @include('users.edit-user')
    @include('users.delete-user')
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
                            <th>Profile Photo</th>
                            <th>Email</th>
                            <th>Birthday</th>
                            <th>Country</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Last Login</th>
                            @can('view-button')
                                <th>Actions</th>
                            @endcan
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
        var $dataTable = $('#example');
        var userCanViewButton = {{ auth()->user()->can('view-button') ? 'true' : 'false' }};
        $dataTable.DataTable({
            "processing": true,
            "scrollX": true,
            "data": {!!  $users->toJson() !!},
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "last_name"},
                {"data": "username"},
                {
                    "data": "profile_photo",
                    "render": function (data, type, row) {
                        // Assuming profile_photo contains the URL of the photo
                        return '<img src="' + data + '" alt="Profile Photo" style="width: 70px; height: 70px;" class="rounded-xl object-cover">';
                    }
                },
                {"data": "email"},
                {"data": "birthday"},
                {"data": "country"},
                {
                    "data": "role",
                    "render": function (data, type, row) {
                        switch (data) {
                            case 0:
                                return 'User';
                            case 1:
                                return 'Moderator';
                            case 2:
                                return 'Admin';
                            default:
                                return 'Unknown Role';
                        }
                    }
                },
                {"data": "created_at"},
                {"data": "last_login"},
                    @can('view-button')
                {
                    "data": null,
                    "render": function (data, type, row) {
                        var buttonsHtml = '<div class="flex flex-col gap-2">';

                        // Add buttons HTML only if user is an admin
                        buttonsHtml += '<button class="edit-user-btn bg-orange-500 text-white rounded-full px-2 py-1 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 w-full items-center" data-id="' + row.id + '">Edit<i class="fa fa-user-pen ml-1 text-xs"></i></button>';
                        buttonsHtml += '<button class="delete-user-btn bg-red-600 text-white rounded-full px-2 py-1 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 items-center w-full" data-id="' + row.id + '">Delete<i class="fa fa-trash ml-0.5 text-xs"></i></button>';

                        buttonsHtml += '</div>';

                        return buttonsHtml;
                    }
                },
                @endcan

            ],

        });


        // Delete user button click handler
        $dataTable.on('click', '.delete-user-btn', function () {
            var userId = $(this).data('id');
            // Show the delete confirmation modal
            $('#delete-user-modal').removeClass('hidden').attr('data-user-id', userId);
        });

        $('#cancel-delete-btn').click(function () {
            $('#delete-user-modal').addClass('hidden');
        });

        $('#delete-close-modal').click(function () {
            $('#delete-user-modal').addClass('hidden');
        })

        $('#confirm-delete-btn').click(function () {
            var userId = $('#delete-user-modal').attr('data-user-id');

            // Perform the delete operation via AJAX
            $.ajax({
                url: "/users/" + userId + "/delete",
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        // Close the delete confirmation modal
                        $('#delete-user-modal').addClass('hidden');

                        // Remove the deleted user row from the DataTable
                        var table = $('#example').DataTable();
                        var rowIndex;
                        table.rows().every(function (index) {
                            var rowData = this.data();
                            if (rowData.id == userId) {
                                rowIndex = index;
                                return false; // Stop iterating once the row is found
                            }
                        });

                        // Check if the rowIndex is found
                        if (rowIndex !== undefined) {
                            // Remove the row from the DataTable
                            table.row(rowIndex).remove().draw(false);
                        } else {
                            // Row not found, handle the error
                            console.error('Row with user ID ' + userId + ' not found in the DataTable.');
                        }

                        // Show success message
                        Toastify({
                            text: "User deleted successfully!",
                            duration: 3000,
                            gravity: "top",
                            position: 'center',
                            style: {
                                background: 'linear-gradient(to right, #00b09b, #96c93d)',
                                borderRadius: '50px'
                            }
                        }).showToast();
                    } else {
                        // Show error message
                        Toastify({
                            text: 'Failed to delete user. Please try again.',
                            duration: 3000,
                            close: true,
                            gravity: 'bottom',
                            position: 'center',
                            style: {
                                background: 'linear-gradient(to right, red, #ffc371)',
                                borderRadius: '50px'
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


        $('#add-user-form').submit(function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var birthday = $('#birthday').val();
            var formattedBirthday = formatDate(birthday);
            formData += '&birthday=' + formattedBirthday;

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
                            "profile_photo": response.user.profile_photo,
                            "email": response.user.email,
                            "birthday": response.user.birthday,
                            "country": response.user.country,
                            "role": response.user.role,
                            "created_at": response.user.created_at,
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

        function formatDate(dateString) {
            var parts = dateString.split('/');
            // Assuming dateString is in MM/DD/YYYY format
            var formattedDate = parts[2] + '-' + parts[0] + '-' + parts[1];
            return formattedDate;
        }

        $('#add-user-btn').click(function () {
            $('#add-user-modal').removeClass('hidden');
        });

        $('#close-modal-btn').click(function () {
            $('#add-user-modal').addClass('hidden');
        });
        $('#close-modal').click(function () {
            $('#add-user-modal').addClass('hidden');
        });


        // Edit user button click handler
        $dataTable.on('click', '.edit-user-btn', function () {
            var userId = $(this).data('id');

            // Assuming you have a function to fetch user data by ID and populate the modal
            fetchUserData(userId);

            // Show the edit-user-modal
            $('#edit-user-modal').removeClass('hidden');
        });

        $('#edit-close-modal-btn').click(function () {
            $('#edit-user-modal').addClass('hidden');
        })
        $('#edit-close-modal').click(function () {
            $('#edit-user-modal').addClass('hidden');
        })


        // Function to fetch user data by ID and populate the modal
        function fetchUserData(userId) {
            // Perform AJAX request to fetch user data by ID
            $.ajax({
                url: "/users/" + userId + "/fetch",
                type: 'GET',
                success: function (response) {
                    // Assuming you have fields in the edit modal to populate with user data
                    $('.edit-user-id').val(response.user.id);
                    $('#edit-name').val(response.user.name);
                    $('#edit-last_name').val(response.user.last_name);
                    $('#edit-username').val(response.user.username);
                    $('#edit-email').val(response.user.email);
                    $('#edit-gender').val(response.user.gender);
                    $('#edit-country').val(response.user.country);
                    $('#edit-country').val(response.user.country);

                    var birthdayDate = new Date(response.user.birthday);
                    var formattedBirthday = birthdayDate.toISOString().split('T')[0];

                    $('#edit-birthday').val(formattedBirthday);
                    $('#edit-role').val(response.user.role);
                    $('#edit-sub_role').val(response.user.sub_role);
                    $('#edit-password').val(response.user.password);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message if data fetching fails
                }
            });
        }

        $('#edit-user-form').submit(function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var userId = $(this).find('.edit-user-id').val(); // Assuming you have an input field for user ID in the edit form
            $.ajax({
                url: "/users/" + userId + /update/, // Assuming this is the route for updating users and it accepts the user ID as part of the URL
                type: 'PUT', // Assuming you're using the PUT method for updates
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        $('#edit-user-modal').addClass('hidden');
                        // Assuming you have a function to update the row in the DataTable with the new data
                        updateRowInDataTable(response.user);
                        Toastify({
                            text: "User updated successfully!",
                            duration: 3000,
                            gravity: "top",
                            position: 'center',
                            style: {
                                background: 'linear-gradient(to right, #00b09b, #96c93d)',
                                borderRadius: '50px'
                            }
                        }).showToast();
                    } else {
                        $.each(response.errors, function (key, value) {
                            $('#edit-' + key + '_error').text(value[0]);
                        });
                        Toastify({
                            text: 'Failed to update user. Please check your inputs and try again.',
                            duration: 3000,
                            close: true,
                            gravity: 'bottom',
                            position: 'center',
                            style: {
                                background: 'linear-gradient(to right, red, #ffc371)',
                                borderRadius: '50px'
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

        function updateRowInDataTable(updatedUserData) {
            var table = $('#example').DataTable();

            // Find the row index based on the user ID
            var rowIndex = table.row(function (index, data, node) {
                return data.id === updatedUserData.id; // Assuming each row has an id attribute with the user's ID
            }).index();

            // Check if the row index is valid
            if (rowIndex !== null && rowIndex !== undefined) {
                // Update the row data
                table.row(rowIndex).data(updatedUserData).draw(false);
            } else {
                // Row not found, handle the error
                console.error('Row with user ID ' + updatedUserData.id + ' not found in the DataTable.');
            }
        }
    });
</script>

