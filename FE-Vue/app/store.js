import { ref , reactive } from 'vue';

export const isEdit = ref(true);

const globalStore = reactive({
  isEdit: true,
})

export default globalStore