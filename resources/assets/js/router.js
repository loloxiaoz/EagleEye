const routers = [
    {
        path: '/',
        meta: {
            title: 'home'
        },
        component: (resolve) => require(['./components/menu.vue'], resolve)
    },
];
export default routers;
