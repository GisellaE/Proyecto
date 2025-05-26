<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Editar Categoría</h1>
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

      <!-- Mostrar imagen actual si existe -->
      <div v-if="category.image" class="mb-4">
        <label>Imagen actual:</label>
        <img :src="`/storage/${category.image}`" alt="Imagen categoría" class="max-w-xs mt-2" />
      </div>

      <!-- Input para subir nueva imagen -->
      <div class="mb-4">
        <label>Nueva Imagen</label>
        <input type="file" @change="onFileChange" class="border w-full p-2" />
      </div>

      <button type="submit" class="bg-green-500 text-white px-4 py-2">Actualizar</button>
    </form>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
  props: {
    category: Object,
  },
  setup(props) {
    const form = useForm({
      name: props.category.name,
      description: props.category.description,
      priority: props.category.priority,
      image: null,
    });

    function onFileChange(e) {
      form.image = e.target.files[0];
    }

    function submit() {
      const formData = new FormData();
      formData.append('name', form.name);
      formData.append('description', form.description);
      formData.append('priority', form.priority);
      if (form.image) {
        formData.append('image', form.image);
      }
      formData.append('_method', 'PUT');

      Inertia.post(`/categories/${props.category.slug}`, formData, {
        forceFormData: true,
        onSuccess: () => {
          // opcional: notificación
        },
      });
    }

    return { form, submit, onFileChange };
  },
};
</script>
