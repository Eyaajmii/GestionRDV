<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16 gap-4">

            {{-- LOGO --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                <div class="w-9 h-9 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="18" height="18" rx="4" stroke="#4f46e5" stroke-width="1.5" />
                        <path d="M12 8v8M8 12h8" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <div>
                    <div class="text-[15px] font-semibold text-gray-900 tracking-tight leading-none">RendezCare</div>
                    <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">Gestion des Rendez-Vous</div>
                </div>
            </a>

            {{-- LIENS DESKTOP --}}
            <div class="hidden md:flex items-center gap-0.5">
                @auth
                @if(auth()->user()->patient || auth()->user()->medecin)
                <a href="{{ route('rendezvous.index') }}"
                    class="flex items-center gap-1.5 text-[13px] px-3 py-2 rounded-lg border transition-all
                               {{ request()->routeIs('rendezvous.index')
                                   ? 'bg-indigo-50 text-indigo-700 font-semibold border-indigo-200'
                                   : 'text-gray-500 border-transparent hover:text-gray-900 hover:bg-gray-50 hover:border-gray-200' }}">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none">
                        <rect x="1" y="1" width="6" height="6" rx="1.5" fill="currentColor" />
                        <rect x="9" y="1" width="6" height="6" rx="1.5" fill="currentColor" />
                        <rect x="1" y="9" width="6" height="6" rx="1.5" fill="currentColor" />
                        <rect x="9" y="9" width="6" height="6" rx="1.5" fill="currentColor" />
                    </svg>
                    Mes rendez-vous
                </a>
                @endif
                @if(auth()->user()->patient)
                <a href="{{ route('rendezvous.create') }}"
                    class="flex items-center gap-3 text-[13px] px-3 py-2 rounded-lg border transition-all group
                               {{ request()->routeIs('rendezvous.create')
                                   ? 'bg-indigo-50 text-indigo-700 font-semibold border-indigo-200'
                                   : 'text-gray-500 border-transparent hover:text-gray-900 hover:bg-gray-50 hover:border-gray-200' }}">
                    <span class="w-5 h-5 flex items-center justify-center rounded-md shrink-0 transition-colors
                                {{ request()->routeIs('rendezvous.create')
                                    ? 'bg-indigo-100 text-indigo-600'
                                    : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}">
                        <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none">
                            <path d="M6 1v10M1 6h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                    Prendre rendez-vous
                </a>
                @endif
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-1.5 text-[11px] px-3 py-2 rounded-lg border uppercase tracking-widest ml-1 transition-all
                               {{ request()->routeIs('admin.*')
                                   ? 'bg-gray-100 text-gray-900 font-semibold border-gray-300'
                                   : 'text-gray-400 border-gray-200 hover:text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none">
                        <path d="M6 1a2 2 0 100 4 2 2 0 000-4zM2 10a4 4 0 018 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    Admin
                </a>
                @endif
                @endauth
            </div>

            {{-- USER DESKTOP --}}
            @auth
            <div class="hidden md:flex items-center gap-2.5 shrink-0">

                {{-- AVATAR + NOM (CLICABLE) --}}
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 hover:bg-gray-50 px-2 py-1 rounded-lg transition">

                    {{-- CERCLE --}}
                    <div class="w-8 h-8 bg-indigo-50 border border-indigo-200 rounded-full flex items-center justify-center text-[11px] font-semibold text-indigo-600 shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>

                    {{-- NOM + ROLE --}}
                    <div>
                        <div class="text-[13px] font-medium text-gray-700 leading-none">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">
                            @if(auth()->user()->medecin) Médecin
                            @elseif(auth()->user()->patient) Patient
                            @else Administrateur
                            @endif
                        </div>
                    </div>

                </a>

                {{-- SEPARATEUR --}}
                <div class="w-px h-5 bg-gray-200 mx-1"></div>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 text-[13px] text-gray-400 hover:text-red-500 transition-all group appearance-none bg-transparent border-none p-0 cursor-pointer">
                        <span class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 group-hover:bg-red-100 group-hover:text-red-400 transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none">
                                <path d="M6 2H3a1 1 0 00-1 1v10a1 1 0 001 1h3M11 11l3-3-3-3M14 8H6"
                                    stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        Déconnexion
                    </button>
                </form>

            </div>
            @endauth

            {{-- MOBILE TOGGLE --}}
            <button @click="open = !open"
                class="md:hidden p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition border border-gray-200">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path x-show="!open" stroke-linecap="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    <path x-show="open" stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-0.5">
        @auth
        @if(auth()->user()->patient || auth()->user()->medecin)
        <a href="{{ route('rendezvous.index') }}"
            class="flex items-center gap-3 text-sm px-3 py-2.5 rounded-lg transition-all group
                       {{ request()->routeIs('rendezvous.index')
                           ? 'bg-indigo-50 text-indigo-700 font-semibold'
                           : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
            <span class="w-5 h-5 flex items-center justify-center rounded-md shrink-0 transition-colors
                        {{ request()->routeIs('rendezvous.index')
                            ? 'bg-gray-300 text-gray-700'
                            : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}">
                <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none">
                    <rect x="0.5" y="0.5" width="4" height="4" rx="1" fill="currentColor" />
                    <rect x="6.5" y="0.5" width="4" height="4" rx="1" fill="currentColor" />
                    <rect x="0.5" y="6.5" width="4" height="4" rx="1" fill="currentColor" />
                    <rect x="6.5" y="6.5" width="4" height="4" rx="1" fill="currentColor" />
                </svg>
            </span>
            Mes rendez-vous
        </a>
        @endif
        @if(auth()->user()->patient)
        <a href="{{ route('rendezvous.create') }}"
            class="flex items-center gap-3 text-sm px-3 py-2.5 rounded-lg transition-all group
                       {{ request()->routeIs('rendezvous.create')
                           ? 'bg-indigo-50 text-indigo-700 font-semibold'
                           : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
            <span class="w-5 h-5 flex items-center justify-center rounded-md shrink-0 transition-colors
                        {{ request()->routeIs('rendezvous.create')
                            ? 'bg-indigo-100 text-indigo-600'
                            : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}">
                <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none">
                    <path d="M6 1v10M1 6h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </span>
            Prendre rendez-vous
        </a>
        @endif
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 text-sm px-3 py-2.5 rounded-lg transition-all group
                       {{ request()->routeIs('admin.*')
                           ? 'bg-gray-100 text-gray-900 font-semibold'
                           : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
            <span class="w-5 h-5 flex items-center justify-center rounded-md shrink-0 transition-colors
                        {{ request()->routeIs('admin.*')
                            ? 'bg-gray-300 text-gray-700'
                            : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}">
                <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none">
                    <path d="M6 1a2 2 0 100 4 2 2 0 000-4zM2 10a4 4 0 018 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </span>
            Administration
        </a>
        @endif
        <div class="border-t border-gray-100 pt-2 mt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 w-full text-sm text-gray-500 hover:text-red-500 px-3 py-2.5 rounded-lg hover:bg-red-50/60 transition-all group appearance-none bg-transparent border-none cursor-pointer">
                    <span class="w-5 h-5 flex items-center justify-center rounded-md bg-gray-100 text-gray-400 group-hover:bg-red-100 group-hover:text-red-400 transition-colors shrink-0">
                        <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none">
                            <path d="M4.5 2H3a1 1 0 00-1 1v6a1 1 0 001 1h1.5M8 8.5L11 6 8 3.5M11 6H4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    Déconnexion
                </button>
            </form>
        </div>
        @endauth
    </div>

</nav>