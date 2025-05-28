<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
          <!-- Logo -->
          <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <Link href="/home" class="text-2xl font-bold text-gray-800 hover:text-blue-600 transition-colors">
              TimeZone
            </Link>
          </div>

          <!-- Breadcrumb -->
          <div class="hidden md:flex items-center space-x-2 text-sm text-gray-600">
            <Link href="/home" class="hover:text-blue-600 transition-colors">Inicio</Link>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-900">Categorías</span>
          </div>

          <!-- Usuario/Auth -->
          <div class="flex items-center space-x-4">
            <div v-if="!$page.props.auth.user" class="flex items-center space-x-2">
              <Link :href="route('login')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                Ingresar
              </Link>
              <Link :href="route('register')" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition-colors">
                Registrarse
              </Link>
            </div>
            <div v-else class="flex items-center space-x-2">
              <span class="text-gray-700">Hola, {{ $page.props.auth.user.name }}</span>
              <Link :href="route('profile.show')" class="p-2 text-gray-700 hover:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 text-white py-16">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Categorías de Relojes</h1>
        <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
          Explora nuestra amplia gama de categorías especializadas
        </p>
      </div>
    </section>

    <div class="container mx-auto px-4 py-8">
      <!-- Botón de regreso -->
      <div class="mb-6">
        <Link href="/home" class="inline-flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors group">
          <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          <span>Volver al inicio</span>
        </Link>
      </div>

      <!-- Header con botón de crear (solo si está autenticado) -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h2 class="text-3xl font-bold text-gray-900">Todas las Categorías</h2>
          <p class="text-gray-600 mt-2">{{ categories.length }} categorías disponibles</p>
        </div>
        
        <Link 
          v-if="$page.props.auth.user"
          :href="route('categories.create')" 
          class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 flex items-center space-x-2"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <span>Nueva Categoría</span>
        </Link>
      </div>

      <!-- Mensajes de éxito/error -->
      <div v-if="flashMessage.success" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        {{ flashMessage.success }}
      </div>
      <div v-if="flashMessage.error" class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
        {{ flashMessage.error }}
      </div>

      <!-- Grid de categorías -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div 
          v-for="category in categories" 
          :key="category.id"
          class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
        >
          <!-- Imagen de la categoría -->
          <div class="relative h-48 bg-gradient-to-br from-blue-100 to-purple-100">
            <img 
              v-if="category.image" 
              :src="category.image_url || `/storage/${category.image}`" 
              :alt="category.name"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
              <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
            </div>

            <!-- Badge de cantidad de productos -->
            <div class="absolute top-3 right-3">
              <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-2 py-1 rounded-full text-sm font-medium">
                {{ category.products_count }} productos
              </span>
            </div>

            <!-- Overlay con botones de acción (solo para admin) -->
            <div v-if="$page.props.auth.user" class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
              <Link 
                :href="route('categories.edit', category.slug)"
                class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors"
                title="Editar"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
              </Link>
              <button 
                @click="deleteCategory(category)"
                class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition-colors"
                title="Eliminar"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Información de la categoría -->
          <div class="p-6">
            <div class="mb-4">
              <h3 class="text-xl font-bold text-gray-900 mb-2">{{ category.name }}</h3>
              <p v-if="category.description" class="text-gray-600 text-sm line-clamp-2">
                {{ category.description }}
              </p>
            </div>

            <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
              {{ category.products_count }} {{ category.products_count === 1 ? 'producto' : 'productos' }}
            </div>

            <!-- Badge del status -->
            <div class="flex items-center justify-between mt-4">
              <span 
                :class="category.status 
                  ? 'bg-green-100 text-green-700' 
                  : 'bg-red-100 text-red-700'" 
                class="text-xs font-semibold px-3 py-1 rounded-full"
              >
                {{ category.status ? 'Activa' : 'Inactiva' }}
              </span>

              <Link 
                :href="route('categories.show', category.slug)"
                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105 text-sm font-medium"
              >
                Ver productos
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Mensaje si no hay categorías -->
      <div v-if="categories.length === 0" class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay categorías disponibles</h3>
        <p class="text-gray-600 mb-4">Comienza creando tu primera categoría</p>
        <Link 
          v-if="$page.props.auth.user"
          :href="route('categories.create')" 
          class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors"
        >
          Crear primera categoría
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { computed } from 'vue'

defineProps({
  categories: Array,
})

// Computed para manejar mensajes flash de forma segura
const flashMessage = computed(() => {
  const flash = window.usePage?.()?.props?.flash || {}
  return {
    success: flash.success || null,
    error: flash.error || null
  }
})

const deleteCategory = (category) => {
  if (confirm(`¿Estás seguro de que quieres eliminar la categoría "${category.name}"?`)) {
    router.delete(route('categories.destroy', category.slug))
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
