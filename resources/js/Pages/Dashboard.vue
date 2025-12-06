<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
<!--        <template #header>-->
<!--            <h2 class="text-xl font-semibold leading-tight text-gray-800">-->
<!--                Dashboard-->
<!--            </h2>-->
<!--        </template>-->

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 p-2 sm:px-6 lg:px-8">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            </div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                    <div class="relative flex min-h-[140px] flex-col justify-between overflow-hidden rounded-xl p-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-pink-500 to-red-600 opacity-90"></div>
                        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-white opacity-10 blur-xl"></div>

                        <div class="relative z-10 flex flex-col">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium uppercase text-white opacity-80">
                                    Universities
                                </h3>
                                <a href="#" class="text-white opacity-70 hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </a>
                            </div>
                            <p class="mt-4 text-5xl font-bold text-white">
                                72
                            </p>
                        </div>
                    </div>

                    <div class="relative flex min-h-[140px] flex-col justify-between overflow-hidden rounded-xl p-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-500 to-cyan-600 opacity-90"></div>
                        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-white opacity-10 blur-xl"></div>

                        <div class="relative z-10 flex flex-col">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium uppercase text-white opacity-80">
                                    Destinations
                                </h3>
                                <a href="#" class="text-white opacity-70 hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </a>
                            </div>
                            <p class="mt-4 text-5xl font-bold text-white">
                                8
                            </p>
                        </div>
                    </div>

                    <div class="relative flex min-h-[140px] flex-col justify-between overflow-hidden rounded-xl p-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-teal-500 to-green-600 opacity-90"></div>
                        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-white opacity-10 blur-xl"></div>

                        <div class="relative z-10 flex flex-col">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium uppercase text-white opacity-80">
                                    Programs
                                </h3>
                                <a href="#" class="text-white opacity-70 hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </a>
                            </div>
                            <p class="mt-4 text-5xl font-bold text-white">
                                875
                            </p>
                        </div>
                    </div>

                    <div class="relative flex min-h-[140px] flex-col justify-between overflow-hidden rounded-xl p-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-purple-500 to-fuchsia-600 opacity-90"></div>
                        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-white opacity-10 blur-xl"></div>

                        <div class="relative z-10 flex flex-col">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium uppercase text-white opacity-80">
                                    Scholarships
                                </h3>
                                <a href="#" class="text-white opacity-70 hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </a>
                            </div>
                            <p class="mt-4 text-5xl font-bold text-white">
                                49
                            </p>
                        </div>
                    </div>

                    <div class="relative flex min-h-[140px] flex-col justify-between overflow-hidden rounded-xl p-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-indigo-700 opacity-90"></div>
                        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-white opacity-10 blur-xl"></div>

                        <div class="relative z-10 flex flex-col">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium uppercase text-white opacity-80">
                                    Applicants
                                </h3>
                                <a href="#" class="text-white opacity-70 hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </a>
                            </div>
                            <p class="mt-4 text-5xl font-bold text-white">
                                21
                            </p>
                        </div>
                    </div>

                    <div class="relative flex min-h-[140px] flex-col justify-between overflow-hidden rounded-xl p-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-yellow-500 to-amber-600 opacity-90"></div>
                        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-white opacity-10 blur-xl"></div>

                        <div class="relative z-10 flex flex-col">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium uppercase text-white opacity-80">
                                    Appointments
                                </h3>
                                <a href="#" class="text-white opacity-70 hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </a>
                            </div>
                            <p class="mt-4 text-5xl font-bold text-white">
                                21
                            </p>
                        </div>
                    </div>

                    <div class="relative flex min-h-[140px] flex-col justify-between overflow-hidden rounded-xl p-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-gray-700 to-gray-800 opacity-90"></div>
                        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-white opacity-10 blur-xl"></div>

                        <div class="relative z-10 flex flex-col">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium uppercase text-white opacity-80">
                                    B2B Partners
                                </h3>
                                <a href="#" class="text-white opacity-70 hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </a>
                            </div>
                            <p class="mt-4 text-5xl font-bold text-white">
                                2
                            </p>
                        </div>
                    </div>

                    <div class="relative flex min-h-[140px] flex-col justify-between overflow-hidden rounded-xl p-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-gray-400 to-gray-500 opacity-90"></div>
                        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-white opacity-10 blur-xl"></div>

                        <div class="relative z-10 flex flex-col">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium uppercase text-white opacity-80">
                                    B2C Clients
                                </h3>
                                <a href="#" class="text-white opacity-70 hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </a>
                            </div>
                            <p class="mt-4 text-5xl font-bold text-white">
                                0
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
