<!-- resources/js/Pages/FieldSelection.vue -->
<template>
    <AppLayout>
        <v-card class="mx-auto mt-8" elevation="8" max-width="600">
            <v-card-title class="text-h4 font-weight-bold text-center py-4 primary white--text">
                Select IT Field
            </v-card-title>
            <v-card-text class="pa-6">
                <v-select
                    v-model="form.selectedField"
                    :error-messages="form.errors.selectedField"
                    :items="fields"
                    label="Choose an IT field"
                    outlined
                ></v-select>
            </v-card-text>
            <v-card-actions class="pa-6">
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="!form.selectedField"
                    color="primary"
                    elevation="2"
                    large
                    @click="submit"
                >
                    Start Evaluation
                </v-btn>
            </v-card-actions>
        </v-card>
    </AppLayout>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    fields: Array,
});

const form = useForm({
    selectedField: null,
});

const submit = () => {
    form.post(route('evaluation.start'));
};
</script>
