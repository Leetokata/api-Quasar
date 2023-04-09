
const routes = [
  {
    path: '/',
    redirect: 'productos',
    component: () => import('layouts/MainLayout.vue'),
    children: [

      { path: 'productos', name: 'productos', component: () => import('components/List.vue') },
      { path: 'test', name: 'test', component: () => import('pages/TestPage.vue') },



      { path: 'producto/:id/variantes', name: 'showProducto', component: () => import('components/ListProductVariants.vue') },
      {
        path: 'producto',
        name: 'addProduct',
        component: () => import('components/AddProduct.vue'),

      },
      {
        path: 'producto/:id',
        name: 'EditProduct',
        component: () => import('components/AddProduct.vue'),
        props: (route) => {
          return {
            id: route.params.id
          }
        }
      }


    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
