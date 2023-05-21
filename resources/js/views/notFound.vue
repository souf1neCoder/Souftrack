<template>
  <hero-home-view>
    <!-- component -->
<main class="w-full flex flex-col justify-center items-center ">
	<h1 class="text-9xl font-extrabold text-dark-light tracking-widest">404</h1>
	<div class="bg-main-blue px-2 text-sm text-white rounded rotate-12 absolute">
		Page Not Found
	</div>
	<div class="my-6">
      <div class="text-center">
                    <router-link
                        class="w-full px-4 py-2 font-bold text-white bg-main-blue rounded-full hover:bg-blue-700 "
                        :to="{ name: 'Home' }"
                    >
                        Go Home
                    </router-link>
                </div>
    </div>
</main>
  </hero-home-view>
</template>

<script setup>
import HeroHomeView from '../components/HeroHomeView.vue'
</script>

<style>

</style>