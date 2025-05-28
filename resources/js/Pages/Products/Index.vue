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

          <!-- Navigation Links -->
          <div class="hidden md:flex items-center space-x-8">
            <Link href="/home" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
              Inicio
            </Link>
            <Link href="/products" class="text-blue-600 font-medium border-b-2 border-blue-600">
              Catálogo
            </Link>
            <Link href="/categories" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
              Categorías
            </Link>
            <Link href="/contact" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
              Contacto
            </Link>
          </div>

          <!-- Search and User Actions -->
          <div class="flex items-center space-x-4">
            <!-- Search -->
            <div class="hidden lg:block relative">
              <input 
                v-model="searchQuery"
                @input="handleSearch"
                type="text" 
                placeholder="Buscar relojes..." 
                class="w-64 px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-100 border border-gray-300 rounded-full focus:outline-none focus:bg-white focus:border-blue-500 transition-all"
              >
              <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
              </svg>
            </div>

            <!-- Auth Section -->
            <div v-if="!$page.props.auth.user" class="flex items-center space-x-2">
              <Link :href="route('login')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                Ingresar
              </Link>
              <Link :href="route('register')" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition-colors">
                Registrarse
              </Link>
            </div>

            <!-- User Menu (if authenticated) -->
            <div v-else class="relative" ref="userDropdown">
              <button 
                @click="showUserDropdown = !showUserDropdown"
                class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition-colors p-2 rounded-lg hover:bg-gray-50"
              >
                <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                  <span class="text-white text-sm font-semibold">
                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                  </span>
                </div>
                <span class="font-medium hidden sm:block">{{ $page.props.auth.user.name }}</span>
              </button>

              <!-- Dropdown Menu -->
              <div 
                v-show="showUserDropdown"
                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
              >
                <Link :href="route('profile.show')" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                  Mi Perfil
                </Link>
                <Link href="/orders" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                  Mis Pedidos
                </Link>
                <div class="border-t border-gray-100 my-2"></div>
                <form @submit.prevent="logout" class="block">
                  <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                    Cerrar Sesión
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 text-white py-16">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Catálogo de Relojes</h1>
        <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
          Descubre nuestra exclusiva colección de relojes premium
        </p>
        <div class="flex justify-center">
          <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 max-w-md w-full">
            <input 
              v-model="searchQuery"
              @input="handleSearch"
              type="text" 
              placeholder="Buscar por marca, modelo..." 
              class="w-full px-4 py-3 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-white/50"
            >
          </div>
        </div>
      </div>
    </section>

    <!-- Filtros y Productos -->
    <div class="container mx-auto px-4 py-8">
      <!-- Botón de regreso y Crear Producto -->
      <div class="flex justify-between items-center mb-6">
        <Link href="/home" class="inline-flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors group">
          <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          <span>Volver al inicio</span>
        </Link>

        <!-- Botón de crear producto (solo para usuarios autenticados) -->
        <Link 
          v-if="$page.props.auth.user"
          :href="route('products.create')" 
          class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 flex items-center space-x-2"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <span>Nuevo Producto</span>
        </Link>
      </div>

      <!-- Mensajes de éxito/error -->
      <div v-if="flashMessage.success" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        {{ flashMessage.success }}
      </div>
      <div v-if="flashMessage.error" class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
        {{ flashMessage.error }}
      </div>

      <!-- Filtros -->
      <div class="mb-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <!-- Contador de productos -->
          <div class="text-gray-600">
            <span class="font-semibold text-gray-900">{{ filteredProducts.length }}</span> productos encontrados
          </div>

          <!-- Categorías -->
          <div class="flex flex-wrap gap-2">
            <button 
              @click="selectedCategory = null"
              :class="[
                'px-4 py-2 rounded-full font-medium transition-colors',
                selectedCategory === null 
                  ? 'bg-blue-600 text-white' 
                  : 'bg-white text-gray-700 hover:bg-gray-100'
              ]"
            >
              Todos
            </button>
            <button 
              v-for="category in categories" 
              :key="category.id"
              @click="selectedCategory = category.id"
              :class="[
                'px-4 py-2 rounded-full font-medium transition-colors',
                selectedCategory === category.id 
                  ? 'bg-blue-600 text-white' 
                  : 'bg-white text-gray-700 hover:bg-gray-100'
              ]"
            >
              {{ category.name }}
            </button>
          </div>

          <!-- Ordenamiento -->
          <div class="flex items-center space-x-4">
            <label class="text-sm font-medium text-gray-700">Ordenar por:</label>
            <select 
              v-model="sortBy"
              @change="handleSort"
              class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="name_asc">Nombre A-Z</option>
              <option value="name_desc">Nombre Z-A</option>
              <option value="price_asc">Precio menor</option>
              <option value="price_desc">Precio mayor</option>
              <option value="newest">Más nuevos</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Grid de productos -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div 
          v-for="product in filteredProducts" 
          :key="product.id"
          class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
        >
          <!-- Imagen del producto -->
          <div class="relative aspect-square bg-gray-100 p-4">
            <img 
              v-if="product.image" 
              :src="product.image_url || `/storage/${product.image}`" 
              :alt="product.name"
              class="w-full h-full object-contain rounded-xl"
            />
            <div v-else class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center">
              <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>

            <!-- Badge de categoría -->
            <div v-if="product.category" class="absolute top-2 left-2">
              <span class="bg-blue-600 text-white px-2 py-1 rounded-full text-xs font-medium">
                {{ product.category.name }}
              </span>
            </div>

            <!-- Badge de stock -->
            <div v-if="product.stock <= 5" class="absolute top-2 right-2">
              <span 
                :class="[
                  'px-2 py-1 rounded-full text-xs font-medium',
                  product.stock === 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'
                ]"
              >
                {{ product.stock === 0 ? 'Agotado' : `Solo ${product.stock}` }}
              </span>
            </div>

            <!-- Overlay con botones de acción CRUD (solo para admin) -->
            <div v-if="$page.props.auth.user" class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
              <Link 
                :href="route('products.edit', product.slug)"
                class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors"
                title="Editar producto"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
              </Link>
              <Link 
                :href="route('products.show', product.slug)"
                class="bg-green-600 text-white p-2 rounded-lg hover:bg-green-700 transition-colors"
                title="Ver detalles"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
              </Link>
              <button 
                @click="deleteProduct(product)"
                class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition-colors"
                title="Eliminar producto"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Información del producto -->
          <div class="p-4">
            <div class="mb-2">
              <p class="text-xs font-medium text-blue-600">{{ product.brand || 'Sin marca' }}</p>
              <h3 class="font-bold text-gray-900 line-clamp-2">{{ product.name || 'Sin nombre' }}</h3>
            </div>

            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ product.description || 'Sin descripción' }}</p>

            <div class="flex items-center justify-between">
              <div class="flex flex-col">
                <span class="text-2xl font-bold text-gray-900">${{ formatPrice(product.price) }}</span>
                <span class="text-xs text-gray-500">Precio final</span>
              </div>

              <div class="flex space-x-2">
                <button class="p-2 text-gray-600 hover:text-red-500 transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                  </svg>
                </button>
                <Link 
                  v-if="product.slug"
                  :href="route('products.show', product.slug)"
                  class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                >
                  Ver detalles
                </Link>
              </div>
            </div>

            <!-- Stock info para admin -->
            <div v-if="$page.props.auth.user" class="mt-3 pt-3 border-t border-gray-100">
              <div class="flex justify-between text-xs text-gray-500">
                <span>Stock: {{ product.stock || 0 }}</span>
                <span>ID: #{{ product.id }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mensaje si no hay productos -->
      <div v-if="filteredProducts.length === 0" class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 20.4a7.962 7.962 0 01-8-7.109C5.043 8.264 8.389 4 12 4s6.957 4.264 8 9.291z"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No se encontraron productos</h3>
        <p class="text-gray-600 mb-4">Intenta ajustar los filtros o términos de búsqueda</p>
        <Link 
          v-if="$page.props.auth.user"
          :href="route('products.create')" 
          class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors"
        >
          Crear primer producto
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, useForm, router, usePage } from '@inertiajs/vue3'
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  products: {
    type: Array,
    default: () => []
  },
  categories: {
    type: Array,
    default: () => []
  },
})

// Obtener datos de la página de forma segura
const page = usePage()

// Computed para manejar mensajes flash
const flashMessage = computed(() => {
  const flash = page.props?.flash || {}
  return {
    success: flash.success || null,
    error: flash.error || null
  }
})

// Estado reactivo
const searchQuery = ref('')
const selectedCategory = ref(null)
const sortBy = ref('name_asc')
const showUserDropdown = ref(false)
const userDropdown = ref(null)

// Logout functionality
const logoutForm = useForm({})

const logout = () => {
  logoutForm.post(route('logout'))
}

// Función para eliminar producto
const deleteProduct = (product) => {
  if (confirm(`¿Estás seguro de que quieres eliminar el producto "${product.name}"? Esta acción no se puede deshacer.`)) {
    router.delete(route('products.destroy', product.slug))
  }
}

// Productos filtrados
const filteredProducts = computed(() => {
  let filtered = []
  
  if (Array.isArray(props.products)) {
    filtered = [...props.products]
  } else if (props.products && props.products.data && Array.isArray(props.products.data)) {
    filtered = [...props.products.data]
  } else {
    console.error('Products is not an array:', props.products)
    return []
  }

  // Filtrar por búsqueda
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(product => 
      product?.name?.toLowerCase().includes(query) ||
      product?.brand?.toLowerCase().includes(query) ||
      product?.description?.toLowerCase().includes(query)
    )
  }

  // Filtrar por categoría
  if (selectedCategory.value) {
    filtered = filtered.filter(product => product?.category?.id === selectedCategory.value)
  }

  // Ordenar
  filtered.sort((a, b) => {
    switch (sortBy.value) {
      case 'name_asc':
        return (a?.name || '').localeCompare(b?.name || '')
      case 'name_desc':
        return (b?.name || '').localeCompare(a?.name || '')
      case 'price_asc':
        return (a?.price || 0) - (b?.price || 0)
      case 'price_desc':
        return (b?.price || 0) - (a?.price || 0)
      case 'newest':
        return new Date(b?.created_at || 0) - new Date(a?.created_at || 0)
      default:
        return 0
    }
  })

  return filtered
})

// Funciones
const formatPrice = (price) => {
  if (!price) return '0.00'
  return new Intl.NumberFormat('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price)
}

const handleSearch = () => {
  // La búsqueda se maneja reactivamente
}

const handleSort = () => {
  // El ordenamiento se maneja reactivamente
}

// Cerrar dropdown al hacer clic fuera
const handleClickOutside = (event) => {
  if (userDropdown.value && !userDropdown.value.contains(event.target)) {
    showUserDropdown.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>