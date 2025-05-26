<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Crear Categoría</h1>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <div class="mb-4">
        <label>Nombre</label>
        <input v-model="form.name" class="border w-full p-2" />
      </div>
      <div class="mb-4">
        <label>Descripción</label>
        <textarea v-model="form.description" class="border w-full p-2"></textarea>
      </div>
      <div class="mb-4">
        <label>Prioridad</label>
        <input type="number" v-model="form.priority" class="border w-full p-2" />
      </div>
      <div class="mb-4">
        <label>Imagen</label>
        <input type="file" @change="onFileChange" class="border w-full p-2" />
      </div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2">Guardar</button>
    </form>
  </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';

export default {
  setup() {
    const form = useForm({
      name: '',
      description: '',
      priority: 1,
      image: null, // Aquí guardamos el archivo
    });

    function onFileChange(e) {
      form.image = e.target.files[0]; // Asignamos el archivo seleccionado
    }

    function submit() {
      form.post('/categories');
    }

    return { form, submit, onFileChange };
  }
}
</script>
