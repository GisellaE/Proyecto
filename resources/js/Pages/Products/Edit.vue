<template>
  <form @submit.prevent="submit">
    <div>
      <label for="name">Nombre</label>
      <input v-model="form.name" id="name" type="text" required />
    </div>

    <div>
      <label for="slug">Slug</label>
      <input v-model="form.slug" id="slug" type="text" />
    </div>

    <div>
      <label for="description">Descripción</label>
      <textarea v-model="form.description" id="description"></textarea>
    </div>

    <div>
      <label for="price">Precio</label>
      <input v-model.number="form.price" id="price" type="number" min="0" required />
    </div>

    <div>
      <label for="brand">Marca</label>
      <input v-model="form.brand" id="brand" type="text" required />
    </div>

    <div>
      <label for="stock">Stock</label>
      <input v-model.number="form.stock" id="stock" type="number" min="0" required />
    </div>

    <div>
      <label for="category_id">Categoría</label>
      <select v-model="form.category_id" id="category_id" required>
        <option value="" disabled>Selecciona una categoría</option>
        <option v-for="category in categories" :key="category.id" :value="category.id">
          {{ category.name }}
        </option>
      </select>
    </div>

    <!-- Campo de imagen -->
    <div>
      <label for="image">Imagen</label>
      <input @change="onFileChange" type="file" id="image" accept="image/*" />
    </div>

    <!-- Vista previa de la imagen -->
    <div v-if="previewImage">
      <img :src="previewImage" alt="Vista previa" style="max-width: 200px; margin-top: 10px;" />
    </div>

    <!-- Mostrar la imagen actual si existe -->
    <div v-if="product.image">
      <h4>Imagen actual:</h4>
      <img :src="`/storage/${product.image}`" alt="Imagen producto" style="max-width: 200px;" />
    </div>

    <button type="submit">Actualizar producto</button>
  </form>
</template>

<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
  props: {
    categories: Array,
    product: Object,
  },
  setup() {
    const form = useForm({
      name: product.name || '',
      slug: product.slug || '',
      description: product.description || '',
      price: product.price || '',
      brand: product.brand || '',
      stock: product.stock || '',
      category_id: product.category_id || '',
      image: null,
    });

    const previewImage = ref(null);

    // Función para manejar el cambio del archivo
    function onFileChange(e) {
      const file = e.target.files[0];
      form.image = file;

      if (file) {
        previewImage.value = URL.createObjectURL(file);
      } else {
        previewImage.value = null;
      }
    }

    // Función para enviar el formulario
    function submit() {
      const formData = new FormData();
      for (const key in form) {
        if (form[key] !== null && form[key] !== undefined) {
          formData.append(key, form[key]);
        }
      }
      form.put(`/products/${product.slug}`, { data: formData });
    }

    return { form, onFileChange, previewImage, submit };
  },
};
</script>
