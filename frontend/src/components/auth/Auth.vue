<script lang="ts" setup>
  import { ref } from 'vue'
  import { Button, Input, Alert } from 'flowbite-vue'
  import { http } from '../../api/http'
  import { useStore } from "../../store/useStore"
import { AxiosError } from 'axios'
import { useRouter } from 'vue-router'

  const { actions } = useStore()
  const router = useRouter()

  const email = ref<any>('test@test.com');
  const password = ref<any>('123456');
  const error = ref<any>(null);

  function login(): any {
    http.post('http://localhost:8086/api/login', { username: email.value, password: password.value }).then(function (response) {

      actions.setUser({
        username: email.value,
        token: response.data.token
      });

      router.push('/')
    }).catch(function( err: AxiosError ): void {
      // console.log(err)
      error.value = err.message
    })
  }
</script>


<template>
  <div 
    class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Sign in</h2>
      <form class="mt-8 space-y-6" action="#" method="POST">
        <Input v-model="email" size="lg" label="Enter E-mail (test@test.com)" />
        <Input v-model="password" type="password" size="lg" label="Enter Password (123456)" />

        <Alert v-if="error" type="danger" class="mb-2">{{ error }}</Alert>

        <div class="text-center">
          <Button @click="login" type="button" size="lg" gradient="green-blue">
            Sign in</Button>
        </div>
      </form>
    </div>
  </div>  
</template>

