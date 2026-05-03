<nav class="bg-white shadow p-4 flex justify-between">

    {{-- LOGO --}}
    <div>
        <a href="{{ route('dashboard') }}" class="font-bold">
            RDV System
        </a>
    </div>

    {{-- MENU --}}
    <div class="space-x-4 flex items-center">

        @auth
            {{-- 👤 PATIENT --}}
            @if(auth()->user()->patient)

                <a href="{{ route('rendezvous.store') }}" class="text-blue-600">
                    Prendre RDV
                </a>

                <a href="{{ route('rendezvous.index') }}">
                    Mes RDV
                </a>

                <a href="{{ route('profile.update') }}">
                    Profil
                </a>

            {{-- 👨‍⚕️ MEDECIN --}}
            @elseif(auth()->user()->medecin)

                <a href="{{ route('rendezvous.index') }}">
                    Mes RDV
                </a>

                <a href="{{ route('profile.edit') }}">
                    Profil
                </a>

            @endif

            {{-- 🔴 LOGOUT (COMMUN) --}}
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="text-red-500">
                    Logout
                </button>
            </form>

        @endauth

    </div>

</nav>