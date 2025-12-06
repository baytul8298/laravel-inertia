<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        <div class="">
            <h2 class="text-3xl font-bold text-[#1E73BE] mb-8 text-center">
                LOGIN
            </h2>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div class="mb-6">
                    <InputLabel for="email" value="Email" class="text-gray-500 text-sm mb-1" />

                    <TextInput
                        id="email"
                        type="email"
                        class="w-full border-t-0 border-l-0 border-r-0 border-b border-gray-300 focus:border-[#1E73BE] focus:ring-0 px-0 mt-0 text-gray-700 bg-[#E8F0FE]"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        :placeholder="form.email ? '' : 'baytul@gmail.com'"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4 mb-8">
                    <InputLabel for="password" value="Password" class="text-gray-500 text-sm mb-1" />

                    <TextInput
                        id="password"
                        type="password"
                        class="w-full border-t-0 border-l-0 border-r-0 border-b border-gray-300 focus:border-[#1E73BE] focus:ring-0 px-0 mt-0 text-gray-700 bg-[#E8F0FE]"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        :placeholder="form.password ? '' : '••••••••'"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <PrimaryButton
                        class="w-full justify-center bg-[#1E73BE] hover:bg-blue-700 focus:ring-[#1E73BE] rounded-md py-2.5 text-base font-semibold"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        LOGIN
                    </PrimaryButton>
                </div>

                <div class="mt-8 text-center text-sm">
                    <span class="text-gray-600">Don't have an account yet? </span>
                    <Link :href="route('register')" class="text-sm text-[#1E73BE] hover:text-blue-700 underline">
                        Register
                    </Link>
                </div>
            </form>

        </div>
    </GuestLayout>
</template>
