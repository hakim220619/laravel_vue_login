import { createRouter, createWebHistory } from 'vue-router';

function requireLogin(to, from, next) {
  let token = JSON.parse(localStorage.getItem('token'));
  if (token) {
    next()
  } else {
    next('/login')
  }
}
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/login' },
    {
      path: '/',
      // component: () => import('@/layouts/default.vue'),
      beforeEnter: requireLogin,
      children: [
        {
          name: 'dashboard',
          path: 'dashboard',
          component: () => import('@/pages/dashboard.vue'),
        },
        {
          path: 'account-settings',
          component: () => import('@/pages/account-settings.vue'),
        },
        {
          name: 'users',
          path: 'users',
          component: () => import('@/pages/users/users.vue'),
        },
        {
          name: 'addUsers',
          path: 'addUsers',
          component: () => import('@/pages/users/addUsers.vue'),
        },
        {
          name: 'editUsers',
          path: 'editUsers',
          component: () => import('@/pages/users/editUsers.vue'),
        },
        {
          name: 'students',
          path: 'students',
          component: () => import('@/pages/students/students.vue'),
        },
        {
          name: 'addStudents',
          path: 'addStudents',
          component: () => import('@/pages/students/addStudents.vue'),
        },
        {
          name: 'editStudents',
          path: 'editStudents',
          component: () => import('@/pages/students/editStudents.vue'),
        },
        {
          name: 'settingPayment',
          path: 'settingPayment',
          component: () => import('@/pages/settingPayment/billPayment.vue'),
        },
        {
          name: 'addPayment',
          path: 'addPayment',
          component: () => import('@/pages/settingPayment/addPayment.vue'),
        },
        {
          name: 'editPayment',
          path: 'editPayment',
          component: () => import('@/pages/settingPayment/editPayment.vue'),
        },
        {
          path: 'masterData',
          component: () => import('@/pages/masterData.vue'),
        },
        {
          path: 'tables',
          component: () => import('@/pages/tables.vue'),
        },
        {
          path: 'form-layouts',
          component: () => import('@/pages/form-layouts.vue'),
        },
        {
          path: '/logout',
          redirect: '/login',
          beforeEnter: (to, from, next) => {
            localStorage.clear();
            next();
          }
        }
      ],
    },
    {
      path: '/',
      component: () => import('@/layouts/blank.vue'),

      children: [
        {
          name: "login",
          path: 'login',
          component: () => import('@/pages/login.vue'),
        },
        {
          path: 'register',
          component: () => import('@/pages/register.vue'),
        },
        {
          path: '/:pathMatch(.*)*',
          component: () => import('@/pages/[...all].vue'),
        },
      ],
    },
  ],
})

export default router
