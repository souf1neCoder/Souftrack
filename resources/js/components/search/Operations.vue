<template>
    <div class="md:mt-16 mt-12 pb-48">
        <div class="md:w-3/4 w-11/12 mx-auto md:p-5 p-2">
            <div
                class="mt-4 grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <div
                    v-for="opr in props.operations"
                    :key="opr.id" data-bs-toggle="tooltip" data-bs-placement="top" :title="opr.remark"
                    class="rounded-xl bg-white shadow-lg h-auto"
                >
                <div class="w-full rounded-t-xl text-center p-1 font-medium text-white"
                            :class="
                                opr.categories.category_type == 'expense'
                                    ? 'bg-red-600'
                                    : 'bg-green-600'
                            "
                >
                <h2><span v-text="opr.categories.category_type == 'expense' ? '-' : '+'"></span>{{ opr.amount }}</h2>
            </div>
                    <div class="flex justify-between md:p-4 p-2 items-center">
                        <div class="">
                        <p class="text-sm font-medium text-gray-500">
                            {{ moment(opr.created_at).format("ll") }}
                        </p>
                        <h3 class="font-semibold text-dark-bold">
                            {{ opr.categories.category_name }}
                        </h3>
                        <!-- <p class="mt-2 text-sm text-gray-500">
                            {{ opr.remark }}
                        </p> -->
                    </div>
                    <div
                        class="flex flex-col h-full justify-between items-center"
                    >
                        <div
                            class="w-6 h-6 cursor-pointer flex text-slate-400 items-center justify-center rounded-full border-2 border-slate-400 hover:border-red-600 hover:text-red-600 transition ease-in-out delay-300"
                            @click="deleteOperation(opr.id)"
                        >
                            <i class="fa-solid fa-minus"></i>
                        </div>
                        <div>
                            <button
                                type="button"
                                @click="openModalEditOpr(opr.id)"
                                class="px-2 text-xl text-slate-400 hover:text-dark-bold transition ease-in-out delay-300"
                            >
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>
                    </div>
                    </div>
                    <!-- <div class="">
                        <h2
                            class="font-medium rounded md:px-2 px-1 py-1 text-white"
                            :class="
                                opr.categories.category_type == 'expense'
                                    ? 'bg-red-600'
                                    : 'bg-green-600'
                            "
                        >
                            <span
                                v-text="
                                    opr.categories.category_type == 'expense'
                                        ? '-'
                                        : '+'
                                "
                            ></span
                            >{{ opr.amount }}
                        </h2>
                    </div> -->


                </div>
            </div>
        </div>
    </div>
    <edit-operation />
</template>

<script setup>
import EditOperation from "../operations/EditOperation.vue";

import { ref, reactive, computed, provide } from "vue";
import {useRouter} from 'vue-router'

import moment from "moment";
import { useStore } from "vuex";
import Swal from "sweetalert2";
const props = defineProps(["operations"]);
const store = useStore();
const router = useRouter();

let isOpenEditOpr = ref(false);
provide("isOpenEditOpr", isOpenEditOpr);

let operation = reactive({});
provide("operation", operation);
const deleteOperation = async (id) => {
    await axios
        .delete(`api/operations/${id}`, store.getters.getConfig)
        .then((res) => {
            console.log(res.data.message);
            Swal.fire({
                title: res.data.message,
                icon: "success",
                showClass: {
                    popup: "animate__animated animate__fadeInDown",
                },
                hideClass: {
                    popup: "animate__animated animate__fadeOutUp",
                },
            });
            console.log(router.currentRoute.value.name)
            router.currentRoute.value.name === "Dashboard"
                ? store.dispatch("loadOperations")
                : router.push({ name: "Dashboard" });
        })
        .catch((err) => {
            console.log(err.message);
        });
};

const openModalEditOpr = async (id) => {
    await axios
        .get(`api/operations/${id}/edit`, store.getters.getConfig)
        .then((res) => {
            console.log(res.data.data);
            operation.id = res.data.data.id;
            operation.amount = res.data.data.amount;
            operation.remark = res.data.data.remark;
            operation.category_id = res.data.data.category_id;
        })
        .catch((err) => {
            console.log(err.message);
        });
    isOpenEditOpr.value = true;
};
</script>

<style></style>
