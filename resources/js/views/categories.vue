<template>
    <hero-home-view class="pb-48">
        <!-- Col -->

        <div class="w-full xl:w-3/4 lg:w-11/12 bg-white mx-auto p-5">
            <h3 class="md:pt-4 pt-2 md:text-xl lg:text-2xl text-lg text-dark-light text-center">
                Category Setting
            </h3>

            <div class="grid md:grid-cols-2 grid-cols-1 lg:gap-4 md:gap-3  md:mt-8 mt-4">
                <div class="cat_type_1 cat_type">
                    <h4
                        class="cat_type_title tracking-wide text-center text-dark-bold text-base border-b-8 border-main-yellow rounded-b font-medium uppercase"
                    >
                        Expenses ({{ catExpenses.length }})
                    </h4>
                    <div class="mt-6">
                        <div
                            v-for="catExp in catExpenses"
                            :key="catExp.id"
                            class="flex justify-between items-center mb-1 rounded-xl bg-white px-3 py-1 border border-gray-300"
                        >
                            <div
                                class="w-6 h-6 cursor-pointer flex text-slate-400 items-center justify-center rounded-full border-2 border-slate-400 hover:border-red-600 hover:text-red-600 transition ease-in-out delay-300"
                                @click="deleteCategory(catExp.id)"
                            >
                                <i class="fa-solid fa-minus"></i>
                            </div>
                            <div>
                                <h6 class="text-dark-bold">
                                    {{ catExp.category_name }} <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-1.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{catExp.operations_count}}</span>

                                </h6>
                            </div>
                            <div>
                                <button
                                    type="button"
                                    v-if="!catExp.is_default"
                                    @click="openModal(catExp.id)"
                                    class="px-2 text-xl text-slate-400	hover:text-dark-bold transition ease-in-out delay-300"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ... -->
                <div class="cat_type_2 cat_type">
                    <h4
                        class="cat_type_title tracking-wide text-center text-dark-bold text-base border-b-8 border-main-yellow rounded-b font-medium uppercase"
                    >
                        Income ({{ catIncome.length }})
                    </h4>
                    <div class="mt-6">
                        <div
                            v-for="catInc in catIncome"
                            :key="catInc.id"
                            class="flex justify-between items-center mb-1 rounded-xl bg-white px-3 py-1 border border-gray-300"
                        >
                            <div data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Category"
                                class="w-6 h-6 cursor-pointer flex text-slate-400 items-center justify-center rounded-full border-2 border-slate-400 hover:border-red-600 hover:text-red-600 transition ease-in-out delay-300"
                                @click="deleteCategory(catInc.id)"
                            >
                                <i class="fa-solid fa-minus"></i>
                            </div>
                            <div>
                                <h6 class="text-dark-bold">
                                    {{ catInc.category_name }} <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-1.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{catInc.operations_count}}</span>
                                </h6>
                            </div>
                            <div>
                                <button data-bs-toggle="tooltip" data-bs-placement="top" title="Update Category"
                                    type="button"
                                    v-if="!catInc.is_default"
                                    @click="openModal(catInc.id)"
                                    class="px-2 text-xl text-slate-400	hover:text-dark-bold transition ease-in-out delay-300"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add Category"
            @click="openModalAdd"
                class="w-12 h-12 rounded-full mt-8 mx-auto block text-xl bg-neutral-900/10 hover:bg-neutral-900/20 transition ease-in-out delay-300"
            >
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
        <edit-category  />
        <add-category  />
    </hero-home-view>
    <spinner v-if="loader" />

</template>

<script setup>
// Import components
import HeroHomeView from "../components/HeroHomeView.vue";
import EditCategory from "../components/categories/EditCategory.vue";
import AddCategory from "../components/categories/AddCategory.vue";
import Spinner from "../components/Spinner.vue";

// IMPORTS
import { useStore } from "vuex";
import { ref, computed, reactive,provide ,onMounted} from "vue";
import Swal from "sweetalert2";

//
const store = useStore();


    store.dispatch('loadCategories')

let isOpen = ref(false);
let isOpenAdd = ref(false);
provide('isOpen',isOpen);
provide('isOpenAdd',isOpenAdd);
const openModalAdd = ()=>{isOpenAdd.value = true}
const openModal = async (id) => {
    await axios
        .get(`api/categories/${id}/edit`, store.getters.getConfig)
        .then((res) => {
            console.log(res.data.data);
            category.id = res.data.data.id;
            category.category_name = res.data.data.category_name;
            category.category_type = res.data.data.category_type;
        })
        .catch((err) => {
            console.log(err.message);
        });
    isOpen.value = true;

};
let category = reactive({
    id: 0,
    category_name: "",
    category_type: "",
});
provide('category',category);
//
//DATA
const loader = computed(()=>store.getters.getLoaderSpinner)
let categories = computed(() => store.getters.getCategories)
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


const deleteCategory = async (id) => {
    await axios
        .delete(`api/categories/${id}`, store.getters.getConfig)
        .then((res) => {

               store.dispatch('loadCategories')
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
        })
        .catch((err) => {
            console.log(err.message);
        });
};
//

</script>
