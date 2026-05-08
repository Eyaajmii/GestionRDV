<nav class="bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">

        <!-- LOGO -->
        <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-wide">
            🏥 RDV System
        </a>

        <!-- MENU -->
        <div class="flex items-center space-x-6 text-sm font-medium">

            @auth

                @if(auth()->user()->patient)
                    <a href="{{ route('rendezvous.create') }}" 
                       class="hover:bg-white/20 px-3 py-2 rounded-lg transition">
                        Prendre RDV
                    </a>

                    <a href="{{ route('rendezvous.index') }}" 
                       class="hover:bg-white/20 px-3 py-2 rounded-lg transition">
                        Mes RDV
                    </a>

                    <a href="{{ route('profile.update') }}" 
                       class="hover:bg-white/20 px-3 py-2 rounded-lg transition">
                        Profil
                    </a>

                @elseif(auth()->user()->medecin)

                    <a href="{{ route('rendezvous.index') }}" 
                       class="hover:bg-white/20 px-3 py-2 rounded-lg transition">
                        Mes RDV
                    </a>

                    <a href="{{ route('profile.edit') }}" 
                       class="hover:bg-white/20 px-3 py-2 rounded-lg transition">
                        Profil
                    </a>

                @endif

                <!-- LOGOUT -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition shadow">
                        Logout
                    </button>
                </form>

            @endauth

        </div>
    </div>
</nav>