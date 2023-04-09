<template>
   <q-page class="q-pa-md">
     <div class="row justify-center">
       <span class="text-h4">{{mainTitle}}</span>
     </div>

     <div class="row justify-center">
      <div class="col-12 col-md-8 q-mt-md">
        <q-form class="q-gutter-md"  @submit="saveProduct">
          <q-input outlined
          v-model="nombre"
            label="Nombre *"
            hint="Nombre completo del producto"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor escriba el nombre del producto']"
          />
          <q-input outlined class="q-mt-md"
          v-model="referencia"
            label="Referencia *"
            hint="referencia del producto"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor escriba la referencia del producto']"
          />

          <q-input outlined class="q-mt-md"
          filled
          v-model="precio"
          label="Precio *"
          mask="#.##"
          fill-mask="0"
          reverse-fill-mask
          hint="Decimanles 0.00"
          lazy-rules
          :rules="[ val => val && val.length > 0 || 'Por favor indique el precio del producto']"
          />

          <q-input outlined class="q-mt-md"
            v-model="descripcion"
            label="Descripcion *"
            hint="Descripcion del producto"
            type="text"
            autogrow
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor escriba alguna descripcion']"
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
   </q-page>
</template>

<script>
import { computed, ref, defineComponent } from 'vue'
import { useRouter } from 'vue-router';
import {api} from 'src/boot/axios';
import { route } from 'quasar/wrappers';


export default defineComponent({
  name: 'AddProduct',
  props: {
    id: {
      type: String,
      required: false
    },

  },
  setup(props){
    const router = useRouter()

    const id = props.id

    const nombre = ref()
    const referencia = ref()
    const descripcion = ref()
    const precio = ref(0)
    const isLoading = ref(false)

    const mainTitle = computed(()=>{
      return props.id ? 'Modificar Producto':'Crear Producto'
    })

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
          router.push({name: 'productos'})
        }
      } catch (error) {
        isLoading.value = false
        alert('Ocurrio un error y no se guardaron los datos');
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
      id
    }


  }
})
</script>
