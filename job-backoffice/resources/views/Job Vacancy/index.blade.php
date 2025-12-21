<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Vacancies {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="overflow-x-auto p-30 m-4">

        <x-toast-notification />

        <div class="flex justify-end items-center space-x-4">
            @if (request()->has('archived') && request()->input('archived') == 'true')

                <!-- Active -->
                <a href="{{ route('job-vacancies.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Active Job Vacancies
                </a>

            @else

                <!-- Archived-->
                <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Archived Job Vacancies
                </a>

            @endif

            <!-- Add Job categories Button-->
            <a href="{{ route('job-vacancies.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2">
                Add Job Vacancy
            </a>
        </div>


        <!-- JobCategories table-->
        <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white ">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black-700">Title</th>

                    @if (auth()->user()->role == 'admin')
                    <th class="px-20 py-3 text-left text-md font-semibold text-black">Company</th>
                    @endif

                    <th class="px-20 py-3 text-left text-md font-semibold text-black">Location</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black">Type</th>
                    <th class="px-20 py-3 text-left text-md font-semibold text-black">Salary</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($vacancies as $vacancy)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800 "> <a class="text-blue-500 hover:text-blue-700 underline"
                                href="{{ route('job-vacancies.show', $vacancy->id) }}">
                                {{ $vacancy->title }}</a></td>

                        @if (auth()->user()->role == 'admin')
                        <td class="px-6 py-4 text-gray-800 "> {{ $vacancy->company->name }} </td>
                        @endif
                        
                        <td class="px-6 py-4 text-gray-800 "> {{ $vacancy->location }} </td>
                        <td class="px-6 py-4 text-gray-800 "> {{ $vacancy->type }} </td>
                        <td class="px-6 py-4 text-gray-800 "> {{ $vacancy->salary }} </td>
                        <td>
                            <div class="flex space-x-4">
                                @if (request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-vacancies.restore', $vacancy->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700"> Restore </button>
                                    </form>


                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-vacancies.edit', $vacancy->id)}}"
                                        class="text-blue-500 hover:text-blue-700">✍️Edit</a>

                                    <!-- Archive button-->
                                    <form action="{{ route('job-vacancies.destroy', $vacancy->id) }}" method="post"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-orange-500 hover:text-orange-700">🗃️Archive</button>
                                    </form>
                                @endif


                            </div>


                        </td>
                    </tr>

         @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-gray-800">No Vacancies found</td>
                    </tr>

                @endforelse
            </tbody>
        </table>






        <div class="mt-4">{{ $vacancies->links() }}</div>
    </div>
</x-app-layout>