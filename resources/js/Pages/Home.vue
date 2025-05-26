<template>
  <div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl font-bold text-center text-gray-900 mb-6">Tienda de Relojes</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="product in products" :key="product.id" class="bg-white rounded-lg shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
          <div class="relative">
            <img :src="product.image" alt="Imagen del producto" class="w-full h-48 object-cover" />
            <div class="absolute top-0 left-0 bg-gray-800 text-white py-1 px-3 text-xs rounded-br-lg">
              {{ product.category.name }}
            </div>
          </div>
          <div class="p-6">
            <h2 class="font-semibold text-xl text-gray-800 hover:text-blue-600 transition-colors duration-300">
              <!-- Usamos Link para navegar sin recargar -->
              <Link :href="`/products/${product.slug}`">
                {{ product.name }}
              </Link>
            </h2>
            <p class="text-gray-600 mt-2">Marca: {{ product.brand }}</p>
            <p class="text-xl font-semibold text-gray-900 mt-4">${{ product.price }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
  props: {
    products: Array,
  },
  components: {
    Link,
  },
}
</script>

<style scoped>
/* Estilos adicionales si es necesario */
</style>
