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
            <span class="text-gray-900">Nuevo Producto</span>
          </div>

          <!-- Usuario -->
          <div class="flex items-center space-x-2">
            <span class="text-gray-700">{{ $page.props.auth.user.name }}</span>
            <Link :href="route('profile.show')" class="p-2 text-gray-700 hover:text-blue-600 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
      <!-- Botón de regreso -->
      <div class="mb-6">
        <Link href="/products" class="inline-flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors group">
          <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          <span>Volver a productos</span>
        </Link>
      </div>

      <!-- Formulario -->
      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
          <!-- Header -->
          <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
            <h1 class="text-3xl font-bold text-white">Crear Nuevo Producto</h1>
            <p class="text-blue-100 mt-2">Agrega un nuevo reloj a tu catálogo</p>
          </div>

          <!-- Formulario -->
          <form @submit.prevent="submit" class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <!-- Columna izquierda -->
              <div class="space-y-6">
                <!-- Nombre -->
                <div>
                  <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nombre del producto *
                  </label>
                  <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Ej: Rolex Submariner"
                    required
                  />
                  <div v-if="$page.props.errors.name" class="text-red-600 text-sm mt-1">
                    {{ $page.props.errors.name }}
                  </div>
                </div>

                <!-- Slug -->
                <div>
                  <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                    Slug (URL amigable)
                  </label>
                  <input
                    id="slug"
                    v-model="form.slug"
                    type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Se generará automáticamente del nombre"
                  />
                  <div v-if="$page.props.errors.slug" class="text-red-600 text-sm mt-1">
                    {{ $page.props.errors.slug }}
                  </div>
                </div>

                <!-- Marca -->
                <div>
                  <label for="brand" class="block text-sm font-semibold text-gray-700 mb-2">
                    Marca
                  </label>
                  <input
                    id="brand"
                    v-model="form.brand"
                    type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Ej: Rolex, Omega, Casio"
                  />
                  <div v-if="$page.props.errors.brand" class="text-red-600 text-sm mt-1">
                    {{ $page.props.errors.brand }}
                  </div>
                </div>

                <!-- Categoría -->
                <div>
                  <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Categoría *
                  </label>
                  <select
                    id="category_id"
                    v-model="form.category_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    required
                  >
                    <option value="">Selecciona una categoría</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{ category.name }}
                    </option>
                  </select>
                  <div v-if="$page.props.errors.category_id" class="text-red-600 text-sm mt-1">
                    {{ $page.props.errors.category_id }}
                  </div>
                </div>

                <!-- Precio y Stock -->
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                      Precio *
                    </label>
                    <div class="relative">
                      <span class="absolute left-3 top-3 text-gray-500">$</span>
                      <input
                        id="price"
                        v-model="form.price"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="0.00"
                        required
                      />
                    </div>
                    <div v-if="$page.props.errors.price" class="text-red-600 text-sm mt-1">
                      {{ $page.props.errors.price }}
                    </div>
                  </div>

                  <div>
                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                      Stock *
                    </label>
                    <input
                      id="stock"
                      v-model="form.stock"
                      type="number"
                      min="0"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                      placeholder="0"
                      required
                    />
                    <div v-if="$page.props.errors.stock" class="text-red-600 text-sm mt-1">
                      {{ $page.props.errors.stock }}
                    </div>
                  </div>
                </div>

                <!-- Descripción -->
                <div>
                  <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Descripción
                  </label>
                  <textarea
                    id="description"
                    v-model="form.description"
                    rows="6"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                    placeholder="Describe las características del producto..."
                  ></textarea>
                  <div v-if="$page.props.errors.description" class="text-red-600 text-sm mt-1">
                    {{ $page.props.errors.description }}
                  </div>
                </div>
              </div>

              <!-- Columna derecha -->
              <div class="space-y-6">
                <!-- Imagen -->
                <div>
                  <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    Imagen del producto
                  </label>
                  <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition-colors">
                    <input
                      id="image"
                      @change="handleImageUpload"
                      type="file"
                      accept="image/*"
                      class="hidden"
                      ref="imageInput"
                    />
                    
                    <div v-if="!imagePreview" @click="$refs.imageInput.click()" class="cursor-pointer">
                      <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                      <p class="text-gray-600 mb-2">Haz clic para subir una imagen</p>
                      <p class="text-gray-400 text-sm">PNG, JPG, GIF hasta 2MB</p>
                    </div>

                    <div v-else class="relative">
                      <img :src="imagePreview" alt="Preview" class="max-w-full h-48 mx-auto rounded-lg object-cover">
                      <button 
                        @click="removeImage"
                        type="button"
                        class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full hover:bg-red-700 transition-colors"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                      </button>
                      <button 
                        @click="$refs.imageInput.click()"
                        type="button"
                        class="mt-2 text-blue-600 hover:text-blue-700 transition-colors text-sm"
                      >
                        Cambiar imagen
                      </button>
                    </div>
                  </div>
                  <div v-if="$page.props.errors.image" class="text-red-600 text-sm mt-1">
                    {{ $page.props.errors.image }}
                  </div>
                </div>

                <!-- Tips -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                  <div class="flex items-center space-x-2 text-blue-800 mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Consejos para tu producto</span>
                  </div>
                  <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Usa un nombre descriptivo y único</li>
                    <li>• Agrega una imagen de alta calidad</li>
                    <li>• Incluye detalles en la descripción</li>
                    <li>• Especifica la marca si la conoces</li>
                    <li>• Mantén el stock actualizado</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row gap-4 pt-8 mt-8 border-t border-gray-200">
              <button
                type="submit"
                :disabled="form.processing"
                class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2"
              >
                <svg v-if="form.processing" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>{{ form.processing ? 'Creando...' : 'Crear Producto' }}</span>
              </button>

              <Link 
                href="/products"
                class="bg-gray-200 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-300 transition-colors text-center"
              >
                Cancelar
              </Link>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  categories: Array,
})

const imagePreview = ref(null)
const imageInput = ref(null)

const form = useForm({
  name: '',
  slug: '',
  description: '',
  brand: '',
  price: '',
  stock: '',
  category_id: '',
  image: null,
})

const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.image = file
    
    // Crear preview
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const removeImage = () => {
  form.image = null
  imagePreview.value = null
  imageInput.value.value = ''
}

const submit = () => {
  form.post(route('products.store'))
}
</script>

<style scoped>
/* Ningún estilo personalizado necesario, todo está con Tailwind */
</style>