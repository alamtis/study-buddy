<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto mt-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-green-600 text-white text-center py-6 px-4">
                    <h1 class="text-3xl font-bold">Evaluation Report</h1>
                </div>
                <div class="p-6 space-y-6">
                    <div v-if="evaluation.report === null"
                         class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        <p class="font-bold">Excellent work!</p>
                        <p>You've answered all questions correctly. Here's a study plan to help you level up even
                            further.</p>
                    </div>
                    <div v-else class="bg-white shadow rounded-lg">
                        <h2 class="text-xl font-semibold text-green-800 px-6 py-4">Analysis</h2>
                        <div class="px-6 py-4 prose max-w-none" v-html="formattedReport"></div>
                    </div>
                    <div class="bg-white shadow rounded-lg">
                        <h2 class="text-xl font-semibold text-green-800 px-6 py-4">Study Plan</h2>
                        <div class="px-6 py-4 prose max-w-none" v-html="formattedStudyPlan"></div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <v-btn color="success" elevation="2" large @click="backToHome">
                        Back to Home
                    </v-btn>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import {computed} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import {marked} from 'marked';

const props = defineProps({
    evaluation: Object,
    allCorrect: Boolean,
});

const formatText = (text) => {
    return marked(text);
};

const formattedReport = computed(() => {
    if (props.allCorrect) {
        return "Excellent work! You've answered all questions correctly.";
    } else {
        return formatText(props.evaluation.report);
    }
});

const formattedStudyPlan = computed(() => formatText(props.evaluation.study_plan));

const backToHome = () => {
    window.location.href = route('home');
};
</script>
<style>
.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #166534; /* text-green-800 */
}

.prose a {
    color: #16a34a; /* text-green-600 */
}

.prose strong {
    color: #166534; /* text-green-800 */
}

.prose em {
    color: #6b7280; /* text-gray-500 */
}

.prose code {
    color: #ef4444; /* text-red-500 */
    background-color: #f3f4f6; /* bg-gray-100 */
    padding: 0.2em 0.4em;
    border-radius: 0.25rem;
}

.prose blockquote {
    border-left-color: #16a34a; /* border-green-600 */
    background-color: #f3f4f6; /* bg-gray-100 */
}
</style>
