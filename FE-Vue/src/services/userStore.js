import { defineStore } from 'pinia';
import { userService } from '@/services/userService';

export const useUserStore = defineStore('user', {
  state: () => ({
    users: [],
    currentUser: null,
    loading: false,
    error: null,
    pagination: {
      page: 1,
      limit: 10,
      total: 0,
    },
  }),

  getters: {
    getUserById: (state) => (id) => {
      return state.users.find(user => user.id === id);
    },
    hasUsers: (state) => state.users.length > 0,
    totalPages: (state) => Math.ceil(state.pagination.total / state.pagination.limit),
  },

  actions: {
    async fetchUsers(params = {}) {
      this.loading = true;
      this.error = null;
      
      try {
        const response = await userService.getUsers({
          page: this.pagination.page,
          limit: this.pagination.limit,
          ...params,
        });
        
        this.users = response.data.users;
        this.pagination.total = response.data.total;
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to fetch users';
      } finally {
        this.loading = false;
      }
    },

    async createUser(userData) {
      this.loading = true;
      this.error = null;
      
      try {
        const response = await userService.createUser(userData);
        this.users.unshift(response.data);
        return response.data;
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to create user';
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async updateUser(id, userData) {
      this.loading = true;
      this.error = null;
      
      try {
        const response = await userService.updateUser(id, userData);
        const index = this.users.findIndex(user => user.id === id);
        if (index !== -1) {
          this.users[index] = response.data;
        }
        return response.data;
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to update user';
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async deleteUser(id) {
      this.loading = true;
      this.error = null;
      
      try {
        await userService.deleteUser(id);
        this.users = this.users.filter(user => user.id !== id);
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to delete user';
        throw error;
      } finally {
        this.loading = false;
      }
    },
  },
});