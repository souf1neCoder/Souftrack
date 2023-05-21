<template>
    <hero-home-view>
        <form class="border rounded-lg" @submit.prevent="searchFor">
            <div class="flex items-center md:flex-row flex-col ">
                <div class="flex-none ">

                <Menu>
                    <div>
                        <MenuButton class="py-2 md:px-5 px-2 md:border-r-2">
                           <span v-text="search.category_id !=0 ? category : 'All categories'"></span> <i class="fa-solid fa-chevron-down"></i>
                        </MenuButton>
                    </div>

                    <transition
                        enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0"
                    >
                        <MenuItems
                            class="absolute mt-4 origin-top md:z-auto z-20 divide-y divide-gray-100 rounded-md bg-white shadow-lg overflow-scroll" style="height: 200px;"
                        >
                            <div class="p-1 ">
                                <MenuItem

                                >
                                    <li
                                        data-id=""
                                        @click="setCategory"
                                        class="text-dark-bold group cursor-pointer flex w-full items-center justify-center rounded-md py-2 md:px-4 px-2 text-sm hover:bg-slate-100"
                                    >
                                        All categories
                                    </li>
                                </MenuItem>
                                <MenuItem
                                    v-for="cat in categories"
                                    :key="cat.id"
                                >
                                    <li
                                        :data-id="cat.id"
                                        @click="setCategory"
                                        class="text-dark-bold group cursor-pointer flex w-full items-center justify-center rounded-md py-2 md:px-4 px-2 text-sm hover:bg-slate-100"
                                    >
                                        {{ cat.category_name }}
                                    </li>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
                </div>
                <div class="search_bar flex-initial w-full">
                    <div class="search_bar_input">
                        <label
                            for="default-search"
                            class="mb-2 text-sm font-medium text-dark-bold sr-only"
                            >Search</label
                        >
                        <div class="relative">
                            <div
                                class="hidden md:flex absolute inset-y-0 left-0 items-center md:pl-3 pointer-events-none"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-5 h-5 text-gray-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    ></path>
                                </svg>
                            </div>
                            <input
                                type="search"
                                id="default-search"
                                class="block p-4 md:pl-10 w-full text-sm text-dark-bold border-transparent focus:border-transparent  focus:outline-0 focus:ring-0"
                                placeholder="Search Remarks, Amount..."
                                v-model="search.search_term"
                                @keyup="searchFor"

                            />
                            <button
                                type="submit"
                                class="text-white absolute md:right-2.5 right-1 bottom-2 bg-main-blue hover:bg-blue-800 focus:ring-0 focus:outline-none  font-medium rounded-lg text-sm md:px-4 px-2 py-2"
                            >
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </hero-home-view>
    <operations :operations="operations" />
</template>

<script setup>
// Import components
import HeroHomeView from "../components/HeroHomeView.vue";
import Operations from "../components/search/Operations.vue";
import Spinner from "../components/Spinner.vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";

//
import { ref,reactive,computed ,onMounted} from "vue";
import { useStore } from "vuex";

//
onMounted(()=>{
    store.dispatch('loadCategories')
})
const store = useStore();
const categories = computed(() => store.getters.getCategories)
const operations = computed(() => store.getters.getOperationsSearch)
let search = reactive({
    search_term:'',
    category_id:''
})
let categoryName = ref('')

const searchFor = ()=>{
    store.dispatch('loadOperationsSearch',search)
}

let category = computed(()=>{
    return categoryName.value
})
//
const setCategory = (event)=>{
    search.category_id = event.target.dataset.id
    categoryName.value = event.target.innerText
    searchFor();
    console.log(event.target.dataset.id)
    console.log(categoryName.value)

}
//

</script>
