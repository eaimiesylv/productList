<template>
  <div id="container">
    <!--nav element-->
    <NavComponent />
    <!--main element-->
    <main>
      <HeaderComponent />
      <h2 class="text-center my-4">Dashboard</h2>
      <div v-if="dashboardList" class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="p-3 bg-primary text-white rounded mb-3">
              <p>Total Products: {{ dashboardList.total_products }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 bg-secondary text-white rounded mb-3">
              <p>Total Media: {{ dashboardList.total_media }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 bg-success text-white rounded mb-3">
              <p>Total Downloads: {{ dashboardList.total_download }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 bg-danger text-white rounded mb-3">
              <p>Total Views: {{ dashboardList.total_view }}</p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import NavComponent from "@/components/NavComponent.vue";
import HeaderComponent from "@/components/HeaderComponent.vue";
//import SectionComponent from "@/components/SectionComponent.vue";

import useDashboardStore from '../store/dashboard';

const dashboardStore = useDashboardStore();
const dashboardList = ref(null);

const fetchDashboardData = async () => {
  try {
    await dashboardStore.fetchData();
    dashboardList.value = dashboardStore.dashboards;
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  fetchDashboardData();
});
</script>

<style scoped>
.main {
  padding: 20px;
}

.text-center {
  text-align: center;
}

.my-4 {
  margin: 1.5rem 0;
}

.bg-primary {
  background-color: #007bff !important;
}

.bg-secondary {
  background-color: #6c757d !important;
}

.bg-success {
  background-color: #28a745 !important;
}

.bg-danger {
  background-color: #dc3545 !important;
}

.p-3 {
  padding: 1rem !important;
}

.text-white {
  color: #fff !important;
}

.rounded {
  border-radius: 0.25rem !important;
}

.mb-3 {
  margin-bottom: 1rem !important;
}
</style>
