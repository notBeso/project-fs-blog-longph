<template>
    <div class="grid-container">
        <div class="grid-item">
            <NuxtLink to="/">
                <img src="./img/logo.png" style="width: 113px;">
            </NuxtLink>
        </div>
        <div class="grid-item">
            <h1 class="name-tittle">Blogmanagement</h1>
        </div>
  </div>
</template>

<style scoped>
    .grid-container {
        display: grid;
        grid-template-columns: 1fr 5fr;
        gap: 0; 
        width: 100vw;
    }

    .grid-item {
        background-color: black;
        padding: auto;
        text-align: center;
    }

    .name-tittle {
        color: white;
    }
</style>