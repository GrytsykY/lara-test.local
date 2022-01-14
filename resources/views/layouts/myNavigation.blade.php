<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">

        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ml-6">




            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')"
                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    {{ __('ВЫХОД') }}
                </x-dropdown-link>
            </form>

        </div>
    </div>
</div>
