<template>
    <div class="row" v-if="pages">
        <div class="mid_center">
            <ul class="pagination">
                <li v-for="list in pages"
                    :class="{active : list.current}"
                    @click="setPage(list.page)">
                    <a href="javascript:void(0)">{{ list.page }}</a>
                </li>
            </ul>
        </div>
    </div><!-- /.row -->
</template>

<script>
    export default {
        props : ['number', 'current'],

        data : function() {
            return {
                pages : null
            }
        },

        mounted() {
            this.setPages();
        },

        watch : {
            current : function() {
                this.setPages();
            }
        },

        methods : {
            /**
             * sets the new page
             * @param page
             */
            setPage(page) {
                this.$emit('select-page', page)
            },

            /**
             * sets the pages array
             *
             * @return void
             */
            setPages() {
                this.pages = [];
                for (let count = 1; count <= this.number; count++) {
                    let isCurrent = (this.current === count);
                    this.pages.push({page: count, current: isCurrent});
                }
            }
        }
    }
</script>