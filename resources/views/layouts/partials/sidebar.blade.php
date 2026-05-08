<aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 h-screen p-4">

    <div class="mb-6">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="3" width="18" height="18" rx="4" stroke="#4f46e5" stroke-width="1.5" />
                    <path d="M12 8v8M8 12h8" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" />
                </svg>
            </div>

            <div>
                <div class="text-[15px] font-semibold text-gray-900">Admin Panel</div>
                <div class="text-[10px] text-gray-400 uppercase tracking-widest">Gestion clinique</div>
            </div>
        </div>
    </div>
    <nav class="space-y-6">

        <a href="{{ url('/dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
    {{ request()->is('dashboard')
        ? 'bg-indigo-50 text-indigo-700 font-semibold border border-indigo-200'
        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                <path d="M3 10h18M3 14h18M3 6h18M3 18h18"
                    stroke="currentColor"
                    stroke-width="1.5" />
            </svg>

            Dashboard
        </a>
        <div>
            <p class="text-xs uppercase text-gray-400 tracking-widest mb-2">Patients</p>

            <div class="space-y-1">

                <a href="{{ route('patients.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
           {{ request()->routeIs('patient.index')
                ? 'bg-indigo-50 text-indigo-700 font-semibold'
                : 'text-gray-600 hover:bg-gray-50' }}">
                    Liste des patients
                </a>

            </div>
        </div>
        <div>
            <p class="text-xs uppercase text-gray-400 tracking-widest mb-2">Médecins</p>

            <div class="space-y-1">
                <a href="{{ route('medecin.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('medecin.index')
                        ? 'bg-indigo-50 text-indigo-700 font-semibold'
                        : 'text-gray-600 hover:bg-gray-50' }}">
                    Liste médecins
                </a>

                <a href="{{ route('medecin.create') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('medecin.create')
                        ? 'bg-indigo-50 text-indigo-700 font-semibold'
                        : 'text-gray-600 hover:bg-gray-50' }}">
                    Ajouter médecin
                </a>
            </div>
        </div>
        <div>
            <p class="text-xs uppercase text-gray-400 tracking-widest mb-2">Rendez-vous</p>

            <div class="space-y-1">
                <a href="{{ route('rendezvous.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('rendezvous.index')
                        ? 'bg-indigo-50 text-indigo-700 font-semibold'
                        : 'text-gray-600 hover:bg-gray-50' }}">
                    Tous les rendez-vous
                </a>
            </div>
        </div>

    </nav>

    <div class="mt-10 pt-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-500 transition">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                    <path d="M10 17l5-5-5-5M15 12H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M21 3v18" stroke="currentColor" stroke-width="1.5" />
                </svg>
                Déconnexion
            </button>
        </form>
    </div>

</aside>