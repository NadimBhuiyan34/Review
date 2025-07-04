<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div 
        class="min-h-screen w-full bg-gradient-to-br from-blue-600 via-purple-600 to-pink-500 relative flex items-center justify-center"
        style="background-image: url('https://img.freepik.com/free-photo/computer-mouse-paper-bags-blue-background-top-view_169016-43523.jpg'); background-size: cover; background-position: center;"
    >
        <div class="absolute inset-0 bg-black/50"></div>

        <form @submit.prevent="submit" class="relative z-10 w-full max-w-md space-y-8 rounded-2xl bg-white/10 p-10 shadow-2xl backdrop-blur-lg">
            <Head title="Register" />

            <h1 class="text-center text-4xl font-extrabold tracking-wide text-white">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500">
                    Review
                </span>
                <span class="text-white">Hub</span>
            </h1>
            <p class="text-center text-sm text-gray-200">Create your account below</p>

            <div class="space-y-6">
                <div class="space-y-2">
                    <Label for="name" class="text-white">Name</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        v-model="form.name"
                        placeholder="Full name"
                        class="h-12 rounded-lg border-none bg-white/20 text-white placeholder-gray-200 focus:bg-white/30 focus:ring-2 focus:ring-white/60"
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="space-y-2">
                    <Label for="email" class="text-white">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        v-model="form.email"
                        placeholder="you@example.com"
                        class="h-12 rounded-lg border-none bg-white/20 text-white placeholder-gray-200 focus:bg-white/30 focus:ring-2 focus:ring-white/60"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="space-y-2">
                    <Label for="password" class="text-white">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        v-model="form.password"
                        placeholder="••••••••"
                        class="h-12 rounded-lg border-none bg-white/20 text-white placeholder-gray-200 focus:bg-white/30 focus:ring-2 focus:ring-white/60"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="space-y-2">
                    <Label for="password_confirmation" class="text-white">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        v-model="form.password_confirmation"
                        placeholder="••••••••"
                        class="h-12 rounded-lg border-none bg-white/20 text-white placeholder-gray-200 focus:bg-white/30 focus:ring-2 focus:ring-white/60"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button
                    type="submit"
                    class="h-12 w-full rounded-lg bg-white/30 text-lg font-semibold text-white hover:bg-white/40 transition"
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                    <span v-if="!form.processing">Create account</span>
                </Button>
            </div>

            <div class="text-center text-sm text-gray-200">
                Already have an account?
                <TextLink :href="route('login')" class="font-semibold underline hover:text-white">Log in</TextLink>
            </div>
        </form>
    </div>
</template>
