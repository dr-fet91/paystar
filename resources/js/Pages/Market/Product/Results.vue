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
    tracking_code: String,
    card_number: String,
    card_number: String,
    message: String,
    errors: Object,
});

const form = useForm({
});

</script>

<template>
    <Head title="نتیجه پرداخت" />
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
                                <span>نتیجه پرداخت </span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-12">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                           پیام : {{ message }}
                                        </h2>
                                        <section class="content-header-link">
                                            <p>شماره سفارش: {{ order.id }}</p>
                                            <p>درگاه پرداخت: {{ gateway }}</p>
                                            <p>شماره کارت: {{ card_number ?? '-' }}</p>
                                            <p>کد رهگیری: {{ tracking_code ?? '-' }}</p>
                                        </section>
                                    </section>
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
