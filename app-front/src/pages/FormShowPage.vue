<template>
    <main
        class="flex items-center justify-center h-screen">
        <div class="
            border-8 border-gray-200 rounded-xl
            w-[500px] -mt-14 p-8
            flex flex-col gap-y-5
        ">
            <div v-if="feedback.isLoaded" class="flex flex-col">
                <h1 class="text-3xl font-medium text-gray-500">{{ feedback.title }}</h1>
                <h3 class="text-xl font-medium text-gray-500">{{ feedback.service_name }}</h3>
                <p class="text-sm text-gray-400">{{ datetime }}</p>
                <div class="flex">
                    <svg v-for="i in 5" :key="i" class="w-4 h-4 text-yellow-300 me-1" :class="{ 'dark:text-gray-500': i > feedback.rating }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                    </svg>
                </div>
                <p class="text-base mt-2 text-gray-500">{{ feedback.description }}</p>
            </div>
            <div>
                <RouterLink
                    :to="{ name: 'feedback-create' }"
                    class="
                        flex items-center gap-0.5 outline-brand-2
                        text-gray-400
                        transition-colors
                        focus:text-brand-2 hover:text-brand-2
                ">
                    <svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-5 h-6 -mb-0.5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                    </svg>
                    <span>Новый отзыв</span>
                </RouterLink>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import axios from 'axios';
import { onBeforeMount, reactive, computed } from 'vue';
import { useRoute } from 'vue-router';
import env from '@/env.json';

const idFromRouter = useRoute().params.id
const feedback = reactive({
    title: '',
    description: '',
    datetime: '',
    service_name: '',
    rating: 0,
    isLoaded: false
});

const datetime = computed(() => {
    const date = new Date(feedback.datetime * 1000);
    date.setTime(date.getTime() + date.getTimezoneOffset() * 60 * 1000);
    return date.toLocaleString();
})


onBeforeMount(() => {
    axios.get<FeedbackResponse>(env.backend_url + `/feedbacks/${idFromRouter}`)
        .then(feedbackResponse => {
            const feedbackResponseData = feedbackResponse.data;
            feedback.title = feedbackResponseData.title;
            feedback.description = feedbackResponseData.description;
            feedback.datetime = feedbackResponseData.datetime;
            feedback.service_name = feedbackResponseData.service_name;
            feedback.rating = feedbackResponseData.rating;
            feedback.isLoaded = true;
        }).catch(error => {
            alert(error);
        });
});

interface FeedbackResponse {
    title: string;
    description: string;
    datetime: string;
}
</script>
