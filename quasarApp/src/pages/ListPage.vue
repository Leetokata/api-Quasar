<template>
 <q-page class="q-pa-md">
    <div class="flex justify-between">
      <span class="text-h3">Productos</span>
      <q-btn label="Crear" color="primary"  @click="this.$router.push({name:'addProduct'})"/>
      <!-- <q-btn label="Edit" color="primary"  @click="this.$router.push({name:'EditProduct', params: {id: 1}})"/> -->

    </div>
  </q-page>
</template>
