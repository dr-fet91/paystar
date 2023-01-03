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
    errors: Object,
});

const payment = ref(false);
const gateway = ref(false);
const form = useForm({
    payment: payment, 
    gateway: gateway, 
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
                                <span>انتخاب نوع پرداخت </span>
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
                                            انتخاب نوع پرداخت
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>
                                <section class="payment-select">
                                    <input type="radio" @click="payment = 'online'; gateway = 'paystar'" name="payment_type" value="1" id="d1"/>
                                    <label for="d1" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                        <section class="mb-2">
                                            <i class="fa fa-credit-card mx-1"></i>
                                            پرداخت آنلاین
                                        </section>
                                        <section class="mb-2">
                                            <i class="fa fa-calendar-alt mx-1"></i>
                                            درگاه پرداخت paystar
                                        </section>
                                    </label>

                                    <section class="mb-2"></section>

                                    <input type="radio" name="payment_type" value="2" id="d2"/>
                                    <label for="d2" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                        <section class="mb-2">
                                            <i class="fa fa-id-card-alt mx-1"></i>
                                            پرداخت آفلاین
                                        </section>
                                        <section class="mb-2">
                                            <i class="fa fa-calendar-alt mx-1"></i>
                                            حداکثر در 2 روز کاری بررسی می شود
                                        </section>
                                    </label>

                                    <section class="mb-2"></section>

                                    <input type="radio" name="payment_type" value="3" id="d3"/>
                                    <label for="d3" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                        <section class="mb-2">
                                            <i class="fa fa-money-check mx-1"></i>
                                            پرداخت در محل
                                        </section>
                                        <section class="mb-2">
                                            <i class="fa fa-calendar-alt mx-1"></i>
                                            پرداخت به پیک هنگام دریافت کالا
                                        </section>
                                    </label>


                                </section>
                            </section>




                        </section>
                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <p class="my-3">
                                    <i class="fa fa-info-circle me-1"></i> کاربر گرامی کالاها بر اساس نوع ارسالی که انتخاب می کنید در مدت زمان ذکر شده ارسال می شود.
                                </p>

                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">مبلغ قابل پرداخت</p>
                                    <p class="fw-bold">{{new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(order.amount)}} ریال</p>
                                </section>
                                <form @submit.prevent="form.post(route('payment_submit'), {onSuccess: () => form.reset(), onStart:() => errors = null})">
                                    <section class="">
                                        <section id="payment-button" v-show="!payment" class="text-warning border border-warning text-center py-2 pointer rounded-2">نوع پرداخت را انتخاب کن</section>
                                        <PrimaryButton id="final-level" v-show="payment" href="my-orders.html" class="btn btn-danger w-100 mt-2">ثبت سفارش و گرفتن کد رهگیری</PrimaryButton>
                                    </section>
                                </form>
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
