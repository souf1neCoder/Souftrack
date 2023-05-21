<template>
    <hero-home-view class="pb-48">
        <div class="w-full p-2 mt-8">
            <div class="mt-5">
                <div class="container mx-auto md:w-3/4 w-full">
                    <TabGroup>
                        <TabList
                            class="flex space-x-1 justify-center rounded-xl bg-main-blue p-1"
                        >
                            <Tab class="hidden lg:block">
                                <img
                                    class="rounded-full h-6 sm:h-10"
                                    src="images/logo.png"
                                    alt="logo souftrack"
                                />
                            </Tab>
                            <Tab v-slot="{ selected }">
                                <button
                                    :class="[
                                        'w-full rounded-lg md:p-2.5 p-1 md:text-base text-sm font-medium md:leading-5 leading-0 text-white hover:bg-white[0.12]',
                                        'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                        selected ? 'bg-white/[0.12]' : '',
                                    ]"
                                >
                                    Expenses Categories
                                </button>
                            </Tab>
                            <Tab v-slot="{ selected }">
                                <button
                                    :class="[
                                        'w-full rounded-lg md:p-2.5 p-1 md:text-base text-sm font-medium md:leading-5 leading-0 text-white hover:bg-white[0.12]',
                                        'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                        selected ? 'bg-white/[0.12]' : '',
                                    ]"
                                >
                                    Income Categories
                                </button>
                            </Tab>
                            <Tab v-slot="{ selected }">
                                <button
                                    :class="[
                                        'w-full rounded-lg md:p-2.5 p-1 md:text-base text-sm font-medium md:leading-5 leading-0 text-white hover:bg-white[0.12]',
                                        'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                        selected ? 'bg-white/[0.12]' : '',
                                    ]"
                                >
                                    Expenses Stats
                                </button>
                            </Tab>
                            <Tab v-slot="{ selected }">
                                <button
                                    :class="[
                                        'w-full rounded-lg md:p-2.5 p-1 md:text-base text-sm font-medium md:leading-5 leading-0 text-white hover:bg-white[0.12]',
                                        'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                        selected ? 'bg-white/[0.12]' : '',
                                    ]"
                                >
                                    Income Stats
                                </button>
                            </Tab>
                        </TabList>

                        <TabPanels class="mt-2">
                            <!--  -->
                            <TabPanel
                                :class="[
                                    'rounded-xl bg-white p-3',
                                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                ]"
                            >
                                <hero />
                            </TabPanel>
                            <!--  -->
                            <TabPanel
                                :class="[
                                    'rounded-xl bg-white p-3',
                                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                ]"
                            >
                            <div v-if="statistics_circle_exp.length >= 1">
                                <circle-chart
                                    :chartData="statistics_circle_exp"
                                />
                            </div>
                            <div v-else>
                                <h6 class="pt-4 md:text-xl text-base text-dark-light text-center">
                No Transactions Yet
            </h6>
                            </div>
                            </TabPanel>
                            <!--  -->
                            <TabPanel
                                :class="[
                                    'rounded-xl bg-white p-3',
                                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                ]"
                            >
                            <div v-if="statistics_circle_exp.length >= 1">

                                <circle-chart
                                    :chartData="statistics_circle_inc"
                                />
                                </div>
                                <div v-else>
                                <h6 class="pt-4 md:text-xl text-base text-dark-light text-center">
                No Transactions Yet
            </h6>
                            </div>
                            </TabPanel>
                            <!--  -->
                            <TabPanel
                                :class="[
                                    'rounded-xl bg-white p-3 pb-12',
                                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                ]"
                            >
                                <line-chart
                                    :chartData="statistics_line_exp"
                                    chartTitle="Expenses Statistics"
                                />
                            </TabPanel>
                            <TabPanel
                                :class="[
                                    'rounded-xl bg-white p-3 pb-12',
                                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                ]"
                            >
                                <line-chart
                                    :chartData="statistics_line_inc"
                                    chartTitle="Income Statistics"
                                />
                            </TabPanel>
                        </TabPanels>
                    </TabGroup>
                </div>
            </div>
        </div>
    </hero-home-view>
    <spinner v-if="loader" />
</template>

<script setup>
import HeroHomeView from "../components/HeroHomeView.vue";
import CircleChart from "../components/statistics/CircleChart.vue";
import LineChart from "../components/statistics/LineChart.vue";
import Hero from "../components/statistics/Hero.vue";
import Spinner from "../components/Spinner.vue";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
const store = useStore();
store.dispatch("loadStatistics");
const loader = computed(() => store.getters.getLoaderSpinner);

let statistics_circle_exp = computed(
    () => store.getters.getChartCircleOptionsExp
);
let statistics_circle_inc = computed(
    () => store.getters.getChartCircleOptionsInc
);
let statistics_line_inc = computed(() => store.getters.getChartLineOptionsInc);
let statistics_line_exp = computed(() => store.getters.getChartLineOptionsExp);
</script>

<style></style>
