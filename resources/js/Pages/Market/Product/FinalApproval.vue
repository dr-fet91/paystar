<script setup>
import { useForm, Head } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Header from '@/Components/MyComponents/Header.vue';
import Footer from '@/Components/MyComponents/Footer.vue';
import Product from '@/Components/MyComponents/Product.vue';
import Error from '@/Components/MyComponents/Error.vue';
import { ref } from 'vue'
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    order: Object,
    gateway: String,
    token: String,
    BankUrl: String,
    errors: Object,
});

const form = useForm({
});

</script>

<template>
    <Head title="سبد خرید" />
    <Header />
 <!-- start cart -->
 <section class="mb-4">
        <Error :errors="errors" />
        <section class="container-xxl" >
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>رفتن به درگاه پرداخت </span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-9">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                           درگاه : {{ gateway }}
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>
      
                            </section>




                        </section>
                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">

                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">مبلغ قابل پرداخت</p>
                                    <p class="fw-bold">{{new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(order.amount)}} ریال</p>
                                </section>
                                
                                    <section class="">
                                        <form v-bind:action="BankUrl" method="post">
                                            <input type="hidden" name="token" v-bind:value="token">
                                            <PrimaryButton id="final-level"  href="my-orders.html" class="btn btn-danger w-100 mt-2">درگاه پرداخت</PrimaryButton>
                                        </form>
                                        
                                    </section>

                            </section>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->




    <Footer />
</template>
