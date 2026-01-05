<template>
	<button class="edit-btn" @click="goDetail">Edit</button>
</template>
<script setup lang="ts">
import { useRouter } from 'vue-router'

const router = useRouter()

const { blogId } = defineProps(['blogId'])

const goDetail= () => router.push(`/edit/${blogId}`)
</script>

<style scoped>
.edit-btn {
        color: dodgerblue;
        background-color: white;
        border: 1px solid dodgerblue;
        font-size: small;
        padding: 5px 10px;
        border-radius: 5px;
}
</style>
