<!-- Delete User Confirmation Modal -->
<div id="delete-user-modal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- Modal content -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex flex-row justify-between">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Confirm delete</h3>
                    <button type="button" id="delete-close-modal" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-full items-center text-white bg-red-500 hover:bg-red-800 w-10 h-10"><i class="fa fa-times"></i></button>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:text-left">
                    <p class="text-gray-900 dark:text-gray-200">Are you sure you want to delete this user?</p>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="cancel-delete-btn" class="mt-3 w-full inline-flex justify-center rounded-full border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm items-center">Cancel<i class="fa fa-times ml-2 text-xs"></i></button>
                <button type="button" id="confirm-delete-btn" class="w-full inline-flex justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm items-center">Delete<i class="fa fa-trash ml-2 text-xs"></i></button>
            </div>
        </div>
    </div>
</div>
