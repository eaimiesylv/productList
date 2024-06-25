import { defineStore } from 'pinia';
import api from '../axios';

const useProductStore = defineStore({
  id: 'product_id',
  state: () => ({
    products: JSON.parse(localStorage.getItem('products')) || [],
  }),
  getters: {
    getProduct(state) {
      return state.products;
    }
  },
  actions: {
    async fetchData() {
      try {
        const response = await api.get('products');
        if (response && response.data) {
          this.products = response.data;
          this.updateLocalStorage();
          return { success: true, response: this.products };
        } else {
          return { success: false, response: 'No record found' };
        }
      } catch (error) {
        return { success: false, response: error };
      }
    },
    async postProduct(payLoad) {
      try {
        const response = await api.post('products', payLoad);
        if (response && response.status === 201) {
          this.products.push(response.data);
          this.updateLocalStorage();
          return { success: true, response: response };
        } else {
          return { success: false, response: 'Error' };
        }
      } catch (error) {
        const errorMsg = error.response?.data?.message || 'An error occurred';
        return { success: false, response: errorMsg };
      }
    },
    updateLocalStorage() {
      localStorage.setItem('products', JSON.stringify(this.products));
    }
  },
});

export default useProductStore;
