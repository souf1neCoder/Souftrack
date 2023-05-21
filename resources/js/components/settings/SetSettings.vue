<template>
    <TransitionRoot appear :show="isOpenSetting" as="template">
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
                                    <TabGroup>
                                        <TabList
                                            class="flex space-x-1 justify-center rounded-xl bg-main-blue p-1"
                                        >
                                            <Tab

                                                v-slot="{ selected }"
                                            >
                                                <button
                                                    :class="[
                                                        'w-full rounded-lg md:p-2.5 p-1 md:text-base text-sm font-medium md:leading-5 leading-0 text-white hover:bg-white[0.12]',
                                                        'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                                        selected
                                                            ? 'bg-white/[0.12]'
                                                            : '',
                                                    ]"
                                                >
                                                    Budget
                                                </button>
                                            </Tab>
                                            <Tab

                                                v-slot="{ selected }"
                                            >
                                                <button
                                                     :class="[
                                                        'w-full rounded-lg md:p-2.5 p-1 md:text-base text-sm font-medium md:leading-5 leading-0 text-white hover:bg-white[0.12]',
                                                        'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                                        selected
                                                            ? 'bg-white/[0.12]'
                                                            : '',
                                                    ]"
                                                >
                                                    Start Month
                                                </button>
                                            </Tab>
                                             <Tab

                                                v-slot="{ selected }"
                                            >
                                                <button
                                                     :class="[
                                                        'w-full rounded-lg md:p-2.5 p-1 md:text-base text-sm font-medium md:leading-5 leading-0 text-white hover:bg-white[0.12]',
                                                        'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                                        selected
                                                            ? 'bg-white/[0.12]'
                                                            : '',
                                                    ]"
                                                >
                                                    Password
                                                </button>
                                            </Tab>
                                        </TabList>

                                        <TabPanels class="mt-2">
                                            <TabPanel

                                                :class="[
                                                    'rounded-xl bg-white p-3',
                                                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                                ]"
                                            >
                                                <form
                                        @submit.prevent="setBudgetMonth"
                                        class="flex flex-col w-10/12 mx-auto"
                                    >
                                        <div class="mb-2 text-left">

                                            <input
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                v-model="startMonthBudget.budget"
                                                placeholder="Budget"
                                                class="border-b-2 focus:border-b-main-yellow w-full focus:outline-none text-dark-bold text-sm leading-tight appearance-none"
                                                :class="
                                                    errors && errors.budget
                                                        ? 'border-red-600'
                                                        : ''
                                                "

                                            />
                                            <small
                                                class="text-red-600"
                                                v-if="
                                                    errors && errors.budget
                                                "
                                                >{{
                                                    errors.budget[0]
                                                }}</small
                                            >
                                        </div>
                                         <button
                                            type="submit"
                                            class="w-full px-2 py-1 md:text-base text-sm font-medium text-white bg-main-blue rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                        >
                                            Set Budget
                                        </button>
                                                </form>
                                            </TabPanel>
                                            <!--  -->
                                            <TabPanel

                                                :class="[
                                                    'rounded-xl bg-white p-3',
                                                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                                ]"
                                            >
                                               <form
                                        @submit.prevent="setBudgetMonth"
                                        class="flex flex-col w-10/12 mx-auto"
                                    >
                                        <div class="mb-2 text-left">

                                            <input
                                                type="number"
                                                step="1"
                                                min="1"
                                                max="27"
                                                v-model="startMonthBudget.start_month"
                                                placeholder="Start Month"
                                                class="border-b-2 focus:border-b-main-yellow w-full focus:outline-none text-dark-bold text-sm leading-tight appearance-none"
                                                :class="
                                                    errors && errors.start_month
                                                        ? 'border-red-600'
                                                        : ''
                                                "

                                            />
                                            <small
                                                class="text-red-600"
                                                v-if="
                                                    errors && errors.start_month
                                                "
                                                >{{
                                                    errors.start_month[0]
                                                }}</small
                                            >
                                        </div>
                                         <button
                                            type="submit"
                                            class="w-full px-2 py-1 md:text-base text-sm font-medium text-white bg-main-blue rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                        >
                                            Set Start Month
                                        </button>
                                                </form>
                                            </TabPanel>
                                             <!--  -->
                                            <TabPanel

                                                :class="[
                                                    'rounded-xl bg-white p-3',
                                                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                                                ]"
                                            >
                                                  <form
                                        @submit.prevent="changePassword"
                                        class="flex flex-col w-10/12 mx-auto"
                                    >
                                        <div class="mb-4 text-left">

                                            <input
                                                type="password"
                                                v-model="formPassword.oldPassword"
                                                placeholder="Current Password"
                                                class="border-b-2 focus:border-b-main-yellow w-full focus:outline-none text-dark-bold text-sm leading-tight appearance-none"
                                                :class="
                                                    errors && errors.oldPassword
                                                        ? 'border-red-600'
                                                        : ''
                                                "

                                            />
                                            <small
                                                class="text-red-600"
                                                v-if="
                                                    errors && errors.oldPassword
                                                "
                                                >{{
                                                    errors.oldPassword[0]
                                                }}</small
                                            >
                                        </div>

                                        <div class="mb-4 text-left">

                                            <input
                                                type="password"
                                                v-model="formPassword.password"
                                                placeholder="New Password"
                                                class="border-b-2 focus:border-b-main-yellow w-full focus:outline-none text-dark-bold text-sm leading-tight appearance-none"
                                                :class="
                                                    errors && errors.password
                                                        ? 'border-red-600'
                                                        : ''
                                                "

                                            />
                                            <small
                                                class="text-red-600"
                                                v-if="
                                                    errors && errors.password
                                                "
                                                >{{
                                                    errors.password[0]
                                                }}</small
                                            >
                                        </div>

                                        <div class="mb-4 text-left">

                                            <input
                                                type="password"
                                                v-model="formPassword.password_confirmation"
                                                placeholder="Confirm Password"
                                                class="border-b-2 focus:border-b-main-yellow w-full focus:outline-none text-dark-bold text-sm leading-tight appearance-none"

                                            />

                                        </div>
                                         <button
                                            type="submit"
                                            class="w-full px-2 md:text-base text-sm py-1 font-medium text-white bg-main-blue rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                        >
                                            Change Password
                                        </button>
                                                </form>
                                            </TabPanel>
                                        </TabPanels>
                                    </TabGroup>
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
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";

// IMPORTS
import { useStore } from "vuex";
import { ref, watch, reactive, inject, onMounted } from "vue";
const store = useStore();
let isOpenSetting = inject("isOpenSetting");

const closeModal = () => {
            store.dispatch('loadProfile');

    isOpenSetting.value = false;
    formPassword.oldPassword = "";
    formPassword.password = "";
    formPassword.password_confirmation = "";
};

let props = defineProps(['profile']);
watch(props.profile,(val)=>{
    startMonthBudget.budget = val?.account?.budget,
    startMonthBudget.start_month = val?.account?.start_month
    console.log(val);

},{deep:true})

let startMonthBudget = {
    budget:null,
    start_month:null
}


const setBudgetMonth = async ()=>{
   await axios.patch(`api/accounts/${props.profile.account.id}`,startMonthBudget,store.getters.getConfig).then((res)=>{
        console.log(res.data.data.message)
        store.dispatch('loadOperations');
        closeModal();
                   store.dispatch('popUp',{iconMsg:'success',msg:res.data.message});

    }) .catch((e) => {
            if(e.response.status === 422){
                errors.value = e.response.data.errors
            }else{
            store.dispatch('popUp',{iconMsg:'error',msg:'Something went wrong.'});

            }
        });
}
const formPassword = reactive({
    oldPassword:"",
    password:"",
    password_confirmation:"",
});

const changePassword = async ()=>{
    await axios.patch(`api/users/${props.profile.user.id}`,formPassword,store.getters.getConfig).then((res)=>{
            closeModal()
            store.dispatch('popUp',{iconMsg:'success',msg:res.data.message});
    }).catch((e) => {
            if(e.response.status === 422){
                errors.value = e.response.data.errors
                }else{
            store.dispatch('popUp',{iconMsg:'error',msg:'Something went wrong.'});

            }
        });
}

let errors = ref([]);






</script>

<style></style>
