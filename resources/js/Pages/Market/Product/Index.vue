<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Header from '@/Components/MyComponents/Header.vue';
import Footer from '@/Components/MyComponents/Footer.vue';
import Product from '@/Components/MyComponents/Product.vue';


defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    products: Object,
});
</script>

<template>
    <Head title="محصولات" />
    <Header />
    <main id="main-body-one-col" class="main-body">
       <!-- start product lazy load -->
       <section class="mb-3">
            <section class="container-xxl" >
                <section class="row">
                    <section class="col">
                        <section class="content-wrapper bg-white p-3 rounded-2">
                            <!-- start vontent header -->
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span>محصولات</span>
                                    </h2>
                                    <section class="content-header-link">
                                    </section>
                                </section>
                            </section>
                            <!-- start vontent header -->
                            <section class="lazyload-wrapper" >
                                <section class="d-flex">
                                    <Product
                                        v-for="product in products"
                                        :key="product.id"
                                        :product="product"
                                     />
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
        <!-- end product lazy load -->
    </main>
    <Footer />
</template>
