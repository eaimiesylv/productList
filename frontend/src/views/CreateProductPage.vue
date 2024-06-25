<template>
  <div id="container">
    <!--nav element-->
    <NavComponent />
    <!--main element-->
    <main class="container mt-5">
      <div>
        <h4 class="text-center mb-4">Product Page</h4>
        <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
        <form @submit.prevent="submitProduct" class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
              <input type="text" v-model="form.product_name" id="product_name" class="form-control" placeholder="Enter product name" required>
              <div v-if="!form.product_name && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6">
              <label for="product_title" class="form-label">Product Title <span class="text-danger">*</span></label>
              <input type="text" v-model="form.product_title" id="product_title" class="form-control" placeholder="Enter product title" required>
              <div v-if="!form.product_title && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-12">
              <label for="product_description" class="form-label">Product Description <span class="text-danger">*</span></label>
              <textarea v-model="form.product_description" id="product_description" class="form-control" placeholder="Enter product description" required></textarea>
              <div v-if="!form.product_description && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6">
              <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
              <input type="text" v-model="form.category" id="category" class="form-control" placeholder="Enter category" required>
              <div v-if="!form.category && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6">
              <label for="tag" class="form-label">Tag <span class="text-danger">*</span></label>
              <input type="text" v-model="form.tag" id="tag" class="form-control" placeholder="Enter tag" required>
              <div v-if="!form.tag && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6">
              <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
              <input type="number" v-model="form.size" id="size" class="form-control" placeholder="Enter size" required>
              <div v-if="!form.size && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6">
              <label for="weight" class="form-label">Weight <span class="text-danger">*</span></label>
              <input type="number" v-model="form.weight" id="weight" class="form-control" placeholder="Enter weight" required>
              <div v-if="!form.weight && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6">
              <label for="sku_id" class="form-label">SKU ID <span class="text-danger">*</span></label>
              <input type="text" v-model="form.sku_id" id="sku_id" class="form-control" placeholder="Enter SKU ID" required>
              <div v-if="!form.sku_id && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6">
              <label for="colour" class="form-label">Colour <span class="text-danger">*</span></label>
              <input type="text" v-model="form.colour" id="colour" class="form-control" placeholder="Enter colour" required>
              <div v-if="!form.colour && submitAttempted" class="text-danger">This field is required</div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3 w-100" :disabled="loading">{{ loading ? 'Please wait...' : 'Submit' }}</button>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import NavComponent from "@/components/NavComponent.vue";
import useProductStore from '../store/product';

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

const loading = ref(false);
const errorMessage = ref('');
const submitAttempted = ref(false);
const router = useRouter();

const submitProduct = async () => {
  submitAttempted.value = true;
  if (form.value.product_name && form.value.product_title && form.value.product_description && form.value.category && form.value.tag && form.value.size && form.value.weight && form.value.sku_id && form.value.colour) {
    try {
      loading.value = true;
      errorMessage.value = '';
      const response = await useProductStore().postProduct(form.value);
      if (response.success) {
        resetForm();
        router.push('/product');
      } else {
        errorMessage.value = response.response?.response?.data?.message || response.response;
      }
    } catch (error) {
      console.error(error);
    } finally {
      loading.value = false;
    }
  } else {
    errorMessage.value = 'Please fill in all required fields.';
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
  submitAttempted.value = false;
};
</script>
