<script setup>
import { onMounted, ref } from "vue";

let tenants = ref([])
onMounted(async () => {
    getTenants();
})

const getTenants = async () => {
    let response = await axios.get("/api/get_all_tenants");
    tenants.value = response.data.tenants
    console.log('tenants', tenants.value)
}

let form = ref({
    tenant_name: '',
    tenant_domain: '',
})

const createTenant = () => {
    const formData = new FormData();
    formData.append('tenant_name', form.value.tenant_name);
    formData.append('tenant_domain', form.value.tenant_domain);


    axios.post('/api/create_tenant/', formData)
        .then((response) => {
            form.value.tenant_name = '',
                form.value.tenant_domain = '',
                getTenants();
                Swal.fire({
                    icon: 'success',
                    title: 'Tenant created successfully',
                    html: `You can now access the <b>${response['data']['tenant_name']}</b> application by click on this link <a href="//${response['data']['domain']}" target="_blank">${response['data']['domain']}</a>`,
                })
        })
        .catch((error) => {
            Swal.fire({
                icon: 'error',
                title: 'Oops..',
                text: 'Something went wrong!',
            })
        })


}
</script>
<template>
    <div class="auth-container">
        <div>
            <h2>Create new tenant</h2>
        </div>
        <div class="mt-2">
            <input type="text" class="input" placeholder="Enter tenant name" v-model="form.tenant_name">
        </div>
        <div class="mt-2">
            <input type="text" class="input" style="width: 80%;" placeholder="Enter sub domain"
                v-model="form.tenant_domain">.localhost
        </div>
        <button class="btn btn-secondary mt-2 ml-1" @click="createTenant()">
            Save
        </button>
    </div>

    <div class="tenant-container">
        <div class="table--heading mt-2 tenants__list__heading" style="padding-top: 20px;background:#FFF">
            <!-- <p class="table--heading--col1">&#32;</p> -->
            <p class="table--heading--col1">Tenant Id</p>
            <p class="table--heading--col2">
                Tenant Name
            </p>
            <p class="table--heading--col4">Tenant Domain</p>
            <p class="table--heading--col3">
                Status
            </p>
            <!-- <p class="table--heading--col5">&#32;</p> -->
            <p class="table--heading--col5">actions</p>
        </div>
        <div class="table--items tenants__list__item" v-for="item in tenants" v-if="tenants && tenants.length > 0">
            <p class="table--items-col1">{{ item.tenant_id }}</p>
            <p class="table--items-col1">{{ item.tenant_name }}</p>
            <a v-bind:href="'http://' + item.domain" target="_blank">{{ item.domain }}</a>
            <p>Active</p>
            <div>
                <button class="btn-icon btn-icon-danger" @click="deleteProduct(item.id)">
                    <!-- <i class="far fa-trash-alt"></i> -->
                    Delete
                </button>
            </div>
        </div>
        <div class="table--items" v-else>
            <p>Tenants not found</p>
        </div>
    </div>
</template>