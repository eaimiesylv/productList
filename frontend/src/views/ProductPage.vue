<template>
  <div id="container">
    <!--nav element-->
    <NavComponent />
    <!--main element-->
    <main class="container mt-5">
      <span><router-link to="/create-product">Create Product</router-link></span>
      <table class="table table-striped mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Product Name</th>
            <th scope="col">Product Title</th>
            <th scope="col">Product Description</th>
            <th scope="col">Category</th>
            <th scope="col">Tag</th>
            <th scope="col">Size</th>
            <th scope="col">Weight</th>
            <th scope="col">SKU ID</th>
            <th scope="col">Colour</th>
          </tr>
        </thead>
        <tbody v-if="products && products.length > 0">
          <tr v-for="(product, index) in products" :key="product.id">
            <td>{{ index + 1 }}</td>
            <td>{{ product.product_name }}</td>
            <td>{{ product.product_title }}</td>
            <td>{{ product.product_description }}</td>
            <td>{{ product.category }}</td>
            <td>{{ product.tag }}</td>
            <td>{{ product.size }}</td>
            <td>{{ product.weight }}</td>
            <td>{{ product.sku_id }}</td>
            <td>{{ product.colour }}</td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="10" class="text-center">No products found</td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import NavComponent from "@/components/NavComponent.vue";
//import CreateProductComponent from "@/components/base/CreateProductComponent.vue";
import useProductStore from '../store/product';

const productStore = useProductStore();
const products = ref([]);

const fetchProducts = async () => {
  try {
    await productStore.fetchData();
    products.value = productStore.products;
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  fetchProducts();
});
</script>
