<template>
  <nav>
    <!-- <img src="@/assets/logo.jpg" alt="Task Scheduler" class="img"/> -->
    <h4 style="color:white; text-align: center; margin:1em"> BanPIM</h4>
    <hr style="color:red">
   
    <router-link to="/dashboard">
      <i class="fas fa-tachometer-alt"></i> Dashboard
    </router-link>

    <router-link to="/product">
      <i class="fas fa-store"></i>Product
    </router-link>

    <router-link to="/media">
      <i class="fas fa-box"></i> Media
    </router-link>

  
    <router-link to="#"  @click="logout">
      <i class="fas fa-sign-out-alt"></i> Log Out
    </router-link>
  </nav>
</template>

<script setup>
import { useRouter } from 'vue-router';
import useAuthStore from '../store';

const router = useRouter();
const authStore = useAuthStore();

const logout = async () => {
  await authStore.logout();
  router.push('/');
};
</script>

<style scoped>

</style>
