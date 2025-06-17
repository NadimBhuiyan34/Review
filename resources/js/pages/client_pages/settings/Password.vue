<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/ClientLayout.vue';

import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Password settings',
        href: '/settings/password',
    },
];

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors: any) => {
            if (errors.password) {
                form.reset('password', 'password_confirmation');
                if (passwordInput.value instanceof HTMLInputElement) {
                    passwordInput.value.focus();
                }
            }

            if (errors.current_password) {
                form.reset('current_password');
                if (currentPasswordInput.value instanceof HTMLInputElement) {
                    currentPasswordInput.value.focus();
                }
            }
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Password settings" />

        <div class="mx-auto max-w-[1550px] space-y-8 rounded-2xl border border-gray-100 bg-white px-6 py-10  my-5">
            <!-- Heading -->
            <HeadingSmall title="🔒 Update Password" description="Ensure your account is using a long, unique password for better security." />

            <!-- Form -->
            <form @submit.prevent="updatePassword" class="space-y-6">
                <!-- Current Password -->
                <div class="space-y-1.5">
                    <Label for="current_password">Current Password</Label>
                    <Input
                        id="current_password"
                        ref="currentPasswordInput"
                        v-model="form.current_password"
                        type="password"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="block w-full"
                    />
                    <InputError :message="form.errors.current_password" />
                </div>

                <!-- New Password -->
                <div class="space-y-1.5">
                    <Label for="password">New Password</Label>
                    <Input
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1.5">
                    <Label for="password_confirmation">Confirm New Password</Label>
                    <Input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-4">
                    <Button :disabled="form.processing" class="rounded-lg px-6 py-2.5">Save Password</Button>

                    <Transition
                        enter-active-class="transition ease-in-out duration-300"
                        enter-from-class="opacity-0 translate-y-2"
                        leave-active-class="transition ease-in-out duration-300"
                        leave-to-class="opacity-0 -translate-y-2"
                    >
                        <p v-show="form.recentlySuccessful" class="text-sm text-green-600">✔️ Saved successfully.</p>
                    </Transition>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
