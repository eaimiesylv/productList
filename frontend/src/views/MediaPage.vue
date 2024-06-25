<template>
  <div id="container">
    <!--nav element-->
    <NavComponent />
    <!--main element-->
    <main class="container mt-5">
      <span><router-link to="/create-media">Create Media</router-link></span>
      <table class="table table-striped mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Media Name</th>
            <th scope="col">Description</th>
            <th scope="col">Category</th>
            <th scope="col">Media</th>
          </tr>
        </thead>
        <tbody v-if="mediaList && mediaList.length > 0">
          <tr v-for="(media, index) in mediaList" :key="media.id">
            <td>{{ index + 1 }}</td>
            <td><img :src="media.media_name" alt="Media" class="img-fluid" style="width: 150px;" /></td>
            <td>{{ media.description }}</td>
            <td>{{ media.category }}</td>
            <td>{{ media.media }}</td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="5" class="text-center">No media found</td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import NavComponent from "@/components/NavComponent.vue";
import useMediaStore from '../store/media';

const mediaStore = useMediaStore();
const mediaList = ref([]);

const fetchMedia = async () => {
  try {
    await mediaStore.fetchData();
    mediaList.value = mediaStore.media;
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  fetchMedia();
});
</script>
