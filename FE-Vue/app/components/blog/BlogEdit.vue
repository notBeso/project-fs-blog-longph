<template>
    <div class="main-content">
        <p>Edit Blogs</p>
        <div class="main-form-container">
            
            <div class="form">
                <label for="title">Tiêu đề:</label>
                <input 
                    v-model="title" 
                    type="text" 
                    id="title"
                    :class="{ 'error': errors.title }"
                />
                <span v-if="errors.title" class="error-message">
                    {{ errors.title }}
                </span>
            </div>

            <div class="form">
                <label for="describe">Mô tả ngắn:</label>
                <textarea 
                    v-model="describe" 
                    type="text" 
                    id="describe"
                    :class="{ 'error': errors.describe }"
                ></textarea>
                <span v-if="errors.describe" class="error-message">
                    {{ errors.describe }}
                </span>
            </div>

            <div class="form">
                <label for="detail">Chi tiết:</label>
                <textarea 
                    v-model="detail" 
                    type="detail" 
                    id="detail"
                    :class="{ 'error': errors.detail }"
                ></textarea>
                <span v-if="errors.detail" class="error-message">
                    {{ errors.detail }}
                </span>
            </div>

            <form @submit.prevent>
                <input
                    ref="fileInput"
                    type="file" 
                    style="border: none;"
                    @change="handleFileChange"
                    v-on:change="item.thumbs"
                    v-if="isRemoveThumbs"
                    accept="image/*"
                />

                <div v-else-if="item.thumbs_url">
                    <label>Your File:
                        <button @click="() => isRemoveThumbs = true">Delete</button>
                    </label>
                    <img :src="item.thumbs_url" v-if="item.thumbs_url" style="max-width:50vw; margin: 0"/>
                </div>
            </form>

            <div class="form">
                <label for="">Vị trí:</label> 
                <div style="display:flex;">
                <div v-for="loc in locations" :key="loc.id" style="width: 150px;display: flex;">
                    <input type="checkbox" v-model="selectedLocation" :value="loc.id" style="display:flex; width: fit-content;">
                    <span style="display:flex;">{{ loc.label }}</span>
                    
                </div></div>
                <span v-if="errors.selectedLocation" class="error-message">
                    {{ errors.selectedLocation }}
                </span>
            </div>

            <div class="form">
                <label for="publicity">Public:</label>
                <div style="display:flex;">
                    <input class="form-check-input" type="radio" value="true" v-model="publicity">
                    <span class="form-check-label" for="inlineRadio1">Yes</span>
                    
                    <input class="form-check-input" type="radio" value="false" v-model="publicity">
                    <span class="form-check-label" for="inlineRadio2">No</span>
                </div>
                <span v-if="errors.publicity" class="error-message">
                    {{ errors.publicity }}
                </span>
            </div>

            <div class="double-form">
                <div class="form-slot ">
                    <div>
                        <label for="category">Loại:</label>
                        <select class="form-control" id="exampleFormControlSelect1" v-model="category">
                            <option disabled>-Choose a type-</option>
                            <option v-for="option in options" >
                                {{ option.label }}
                            </option>
                        </select>
                    </div>
                    <span v-if="errors.category" class="error-message">
                        {{ errors.category }}
                    </span>
                </div>
                <div class="form-slot">
                    <div>
                        <label for="blog-tittle">Date Public:</label>
                        <input type="date" id="myDate" name="selectedDate" v-model="DateSelect">
                    </div>
                    <span v-if="errors.DateSelect" class="error-message">
                        {{ errors.DateSelect }}
                    </span>
                </div>
            </div>
            
        </div>
        <button class="submit-btn" type="submit" @click="updateBlog">Update</button>

        <button class="clear-btn" @click="clearBox">Clear</button>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import { useForm, useField } from 'vee-validate'
    import * as yup from 'yup'
    import { RouterLink, useRoute, useRouter } from 'vue-router';

    const { $getLocations, $getOptions } = useNuxtApp()
    const fileInput = ref(null)
    const selectedFile = ref(null)

    const route = useRoute();
    const router = useRouter()
    const blogId = route.params.id;
    const item = ref((await axios.get(`http://localhost:8000/api/blogs/${blogId}`)).data)

    const options = ref(await $getOptions())
    const locations = ref(await $getLocations())

    const validationSchema = yup.object({
        title: yup.string().required('title is required').min(5, 'Name must be at least 5 characters'),
        describe: yup.string().required('describe is required').min(10, 'Name must be at least 10 characters'),
        detail: yup.string().required('detail is required').min(10, 'Name must be at least 10 characters'),
        selectedLocation: yup.array().min(1, 'Please select at least one location.').required('location is required'),
        publicity: yup.string().required('public is required'),
        category: yup.string().required('category is required'),
        DateSelect: yup.string().required('date is required'),
    });

    const { handleSubmit, errors } = useForm({
        initialValues: {
            title: item.value.title,
            describe: item.value.des,
            detail: item.value.detail,
            selectedLocation: item.value.position,
            publicity: item.value.public,
            category: item.value.category,
            DateSelect: item.value.data_public,
        },
        validationSchema,
    });

    const { value: title } = useField('title')
    const { value: describe } = useField('describe')
    const { value: detail } = useField('detail')
    const { value: selectedLocation } = useField('selectedLocation')
    const { value: publicity } = useField('publicity')
    const { value: category } = useField('category')
    const { value: DateSelect } = useField('DateSelect')
    

    const handleFileChange = (event) => {
        selectedFile.value = event.target.files[0]
    }

    const clearBox = () => {
        alert('click')
        title.value = ''
        describe.value = ''
        detail.value = ''

        if (fileInput.value) {
            fileInput.value.value = ''
        }

        selectedFile.value = null

        publicity.value = ''
        selectedLocation.value = []
        category.value = ''
        DateSelect.value = ''
    }

    item.value.thumbs = null
    const isRemoveThumbs = ref(!item.value.thumbs_url)

    const initStatesForItem = () => {
        item.value.thumbs = null
        selectedFile.value = null
        isRemoveThumbs.value = !item.value.thumbs_url
    }

    const updateBlog = async () => {
        try {
	    const formData = new FormData()

        formData.append("title", title.value)
        formData.append("des", describe.value)
        formData.append("detail", detail.value)
        formData.append("category", category.value)
        formData.append("public", publicity.value)
        formData.append("data_public", DateSelect.value)

	    selectedLocation.value.forEach((pos) => formData.append("position[]", pos))
        formData.append("isRemoveThumbs", isRemoveThumbs.value)

	    if(isRemoveThumbs.value && selectedFile.value) {
		    formData.append("thumbs", selectedFile.value)
	    }
            
        item.value = (await axios.put(`http://localhost:8000/api/blogs/${blogId}`, formData)).data;
	    alert('Success')
        router.push('/');
	    initStatesForItem()
        } catch (error) {
            alert('Error:', error)
        }
    }
</script>

<style scoped>
    .main-content {
        background-color: WhiteSmoke;
        padding:0 0 20px 0;
    }

    .main-form-container {
        background-color: white;
        padding: 20px;
        text-align: left;
    }
    
    p {
        text-align: left;
        margin: 0 0 10px 10px;
        font-size: 40px;
        font-weight: 500;
        padding: 0;
    }

    form {
        margin-bottom: 30px;
    }

    label {
        font-size: 25px;
        display: block;
        margin-bottom: 10px;
    }

    textarea{
        width: 98%;
        min-height: 100px;
        font-size: 25px;
        font-weight: 200;
        border: 1px solid gray;
        resize: vertical;
        overflow: scroll;
        overflow-x:hidden;
    }

    input{
        width: 98%;
        font-size: 25px;
        font-weight: 200;
        border: 1px solid gray;
    }

    select {
        width: 98%;
    }

    .double-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0; 
    }

    .form-slot {
        padding: auto;
        text-align: left;
    }

    .form-check-label {
        display: flex;
        margin-right: 2%;
        font-size: larger;
    }
    .form-check-input {
        width: fit-content;
    }

    .form-control {
        height: 35px;
        border: 1px solid gray;
        font-size: larger;
    }

    .submit-btn , .clear-btn  {
        border-radius: 5px;
        margin: 5px;
        padding: 6px 10px;
        border: none;
        color: white;
        margin-top: 15px;
    }

    .submit-btn {
        background-color: forestgreen;

    }

    .clear-btn {
        background-color: royalblue;
    }

    .error {
        border-color: red;
    }

    .error-message {
        color: red;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }
</style>
