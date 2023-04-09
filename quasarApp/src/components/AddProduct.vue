<template>
   <q-page class="q-pa-md">
     <div class="row justify-center">
       <q-btn
        class="button-back"
        round color="blue-8"
        icon="arrow_back"
        @click="this.$router.push({name:'productos'})">
      </q-btn>
       <span class="text-h5">{{mainTitle}}</span>
     </div>

     <div class="row justify-center">
      <div class="col-12 col-md-8 q-mt-md">
          <div class="row product--row bg-indigo-2 q-pa-sm q-mb-md" v-if="isSave">
            <div class="col-11 flex items-center">
              <span class="text-h6 q-ml-sm">Producto: {{ nombre }}</span>
            </div>
            <div class="col-1 text-right">
              <q-btn class="button-head" round color="indigo-12"  :icon="isShow ? 'expand_less' : 'expand_more'" @click="toggleButton"></q-btn>
            </div>
          </div>

          <q-form class="q-gutter-md q-mt-sm" @submit="eventSubmit" v-if="isShow">
            <q-input outlined
              v-model="nombre"
              label="Nombre *"
              hint="Nombre completo del producto"

            />

            <q-input
              outlined class="q-mt-md"
              v-model="referencia"
              label="Referencia *"
              hint="referencia del producto"

              />
              <q-input outlined class="q-mt-md"
              filled
              v-model="precio"
              label="Precio *"
              mask="#.##"
              fill-mask="0"
              reverse-fill-mask
              hint="Decimanles 0.00"
              />

              <q-input outlined class="q-mt-md"
                v-model="descripcion"
                label="Descripcion *"
                hint="Descripcion del producto"
                type="text"
                autogrow

              />

              <div class="row justify-center">
                <q-btn :loading="isLoading" type="submit" icon="save" padding="10px 20px" size="md" color="primary"  style="width: 150px">
                  &nbsp;Guardar
                  <template v-slot:loading>
                    <q-spinner-hourglass class="on-left" />
                    Guardando...
                  </template>
                </q-btn>
              </div>
          </q-form>
      </div>
     </div>

     <div class="row justify-center" v-if="id">
      <div class="col-12 col-md-8">
        <q-separator color="blue" class="q-my-md" />
        <div class="col-12 flex justify-between q-pa-sm">
          <span class="text-h5">Variaciones</span>
          <q-btn
            v-if="!isShowTable"
            class="q-ml-md"
            round color="indigo-12"
            icon="arrow_back_ios_new"
            @click="toggleButtonVar"
          />

          <q-btn
            v-if="isShowTable"
            class="btn-border q-ml-md"
            color="indigo-12"
            icon="add"
            label="Agregar"
            @click="toggleButtonVar"
          />

        </div>

        <div class="col-12 q-mt-lg">
          <q-table
            v-if="isShowTable"
            flat bordered
            title="Variaciones del producto"
            dense
            :rows="variaciones"
            :columns="columns"
            row-key="id"
            no-data-label="Sin variaciones agregadas"
          >
            <template v-slot:body-cell-accion="props">
              <q-td :props="props">
                <q-btn dense round flat color="indigo-12"  icon="edit" @click="editVariacion(props)"></q-btn>

              </q-td>
            </template>
          </q-table>

          <div class="form-container">
            <q-form class="q-gutter-md q-mt-sm" @submit="submitVariacion" v-if="!isShowTable">
              <q-input
                outlined class="q-mt-md"
                v-model="dataVariacion.referencia"
                label="Referencia *"
                hint="referencia de la variacion"
              />
              <q-input
                outlined class="q-mt-md"
                filled
                v-model="dataVariacion.precio"
                label="Precio *"
                mask="#.##"
                fill-mask="0"
                reverse-fill-mask
                hint="Decimanles 0.00"
              />

              <q-input outlined class="q-mt-md"
                v-model="dataVariacion.descripcion"
                label="Descripcion *"
                hint="Descripcion de la variacion"
                type="text"
                autogrow
              />

              <div class="row justify-center">
                <q-btn type="submit" icon="save" padding="10px 20px" size="md" color="cyan-6"  style="width: 150px">
                  &nbsp;Guardar
                  <template v-slot:loading>
                    <q-spinner-hourglass class="on-left" />
                    Guardando...
                  </template>
                </q-btn>
              </div>
            </q-form>
          </div>

        </div>
      </div>

     </div>
   </q-page>


   <q-dialog v-model="dialog" position="top">
      <q-card style="width: 550px" class="bg-red">
        <div class="row justify-center q-pa-sm">
          <q-icon name="warning" color="warning" size="2rem" />
          <span class="text-h6 q-ml-sm text-white">Alerta</span>
        </div>
        <q-card-section class="q-pa-sm text-white">
          <div class="row justify-center">
            <span class="text-h8">En el formulario de {{ formError.type }} se encontraron los siguientes errores</span>
          </div>

          <template v-if="formError">
            <ul>
              <li v-for="(error, index) in formError.error" :key="index">{{ error[0] }}</li>
            </ul>
          </template>

          <q-space />

        </q-card-section>
      </q-card>
    </q-dialog>
</template>

<script>
import { ref, computed, defineComponent } from 'vue'
import { useRouter, useRoute } from 'vue-router';
import { useQuasar } from 'quasar'
import {api} from 'src/boot/axios';


export default defineComponent({
  name: 'AddProduct',

  props: {
    id: {
      type: String,
      required: false
    },

  },
  setup(props, {emit}){
    const $q = useQuasar()
    const router = useRouter()
    const route =  useRoute()

    const id = ref()
    const nombre = ref()
    const referencia = ref()
    const descripcion = ref()
    const precio = ref(0)
    const variaciones = ref([])
    const isLoading = ref(false)
    const isSave  = ref(false)
    const isShow  = ref(true)
    const dialog = ref(false)
    const formError = ref({
      error: null,
      type: null
    })

    const dataVariacion = ref({
      id: null,
      referencia: null,
      precio: null,
      descripcion: null
    })
    const isShowTable = ref(true)
    const columns = [
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


    const eventSubmit = ()=>{
      formError.value.error = null
      formError.value.type = null


      if(!isSave.value) return saveProduct()
      updateProduct()
    }
    const toggleButton = ()=>{
        isShow.value = !isShow.value
    }

    const updateProduct = async ()=>{
      if(id.value){
       try {
        isLoading.value = true
        const {data} = await api.put(`/producto/${id.value}`, {
          nombre: nombre.value,
          referencia: referencia.value,
          descripcion: descripcion.value,
          precio: precio.value,
        })

        setDataProduct(data.data)

        $q.dialog({
          title: 'Alerta',
          message: 'Producto Actualizado'
        })

        isLoading.value = false
        toggleButton()

       } catch (error) {
          formError.value.error = error.response.data.errors
          formError.value.type = 'producto'

          isLoading.value = false
          dialog.value =true
       }

      }
    }

    const setDataProduct = (data) =>{
        nombre.value       = data.nombre
        referencia.value   = data.referencia
        descripcion.value  = data.descripcion
        precio.value       = data.precio

        if(data.variaciones?.length > 0){
          variaciones.value = data.variaciones
        }
    }

    const getProduct = async ()=>{
      if(id.value){
        const {data} = await api.get(`/producto/${id.value}`)

        setDataProduct(data.data)

      }
    }

    const checkType = ()=>{
      if(route.params.id){
        id.value = route.params.id
        isSave.value = true
        getProduct()

      }
    }

    checkType()

    const saveProduct =  async () =>{
        isLoading.value = true

      try {
        const { data, status } = await api.post('/producto', {
            nombre: nombre.value,
            referencia: referencia.value,
            descripcion: descripcion.value,
            precio: precio.value,
        });


        if(status === 201){
          isLoading.value = false
          isSave.value = true;
          id.value = data.data.id
          router.push({name: 'EditProduct', params: {id: data.data.id }   })

        }
      } catch (error) {
        formError.value.error = error.response.data.errors
        formError.value.type = 'producto'

        isLoading.value = false
        dialog.value =true
        //alert('Ocurrio un error y no se guardaron los datos');
      }
    }


    const mainTitle = computed(()=>{
      return props.id ? 'Modificar Producto':'Crear Producto'
    })

    // VARIACIONES

    const editVariacion = (data)=>{

      const v = dataVariacion.value
      v.referencia = data.row.referencia
      v.precio = data.row.precio
      v.descripcion = data.row.descripcion
      v.id = data.row.id

      isShowTable.value = !isShowTable.value
    }

    const toggleButtonVar = ()=>{
      isShowTable.value = !isShowTable.value

      const v = dataVariacion.value
      v.referencia = null
      v.precio = null
      v.descripcion = null
      v.id = null
    }

    const submitVariacion =  () =>{
      formError.value.error = null
      formError.value.type = null

      if(!dataVariacion.value.id) return saveVariacion()
      updateVariacion()
    }
    const saveVariacion = async () =>{

      try {
        const {data} = await api.post('/variacion',{
          referencia: dataVariacion.value.referencia,
          precio: dataVariacion.value.precio,
          descripcion: dataVariacion.value.descripcion,
          producto_id: id.value
        })
        variaciones.value.push(data.data)
        $q.dialog({
            title: 'Alerta',
            message: 'Se creo una nueva variacion.'
          })
        toggleButtonVar()
      } catch (error) {
        formError.value.error = error.response.data.errors
        formError.value.type = 'variacion'

        isLoading.value = false
        dialog.value =true
      }
    }

    const updateVariacion = async ()=>{
       try {
        const { data } = await api.put(`/variacion/${dataVariacion.value.id}`,{
          referencia: dataVariacion.value.referencia,
          precio: dataVariacion.value.precio,
          descripcion: dataVariacion.value.descripcion,
          producto_id: id.value
        })


        const index = variaciones.value.findIndex( v => v.id === data.data.id)
        variaciones.value[index] =  data.data
        $q.dialog({
            title: 'Alerta',
            message: 'Se modifico una variacion.'
          })
        toggleButtonVar()

       } catch (error) {
        formError.value.error = error.response.data.errors
        formError.value.type = 'variacion'
        isLoading.value = false
        dialog.value =true
       }

    }

    return {
      mainTitle,
      nombre,
      referencia,
      descripcion,
      precio,
      isLoading,
      saveProduct,
      eventSubmit,
      toggleButton,
      isShow,
      isSave,
      id,
      dialog,
      formError,

      submitVariacion,
      dataVariacion,
      variaciones,
      columns,
      editVariacion,
      isShowTable,
      toggleButtonVar
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
