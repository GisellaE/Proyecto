<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Categorías</h1>
    <Link href="/categories/create" class="text-blue-500 underline">Crear nueva categoría</Link>

    <ul class="mt-4 space-y-2">
      <li v-for="cat in categories" :key="cat.id" class="p-4 border rounded flex justify-between items-center">
        <div class="flex items-center space-x-4">
          <img 
            v-if="cat.image_url" 
            :src="cat.image_url" 
            alt="Imagen categoría" 
            class="w-16 h-16 object-cover rounded"
          />
          <div>
            <h2 class="font-semibold">{{ cat.name }}</h2>
            <p class="text-sm">{{ cat.description }}</p>
            <p class="text-xs text-gray-500">Prioridad: {{ cat.priority }}</p>
          </div>
        </div>

        <div class="flex space-x-2">
          <Link :href="`/categories/${cat.slug}/edit`" class="text-blue-600">Editar</Link>
          <form :action="`/categories/${cat.slug}`" method="POST" @submit.prevent="submitDelete($event, cat.slug)">
            <input type="hidden" name="_method" value="DELETE" />
            <button type="submit" class="text-red-600">Eliminar</button>
          </form>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { Link, router } from '@inertiajs/inertia-vue3';

export default {
  props: {
    categories: Array
  },
  components: { Link },
  methods: {
    submitDelete(event, slug) {
      router.delete(`/categories/${slug}`)
    }
  }
}
</script>
