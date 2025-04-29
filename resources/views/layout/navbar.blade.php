<nav class="bg-base-100 border-b border-base-200 fixed right-0 top-0 transition-all duration-300 left-64 z-[40]" id="main-navbar">
    <div class="px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Left side -->
            <div class="flex items-center space-x-4">
                <!-- Sidebar Toggle -->
                <button class="btn btn-ghost btn-sm rounded-lg" aria-label="Toggle sidebar">
                    <span class="iconify w-5 h-5" data-icon="solar:hamburger-menu-broken"></span>
                </button>

                <!-- Search -->
                <div class="hidden sm:block">

                </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button onclick="toggleTheme()" class="btn btn-ghost btn-sm rounded-lg" aria-label="Theme toggle">
                    <span class="iconify w-5 h-5 dark:hidden" data-icon="solar:sun-bold-duotone"></span>
                    <span class="iconify w-5 h-5 hidden dark:inline" data-icon="solar:moon-bold-duotone"></span>
                </button>

                <!-- Notifications -->
                <div class="dropdown dropdown-end">
                    <button class="btn btn-ghost btn-sm rounded-lg" aria-label="Notifications">
                        <span class="iconify w-5 h-5" data-icon="solar:bell-bold-duotone"></span>
                        <span class="badge badge-sm badge-primary badge-pill absolute -top-1 -right-1">3</span>
                    </button>
                    <div class="dropdown-content bg-base-100 rounded-box shadow-lg mt-2 w-80 z-[50]">
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-sm font-medium">Notifications</h6>
                                <a href="#" class="text-xs text-primary hover:underline">Mark all as read</a>
                            </div>
                            <div class="space-y-4">
                                <!-- Notification Item -->
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full" src="/images/avatars/4.png" alt="">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-base-content">New task assigned to you</p>
                                        <p class="text-xs text-base-content/60">1 hour ago</p>
                                    </div>
                                </div>
                                <!-- More notification items -->
                            </div>
                            <div class="mt-4 pt-4 border-t border-base-200">
                                <a href="#" class="btn btn-primary btn-sm w-full">View All</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="dropdown dropdown-end">
                    <button class="flex items-center space-x-3 focus:outline-none">
                        <img class="h-8 w-8 rounded-full border border-base-200" src="{{ Auth::user()->employee->profile_picture ?? 'https://img.freepik.com/premium-vector/character-avatar-isolated_729149-194801.jpg?semt=ais_hybrid&w=740' }}" alt="User avatar">
                        <div class="hidden md:block text-left">
                            <h6 class="text-sm font-medium">{{ Auth::user()->first_name." ".Auth::user()->last_name }}</h6>
                            <p class="text-xs text-base-content/60">{{ Auth::user()->is_super_admin?'super admin':Auth::user()->employee->typeEmployee->type->type }}</p>
                        </div>
                        <span class="iconify w-4 h-4 text-base-content/60" data-icon="solar:alt-arrow-down-bold-duotone"></span>
                    </button>
                    <div class="dropdown-content bg-base-100 rounded-box shadow-lg mt-2 w-48 z-[50]">
                        <ul class="menu menu-sm w-full">
                            <li>
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2">
                                    <span class="iconify w-4 h-4 mr-2" data-icon="solar:user-bold-duotone"></span>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.settings') }}" class="flex items-center px-4 py-2">
                                    <span class="iconify w-4 h-4 mr-2" data-icon="solar:settings-bold-duotone"></span>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="w-full flex p-0">
                                    @csrf
                                    <button type="submit" class="flex items-center px-4 py-2 w-full text-error hover:bg-error/10 gap-2">
                                        <span class="iconify w-4 h-4 mr-2" data-icon="solar:logout-3-bold-duotone"></span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
