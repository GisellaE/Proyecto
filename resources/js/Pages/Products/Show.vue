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
            <Link href="/products" class="hover:text-blue-600 transition-colors">Productos</Link>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-900">{{ product.name }}</span>
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

    <!-- Contenido principal -->
    <div class="container mx-auto px-4 py-8">
      <!-- Botón de regreso -->
      <div class="mb-6">
        <Link href="/products" class="inline-flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors group">
          <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          <span>Volver al catálogo</span>
        </Link>
      </div>

      <!-- Producto -->
      <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Imagen del producto -->
          <div class="relative">
            <div class="aspect-square bg-gray-100 p-8 flex items-center justify-center">
              <img 
                v-if="product.image" 
                :src="product.image_url || `/storage/${product.image}`" 
                :alt="product.name"
                class="max-w-full max-h-full object-contain rounded-2xl shadow-lg hover:scale-105 transition-transform duration-300"
              />
              <div v-else class="w-64 h-64 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center">
                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>

            <!-- Badge de categoría -->
            <div class="absolute top-4 left-4">
              <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-medium shadow-lg">
                {{ product.category.name }}
              </span>
            </div>

            <!-- Badge de stock -->
            <div class="absolute top-4 right-4">
              <span 
                :class="[
                  'px-3 py-1 rounded-full text-sm font-medium shadow-lg',
                  product.stock > 5 
                    ? 'bg-green-100 text-green-800' 
                    : product.stock > 0 
                      ? 'bg-yellow-100 text-yellow-800'
                      : 'bg-red-100 text-red-800'
                ]"
              >
                {{ product.stock > 0 ? `${product.stock} disponibles` : 'Agotado' }}
              </span>
            </div>
          </div>

          <!-- Información del producto -->
          <div class="p-8 lg:p-12">
            <div class="space-y-6">
              <!-- Título y marca -->
              <div>
                <p class="text-sm font-medium text-blue-600 mb-2">{{ product.brand }}</p>
                <h1 class="text-4xl font-bold text-gray-900 mb-4 leading-tight">
                  {{ product.name }}
                </h1>
              </div>

              <!-- Precio -->
              <div class="border-t border-gray-200 pt-6">
                <div class="flex items-baseline space-x-2">
                  <span class="text-4xl font-bold text-gray-900">${{ formatPrice(product.price) }}</span>
                  <span class="text-lg text-gray-500">USD</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">Precio incluye impuestos</p>
              </div>

              <!-- Descripción -->
              <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Descripción</h3>
                <p class="text-gray-700 leading-relaxed">{{ product.description }}</p>
              </div>

              <!-- Especificaciones -->
              <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Especificaciones</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                      <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-gray-900">Marca</p>
                        <p class="text-sm text-gray-600">{{ product.brand }}</p>
                      </div>
                    </div>
                  </div>

                  <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                      <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-gray-900">Garantía</p>
                        <p class="text-sm text-gray-600">2 años internacional</p>
                      </div>
                    </div>
                  </div>

                  <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                      <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-gray-900">Envío</p>
                        <p class="text-sm text-gray-600">Gratis a domicilio</p>
                      </div>
                    </div>
                  </div>

                  <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                      <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-gray-900">Entrega</p>
                        <p class="text-sm text-gray-600">3-5 días hábiles</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Botones de acción -->
              <div class="border-t border-gray-200 pt-6 space-y-4">
                <div class="flex flex-col sm:flex-row gap-4">
                  <button 
                    :disabled="product.stock === 0"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg hover:from-blue-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13v4a2 2 0 002 2h6a2 2 0 002-2v-4m-8 0V9a2 2 0 012-2h4a2 2 0 012 2v4.01"></path>
                    </svg>
                    <span>{{ product.stock === 0 ? 'Agotado' : 'Agregar al carrito' }}</span>
                  </button>

                  <button class="bg-white border-2 border-gray-300 text-gray-700 py-4 px-6 rounded-xl font-semibold hover:border-red-500 hover:text-red-500 transition-colors flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="hidden sm:inline">Favoritos</span>
                  </button>
                </div>

                <!-- Información adicional -->
                <div class="flex items-center justify-center space-x-6 text-sm text-gray-600">
                  <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>Compra segura</span>
                  </div>
                  <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    <span>Devoluciones fáciles</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Productos relacionados -->
      <div v-if="relatedProducts.length > 0" class="mt-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Productos Relacionados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div 
            v-for="relatedProduct in relatedProducts" 
            :key="relatedProduct.id"
            class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
          >
            <div class="relative aspect-square bg-gray-100 p-4">
              <img 
                v-if="relatedProduct.image" 
                :src="relatedProduct.image_url || `/storage/${relatedProduct.image}`" 
                :alt="relatedProduct.name"
                class="w-full h-full object-contain rounded-xl"
              />
              <div v-else class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>

            <div class="p-4">
              <div class="mb-2">
                <p class="text-xs font-medium text-blue-600">{{ relatedProduct.brand }}</p>
                <h3 class="font-bold text-gray-900 line-clamp-2">{{ relatedProduct.name }}</h3>
              </div>

              <div class="flex items-center justify-between">
                <div class="flex flex-col">
                  <span class="text-xl font-bold text-gray-900">${{ formatPrice(relatedProduct.price) }}</span>
                  <span class="text-xs text-gray-500">Precio final</span>
                </div>

                <Link 
                  :href="route('products.show', relatedProduct.slug)"
                  class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                >
                  Ver
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  product: Object,
  relatedProducts: Array,
})

// Función para formatear el precio
const formatPrice = (price) => {
  return new Intl.NumberFormat('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price)
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>