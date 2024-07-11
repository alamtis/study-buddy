<!-- resources/js/Pages/Evaluation.vue -->
<template>
    <AppLayout>
        <v-card class="mx-auto mt-8" elevation="8" max-width="800">
            <v-card-title class="text-h5 font-weight-bold primary white--text py-4">
                Question {{ currentQuestionIndex + 1 }} of {{ questions.length }}
            </v-card-title>
            <v-card-text class="pa-6">
                <h2 class="text-h6 mb-6">{{ currentQuestion.question }}</h2>
                <v-radio-group v-model="form.selectedAnswer" column>
                    <v-radio
                        v-for="(answer, index) in currentQuestion.answers"
                        :key="index"
                        :label="answer"
                        :value="index"
                        color="primary"
                    ></v-radio>
                </v-radio-group>
            </v-card-text>
            <v-card-actions class="pb-6 px-6">
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="form.selectedAnswer === null"
                    color="primary"
                    elevation="2"
                    large
                    @click="submitAnswer"
                >
                    Next
                </v-btn>
            </v-card-actions>
            <!-- Loading indicator -->
            <v-overlay :value="form.processing">
                <v-progress-circular color="primary" indeterminate></v-progress-circular>
            </v-overlay>
        </v-card>
    </AppLayout>
</template>

<script setup>
import {computed} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    questions: Array,
    currentQuestionIndex: Number,
});

const form = useForm({
    selectedAnswer: null,
});

const currentQuestion = computed(() => props.questions[props.currentQuestionIndex] || {});

const submitAnswer = () => {
    form.post(route('evaluation.answer'), {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

