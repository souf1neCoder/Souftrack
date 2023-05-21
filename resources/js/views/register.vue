<template>
    <hero-home-view  class="pb-48">
        <div class="w-full xl:w-3/4 lg:w-11/12 mx-auto flex p-5">
            <!-- Col -->
            <div
                class="w-full h-auto hidden lg:block lg:w-5/12 bg-cover rounded-l-lg"
                style="background-image: url('images/wallet.jpg')"
            ></div>
            <!-- Col -->
            <div
                class="w-full lg:w-7/12 bg-white p-5  "
            >
                <h3 class="pt-4 text-2xl text-dark-light text-center">
                    Create an Account!
                </h3>

                <form
                    @submit.prevent="register"
                    class="px-8 pt-6 pb-8 mb-4 bg-white rounded"
                >
                    <div class="mb-4">
                        <label
                            class="block mb-2 text-sm font-bold text-dark-bold"
                            for="fullname"
                        >
                            Fullname
                        </label>
                        <input
                            class="w-full px-3 py-2 mb-1 text-sm leading-tight text-dark-bold border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            id="fullname"
                            type="text"
                            placeholder="Fullname"
                            v-model="form.fullname"
                            :class="errors && errors.fullname ? 'border-red-600' : ''"
                        />
                    <small class="text-red-600" v-if="errors && errors.fullname">{{ errors.fullname[0]}}</small>
                    </div>
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
                            type="text"
                            placeholder="Email"
                            v-model="form.email"
                            :class="errors && errors.email ? 'border-red-600' : ''"

                        />
                    <small class="text-red-600" v-if="errors && errors.email">{{ errors.email[0]}}</small>

                    </div>
                    <div class="mb-4 md:flex md:justify-between">
                        <div class="mb-4 md:mr-2 md:mb-0">
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
                                :class="errors && errors.password ? 'border-red-600' : ''"
                            />
                    <small class="text-red-600" v-if="errors && errors.password">{{ errors.password[0]}}</small>

                            <!-- <p class="text-xs italic text-red-500">Please choose a password.</p> border-red-500 -->
                        </div>
                        <div class="md:ml-2">
                            <label
                                class="block mb-2 text-sm font-bold text-dark-bold"
                                for="c_password"
                            >
                                Confirm Password
                            </label>
                            <input
                                class="w-full px-3 py-2 mb-3 text-sm leading-tight text-dark-bold border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="c_password"
                                type="password"
                                placeholder="******"
                                v-model="form.password_confirmation"
                                :class="errors && errors.password_confirmation ? 'border-red-600' : ''"
                            />
                    <small class="text-red-600" v-if="errors && errors.password_confirmation">{{ errors.password_confirmation[0]}}</small>

                        </div>
                    </div>
                    <div class="mb-6 text-center">
                        <button
                            class="w-full px-4 py-2 font-bold text-white bg-main-blue rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                            type="submit"
                        >
                            Sign Up
                        </button>
                    </div>
                    <hr class="mb-6 border-t" />

                    <div class="text-center">
                        <router-link
                            class="inline-block text-sm text-main-blue align-baseline hover:text-blue-800"
                            :to="{ name: 'Login' }"
                        >
                            Already have an account? Sign in!
                        </router-link>
                    </div>
                </form>
            </div>
        </div>
    </hero-home-view>
</template>
<script setup>
// Import components
import HeroHomeView from "../components/HeroHomeView.vue";
// Import methods
import { reactive, ref , computed} from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
// Setup
const router = useRouter();
const store = useStore();

let form = reactive({
    fullname: "",
    email: "",
    password: "",
    password_confirmation: "",
});
let errors = ref([]);


const register = async () => {
    await axios
        .post("/api/register", form,store.getters.getConfig)
        .then((res) => {

                store.dispatch("setToken", res.data.data);
            store.dispatch('loadProfile');
            router.push({ name: "Dashboard" });

        })
        .catch((e) => {
            if(e.response.status === 422){
                errors.value = e.response.data.errors

                console.log(errors.value);
            }else{
                            store.dispatch('popUp',{iconMsg:'error',msg:'Something went wrong.'});

            }
        });
};
</script>
