<template>
  <div id="container">
    <!--nav element-->
    <NavComponent />
    <!--main element-->
    <main class="container mt-5">
      <div>
        <h4 class="text-center mb-4">Create Media</h4>
        <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
        <form @submit.prevent="submitMedia" class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="media" class="form-label">Media <span class="text-danger">*</span></label>
              <input type="text" v-model="form.media" id="media" class="form-control" placeholder="Enter media" required>
              <div v-if="!form.media && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6">
              <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
              <input type="text" v-model="form.category" id="category" class="form-control" placeholder="Enter category" required>
              <div v-if="!form.category && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-12">
              <label for="media_name" class="form-label">Media File <span class="text-danger">*</span></label>
              <input type="file" @change="handleFileChange" id="media_name" class="form-control" required>
              <div v-if="!form.media_name && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6">
              <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea v-model="form.description" id="description" class="form-control" placeholder="Enter description" required></textarea>
              <div v-if="!form.description && submitAttempted" class="text-danger">This field is required</div>
            </div>
            <div class="col-md-6 align-self-end">
              <button type="submit" class="btn btn-primary w-100" :disabled="loading">{{ loading ? 'Please wait...' : 'Submit' }}</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import useMediaStore from '../store/media';
import NavComponent from "@/components/NavComponent.vue";

const form = ref({
  media_name: null,
  description: '',
  media: '',
  category: ''
});

const loading = ref(false);
const errorMessage = ref('');
const submitAttempted = ref(false);
const router = useRouter();

const handleFileChange = (event) => {
  form.value.media_name = event.target.files[0];
};

const submitMedia = async () => {
  submitAttempted.value = true;
  if (form.value.media && form.value.media_name && form.value.description && form.value.category) {
    try {
      loading.value = true;
      errorMessage.value = '';
      const response = await useMediaStore().postMedia(form.value);
      if (response.success) {
        resetForm();
        router.push('/media');
      } else {
        errorMessage.value = response.response;
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
    media_name: null,
    description: '',
    media: '',
    category: ''
  };
  submitAttempted.value = false;
};
</script>
