<template>
    <div class="main-content" style="margin-bottom: 20px;">
        <p>Search Blogs</p>
        <div class="main-form-container" style="padding: 40px;">
            
            <form class="form-grid" @submit.prevent>
                <label for="blog-tittle" style="text-align: left;">Title:</label>
                <input class="search-bar" type="text" @keyup.enter="performSearch" placeholder="Search..." v-model="query" >
            </form>
            <button class="search-btn" type="button" @click="performSearch">Search</button>
        </div>
    </div>

    <div class="main-content" style="padding-bottom: 20px;">
        <p>List Blog</p>
        <div class="main-form-container">
            <div>{{ results.id }}</div>
            <table v-if="results.length" width="100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tin</th>
                        <th>Loại</th>
                        <th>Trạng thái</th>
                        <th>Vị trí</th>
                        <th>Ngày public</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="blog in results" :key="blog.id">
                        <td>{{ blog.id }}</td>
                        <td>{{ blog.title }}</td>
                        <td>{{ blog.category }}</td>
                        <td>{{ blog.public }}</td>
                        <td>{{ $locationIdsToTexts(blog.position, locations) }}</td>
                        <td>{{ blog.data_public }}</td>
			<td><EditBlogButton :blogId="blog.id" /></td>
			<td><DeleteBlogButton :blogId="blog.id" :afterDeleteCallback="removeFromBlogs"/></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<style scoped>
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 7fr;
        gap: 0; 
        height: fit-content;
    }


    .main-content {
        background-color: WhiteSmoke;
        padding:0;
        font-size: 30px;
        
    }

    .main-form-container {
        background-color: white;
    }
    
    p {
        text-align: left;
        margin: 0 0 10px 10px;
        font-size: 40px;
        font-weight: 500;
        padding: 0;
    }

    .search-btn {
        color: forestgreen;
        background-color: white;
        border: 1px solid forestgreen;
        font-size: 30px;
        padding: 5px 10px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .search-bar {
        width: 100%;
        border: 1px solid gray;
        margin:8px 0 0 20px; 
        height: 30px;
        
    }

    input {
        font-size: large;
    }

    table {
        border-collapse: collapse;
        /* max-height: 50px; */
        overflow: scroll;
        overflow-x: hidden;
    }

    th {
        font-size: smaller;
        border: 1px solid lightgray;
        gap: 0;
    }

    td {
        font-size: smaller;
        border: 1px solid lightgray;
        gap: 0;
    }
</style>

<script setup lang="ts">
import axios from 'axios';
import { debounce } from 'lodash';
import { ref } from 'vue'

const { $locationIdsToTexts, $getLocations } = useNuxtApp()

const locations = await $getLocations()
const query = ref('')
const results = ref([])

const performSearch = debounce(async () => {
	if(!query.value) {
		results.value = []
		return
	}

	results.value = (await axios.get(`http://localhost:8000/api/blogs/search?q=${encodeURIComponent(query.value)}`)).data
}, 300)

const removeFromBlogs = (blogId) => {
	results.value = results.value.filter((blog) => blog.id != blogId)	
}
</script>
