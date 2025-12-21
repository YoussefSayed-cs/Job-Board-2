<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             Company {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="overflow-x-auto p-30">

        <x-toast-notification />

        <div class="flex justify-end items-center space-x-4 pb-8 m-3">
            @if (request()->has('archived') && request()->input('archived') == 'true')

                <!-- Active -->
                <a href="{{ route('companies.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Active companies
                </a>

            @else

                <!-- Archived-->
                <a href="{{ route('companies.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Archived Company
                </a>

            @endif

            <!-- Add Job categories Button-->
            <a href="{{ route('companies.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2">Add
                Company</a>
        </div>


        <!-- JobCategories table-->
        <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white "   >
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black-700">Company Name</th>
                    <th class="px-20 py-3 text-left text-md font-semibold text-black">Address</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black">Industry</th>
                    <th class="px-20 py-3 text-left text-md font-semibold text-black">Website</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($companies as $company)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800 "> <a class="text-blue-500 hover:text-blue-700 underline" href="{{ route('companies.show', $company->id) }}">{{ $company->name }}</a> </td>
                        <td class="px-6 py-4 text-gray-800 "> {{ $company->address }} </td>
                        <td class="px-6 py-4 text-gray-800 "> {{ $company->industry }} </td>
                        <td class="px-6 py-4 text-gray-800 "> {{ $company->website }} </td>
                        <td>
                            <div class="flex space-x-4">
                                @if (request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('companies.restore', $company->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700"> Restore </button>
                                    </form>


                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('companies.edit', $company->id)}}"
                                        class="text-blue-500 hover:text-blue-700">✍️Edit</a>

                                    <!-- Archive button-->
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="post"
                                        class="inline-block">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="text-orange-500 hover:text-orange-700">🗃️Archive</button>
                                    </form>
                                @endif


                            </div>


                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>

        




        <div class="mt-4">{{ $companies->links() }}</div>
    </div>
</x-app-layout>