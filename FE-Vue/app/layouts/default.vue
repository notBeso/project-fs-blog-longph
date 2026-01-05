<template>
  <div>
    <header>
        <AppHeader/>
    </header>
    
    <main>
        <div class="grid-container">
            <div class="grid-item">
                <AppMenu/>
            </div>
            <div class="grid-item main-container">
                <div class="inject-content">
                    <slot />
                </div>
            </div>
        </div>
    </main>

    <footer>
        <AppFooter/>
    </footer>
  </div>
</template>

<script setup lang="ts">

</script>

<style scoped>
    .grid-container {
        display: grid;
        grid-template-columns: 1fr 5fr;
        gap: 0; 
        height: fit-content;
    }

    .grid-item {
        background-color: white;
        padding: auto;
        text-align: center;
    }

    .main-container {
        background-color: lightgray;
    }

    .inject-content {
        margin: 30px ;
    }
</style>