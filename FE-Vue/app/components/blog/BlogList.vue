<template>
    <div class="main-content">
        <p>List Blog</p>
        <div class="main-form-container">
            <table v-if="blogs.length" width="100%">
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
                    <tr v-for="blog in blogs" :key="blog.id">
                        <td>{{ blog.id }}</td>
                        <td>{{ blog.title }}</td>
                        <td>{{ blog.category }}</td>
                        <td>{{ blog.public }}</td>
                        <td>{{ $locationIdsToTexts(blog.position, locations) }}</td>
                        <td>{{ blog.data_public }}</td>
                        <td>
			    <EditBlogButton :blogId="blog.id" />
                        </td>
                        <td>
			    <DeleteBlogButton :blogId="blog.id" :afterDeleteCallback="removeFromBlogs"/>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
    .main-content {
        background-color: WhiteSmoke;
        padding:0 0 20px 0;
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
import axios from 'axios'

import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const { $locationIdsToTexts, $getLocations } = useNuxtApp()

const router = useRouter()
const blogs = ref((await axios.get('http://localhost:8000/api/blogs')).data)
const locations = ref(await $getLocations())

const goDetail= (blogId) => router.push(`/edit/${blogId}`)
const removeFromBlogs = (blogId) => {
	blogs.value = blogs.value.filter((blog) => blog.id != blogId)
}
</script>
