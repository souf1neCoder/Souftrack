<template>
    <TransitionRoot appear :show="isOpenAdd" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 align-middle shadow-xl transition-all"
                        >
                            <button
                                type="button"
                                class="absolute right-1 top-1 border border-transparent px-4 py-2 text-sm font-medium text-dark-bold hover:text-main-blue focus:outline-none"
                                @click="closeModal"
                            >
                                <i class="fa-solid fa-x"></i>
                            </button>
                            <div class="mt-5">
                                <div class="container mx-auto">
                                    <form
                                        @submit.prevent="addCategory"
                                        class="flex flex-col w-10/12 mx-auto"
                                    >
                                        <div class="mb-6 text-left">
                                            <input
                                                type="text"
                                                v-model="category.category_name"
                                                placeholder="category name"
                                                class="border-b-2 focus:border-b-main-yellow w-full focus:outline-none text-dark-bold text-sm leading-tight appearance-none"
                                                :class="
                                                    errors &&
                                                    errors.category_name
                                                        ? 'border-red-600'
                                                        : ''
                                                "
                                            />
                                            <small
                                                class="text-red-600"
                                                v-if="
                                                    errors &&
                                                    errors.category_name
                                                "
                                                >{{
                                                    errors.category_name[0]
                                                }}</small
                                            >
                                        </div>
                                        <div class="mb-6 text-left flex">
                                            <div
                                                class="form-check form-check-inline mr-4"
                                            >
                                                <input
                                                    class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-main-yellow checked:border-main-yellow focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                                    type="radio"
                                                    name="category_type"
                                                    id="income"
                                                    value="income"
                                                    v-model="category.category_type"
                                                    checked

                                                />
                                                <label
                                                    class="form-check-label inline-block text-gray-800"
                                                    for="income"
                                                    >Income</label
                                                >
                                            </div>
                                            <div
                                                class="form-check form-check-inline"
                                            >
                                                <input
                                                    class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-main-yellow checked:border-main-yellow focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                                    type="radio"
                                                    name="category_type"
                                                    id="expense"
                                                    value="expense"
                                                    v-model="category.category_type"
                                                />
                                                <label
                                                    class="form-check-label inline-block text-gray-800"
                                                    for="expense"
                                                    >Expense</label
                                                >
                                            </div>
                                             <small
                                                class="text-red-600"
                                                v-if="
                                                    errors &&
                                                    errors.category_type
                                                "
                                                >{{
                                                    errors.category_type[0]
                                                }}</small
                                            >
                                        </div>
                                        <button
                                            type="submit"

                                            class="w-full px-4 py-2 font-bold text-white bg-main-blue rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                        >
                                            Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
     
} from "@headlessui/vue";
// IMPORTS
import { useStore } from "vuex";
import { ref, computed, reactive, inject } from "vue";
const store = useStore();
let category =reactive({
    category_name:"",
    category_type:"income"
})
let isOpenAdd = inject("isOpenAdd");
let errors = ref([]);
const closeModal = () => {
    isOpenAdd.value = false;
    errors.value = [];
    category.category_name = "";
    category.category_type = "income";
};
const addCategory = async () => {
    await axios
        .post("api/categories", category, store.getters.getConfig)
        .then((res) => {
            console.log(res.data.data);
            closeModal();
            store.dispatch('popUp',{iconMsg:'success',msg:res.data.message});
            store.dispatch('loadCategories')

        })
        .catch((err) => {
            if(err.response.status === 422){
                errors.value = err.response.data.errors
            }else{
            store.dispatch('popUp',{iconMsg:'error',msg:'Something went wrong.'});

            }
        });
};
</script>

<style></style>
