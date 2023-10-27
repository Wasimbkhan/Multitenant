// vue router import
import { createRouter, createWebHistory } from "vue-router";

// components import
import productIndex from "../components/products/index.vue";
import newProduct from "../components/products/new.vue";
import editProduct from "../components/products/edit.vue";
import notFound from "../components/notFound.vue";

// components routs
const routes = [
    {
        path: "/",
        component: productIndex,
    },
    {
        path: "/product/new",
        component: newProduct,
    },
    {
        path: "/product/edit/:id",
        component: editProduct,
        props: true,
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound,
    },
];

const router = createRouter({
    history: createWebHistory('/'),
    routes,
});

export default router;
