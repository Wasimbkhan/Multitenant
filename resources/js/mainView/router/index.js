// vue router import
import { createRouter, createWebHistory } from "vue-router";

// components import
import registration from "../components/tenant-registraion/registration.vue";
import notFound from "../components/notFound.vue";

// components routs
const routes = [
    {
        path: "/",
        component: registration,
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound,
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

export default router;
