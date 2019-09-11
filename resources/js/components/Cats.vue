<template>
    <div class="w-3/5 mx-auto">
        <scrollable @at-the-bottom="fetch(cats.length)">
            <cat v-for="cat in cats" :cat="cat" :key="cat.id"></cat>
        </scrollable>

        <div v-show="loading">
            <span class="text-3xl font-bold">Loading...</span>
        </div>
    </div>
</template>

<script>
    import Scrollable from './Scrollable.vue'
    import Cat from './Cat.vue'

    export default {
        data() {
            return {
                cats: [],
                loading: false
            }
        },
        components: {Scrollable, Cat},
        methods: {
            fetch(offset = 0) {
                this.loading = true
                axios.get('/cats', {
                    params: {
                        offset: offset
                    }
                })
                    .then(response => {
                        this.cats = this.cats.concat(response.data)
                    })
                    .finally(response => this.loading = false)
            },
        },
        created() {
            this.fetch()
        }
    }
</script>
