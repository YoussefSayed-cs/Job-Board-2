<nav class="w-64 bg-gray-50 h-screen border-r border-gray-200 shadow-lg flex flex-col">
    <!-- Logo -->
    <div class="flex items-center px-6 py-5 border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <x-application-logo class="h-8 w-auto text-indigo-600" />
            <span class="text-xl font-bold text-gray-800">Backoffice</span>
        </a>
    </div>

    <!-- Links -->
    <ul class="flex-1 flex flex-col px-4 py-6 space-y-2 overflow-y-auto">
        <li>
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                Dashboard
            </a>
        </li>

        @if(auth()->user()->role === 'admin')
            <li>
                <a href="{{ route('companies.index') }}" 
                   class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('companies.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    Companies
                </a>
            </li>
            <li>
                <a href="{{ route('job-categories.index') }}" 
                   class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('job-categories.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    Job Categories
                </a>
            </li>
            <li>
                <a href="{{ route('users.index') }}" 
                   class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('users.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    Users
                </a>
            </li>
        @endif

        @if(auth()->user()->role === 'company-owner')
            <li>
                <a href="{{ route('my-company.show') }}" 
                   class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('my-company.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                    My Company
                </a>
            </li>
        @endif

        <li>
            <a href="{{ route('job-applications.index') }}" 
               class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('job-applications.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                Applications
            </a>
        </li>

        <li>
            <a href="{{ route('job-vacancies.index') }}" 
               class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('job-vacancies.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700' }}">
                Job Vacancies
            </a>
        </li>

        

        <hr class="my-4 border-gray-300" />

        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full text-left px-3 py-2 rounded-md hover:bg-gray-100 text-gray-700">
                    Log Out
                </button>
            </form>
        </li>

        



        
    </ul>
</nav>
