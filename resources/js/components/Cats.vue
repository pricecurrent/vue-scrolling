<template>
    <div class="w-3/5 mx-auto">
        <div  v-for="cat in cats" class="flex bg-white shadow p-4 rounded-lg mt-8">
            <img class="w-24 rounded" :src="cat.photo">
            <div class="ml-4 flex-1 flex flex-col justify-between">
                <h3 class="text-gray-700 text-2xl uppercase">
                    {{ cat.name }}
                    <span class="text-gray-600 text-sm">{{ cat.age }} years</span>
                </h3>

                <div><span class="bg-indigo-100 text-indigo-700 text-sm uppercase px-1 px-2 rounded-sm">{{ cat.character }} </span></div>
            </div>
            <div class="flex flex-col justify-end">
                <button class="text-green-700 font-semibold text-sm p-1 rounded shadow-lg hover:shadow-xl">
                    take this one
                </button>
            </div>
        </div>

        <div v-show="loading">
            <span class="text-3xl font-bold">Loading...</span>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash'
    export default {
        data() {
            return {
                cats: [],
                loading: false
            }
        },
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
            }
        },
        created() {
            this.fetch()
            const eventHandler = () => {
                const scrollTop = document.documentElement.scrollTop
                const viewportHeight = window.innerHeight
                const totalHeight = document.documentElement.offsetHeight

                const atTheBottom = scrollTop + viewportHeight == totalHeight

                if (atTheBottom) {
                    this.fetch(this.cats.length)
                }
            }

            let delayedHandler = _.debounce(eventHandler, 400)

            document.addEventListener('scroll', delayedHandler)
            this.$once('hook:destroyed', () => {
                document.removeEventListener('scroll', delayedHandler)
            })
        }
    }
</script>
