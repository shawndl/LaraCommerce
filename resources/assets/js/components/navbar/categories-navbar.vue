<template>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            Categories<span class="caret"></span>
        </a>
        <ul class="dropdown-menu" id="navbar-category">
            <li v-for="category in categories">
                <a :href="category_url + '/' + encodeURIComponent(category)">{{ category }}</a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        props: ['categories'],

        data : function () {
            return {
                category_url : Laravel.urls.category_url
            }
        },
    }
</script>