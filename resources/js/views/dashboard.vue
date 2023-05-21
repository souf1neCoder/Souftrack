<template>
    <hero-home-view>
        <div
            class="absolute top-0 md:left-0 left-1/2 -translate-x-1/2 md:translate-x-0 px-2 md:px-4 w-full md:w-auto py-1 md:rounded-br-xl md:rounded-tl-xl bg-dark-bold text-white"
        >
            <p v-if="profile.account" class="text-center md:text-left">
                <span class="inline-block text-base" v-if="profile.account.start_month != 1 && profile.account.start_month != ''"
                    >{{
                        moment()
                            .set("date", profile.account.start_month)
                            .format("ll")
                    }}
                    -
                    {{
                        moment()
                            .set("date", profile.account.start_month - 1)
                            .add(1, "months")
                            .format("ll")
                    }}</span
                >
                <span v-else>{{ moment().format("ll") }}</span>
            </p>
        </div>
        <div class="md:w-3/4 w-full mx-auto md:mt-16 mt-12" >
            <div class="flex justify-between md:flex-row flex-col">
                <div class="flex items-start rounded-xl bg-white p-4 shadow-lg md:mb-0 mb-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Income this month">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50"
                    >
                        <img
                            alt="income logo"
                            class="rotate-180 h-8 w-8"
                            src="images/expense-income.png"
                        />
                    </div>

                    <div class="ml-4">
                        <h3 class="font-bold text-green-600">+ {{ income }}</h3>
                        <p class="mt-2 text-sm text-gray-500">Income</p>
                    </div>
                </div>
                <div data-bs-toggle="tooltip" data-bs-placement="top" title="Balance this month"
                    class="flex items-start rounded-xl md:border-2 md:border-t-main-blue bg-white p-4 shadow-lg  md:mb-0 mb-4"
                >
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50"
                    >
                        <img
                            alt="balance logo"
                            class="h-8 w-8"
                            src="images/wallet.png"
                        />
                    </div>

                    <div class="ml-4">
                        <h3 class="font-bold text-main-blue">{{ balance }}</h3>
                        <p class="mt-2 text-sm text-gray-500">Balance</p>
                    </div>
                </div>
                <div class="flex items-start rounded-xl bg-white p-4 shadow-lg  md:mb-0 mb-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Expenses this month">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50"
                    >
                        <img
                            alt="expenses logo"
                            class="h-8 w-8"
                            src="images/expense-income.png"
                        />
                    </div>

                    <div class="ml-4">
                        <h3 class="font-bold text-red-600">- {{ expenses }}</h3>
                        <p class="mt-2 text-sm text-gray-500">Expenses</p>
                    </div>
                </div>
            </div>
            <div class="flex md:mt-6 flex-col rounded-xl bg-white p-4 shadow-lg" v-if="profile.account" >
                <h3 class="md:font-bold font-medium  text-dark-bold">
                    Budget : {{ profile.account.budget }}
                </h3>

                <div class="w-full bg-main-yellow rounded-full h-3">
                    <div
                        class="bg-main-blue h-3 rounded-full"
                        :style="{ width: widthBudget + '%' }"
                    ></div>
                </div>
                <h4 class="mt-2 text-sm text-gray-500 text-right">Budget Remaining : {{profile.account.budget - expenses}}</h4>
            </div>
        </div>
    </hero-home-view>
    <operations :operations="operations" />
    <spinner v-if="loader" />
</template>
<script setup>
// IMPORTS
import { useRouter } from "vue-router";
import Operations from "../components/search/Operations.vue";
import Spinner from "../components/Spinner.vue";

import { useStore } from "vuex";
import { ref, computed, reactive, onMounted ,watch,inject} from "vue";
import moment from "moment";

// Import components
import HeroHomeView from "../components/HeroHomeView.vue";
//
const router = useRouter();
const store = useStore();
store.dispatch('loadOperations')


// DATA
let widthBudget = computed(() => {

    return parseFloat(profile.value.account.budget) != 0
        ? ((parseFloat(profile.value.account.budget) - expenses.value) * 100) /
              parseFloat(profile.value.account.budget)
        : 0;
});
const loader = computed(()=>store.getters.getLoaderSpinner)
const operations = computed(() => store.getters.getOperations)
const expenses = computed(() => store.getters.getExpenses)
const income = computed(() => store.getters.getIncome)
const profile = computed(()=>store.getters.getProfile)

const balance = computed(() => income.value - expenses.value);

const formOpr = reactive({
    amount: 0.0,
    remark: "",
    category_id: null,
});


</script>
