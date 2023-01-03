<script setup>

const props = defineProps(['errors']);
</script>
<template>
    <div v-show="errors" v-for="error in errors" :key="error" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{error}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
    </div>
</template>
