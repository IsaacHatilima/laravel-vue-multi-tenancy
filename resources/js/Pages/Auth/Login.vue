<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button'
import { Input } from '@/Components/ui/input'
import {CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/Components/ui/card";
import { Label } from '@/Components/ui/label'
import { Checkbox } from '@/Components/ui/checkbox'

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <CardContent>
            <form @submit.prevent="submit">

                <div class="grid w-full max-w-sm items-center gap-1.5">
                    <Label for="email">Email</Label>
                    <Input id="email"
                           type="email"
                           class="mt-1 block w-full"
                           :class="{ 'border-red-500': form.errors.email }"
                           v-model="form.email"
                           autofocus
                           autocomplete="username"/>

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>


                <div class="grid w-full max-w-sm items-center gap-1.5 mt-4">
                    <div class="flex justify-between">
                        <Label for="password">Password</Label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Forgot your password?
                        </Link>
                    </div>


                    <Input
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        :class="{ 'border-red-500': form.errors.password }"
                        v-model="form.password"
                        autocomplete="current-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="flex justify-between mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <Link
                        :href="route('register')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Need a group?
                    </Link>
                </div>

                <div class=" mt-4">
                    <Button class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                    </Button>
                </div>
            </form>
        </CardContent>
    </GuestLayout>
</template>
