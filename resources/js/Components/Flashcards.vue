<template>
    <div class="bg-white shadow rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-green-800 px-6 py-4">Flashcards</h2>
        <div class="px-6 py-4">
            <div v-if="flashcards.length > 0" class="bg-gray-100 p-4 rounded-lg">
                <div v-if="currentCard" class="cursor-pointer">
                    <div v-if="!isFlipped">
                        <div class="font-bold" v-html="markedQuestion"></div>
                        <div class="mt-4">
                            <div v-for="(option, index) in currentCard.options" :key="index" class="mb-2">
                                <v-radio
                                    v-model="selectedOption"
                                    :label="option"
                                    :value="option"
                                ></v-radio>
                            </div>
                            <v-btn class="mt-2" color="primary" @click="checkAnswer">Submit</v-btn>
                        </div>
                    </div>
                    <div v-else>
                        <div v-html="markedAnswer"></div>
                    </div>
                </div>
                <div class="mt-4 flex justify-between">
                    <v-btn :disabled="currentIndex === 0" color="primary" @click="prevCard">Previous</v-btn>
                    <v-btn :disabled="currentIndex === flashcards.length - 1" color="primary" @click="nextCard">Next
                    </v-btn>
                </div>
            </div>
            <div v-else class="text-center text-gray-600">
                No flashcards available.
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed, ref} from 'vue';
import {marked} from 'marked';

const props = defineProps({
    flashcards: {
        type: Array,
        default: () => []
    }
});

const currentIndex = ref(0);
const isFlipped = ref(false);
const selectedOption = ref(null);
const incorrectCards = ref([]);

const flashcards = computed(() => props.flashcards);
const currentCard = computed(() => flashcards.value[currentIndex.value]);

const markedQuestion = computed(() => {
    return currentCard.value ? marked(currentCard.value.question) : '';
});

const markedAnswer = computed(() => {
    return currentCard.value ? marked(currentCard.value.answer) : '';
});

const flipCard = () => {
    isFlipped.value = !isFlipped.value;
};

const nextCard = () => {
    if (currentIndex.value < flashcards.value.length - 1) {
        currentIndex.value++;
        isFlipped.value = false;
        selectedOption.value = null;
    } else {
        // If all cards have been completed, start over with incorrect cards
        if (incorrectCards.value.length > 0) {
            currentIndex.value = 0;
            flashcards.value = incorrectCards.value;
            incorrectCards.value = [];
            isFlipped.value = false;
            selectedOption.value = null;
        }
    }
};

const prevCard = () => {
    if (currentIndex.value > 0) {
        currentIndex.value--;
        isFlipped.value = false;
        selectedOption.value = null;
    }
};

const checkAnswer = () => {
    if (selectedOption.value === currentCard.value.answer) {
        isFlipped.value = true;
    } else {
        // Move the card to the incorrect cards list
        incorrectCards.value.push(flashcards.value[currentIndex.value]);
        flashcards.value.splice(currentIndex.value, 1);
        selectedOption.value = null;
        if (currentIndex.value >= flashcards.value.length) {
            currentIndex.value = 0;
        }
    }
};
</script>

<style scoped>
/* Add any additional styles for Markdown content here */
:deep(p) {
    margin-bottom: 0.5em;
}

:deep(ul), :deep(ol) {
    margin-left: 1.5em;
    margin-bottom: 0.5em;
}

:deep(code) {
    background-color: #f0f0f0;
    padding: 0.2em 0.4em;
    border-radius: 3px;
}
</style>
