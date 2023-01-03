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
    carts: Object,
    errors: Object,
});
let total = 0;
const form = useForm({
    
});
function x(value){
    total = Number(total) + Number(value);
}
</script>

<template>
    <Head title="سبد خرید" />
    <Header />
    <!-- start main one col -->
    <main id="main-body-one-col" class="main-body">
        <Error :errors="errors" />
         <!-- start cart -->
        <section class="mb-4">
            <section class="container-xxl" >
                <section class="row">
                    <section class="col">
                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>سبد خرید شما</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>

                        <section class="row mt-4">
                            <section class="col-md-9 mb-3">
                                <section class="content-wrapper bg-white p-3 rounded-2">

                                    <section
                                     v-for="cart in carts" 
                                     :key="cart.id" 
                                     class="cart-item d-md-flex py-3"
                                     >
                                     {{ x(cart.product.price) }}
                                        <section class="cart-img align-self-start flex-shrink-1"><img v-bind:src="'/storage/' + cart.product.image" alt=""></section>
                                        <section class="align-self-start w-100">
                                            <p class="fw-bold">{{ cart.product.name }}</p>
                                            <p><i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i> <span> گارانتی اصالت و سلامت فیزیکی کالا</span></p>
                                            <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا موجود در انبار</span></p>
                                            <section>
                                                <section class="d-inline-block ">
                                                    <label>تعداد</label>: 
                                                {{ cart.number }}
                                                </section>
                                            </section>
                                        </section>
                                        <section class="align-self-end flex-shrink-1">
                                            <section class="text-nowrap fw-bold">{{new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(cart.product.price)}} ریال</section>
                                        </section>
                                    </section>
                                </section>
                            </section>
                            <section class="col-md-3">
                                <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">جمع سبد خرید</p>
                                        <p class="fw-bolder">{{new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(total)}} ریال</p>
                                    </section>

                                    <p class="my-3">
                                        <i class="fa fa-info-circle me-1"></i>کاربر گرامی  خرید شما هنوز نهایی نشده است. برای ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این سفارش صورت میگیرد.
                                    </p>

                                    <form @submit.prevent="form.post(route('order'), { onSuccess: () => form.reset(), onStart:() => errors = null })">
                                        <section class="">
                                            <PrimaryButton>تکمیل فرآیند خرید</PrimaryButton>
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


    </main>
    <!-- end main one col -->


    <Footer />
</template>
