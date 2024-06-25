import { defineStore } from 'pinia';
import api from '../axios';

const useDashboardStore = defineStore({
  id: 'dashboard_id',
  state: () => ({
    dashboards: JSON.parse(localStorage.getItem('dashboards')) || [],
  }),
  getters: {
    getdashboard(state) {
      return state.dashboards;
    }
  },
  actions: {
    async fetchData() {
      try {
        const response = await api.get('dashboards');
        if (response && response.data) {
          this.dashboards = response.data;
          //console.log(this.dashboards);
          this.updateLocalStorage();
          return { success: true, response: this.dashboards };
        } else {
          return { success: false, response: 'No record found' };
        }
      } catch (error) {
        return { success: false, response: error };
      }
    },
    
    updateLocalStorage() {
      localStorage.setItem('dashboards', JSON.stringify(this.dashboards));
    }
  },
});

export default  useDashboardStore;
