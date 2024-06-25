<template>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary mt-3" @click="showModal">
    Create Product
  </button>
  
  <ModalComponent modalId="createModalId">
    <template #body>
      <div>
        <h2 class="text-center mb-4">Product Page</h2>
        <form @submit.prevent="submitProduct" class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="product_name" class="form-label">Product Name</label>
              <input type="text" v-model="form.product_name" id="product_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="product_title" class="form-label">Product Title</label>
              <input type="text" v-model="form.product_title" id="product_title" class="form-control" required>
            </div>
            <div class="col-12">
              <label for="product_description" class="form-label">Product Description</label>
              <textarea v-model="form.product_description" id="product_description" class="form-control" required></textarea>
            </div>
            <div class="col-md-6">
              <label for="category" class="form-label">Category</label>
              <input type="text" v-model="form.category" id="category" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="tag" class="form-label">Tag</label>
              <input type="text" v-model="form.tag" id="tag" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="size" class="form-label">Size</label>
              <input type="text" v-model="form.size" id="size" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="weight" class="form-label">Weight</label>
              <input type="number" v-model="form.weight" id="weight" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="sku_id" class="form-label">SKU ID</label>
              <input type="text" v-model="form.sku_id" id="sku_id" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="colour" class="form-label">Colour</label>
              <input type="text" v-model="form.colour" id="colour" class="form-control" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3 w-100" :disabled="loading">{{ loading ? 'Please wait...' : 'Submit' }}</button>
        </form>

      </div>
    </template>
  </ModalComponent>
</template>

<script setup>
import { ref } from 'vue';
import { Modal } from 'bootstrap';
import ModalComponent from '@/components/base/ModalComponent.vue';
import useProductStore from '../../store/product';



const form = ref({
  product_name: '',
  product_title: '',
  product_description: '',
  category: '',
  tag: '',
  size: '',
  weight: '',
  sku_id: '',
  colour: ''
});

//const products = ref([]);
const loading = ref(false);
const myModal = ref(null);

const showModal = () => {
  const modalElement = document.getElementById('createModalId');
  myModal.value = new Modal(modalElement);
  myModal.value.show();
};






const submitProduct = async () => {
  try {
    loading.value = true;
     await useProductStore().postProduct(form.value)
    //products.value.push(response);
    resetForm();
    myModal.value.hide();
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
};

const resetForm = () => {
  form.value = {
    product_name: '',
    product_title: '',
    product_description: '',
    category: '',
    tag: '',
    size: '',
    weight: '',
    sku_id: '',
    colour: ''
  };
};


</script>
