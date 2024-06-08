<template>
    <div class="flex items-center justify-center h-screen">
        <form @submit.prevent="sendForm" class="
            border-8 border-gray-200 rounded-xl
            w-[500px] -mt-14 p-8
            flex flex-col gap-y-3
        ">
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Заголовок</span>
                <input class="
                px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                focus-visible:outline-brand-2 outline-2
            " type="text" v-model="data.title">
            </label>
            <input v-model="data.datetime" type="datetime-local" />
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Сервис</span>
                <select class="
                px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                focus-visible:outline-brand-2 outline-2" v-model="data.service_name">
                    <option value="Магазин">Магазин</option>
                    <option value="Доставка">Доставка</option>
                    <option value="Приложение">Приложение</option>
                </select>
            </label>
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Оценка</span>
                <div class="flex flex-item">
                    <template v-for="i in 5" :key="i">
                        <input type="radio" :id="i" name="rating" :value="i" class="sr-only" v-model="data.rating" />
                        <label :for="i" class="cursor-pointer">
                            <svg class="w-4 h-4 text-yellow-300 me-1" :class="{ 'dark:text-gray-500': i > data.rating }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        </label>
                    </template>
                </div>
            </label>
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Описание</span>
                <textarea class="
                    px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                    focus-visible:outline-brand-2 outline-2
                " rows="6" v-model="data.description" />
            </label>
            <button class="
                grid place-content-center w-full p-2 mt-1 border-2 border-gray-300 rounded-md shadow-sm outline-none bg-white
                text-lg font-semibold tracking-wide text-gray-400
                transition-all
                focus-visible:bg-brand-2 focus-visible:border-green-700 focus-visible:text-green-800 focus-visible:shadow-xl
                hover:bg-brand-2 hover:border-green-700 hover:text-green-800 hover:shadow-xl
            " type="submit">Отправить</button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import axios from 'axios';
import env from '@/env.json'
import router from '@/router';

const data = reactive({
    description: '',
    title: '',
    datetime: '',
    service_name: '',
    rating: 1,
});

const sendForm = async () => {
    try {
        const response = await sendFormImpl();
        if (!response.data.id)
            throw new Error('Ошибка сервера');
        await router.push({ name: 'feedback-show', params: { id: response.data.id } });
    } catch (error) {
        alert(error);
    }
}

const sendFormImpl = async () => {
    return await axios.post<StoreFeedbackResponse>(env.backend_url + '/feedbacks', {
        'description': data.description,
        'title': data.title,
        'datetime':  new Date(data.datetime).getTime(),
        'service_name': data.service_name,
        'rating': data.rating,
    });
}

interface StoreFeedbackResponse {
    id: number
}
</script>
