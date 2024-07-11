<!-- resources/js/Pages/Auth/Login.vue -->
<template>
    <v-app>
        <v-main class="grey lighten-4">
            <v-container fill-height fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" md="4" sm="8">
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" dark flat>
                                <v-toolbar-title>Login</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text class="pa-6">
                                <v-form @submit.prevent="submit">
                                    <v-text-field
                                        v-model="form.email"
                                        :error-messages="form.errors.email"
                                        label="Email"
                                        name="email"
                                        outlined
                                        prepend-icon="mdi-email"
                                        type="email"
                                    ></v-text-field>

                                    <v-text-field
                                        v-model="form.password"
                                        :error-messages="form.errors.password"
                                        label="Password"
                                        name="password"
                                        outlined
                                        prepend-icon="mdi-lock"
                                        type="password"
                                    ></v-text-field>

                                    <v-checkbox
                                        v-model="form.remember"
                                        color="primary"
                                        label="Remember me"
                                    ></v-checkbox>

                                    <v-btn
                                        :loading="form.processing"
                                        block
                                        class="mt-4"
                                        color="primary"
                                        elevation="2"
                                        large
                                        type="submit"
                                    >
                                        Login
                                    </v-btn>
                                </v-form>
                            </v-card-text>
                            <v-card-actions class="pa-4">
                                <v-spacer></v-spacer>
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-decoration-none"
                                >
                                    Forgot your password?
                                </Link>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
import {Link, useForm} from '@inertiajs/vue3';

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
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
