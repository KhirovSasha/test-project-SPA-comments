<script setup>
import Pagination from "@/Components/Pagination.vue";
import { defineProps, ref, onMounted } from 'vue';
import {Link} from '@inertiajs/vue3';
import { format, differenceInHours, parseISO } from 'date-fns';

const { comments, urlWithParameters, sort, sortAttribute } = defineProps(['comments', 'urlWithParameters', 'sort', 'sortAttribute']);

const sortUrl = ref(`${comments.meta.path}/?page=${comments.meta.current_page}&sort=${sort === 'ASC' && sortAttribute === 'userName' ? '-userName' : 'userName'}`);
const sortEmail = ref(`${comments.meta.path}/?page=${comments.meta.current_page}&sort=${sort === 'ASC' && sortAttribute === 'email' ? '-email' : 'email'}`);
const sortCrateAt = ref(`${comments.meta.path}/?page=${comments.meta.current_page}&sort=${sort === 'ASC' && sortAttribute === 'created_at' ? '-created_at' : 'created_at'}`);

onMounted(() =>{
    if(urlWithParameters != null) {
        comments.meta.links.forEach((e, index) => {

            if(e.url != null && index !== 0 && index !== comments.meta.links.length - 1) {
                const parts = urlWithParameters.split('&');
                e.url = comments.meta.path +  parts[0].slice(0, -1)+e.label + '&' + parts[1];
            }

        })

        if(comments.meta.links[0].url == null){
            comments.meta.links[comments.meta.links.length - 1].url = modifyUrlLastChar('increment');
        } else {
            comments.meta.links[0].url = modifyUrlLastChar('decrement');
        }
    }
})

const formatDateOrTime = (createdAt) => {
    const parsedDate = parseISO(createdAt);
    const currentTime = new Date();
    const hoursDifference = differenceInHours(currentTime, parsedDate);

    if (hoursDifference < 24) {
        return format(parsedDate, 'HH:mm:ss');
    } else {
        return format(parsedDate, 'dd/MM/yyyy');
    }
};

const modifyUrlLastChar = (operation) => {
    const parts = urlWithParameters.split('&');
    const lastChar = parts[0].charAt(parts[0].length - 1);

    const modifiedLastChar = operation === 'increment' ? parseInt(lastChar, 10) + 1 : parseInt(lastChar, 10) - 1;
    const modifiedFirstPart = parts[0].slice(0, -1) + modifiedLastChar;

    return comments.meta.path + modifiedFirstPart + '&' + parts[1];
};

</script>

<template>
    <h1 class="text-5xl font-bold underline">
        Hello world!
    </h1>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" v-if="comments" >
                    <Pagination :links="comments.meta.links"  />
                    <table>
                        <tr>
                            <th>№</th>
                            <th><Link :href="sortUrl">User Name</Link></th>
                            <th><Link :href="sortEmail">Email</Link></th>
                            <th>Comment</th>
                            <th><Link :href="sortCrateAt">Create at</Link></th>
                        </tr>
                        <tr v-for="(comment, index) in comments.data">
                            <td>{{ (comments.meta.current_page - 1) * comments.meta.per_page + index + 1}}</td>
                            <td>{{ comment.userName }}</td>
                            <td>{{ comment.userEmail }}</td>
                            <td>{{ comment.text }}</td>
                            <td>{{ formatDateOrTime(comment.createdAt) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
