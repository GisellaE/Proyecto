<template>
  <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">Editar Categoría</h1>

    <form @submit.prevent="submit" enctype="multipart/form-data" novalidate>
      <!-- Nombre -->
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-semibold mb-2">Nombre</label>
        <input
          id="name"
          type="text"
          v-model="form.name"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <div v-if="$page.props.errors.name" class="text-red-600 mt-1 text-sm">
          {{ $page.props.errors.name }}
        </div>
      </div>

      <!-- Slug -->
      <div class="mb-4">
        <label for="slug" class="block text-gray-700 font-semibold mb-2">Slug</label>
        <input
          id="slug"
          type="text"
          v-model="form.slug"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <div v-if="$page.props.errors.slug" class="text-red-600 mt-1 text-sm">
          {{ $page.props.errors.slug }}
        </div>
      </div>

      <!-- Descripción -->
      <div class="mb-4">
        <label for="description" class="block text-gray-700 font-semibold mb-2">Descripción</label>
        <textarea
          id="description"
          v-model="form.description"
          rows="4"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        ></textarea>
        <div v-if="$page.props.errors.description" class="text-red-600 mt-1 text-sm">
          {{ $page.props.errors.description }}
        </div>
      </div>

      <!-- Imagen -->
      <div class="mb-4">
        <label for="image" class="block text-gray-700 font-semibold mb-2">
          {{ category.image ? 'Cambiar imagen' : 'Imagen de la categoría' }}
        </label>

        <div
          class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition-colors"
          @click="$refs.imageInput.click()"
        >
          <input
            id="image"
            type="file"
            accept="image/*"
            class="hidden"
            ref="imageInput"
            @change="handleImageUpload"
          />

          <template v-if="!imagePreview && !category.image">
            <svg
              class="mx-auto mb-3 w-12 h-12 text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m0 0v6H4v-6m16-10H4a2 2 0 00-2 2v6h20V6a2 2 0 00-2-2z"
              ></path>
            </svg>
            <p class="text-gray-600">Haz clic para seleccionar una imagen</p>
          </template>

          <template v-if="imagePreview">
            <div class="relative inline-block">
              <img
                :src="imagePreview"
                alt="Vista previa"
                class="mx-auto rounded-lg shadow-md w-32 h-32 object-cover"
              />
              <button
                type="button"
                class="absolute top-0 right-0 bg-red-600 rounded-full p-1 hover:bg-red-700 text-white"
                @click.stop="removeImage"
              >
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          </template>

          <template v-if="!imagePreview && category.image">
            <img
              :src="category.image_url"
              alt="Imagen actual"
              class="mx-auto rounded-lg shadow-md w-32 h-32 object-cover"
            />
          </template>
        </div>

        <div v-if="$page.props.errors.image" class="text-red-600 mt-1 text-sm">
          {{ $page.props.errors.image }}
        </div>
      </div>

      <!-- Estado -->
      <div class="mb-6">
        <button
          type="button"
          @click="toggleStatus"
          :class="form.status === 1 ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-400 hover:bg-gray-500'"
          class="px-6 py-2 rounded-xl text-white font-semibold transition-colors"
        >
          {{ form.status === 1 ? 'Activo' : 'Inactivo' }}
        </button>
      </div>

      <!-- Botón guardar -->
      <div>
        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-lg transition-colors"
          :disabled="form.processing"
        >
          Guardar cambios
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps({
  category: Object
})

const form = useForm({
  name: props.category.name || '',
  slug: props.category.slug || '',
  description: props.category.description || '',
  image: null,
  status: props.category.status || 0
})

const imagePreview = ref(null)

function handleImageUpload(event) {
  const file = event.target.files[0]
  if (file) {
    form.image = file

    const reader = new FileReader()
    reader.onload = e => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

function removeImage() {
  form.image = null
  imagePreview.value = null
  if ($refs.imageInput) {
    $refs.imageInput.value = ''
  }
}

function toggleStatus() {
  form.status = form.status === 1 ? 0 : 1
}

function submit() {
  form.put(route('categories.update', props.category.slug))
}
</script>
