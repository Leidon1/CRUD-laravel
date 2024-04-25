<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users table') }}
        </h2>
    </x-slot>

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
                        <tr>{{ "users['name']"  }}</tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    {{--$(document).ready(function() {--}}
    {{--    $('#example').DataTable({--}}
    {{--        "processing": true,--}}
    {{--        "scrollX": true,--}}
    {{--        "ajax": "{{ route('users.data') }}",--}}
    {{--        "columns": [--}}
    {{--            { "data": "id" },--}}
    {{--            { "data": "name" },--}}
    {{--            { "data": "last_name" },--}}
    {{--            { "data": "username" },--}}
    {{--            { "data": "email" },--}}
    {{--            { "data": "birthday_formatted" },--}}
    {{--            { "data": "country" },--}}
    {{--            { "data": "role" },--}}
    {{--            { "data": "created_at_formatted" },--}}
    {{--            { "data": "profile_photo" },--}}
    {{--            { "data": "last_login_formatted" },--}}
    {{--        ],--}}
    {{--        "initComplete": function(settings, json) {--}}
    {{--            console.log(json);--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}
</script>
