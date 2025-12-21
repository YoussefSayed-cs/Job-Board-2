<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User Password') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-x">
        <div class="max-w-7xl mx-auto p-7 m-10 bg-white rounded-lg shadow-mid">
            <form
                action="{{ route('users.update', ['user' => $users->id, 'redirectToList' => request()->query('redirectToList')]) }}"
                method="post">
                @csrf
                @method('PUT')


                <!-- Job Application details -->
                <div class="mb-4 p-6 bg-gray-50  border border-gray-100  rounded-lg shadow-md">
                    <h3 class="text-lg font-bold">User Details</h3>
                    <br>


                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">User Name:</label>
                        <span>{{ $users->name ?? '—' }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">User Email:</label>
                        <span class="text-black">{{ $users->email ?? '—' }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">User Role:</label>
                        <span class="text-black">{{ $users->role ?? '—' }}</span>
                    </div>




                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Change Owner Password</label>
                        <div class="relative" x-data="{showPassword: false}">
                            <input id="password" name="password" :type="showPassword ? 'text' : 'password'"
                                class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                                <!--Eye closed-->
                                <svg x-show="!showPassword" class="w-5 h-5" width="800px" height="800px"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                                <!-- Eye opend -->
                                <svg x-show="showPassword" class="w-5 h-5" width="800px" height="800px"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />


                                    <path
                                        d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>

                        </div>


                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror



                    </div>



                    <div class="flex justify-end space-x-4">

                        <a href="{{ route('users.index') }}"
                            class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                            Cancel
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focue:ring-2">
                            Update User Password
                        </button>
                    </div>
            </form>
        </div>
    </div>


</x-app-layout>