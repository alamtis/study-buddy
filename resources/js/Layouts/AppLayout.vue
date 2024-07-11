<!-- resources/js/Layouts/AppLayout.vue -->
<template>
    <v-app>
        <v-app-bar app color="primary" dark elevation="2">
            <v-app-bar-title>IT Field Evaluation</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn text @click="logout">Logout</v-btn>
        </v-app-bar>
        <v-main class="grey lighten-4">
            <v-container fluid>
                <slot></slot>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';

const form = useForm({});

const logout = () => {
    form.post(route('logout'));
};
</script>
