import apiClient from './api';

export const userService = {
  // Create
  createUser(userData) {
    return apiClient.post('/users', userData);
  },

  // Read
  getUsers(params = {}) {
    return apiClient.get('/users', { params });
  },

  getUserById(id) {
    return apiClient.get(`/users/${id}`);
  },

  // Update
  updateUser(id, userData) {
    return apiClient.put(`/users/${id}`, userData);
  },

  // Delete
  deleteUser(id) {
    return apiClient.delete(`/users/${id}`);
  },

  // Search
  searchUsers(query) {
    return apiClient.get('/users/search', { params: { q: query } });
  },
};