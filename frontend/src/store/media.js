import { defineStore } from 'pinia';
import api from '../axios';

const useMediaStore = defineStore({
  id: 'media_id',
  state: () => ({
    media: JSON.parse(localStorage.getItem('media')) || [],
  }),
  getters: {
    getMedia(state) {
      return state.media;
    }
  },
  actions: {
    async fetchData() {
      try {
        const response = await api.get('medias');
        if (response && response.data) {
          this.media = response.data;
          this.updateLocalStorage();
          return { success: true, response: this.media };
        } else {
          return { success: false, response: 'No record found' };
        }
      } catch (error) {
        return { success: false, response: error };
      }
    },
    async postMedia(payLoad) {
      try {
        const formData = new FormData();
        for (const key in payLoad) {
          formData.append(key, payLoad[key]);
        }
        const response = await api.post('medias', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        if (response && response.status === 201) {
          this.media.push(response.data);
          this.updateLocalStorage();
          return { success: true, response: response };
        } else {
          return { success: false, response: 'Error' };
        }
      } catch (error) {
        return { success: false, response: error };
      }
    },
    updateLocalStorage() {
      localStorage.setItem('media', JSON.stringify(this.media));
    }
  },
});

export default useMediaStore;
