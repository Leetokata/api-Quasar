<template>
  <q-page class="q-pa-md">
    <div class="flex justify-between">
      <span class="text-h3">Listar Productos</span>
      <q-btn label="Crear" color="primary"  @click="this.$router.push({name:'addProduct'})"/>
    </div>
    <div class="row justify-center items-center loading-container" v-if="isLoading" >
        <div >
          <q-circular-progress
            indeterminate
            rounded
            size="50px"
            color="blue"
            class="q-ma-md"
          />
        </div>
    </div>

    <div class="row">
      <div class="col-12 q-mt-lg">
        <q-table
          flat bordered
          title="Productos"
          no-data-label="Sin productos"
          :rows="rows"
          :columns="columns"
          row-key="id"
        >
        <template v-slot:body-cell-accion="props">
          <q-td :props="props">
            <q-btn dense round flat color="indigo-12"  icon="edit" @click="pushProduct(props)"></q-btn>

          </q-td>
        </template>
        </q-table>
      </div>
    </div>

  </q-page>

</template>

<script>

import { computed, ref, defineComponent } from 'vue'
import { api } from 'src/boot/axios'

export default defineComponent({
  name: 'List',
  setup(){

    const isLoading = false

    const columns = [
      {
        name: 'nombre',
        label: 'Nombre',
        align: 'left',
        field: 'nombre',
        sortable: true
      },
      {
        name: 'referencia',
        label: 'Referencia',
        align: 'left',
        field: 'referencia',
        sortable: true
      },
      {
        name: 'precio',
        label: 'Precio',
        align: 'left',
        field: 'precio',
        sortable: true
      },
      {
        name: 'descripcion',
        label: 'Descripcion',
        align: 'left',
        field: 'descripcion',
        sortable: true
      },
      {
        name: 'accion',
        label: 'Accion',
        align: 'left',
        field: 'accion',

      }
    ]

    const rows = ref()
    const pushProduct = (row)=>{
      console.log(row.key)
    }
    const getProduct = async ()=>{
      const { data } = await api.get('/producto')
     rows.value = data.data,
      console.log(data.data)

    }


    getProduct()

    return {
      pushProduct,
      isLoading,
      rows,
      columns,


    }
  }

})
</script>

<style scoped>
.loading-container{
  min-height: 70vh;
}
</style>
