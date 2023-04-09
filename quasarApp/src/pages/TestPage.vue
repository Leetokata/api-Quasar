<template>
  <q-page class="q-pa-md">
    <span class="text-h3">Dialogs</span>
    <div class="q-pa-md q-gutter-sm justify-center">
      <q-btn label="Alert" color="primary" @click="alert" />
      <q-btn label="Confirm" color="primary" @click="confirm" />
      <q-btn label="Prompt" color="primary" @click="prompt" />
    </div>

    <q-separator spaced/>

    <div class="row justify-center" v-if="name">
      <span class="text-h6">Bienvenido Sr. {{ name }}</span>
      <q-separator spaced/>
    </div>


  </q-page>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { useQuasar } from 'quasar'

export default defineComponent({
  name: 'DialogsPage',
  setup(){
    const $q = useQuasar()
    const name = ref()

    function alert () {
      $q.dialog({
        title: 'Alert',
        message: 'Some message'
      }).onOk(() => {
        // console.log('OK')
      }).onCancel(() => {
        // console.log('Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    }

    function confirm () {
      $q.dialog({
        title: 'Confirm',
        message: 'Would you like to turn on the wifi?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        // console.log('>>>> OK')
      }).onOk(() => {
        // console.log('>>>> second OK catcher')
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    }

    function prompt () {
      $q.dialog({
        title: 'Cual es tu nombre?',
        message: 'Por favor escriba su nombre',
        prompt: {
          model: '',
          type: 'text' // optional
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        name.value = data
        // console.log('>>>> OK, received', data)
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        console.log('I am triggered on both OK and Cancel')
      })
    }

    return { alert, confirm, prompt, name }
  }
})
</script>
