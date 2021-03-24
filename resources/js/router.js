require('./bootstrap');

import Vue from "vue";
import VueRouter from "vue-router";

import NotFound from "./views/NotFound";
import Index from "./views/Index";
import Request from "./views/Request"
import Account from "./views/Account";
import axios from "axios";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "index",
        component: Index
    },
    {
        path: "/requests/:id",
        name: "requests",
        component: Request
    },
    {
        path: "/account",
        name: "account",
        component: Account
    },
    {
        path: "*",
        component: NotFound
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

router.beforeEach(async (to, from, next) => {
    if (to.name == 'account') {
        if (!User.guest) {
            next();
        } else {
            next('/');
        }
    } else if (to.name == 'requests') {
        let id = to.params.id;

        try {
            let res = await axios.post('/app/publickey', { public_key: id });

            if (res.data) {
                next();
            } else {
                next('/');
            }
        } catch (err) {
            next('/');
        }
    } else {
        next();
    }
});

export default router;