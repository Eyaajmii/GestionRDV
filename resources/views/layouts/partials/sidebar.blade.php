<aside class="w-64 bg-gray-800 text-white flex-shrink-0 p-4">

    <h2 class="text-xl font-bold mb-6">Admin Panel</h2>

    <ul class="space-y-3">

        <li>
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-300">
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('admin.medecins') }}" class="hover:text-gray-300">
                Médecins
            </a>
        </li>

        <li>
            <a href="{{ route('admin.rendezvous') }}" class="hover:text-gray-300">
                Rendez-vous
            </a>
        </li>

    </ul>
    <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="text-red-500">
                    Logout
                </button>
            </form>

</aside>