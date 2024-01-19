<script setup>
import Pagination from "@/Components/Pagination.vue";
import { defineProps, ref, onMounted } from 'vue';
import {Link} from '@inertiajs/vue3'

const { comments, urlWithParameters, sort, sortAttribute } = defineProps(['comments', 'urlWithParameters', 'sort', 'sortAttribute']);

//$sortUrl = ref("{$comments.meta.path}/?page={$comments.meta.current_page}&sort=" . ($sort === 'ASC' && $sortAttribute === 'userName' ? '-userName' : 'userName'));

const sortUrl = ref((sort === 'ASC' && sortAttribute === 'userName') ? `${comments.meta.path}/?page=${comments.meta.current_page}&sort=-userName` : `${comments.meta.path}/?page=${comments.meta.current_page}&sort=userName`);
const sortEmail = ref((sort === 'ASC' && sortAttribute === 'email') ? `${comments.meta.path}/?page=${comments.meta.current_page}&sort=-email` : `${comments.meta.path}/?page=${comments.meta.current_page}&sort=email`);
const sortCrateAt = ref((sort === 'ASC' && sortAttribute === 'created_at') ? `${comments.meta.path}/?page=${comments.meta.current_page}&sort=-created_at` : `${comments.meta.path}/?page=${comments.meta.current_page}&sort=created_at`);

onMounted(() =>{
    console.log(urlWithParameters);
    if(urlWithParameters != null) {
        comments.meta.links.forEach((e, index) => {

            if(e.url != null && index !== 0 && index !== comments.meta.links.length - 1) {
                const parts = urlWithParameters.split('&');
                e.url = comments.meta.path +  parts[0].slice(0, -1)+e.label + '&' + parts[1];
            }
        })
    }
})
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
                            <td>{{ comment.createdAt }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
