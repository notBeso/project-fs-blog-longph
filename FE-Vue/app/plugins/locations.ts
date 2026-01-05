import axios from 'axios'

export default defineNuxtPlugin(() => {
	return {
		provide: {
			getLocations: async () => (await axios.get('http://localhost:8000/api/blogs/locations')).data,
			locationIdsToTexts: (ids, locations) => {
				const start = ""
				return ids.reduce((acc, id) => {
					const delim = acc.length === 0 ? "" : ", "
					return acc + delim + locations.find((loc) => loc.id === id).label
				}, start)
			}
		}
	}
})
