
<template>
    <TransitionRoot appear :show="isOpenEditOpr" as="template">
        <Dialog as="div" @close="closeModalEditOpr" class="relative z-10">
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
                                @click="closeModalEditOpr"
                            >
                                <i class="fa-solid fa-x"></i>
                            </button>
                            <div class="mt-5">
                                <div class="container mx-auto">
                                    <form
                                        @submit.prevent="editOperation(operation.id)"
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
                                                        :class="catInc.id === operation.category_id ? 'bg-main-yellow text-white' : ''"
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
                                                        :class="catExp.id === operation.category_id ? 'bg-main-yellow text-white' : ''"
                                                        class="hover:bg-main-yellow hover:text-white  text-dark-bold bg-white w-full block px-1.5 py-0.5 border-b border-gray-300"
                                                    >
                                                       
                                                            {{
                                                                catExp.category_name
                                                            }}
                                                        
                                                    </button>
                                                </div>
                                        </div>
                                        <p v-if="categorySelectedName" class="font-bold text-main-yellow">{{categorySelectedName}}</p>
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
                                            Edit
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
import { useStore } from "vuex";
import {useRouter} from "vue-router";
import { toRef,ref,watch,computed ,inject,onMounted} from 'vue';

const store = useStore();
const router = useRouter();
let isOpenEditOpr = inject('isOpenEditOpr')
let operation = inject('operation')
let showIncome = ref(false);
let showExpenses = ref(true);
let categorySelectedName = ref('');


let errors = ref([])
const closeModalEditOpr = () => {
   isOpenEditOpr.value = false
   errors.value = []
    operation.id = 0;
    operation.category_id = 0;
    operation.amount = 0;
    operation.remark = "";

    console.log(operation);
}
// 
//
const editOperation = async (id) => {
    operation.amount = parseFloat(operation.amount)
    await axios
        .patch(`api/operations/${id}`, operation, store.getters.getConfig)
        .then((res) => {
            console.log(res.data.message);
           
            closeModalEditOpr();
                store.dispatch('popUp',{iconMsg:'success',msg:res.data.message});
                router.currentRoute.value.name === 'Dashboard' ? store.dispatch('loadOperations') : router.push({name:'Dashboard'});

        }) .catch((err) => {
            if(err.response.status === 422){
                errors.value = err.response.data.errors
                
                console.log(errors.value);
            }else{
            store.dispatch('popUp',{iconMsg:'error',msg:'Something went wrong.'});
            }
        });
    console.log(operation)
};

const categories  =  computed(() => store.getters.getCategories)

let catIncome = computed(() => {
    return (
        categories.value.filter((cat) => cat.category_type === "income") || []
    );
});
let catExpenses = computed(() => {
    return (
        categories.value.filter((cat) => cat.category_type === "expense") || []
    );
});
onMounted(()=>{
    store.dispatch('loadCategories')
})
const showIncCats = ()=>{
    showIncome.value = true;
    showExpenses.value = false;

}
const showExpCats = ()=>{
    showExpenses.value = true;
    showIncome.value = false;
}
const hideCats = (event)=>{
    categorySelectedName.value = event.target.innerText;

    showExpenses.value = false;
    showIncome.value = false;
    operation.category_id = event.target.dataset.id

}

</script>

<style>

</style>