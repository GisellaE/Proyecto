<template>
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">{{ product.name }}</h1>

    <img v-if="product.image" :src="`/storage/${product.image}`" alt="Imagen producto" class="mb-4 max-w-sm" />

    <p><strong>Marca:</strong> {{ product.brand }}</p>
    <p><strong>Precio:</strong> ${{ product.price }}</p>
    <p><strong>Stock:</strong> {{ product.stock }}</p>
    <p><strong>Categoría:</strong> {{ product.category.name }}</p>
    <p class="mt-4">{{ product.description }}</p>
  </div>
</template>

<script>
export default {
  props: {
    product: Object,
  },
}
</script>
