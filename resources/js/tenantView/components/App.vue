<script setup>
import { onMounted, ref } from "vue";

let tenant = ref();

onMounted(async () => {
    getTenant();
})

const getTenant = async () => {
    let response = await axios.get("/api/get_tenant");
    tenant.value = response.data.tenant
    document.title = tenant.value.tenant_name
}


document.title = 'Tenant App';
</script>
<template>
    <div class="app-brand">
        <h1 v-if="tenant">{{ tenant.tenant_name }}</h1>
    </div>


    <router-view />
</template>