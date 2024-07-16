<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside
            :class="['bg-gray-900 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 transform transition duration-200 ease-in-out z-20', {'translate-x-0': drawer, '-translate-x-full': !drawer}]">
            <nav>
                <a :class="['block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white', {'bg-gray-700': isActive('home')}]"
                   :href="route('home')">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9.279V21h6v-6h6v6h6V9.279l-9-6.857-9 6.857z" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2"/>
                        </svg>
                        <span>Home</span>
                    </div>
                </a>
                <a v-if="$page.props.auth.user.is_admin"
                   :class="['block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white', {'bg-gray-700': isActive('user.management')}]"
                   :href="route('user.management')">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"></path>
                        </svg>
                        <span>User Management</span>
                    </div>
                </a>
                <a :class="['block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white', {'bg-gray-700': isActive('profile.edit')}]"
                   :href="route('profile.edit')">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                  stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"></path>
                        </svg>
                        <span>Profile</span>
                    </div>
                </a>
                <!-- Add more sidebar items here -->
            </nav>
        </aside>

        <!-- Main content -->
        <div
            :class="['flex-1 flex flex-col overflow-hidden transition-all duration-200 ease-in-out', {'ml-64': drawer}]">
            <!-- Navbar -->
            <header class="bg-green-600 text-white">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex items-center">
                        <button class="text-white focus:outline-none" @click="toggleDrawer">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path v-if="!drawer" d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"/>
                                <path v-else d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"/>
                            </svg>
                        </button>
                        <h1 class="text-xl font-semibold ml-4">IT Field Evaluation</h1>
                    </div>
                    <button
                        class="px-4 py-2 text-sm bg-green-700 hover:bg-green-800 rounded-md transition duration-150 ease-in-out"
                        @click="logout">
                        Logout
                    </button>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    <transition appear mode="out-in" name="fade">
                        <slot/>
                    </transition>
                </div>
            </main>
        </div>
    </div>
</template>
<script setup>
import {ref} from 'vue';
import {useForm, usePage} from '@inertiajs/vue3';

const drawer = ref(true);
const form = useForm({});

const toggleDrawer = () => {
    drawer.value = !drawer.value;
};

const logout = () => {
    form.post(route('logout'));
};

// Get the current page URL from Inertia
const page = usePage();

const isActive = (routeName) => {
    // Generate the URL path for the route
    const routePath = route(routeName)?.replace(/^(http[s]?:\/\/[^\/]+)?/, '') || '/'; // Handle undefined and empty path
    // Normalize page URL path
    const normalizedPageUrl = page.url?.replace(/^(http[s]?:\/\/[^\/]+)?/, '') || '/'; // Handle undefined and empty URL
    // Handle root path specifically
    if (routePath === '/' && normalizedPageUrl === '/') {
        return true;
    }
    // Compare current URL path with the generated route path
    return normalizedPageUrl === routePath;
};

</script>



