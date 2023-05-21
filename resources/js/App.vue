<template>
    <div>

    <Layout>
        <header>
            <Nav />
            <HeroHome />
        </header>
    </Layout>
    <NavBottom />
    <router-view></router-view>
    </div>
</template>
<script setup>
import Nav from "./components/Nav.vue";
import Layout from "./components/Layout.vue";
import HeroHome from "./components/HeroHome.vue";
import NavBottom from "./components/NavBottom.vue";
</script>

