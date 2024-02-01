<template>
    <!-- Modal toggle -->
    <button @click="showModal = !showModal"
        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">
        Toggle modal
    </button>

    <!-- Main modal -->
    <div v-show="showModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white w-full md:max-w-2xl mx-auto rounded-lg shadow-lg overflow-y-auto">
            <!-- Modal content -->
            <div class="p-4 md:p-5 space-y-4">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Terms of Service
                    </h3>
                    <button type="button" @click="showModal = !showModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form @submit.prevent="submitForm">
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <div v-html="errorMessages" class="text-red-500"></div>
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-white">
                                User Name
                            </label>
                            <input type="text" id="username" name="username" pattern="[A-Za-z0-9]+" required
                                class="mt-1 p-2 w-full border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700">
                        </div>

                        <!-- Поле E-mail -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">
                                E-mail
                            </label>
                            <input type="email" id="email" name="email" required
                                class="mt-1 p-2 w-full border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700">
                        </div>

                        <!-- Поле Home page -->
                        <div class="mb-4">
                            <label for="homepage" class="block text-sm font-medium text-gray-700 dark:text-white">
                                Home page
                            </label>
                            <input type="text" id="homepage" name="homepage"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700">
                        </div>

                        <!-- img -->
                        <div class="mb-4">
                            <span><img :src="reactiveCaptcha" v-if="reactiveCaptcha" /></span>
                            <button type="button" @click="reloadCaptcha" class="btn btn-danger" id="reload">
                                &#x21bb;
                            </button>

                            <input type="text" id="captcha" placeholder="Enter Captcha" name="captcha"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700">
                        </div>

                        <div class="mb-4">

                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                message</label>
                            <div class="flex space-x-4 mt-4">
                                <button @click.prevent="insertTag('i')" class="btn btn-primary">Italic</button>
                                <button @click.prevent="insertTag('strong')" class="btn btn-primary">Bold</button>
                                <button @click.prevent="insertTag('code')" class="btn btn-primary">Code</button>
                                <button @click.prevent="insertTag('a')" class="btn btn-primary">Add Link</button>
                            </div>

                            <textarea id="message" rows="4" name="message"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write your thoughts here..."></textarea>
                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="default-modal" type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I
                            accept</button>
                        <button data-modal-hide="default-modal" type="button" @click="showModal = !showModal"
                            class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

let { captcha } = defineProps(['captcha']);
const reactiveCaptcha = ref(captcha);
const errorMessages = ref('');

const reloadCaptcha = () => {
    axios.get('/reload-captcha')
        .then(response => {
            reactiveCaptcha.value = response.data.captcha;
        })
        .catch(error => {
            console.error('Помилка при виконанні AJAX-запиту:', error);
        });
};

const submitForm = () => {
    const formData = new FormData(document.querySelector('form'));

    formData.append('_token', csrf);

    axios.post('/captcha-validation', formData)
        .then(response => {
            console.log('Form submitted successfully!', response);
            errorMessages.value = '';
        })
        .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
                const errors = error.response.data.errors;
                const errorMessageArray = Object.values(errors).flat();
                errorMessages.value = errorMessageArray.join('<br>');
            } else {
                errorMessages.value = 'An unexpected error occurred.';
            }
            console.error('Error submitting form:', error);

            reloadCaptcha();
        });
};

const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const showModal = ref(false);

const insertTag = (tag) => {
    const messageInput = document.getElementById('message');
    const cursorPos = messageInput.selectionStart;
    const textBeforeCursor = messageInput.value.substring(0, cursorPos);
    const textAfterCursor = messageInput.value.substring(cursorPos);
    if (tag == 'a') {
        messageInput.value = textBeforeCursor + '<' + tag + ' href="" title="">' + '</' + tag + '>' + textAfterCursor;
    } else {
        messageInput.value = textBeforeCursor + '<' + tag + '>' + '</' + tag + '>' + textAfterCursor;
    }
    messageInput.setSelectionRange(cursorPos + tag.length, cursorPos + tag.length);
    messageInput.focus();
};
</script>