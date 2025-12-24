<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="overflow-x-auto p-30">

    

        <x-toast-notification />

        <div class="flex justify-end items-center space-x-4 mb-8 m-3">
            @if (request()->has('archived') && request()->input('archived') == 'true')

                <!-- Active -->
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center px-4 py-3 bg-blue-700 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Active Users
                </a>

            @else

                <!-- Archived-->
                <a href="{{ route('users.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-6 py-3  bg-black text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Archived Users
                </a>

            @endif
        </div>

        {{-- Search --}}
                <form action="{{ route('users.index') }}" method="GET" class="flex items-center w-1/3 space-x-2 m-4">

                    <div class="flex w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full p-2 rounded-l-lg bg-gray-200 text-black focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Find user by name ">

                        @if(request('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                        @endif

                        <button type="submit" class="bg-gray-500 text-white px-4 py-3 rounded-r-lg hover:bg-gray-600">
                            Search
                        </button>
                    </div>

                    @if(request('search'))
                        <a href="{{ route('users.index', ['filter' => request('filter')]) }}"
                            class="bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600">
                            Clear
                        </a>
                    @endif

                </form>

        <!-- JobApplications table-->
        <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white ">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black-700"> Name </th>
                    <th class="px-20 py-3 text-left text-md font-semibold text-black">Email</th>
                    <th class="px-20 py-3 text-left text-md font-semibold text-black">Role</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800 "><span class="text-gray-500">{{ $user->name ?? 'Unknown User' }}</span></td>
                        <td class="px-6 py-4 text-gray-800 "> {{ $user->email ?? 'N/A' }} </td>
                        <td class="px-6 py-4 text-gray-800 "> {{ $user->role ?? 'N/A' }} </td>

                        <td>
                            <div class="flex space-x-4">
                                @if (request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700"> Restore </button>
                                    </form>


                                @else
                                    @if($user->role != 'admin')

                                        <!-- Edit Button -->
                                        <a href="{{ route('users.edit', $user->id)}}"
                                            class="text-blue-500 hover:text-blue-700">✍️Edit</a>

                                        <!-- Archive button-->
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post" class="inline-block">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="text-orange-500 hover:text-orange-700">🗃️Archive</button>
                                        </form>
                                    @endif
                                @endif


                            </div>


                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-gray-800">No Users found</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</x-app-layout>