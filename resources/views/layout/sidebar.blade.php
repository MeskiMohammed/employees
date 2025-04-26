<div id="layout-sidebar" class="bg-base-100 border-r border-base-200 flex flex-col h-screen w-64 fixed left-0 top-0">
    <div class="p-4 border-b border-base-200">
        <a class="flex items-center justify-center" href="/" data-discover="true">
            <img alt="logo-dark" class="hidden h-8 dark:inline" src="/images/logo/logo-dark.svg" />
            <img alt="logo-light" class="h-8 dark:hidden" src="/images/logo/logo-light.svg" />
        </a>
    </div>

    <div class="overflow-y-auto flex-1 py-4">
        <nav class="px-4 space-y-4">
            <div class="mb-4">
                <p class="text-xs font-semibold text-base-content/60 uppercase tracking-wider mb-4 px-3">Main Menu</p>
                <div class="space-y-1">
                    <a href="/dashboard" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('dashboard') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:home-2-bold-duotone"></span>
                        <span>Dashboard</span>
                    </a>
                    <a href="/employees" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('employees') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:users-group-two-rounded-bold-duotone"></span>
                        <span>Employees</span>
                    </a>
                    <a href="/departments" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('departments') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:buildings-2-bold-duotone"></span>
                        <span>Departments</span>
                    </a>
                    <a href="/users" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('users') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:user-rounded-bold-duotone"></span>
                        <span>Users</span>
                    </a>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-xs font-semibold text-base-content/60 uppercase tracking-wider mb-4 px-3">Management</p>
                <div class="space-y-1">
                    <a href="/leaves" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('leaves') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:calendar-mark-bold-duotone"></span>
                        <span>Leaves</span>
                    </a>
                    <a href="/freelancer-projects" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('freelancer-projects') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:case-minimalistic-bold-duotone"></span>
                        <span>Freelancer Projects</span>
                    </a>
                    <a href="/types" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('types') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:document-text-bold-duotone"></span>
                        <span>Employee Types</span>
                    </a>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-xs font-semibold text-base-content/60 uppercase tracking-wider mb-4 px-3">Settings</p>
                <div class="space-y-1">
                    <a href="/payment-types" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('payment-types') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:wallet-money-bold-duotone"></span>
                        <span>Payment Types</span>
                    </a>
                    <a href="/operators" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('operators') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:settings-bold-duotone"></span>
                        <span>Operators</span>
                    </a>
                    <a href="/statuses" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('statuses') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:info-circle-bold-duotone"></span>
                        <span>Statuses</span>
                    </a>
                    <a href="/user-roles" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('user-roles') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="solar:user-id-bold-duotone"></span>
                        <span>User Roles</span>
                    </a>
                    <a href="/user-statuses" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-base-200 transition-colors group {{ request()->is('user-statuses') ? 'bg-primary/10 text-primary' : 'text-base-content/80' }}">
                        <span class="iconify w-5 h-5 mr-3" data-icon="ic:outline-grade"></span>
                        <span>User Statuses</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <div class="p-4 border-t border-base-200">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <img class="h-8 w-8 rounded-full" src="{{ asset('images/image.png') }}" alt="User avatar">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-base-content truncate">Denish</p>
                <p class="text-xs text-base-content/60 truncate">Administrator</p>
            </div>
        </div>
    </div>
</div>