<template>
   <nav class="w-full">
        <div
            class="container mx-auto p-2 flex flex-wrap justify-between items-center"
        >
            <div class="logo" data-bs-toggle="tooltip" data-bs-placement="right" title="Souftrack" >
                <router-link class="navbar-brand" :to="{ name: 'Home' }"
                    ><img
                        class="mr-3 rounded-full h-12 sm:h-22"
                        src="images/logo.png"
                        alt="logo souftrack"
                /></router-link>
            </div>
            <ul class="text-lg flex items-center  font-medium">
                <li  v-if="token == 0"

                class="inline-block mx-1 lg:mx-3 rounded bg-white bg-opacity-25 p-1 lg:p-2 hover:bg-white hover:text-main-blue transition ease-in-out delay-300"

                :class="route.currentRoute.value.name == 'Login' ? 'bg-opacity-100 text-main-blue' : ''"
                >
                    <router-link
                        :to="{ name: 'Login' }"

                        class="p-1 lg:p-2 tracking-wider text-base"
                        >Sign In</router-link
                    >
                </li>
                <li v-if="token == 0"

                class="inline-block mx-1 lg:mx-3 rounded bg-white bg-opacity-25 p-1 lg:p-2 hover:bg-white hover:text-main-blue transition ease-in-out delay-300"

                :class="route.currentRoute.value.name == 'Register' ? 'bg-opacity-100  text-main-blue' : ''"
                >
                <router-link
                    :to="{name : 'Register' }"
                        class="p-1 lg:p-2 tracking-wider text-base"
                        aria-current="page"
                        >Sign Up</router-link
                    >
                </li>
                <li class="inline-block mx-1  sm:mx-2" v-if="token != 0">
                    <!--  -->
                    <Menu v-if="profile.user && profile.account">
                        <div>
                            <MenuButton class="p-2">
                                <img data-bs-toggle="tooltip" data-bs-placement="bottom"
                                :title="profile.user ?  profile.user.username : ''"
                                    class="rounded-full w-10 h-10 border-white border-2 shadow-white-500/50"
                                    :src="profile.account ? profile.account.account_image : 'images/default_profile_img.png'"
                                    alt="account image"
                                />
                            </MenuButton>
                        </div>

                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                                class="absolute right-6 mt-2 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg"
                            >
                                <div class="p-1">
                                    <MenuItem>
                                        <button
                                        @click="openModalSetting"
                                            class="text-gray-900 group flex w-full hover:bg-slate-100 items-center justify-center rounded-md py-2 px-4 text-sm"
                                        >
                                            <i class="fa-solid fa-gear pr-2"></i> Settings
                                        </button>
                                    </MenuItem>

                                </div>
                                <div class="p-1">
                                    <MenuItem>
                                        <button @click.once="logout"
                                            class="text-gray-900 group flex w-full hover:bg-slate-100 items-center justify-center rounded-md py-2 px-4 text-sm"
                                        >
                                            <i class="fa-solid fa-right-from-bracket pr-2"></i> Logout
                                        </button>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                    <!--  -->
                </li>
            </ul>
        </div>
        <set-settings   :profile="profile" />
    </nav>
    <spinner  v-if="loader" />
</template>

<script setup>
import SetSettings from './settings/SetSettings.vue';
import Spinner from "../components/Spinner.vue";

import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { useStore } from "vuex";
import { computed,reactive,onMounted,provide,ref } from "vue";
import {useRouter} from 'vue-router';
const store = useStore();
const route = useRouter();
let isOpenSetting = ref(false);
const loader = ref(false);

provide('isOpenSetting',isOpenSetting)
const openModalSetting = ()=>{isOpenSetting.value = true}

let profile = computed(()=>{
    return store.getters.getProfile;
})
let token = computed(() => {
    return store.getters.getToken;
});

    if(token.value){
        store.state.configAuth.headers.Authorization =  `Bearer ${token.value}`
        store.dispatch('loadProfile');
    }


const logout = async ()=>{
    loader.value = true;
    await axios.post('api/logout',store.getters.getConfig).then((res) => {
        console.log(store.getters.getConfig);
        console.log(res.data)
        store.dispatch('removeToken')
    store.dispatch('clearData')
    console.log(store.state);
    route.push({name:"Login"})
        loader.value = false;
    }).catch((err) => {
        loader.value = false;
        console.error(err)
    });
    // store.dispatch('removeToken')
    // store.dispatch('clearData')
    // console.log(store.state);
    // route.push({name:"Login"})
}

</script>

<style>

</style>
