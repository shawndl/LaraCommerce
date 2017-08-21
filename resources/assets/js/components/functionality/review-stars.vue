<template>
    <div>
        <i v-for="star in review"
           :class="{'fa' : true, 'fa-star' : star.hasStar,
                    'fa-star-o' : (!star.hasStar && !star.hasHalfStar),
                    'fa-star-half-o' : (!star.hasStar && star.hasHalfStar) }"
           aria-hidden="true"></i>
    </div>
</template>

<script>
    export default {
        props : ['stars'],

        data : function () {
            return {
                review : []
            }
        },

        mounted() {
            this.setReviews();
        },

        methods : {
            'setReviews' : function () {
                let previous = true;
                for(let i = 1; i <= 5; i++) {
                    let hasStar = (i <= this.stars);
                    let hasHalfStar = (previous !== hasStar && this.isFloat(this.stars));
                    this.review.push({'hasStar' : hasStar, 'hasHalfStar' : hasHalfStar});
                    previous = hasStar;
                }
            },

            'isFloat' : function (number) {
                return (number % 1 !== 0);
            }
        }
    }
</script>