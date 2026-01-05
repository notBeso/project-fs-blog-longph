import axios from 'axios'

export default defineNuxtPlugin(() => {
	return {
		provide: {
			getOptions: async () => (await axios.get('http://localhost:8000/api/blogs/options')).data
		}
	}
})
