import { ref, computed } from 'vue'
import axios from 'axios'

export function usePagination(apiUrl) {
  const data = ref([])
  const currentPage = ref(1)
  const lastPage = ref(1)
  const perPage = ref(15)
  const total = ref(0)
  const isLoading = ref(false)
  const error = ref(null)

  const axiosInstance = axios.create({
    baseURL: 'http://laravel-api.test/api', // Your Laravel API URL
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  })

  const fetchData = async (page = 1) => {
    isLoading.value = true
    error.value = null
    
    try {
      const response = await axiosInstance.get(apiUrl, {
        params: {
          page,
          per_page: perPage.value
        }
      })
      
      data.value = response.data.data
      currentPage.value = response.data.meta.current_page
      lastPage.value = response.data.meta.last_page
      total.value = response.data.meta.total
      perPage.value = response.data.meta.per_page
      
    } catch (err) {
      error.value = err.response?.data?.message || err.message
      console.error('Error fetching data:', err)
    } finally {
      isLoading.value = false
    }
  }

  const goToPage = (page) => {
    if (page >= 1 && page <= lastPage.value) {
      fetchData(page)
    }
  }

  const nextPage = () => {
    if (currentPage.value < lastPage.value) {
      goToPage(currentPage.value + 1)
    }
  }

  const prevPage = () => {
    if (currentPage.value > 1) {
      goToPage(currentPage.value - 1)
    }
  }

  const pages = computed(() => {
    const pages = []
    const start = Math.max(1, currentPage.value - 2)
    const end = Math.min(lastPage.value, currentPage.value + 2)
    
    for (let i = start; i <= end; i++) {
      pages.push(i)
    }
    
    return pages
  })

  return {
    data,
    currentPage,
    lastPage,
    perPage,
    total,
    isLoading,
    error,
    fetchData,
    goToPage,
    nextPage,
    prevPage,
    pages
  }
}