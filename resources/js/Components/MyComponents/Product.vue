<script setup>
import { Link } from '@inertiajs/inertia-vue3';
    defineProps(['product']);
</script>
<template>
    <section class="item">
        <section class="lazyload-item-wrapper">
            <section class="product">
                <Link :href="route('product.view', product.slug)" class="product-link">
                    <section class="product-image">
                        <img class="" v-bind:src="'/storage/' + product.image" alt="">
                    </section>
                    <section class="product-colors"></section>
                    <section class="product-name"><h3>{{product.name}}</h3></section>
                    <section class="product-price-wrapper">
                        <section class="product-price">{{new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(product.price)}} ریال</section>
                    </section>
                </Link>
            </section>
        </section>
    </section>
</template>