<template>
    <hero-home-view  class="pb-48">
        <!-- Col -->
        <div class="w-full lg:w-1/2 bg-white mx-auto p-1 lg:p-5">
            <h3 class="pt-4 text-2xl text-dark-light text-center">Sign In!</h3>
            <form
                @submit.prevent="login"
                class="px-0 lg:px-8 pt-6 pb-8 mb-4 bg-white rounded"
            >
                <div class="mb-4">
                    <label
                        class="block mb-2 text-sm font-bold text-dark-bold"
                        for="email"
                    >
                        Email
                    </label>
                    <input
                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-dark-bold border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="email"
                        type="email"
                        placeholder="Email"
                        v-model="form.email"
                        :class="errors && errors.email ? 'border-red-600' : ''"
                    />
                    <small class="text-red-600" v-if="errors && errors.email">{{
                        errors.email[0]
                    }}</small>
                </div>
                <div class="mb-4">
                    <label
                        class="block mb-2 text-sm font-bold text-dark-bold"
                        for="password"
                    >
                        Password
                    </label>
                    <input
                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-dark-bold border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="password"
                        type="password"
                        placeholder="******"
                        v-model="form.password"
                        :class="
                            errors && errors.password ? 'border-red-600' : ''
                        "
                    />
                    <small
                        class="text-red-600"
                        v-if="errors && errors.password"
                        >{{ errors.password[0] }}</small
                    >

                    <!-- <p class="text-xs italic text-red-500">Please choose a password.</p> border-red-500 -->
                </div>
                <div class="mb-6 text-center">
                    <button
                        class="w-full px-4 py-2 font-bold text-white bg-main-blue rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                        type="submit"
                    >
                        Sign In
                    </button>
                </div>
                <hr class="mb-6 border-t" />

                <div class="text-center">
                    <router-link
                        class="inline-block text-sm text-main-blue align-baseline hover:text-blue-800"
                        :to="{ name: 'Register' }"
                    >
                    Already i have an account, Sign up!
                    </router-link>
                </div>
            </form>
        </div>
    </hero-home-view>
</template>
<script setup>
// Import components
import HeroHomeView from "../components/HeroHomeView.vue";
import Swal from "sweetalert2";
// Import Methods
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
// Setup
const router = useRouter();
const store = useStore();

let form = reactive({
    email: "",
    password: "",
});
let errors = ref([]);

const login = async () => {

        await axios
            .post("/api/login", form)
            .then((res) => {
                store.dispatch("setToken", res.data.data);
        console.log(store.getters.getConfig);

                store.dispatch('loadProfile');
                console.log(res.data.data);
                router.push({ name: "Dashboard" });
            })
            .catch((e) => {
                if (e.response.status === 422) {
                    errors.value = e.response.data.errors;

                    console.log(errors.value);
                } else if (e.response.status === 400) {

                store.dispatch('popUp',{iconMsg:'error',msg:e.response.data.message[0]});

                }else{
                store.dispatch('popUp',{iconMsg:'error',msg:'Something went wrong.'});

                }
            });
};
</script>
