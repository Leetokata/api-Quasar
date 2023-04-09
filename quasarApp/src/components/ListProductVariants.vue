<template>
  <q-page class="q-pa-md">
    <div class="row justify-center">
      <q-btn
       class="button-back"
       round color="blue-8"
       icon="arrow_back"
       @click="this.$router.push({name:'productos'})">
     </q-btn>
      <span class="text-h5">Producto y sus variaciones</span>
    </div>

    <div class="row justify-center">
      <div class="col-12 col-md-8 q-mt-md">
        <div class="row justify-center q-mt-lg" v-if="!producto">
          <q-spinner
          color="primary"
          size="3em"
          />
        </div>
        <q-card v-if="producto" class="my-card q-mt-md bg-blue-8 text-white">
          <q-card-section >
            <div class="text-h6">{{ producto.nombre }}</div>
            <q-separator dark />
            <div class="text-subtitle2 q-mt-md"><strong>Referencia: </strong>{{ producto.referencia }}</div>
            <div class="text-subtitle2 q-mt-md"><strong>Precio: </strong> {{ producto.precio }}</div>
            <div class="text-subtitle2 q-mt-lg"><strong>Descripcion: </strong> {{ producto.descripcion }}</div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col-12 col-md-8 q-mt-lg">
        <q-table

            flat bordered
            title="Variaciones del producto"
            dense
            :rows="producto?.variaciones"
            :columns="columns"
            row-key="id"
            no-data-label="Sin variaciones agregadas"
          >
          </q-table>
      </div>
    </div>



  </q-page>



</template>

<script>
import { ref, computed, defineComponent } from 'vue'
import { useRouter, useRoute } from 'vue-router';
import { useQuasar } from 'quasar'
import {api} from 'src/boot/axios';


export default defineComponent({
 name: 'ShowProduct',

 props: {
   id: {
     type: String,
     required: false
   },

 },
 setup(props, {emit}){
  const route = useRoute()

  const producto = ref()

  const columns = [
      {
        name: 'ID',
        label: 'ID',
        align: 'left',
        field: 'id',
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
        name: 'creado',
        label: 'Creado',
        align: 'left',
        field: 'created_at',
        sortable: true
      },
      {
        name: 'actualizado',
        label: 'Actualizado',
        align: 'left',
        field: 'updated_at',
        sortable: true
      },
    ]

  const getProductWithVariants = async ()=>{
    const {data} = await api.get(`/producto/${route.params.id}`)
    producto.value = data.data

  }

   getProductWithVariants()
   return {
    columns,
    producto
   }


 }
})
</script>

<style scoped>
.button-back{
 position: absolute;
 left: 15px;
}
.button-back:hover{
 scale: 1.2;
}
.btn-border{
 border-radius: 10px 10px 10px 10px;
}
.product--row{
 border-radius: 25px 25px 25px 25px;
}
</style>
