<script setup>
import { ref, computed, reactive, inject, watch,onMounted, provide } from "vue";

import { useStore } from "vuex";
import {useRouter} from 'vue-router'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
} from "@headlessui/vue";
//
const store = useStore();
store.dispatch('loadCategories')
const router = useRouter();
let showIncome = ref(false);
let showExpenses = ref(true);
let categorySelectedName = ref('');
const showIncCats = ()=>{
    // clearSelectedCategory()

    showIncome.value = true;
    showExpenses.value = false;

}
const showExpCats = ()=>{
    // clearSelectedCategory()
    showExpenses.value = true;
    showIncome.value = false;
}
const clearSelectedCategory = ()=>{
    categorySelectedName.value = ''
    operation.category_id = null
    showExpenses.value = true;
    showIncome.value = false;
}

const hideCats = (event)=>{
    categorySelectedName.value = event.target.innerText;
    // showExpenses.value = true;
    // showIncome.value = false;
    operation.category_id = event.target.dataset.id
}


const categories  =  computed(() => store.getters.getCategories)

let catIncome = computed(() => {
    return (
        categories.value.filter((cat) => cat.category_type === "income").sort((catA,catB)=>{
            let nameCatA = catA.category_name.toUpperCase();
            let nameCatB = catB.category_name.toUpperCase();
            if (nameCatA < nameCatB) {
    return -1;
  }
  if (nameCatA > nameCatB) {
    return 1;
  }

  // names must be equal
  return 0;
        }) || []
    );
});
let catExpenses = computed(() => {
    return (
        categories.value.filter((cat) => cat.category_type === "expense").sort((catA,catB)=>{
            let nameCatA = catA.category_name.toUpperCase();
            let nameCatB = catB.category_name.toUpperCase();
            if (nameCatA < nameCatB) {
    return -1;
  }
  if (nameCatA > nameCatB) {
    return 1;
  }

  // names must be equal
  return 0;
        }) || []
    );
});

//

let isOpenOpr = inject("isOpenOpr");
let errors = ref([]);
let operation = reactive({
    amount: 0,
    remark: "",
    category_id: null,
});
const closeModalOpr = () => {
    isOpenOpr.value = false;
    operation.amount = 0;
    operation.remark = "";
    operation.category_id = null;
    categorySelectedName.value = '';

};
//
const addOperation = async () => {
    await axios
        .post("api/operations", operation, store.getters.getConfig)
        .then((res) => {
            console.log(res.data.data);
            closeModalOpr();
            clearSelectedCategory();
            store.dispatch('popUp',{iconMsg:'success',msg:res.data.message});
            router.currentRoute.value.name === 'Dashboard' ? store.dispatch('loadOperations') : router.push({name:'Dashboard'});

        })
        .catch((err) => {
            if(err.response.status === 422){
                errors.value = err.response.data.errors
            }else{
            store.dispatch('popUp',{iconMsg:'error',msg:'Something went wrong.'});
            clearSelectedCategory();

            }
        });
};
</script>
<template>
    <TransitionRoot appear :show="isOpenOpr" as="template">
        <Dialog as="div" @close="closeModalOpr" class="relative z-10">
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
                                @click="closeModalOpr"
                            >
                                <i class="fa-solid fa-x"></i>
                            </button>
                            <div class="mt-5">
                                <div class="container mx-auto">
                                    <form
                                        @submit.prevent="addOperation"
                                        class="flex flex-col w-10/12 mx-auto"
                                    >
                                        <div class="mb-2 text-left">
                                            <input
                                                type="number"
                                                step="0.01"
                                                v-model="operation.amount"
                                                placeholder="amount"
                                                class="border-b-2 focus:border-b-main-yellow w-full focus:outline-none text-dark-bold text-sm leading-tight appearance-none"
                                                :class="
                                                    errors && errors.amount
                                                        ? 'border-red-600'
                                                        : ''
                                                "
                                            />
                                            <small
                                                class="text-red-600"
                                                v-if="
                                                    errors && errors.amount
                                                "
                                                >{{
                                                    errors.amount[0]
                                                }}</small
                                            >
                                        </div>
                                        <!--  -->
                                        <div
                                            class="grid grid-cols-2 gap-4 mb-4"
                                        >
                                            <div class="cat_type_1 cat_type cursor-pointer" @click="showExpCats" >
                                                <h4 :class="showExpenses ? 'border-b-main-yellow' : ''"
                                                    class="cat_type_title text-center text-dark-bold text-base border-b-2  rounded-b font-medium "
                                                >
                                                    Expenses
                                                </h4>

                                            </div>
                                            <!-- ... -->
                                            <div class="cat_type_2 cat_type cursor-pointer" @click="showIncCats">
                                                <h4   :class="showIncome ? 'border-b-main-yellow' : ''"
                                                    class="cat_type_title text-center text-dark-bold text-base border-b-2  rounded-b font-medium "
                                                >
                                                    Income
                                                </h4>
                                            </div>
                                        </div>
                                        <div  v-show="showIncome">

                                                <div class="  w-full overflow-auto" style="height:150px" >
                                                    <button
                                                        v-for="catInc in catIncome"
                                                        :key="catInc.id"
                                                        @click="hideCats"
                                                        type="button"
                                                        :data-id="catInc.id"
                                                        class=" hover:bg-main-yellow hover:text-white  text-dark-bold bg-white w-full block px-1.5 py-0.5 border-b border-gray-300"
                                                    >

                                                            {{
                                                                catInc.category_name
                                                            }}

                                                    </button>
                                                </div>
                                        </div>
                                        <div v-show="showExpenses">

                                                 <div class="w-full overflow-auto" style="height:150px">
                                                    <button
                                                        v-for="catExp in catExpenses"
                                                        @click="hideCats"
    type="button"
                                                        :key="catExp.id"
                                                        :data-id="catExp.id"
                                                        class="hover:bg-main-yellow hover:text-white  text-dark-bold bg-white w-full block px-1.5 py-0.5 border-b border-gray-300"
                                                    >

                                                            {{
                                                                catExp.category_name
                                                            }}

                                                    </button>
                                                </div>
                                        </div>
                                        <small
                                                class="text-red-600"
                                                v-if="
                                                    errors && errors.category_id
                                                "
                                                >{{
                                                    errors.category_id[0]
                                                }}</small
                                            >
                                        <p v-text="categorySelectedName" class="font-bold text-main-yellow"></p>
                                        <!--  -->
                                        <div class="mb-2 mt-3 text-left flex">
                                            <input
                                                type="text"
                                                v-model="operation.remark"
                                                placeholder="remark"
                                                class="border-b-2 focus:border-b-main-yellow w-full focus:outline-none text-dark-bold text-sm leading-tight appearance-none"
                                                :class="
                                                    errors && errors.remark
                                                        ? 'border-red-600'
                                                        : ''
                                                "
                                            />
                                            <small
                                                class="text-red-600"
                                                v-if="
                                                    errors && errors.remark
                                                "
                                                >{{
                                                    errors.remark[1]
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



<style></style>
