<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Productos</h1>
    <Link href="/products/create" class="text-blue-500 underline">Crear nuevo producto</Link>

    <ul class="mt-4 space-y-2">
      <li v-for="product in products.data" :key="product.id" class="p-4 border rounded flex justify-between items-center">
        <div class="flex items-center space-x-4">
          <!-- Mostrar la imagen solo si existe -->
          <img 
            v-if="product.image" 
            :src="`/storage/${product.image}`" 
            alt="Imagen producto" 
            class="w-16 h-16 object-cover rounded"
          />
          <div>
            <h2 class="font-semibold">{{ product.name }}</h2>
            <p class="text-sm">{{ product.description }}</p>
            <p class="text-xs text-gray-500">Precio: ${{ product.price }}</p>
            <p class="text-xs text-gray-500">Categoría: {{ product.category.name }}</p> <!-- Mostrar categoría si existe -->
          </div>
        </div>

        <div class="flex space-x-2">
          <!-- Enlace para editar el producto -->
          <Link :href="`/products/${product.slug}/edit`" class="text-blue-600">Editar</Link>
          
          <!-- Formulario para eliminar el producto -->
          <form :action="`/products/${product.slug}`" method="POST" @submit.prevent="submitDelete($event, product.slug)">
            <input type="hidden" name="_method" value="DELETE" />
            <button type="submit" class="text-red-600">Eliminar</button>
          </form>
        </div>
      </li>
    </ul>

    <!-- Paginación -->
    <div v-if="products.meta" class="mt-4">
      <button 
        v-if="products.links.prev" 
        @click="paginate(products.links.prev)" 
        class="text-blue-500"
      >Anterior</button>
      <button 
        v-if="products.links.next" 
        @click="paginate(products.links.next)" 
        class="text-blue-500"
      >Siguiente</button>
    </div>
  </div>
</template>

<script>
import { Link, router } from '@inertiajs/inertia-vue3';

export default {
  props: {
    products: Object,  // Esperamos que productos se pase como un objeto paginado
  },
  components: { Link },
  methods: {
    submitDelete(event, slug) {
      // Elimina el producto utilizando el método DELETE
      router.delete(`/products/${slug}`);
    },

    paginate(url) {
      // Realiza la paginación usando Inertia.js
      if (url) {
        this.$inertia.get(url);
      }
    }
  }
}
</script>
