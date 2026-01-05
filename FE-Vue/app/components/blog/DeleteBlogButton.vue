<template>
	<button class="del-btn" @click="deleteItem()">Delete</button>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'

const nuxtApp = useNuxtApp()

const { blogId, afterDeleteCallback } = defineProps(['blogId', 'afterDeleteCallback'])
 
const deleteItem = async() => {
	if (confirm('Are you sure you want to delete this item?' + blogId)) {
        	try {
                    await axios.delete(`http://localhost:8000/api/blogs/${blogId}/delete`);
                    afterDeleteCallback(blogId)
                }
                catch (error) {
console.log(error)
                    alert('Error deleting item:', error);
                }
        }
}	
</script>

<style scoped>
.del-btn {
        color: red;
        background-color: white;
        border: 1px solid red;
        font-size: small;
        padding: 5px 10px;
        border-radius: 5px;
}	
</style>
