<template>
    <div class="fixed bottom-0 w-full rounded-t-xl bg-white shadow z-10	">
        <div class="container mx-auto p-2">
            <nav class="lg:w-3/4 md:w-full mx-auto">
                <ul class="flex justify-between items-center">
                    <li  data-bs-toggle="tooltip" data-bs-placement="top" title="Dashboard">
                        <router-link
                            :to="{ name: 'Dashboard' }"
                            class="p-3 hover:text-main-blue text-dark-bold transition ease-in-out delay-300 md:text-xl text-sm"


                        >
                            <i class="fa-solid fa-wallet"></i>
                        </router-link>
                    </li>
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Statistics">
                        <router-link
                            :to="{ name: 'Statistics' }"
                            class="p-3 hover:text-main-blue text-dark-bold transition ease-in-out delay-300  md:text-xl text-sm"
                            ><i class="fa-solid fa-chart-pie"></i>
                        </router-link>
                    </li>
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Add Transaction">
                        <button
                        @click="openModalOpr"
                            class="p-5 text-white bg-main-blue hover:bg-blue-800 rounded-lg transition ease-in-out delay-300  md:text-xl text-sm"
                        >

                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </li>
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Search">
                        <router-link
                            :to="{ name: 'Search' }"
                            class="p-3 hover:text-main-blue text-dark-bold transition ease-in-out delay-300  md:text-xl text-sm"
                            ><i class="fa-solid fa-magnifying-glass"></i>
                        </router-link>
                    </li>
                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Categories">
                        <router-link
                            :to="{ name: 'Categories' }"
                            class="p-3 hover:text-main-blue text-dark-bold transition ease-in-out delay-300  md:text-xl text-sm"

                            ><i class="fa-solid fa-table-list"></i>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <add-operation v-if="store.getters.getToken" />
</template>

<script setup>
import AddOperation from './operations/AddOperation.vue';
// IMPORTS
import { useStore } from "vuex";
import {useRouter} from 'vue-router'

import { ref, computed, reactive,provide,watch } from "vue";
//
const router = useRouter();
const store = useStore();
let isOpenOpr = ref(false);
provide('isOpenOpr',isOpenOpr);

const openModalOpr = ()=>{
    if(store.getters.getToken){

        isOpenOpr.value = true
    }else{
        router.push({name:'Login'})
    }
}
</script>

<style>
.router-link-active{
    color: #277BC0 !important;
}
</style>
