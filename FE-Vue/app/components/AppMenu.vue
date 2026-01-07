
<template>
    <div style="padding-left: 5%;">
        <ul class="menu-bar">
            <li>
                <NuxtLink to="/">
                    <img src="../../img/list.png"></img>
                    List
                </NuxtLink>
            </li>
            <li>
                <NuxtLink to="/new">
                    <img src="../../img/plus.png"></img>
                    New
                </NuxtLink>
            </li>
            <li>
                <NuxtLink to="/search">
                    <img src="../../img/loupe.png"></img>
                    Search
                </NuxtLink>
            </li>
        </ul>
    </div>
</template>

<style scoped>
    .menu-bar{
       min-height: 100vh;
    }

    ul {
        list-style: none;
        text-align: left;
        
    }

    a {
        text-decoration: none;
        color: black;
        font-size: 25px;
    }

    li {
        gap: 20px;
        margin-bottom: 30px;
    }
    
    img {
        margin-right: 20px;
    }
</style>

<script>


</script>