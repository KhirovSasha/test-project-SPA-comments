<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import {setupAxiosInterceptors} from '../helpers/axiosInterceptors.js'

export default {
    setup() {
        setupAxiosInterceptors();

        onMounted(() => {
            axios.get('api/mainePage')
                .then(res => {
                    console.log(res);
                }).catch(err => {
                    console.log(err)
                })
        })

        return {};
    }
}
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


