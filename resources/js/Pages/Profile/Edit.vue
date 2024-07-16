<template>
    <app-layout>
        <v-card class="mx-auto mt-6" max-width="800">
            <v-card-title class="text-h5 font-weight-bold bg-green-600 text-white py-4 px-6">
                Edit Profile
            </v-card-title>
            <v-card-text>
                <v-form @submit.prevent="submit">
                    <v-text-field
                        v-model="form.name"
                        :error-messages="form.errors.name"
                        label="Name"
                        required
                    ></v-text-field>

                    <v-text-field
                        v-model="form.email"
                        :error-messages="form.errors.email"
                        label="Email"
                        required
                        type="email"
                    ></v-text-field>

                    <!-- Add more fields as needed -->

                    <v-btn
                        :loading="form.processing"
                        class="mt-4"
                        color="green-darken-2"
                        type="submit"
                    >
                        Update Profile
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </app-layout>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    // Add more fields as needed
});

const submit = () => {
    form.patch(route('profile.update'));
};
</script>
