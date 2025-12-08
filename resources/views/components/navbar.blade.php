<nav class="bg-neutral-primary fixed w-full z-20 top-0 start-0 border-default">
    <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-7" alt="Logo" />
            <span class="self-center text-xl text-heading font-semibold whitespace-nowrap">Dinas Kesehatan</span>
        </a>
        <button data-collapse-toggle="navbar-dropdown" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary"
            aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-neutral-primary">

                @foreach($menus as $menu)
                    @if($menu->submenus->count() > 0)
                        {{-- Menu dengan Submenu (Dropdown) --}}
                        <li>
                            <button id="dropdownNavbar{{ $menu->id }}" data-dropdown-toggle="dropdownMenu{{ $menu->id }}"
                                class="flex items-center justify-between w-full py-2 px-3 rounded font-medium text-heading md:w-auto hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 {{ request()->is(ltrim($menu->link ?? '', '/') . '*') ? 'text-fg-brand' : '' }}">
                                {{ $menu->nama_menu }}
                                <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m19 9-7 7-7-7" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownMenu{{ $menu->id }}"
                                class="z-10 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44">
                                <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownNavbar{{ $menu->id }}">
                                    @foreach($menu->submenus->sortBy('urutan') as $submenu)
                                        <li>
                                            <a href="{{ $submenu->link }}"
                                                class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded {{ request()->is(ltrim($submenu->link, '/') . '*') ? 'bg-neutral-tertiary-medium text-heading' : '' }}">
                                                {{ $submenu->nama_submenu }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        {{-- Menu tanpa Submenu (Link biasa) --}}
                        <li>
                            <a href="{{ $menu->link }}"
                                class="block py-2 px-3 rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 {{ request()->is(ltrim($menu->link ?? '', '/') . '*') ? 'text-white bg-brand md:bg-transparent md:text-fg-brand' : 'text-heading' }}"
                                {{ request()->is(ltrim($menu->link ?? '', '/') . '*') ? 'aria-current=page' : '' }}>
                                {{ $menu->nama_menu }}
                            </a>
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
    </div>
</nav>