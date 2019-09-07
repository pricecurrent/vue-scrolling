<template>
    <div class="bg-white shadow p-4 rounded-lg mt-8">
        <div class="flex">
            <img class="w-24 rounded" :src="cat.photo">
            <div class="ml-4 flex-1 flex flex-col justify-between">
                <h3 class="text-gray-700 text-2xl uppercase">
                    {{ cat.name }}
                    <span class="text-gray-600 text-sm">{{ cat.age }} years</span>
                </h3>

                <div><span class="bg-indigo-100 text-indigo-700 text-sm uppercase px-1 px-2 rounded-sm">{{ cat.character }} </span></div>
            </div>
            <div class="flex flex-col justify-end">
                <button class="text-indigo-600 font-semibold text-sm p-1 rounded shadow-sm">
                    take this one
                </button>
                <button>comment</button>
            </div>
        </div>

        <!-- Comments -->
        <div class="mt-6">
            <div>
                <input class="w-full rounded text-sm border outline-none border-indigo-200 px-3 py-2"
                       v-model="body"
                       placeholder="What do you think of this cat?"
                       @keyup.enter="postComment"
                >
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['cat'],
        data() {
            return {
                body: '',
            }
        },
        methods: {
            postComment() {
                axios.post(`cats/${this.cat.id}/comments`, {
                    body: this.body,
                }).
                    then(respnose => {this.body = ''})
            }
        },
    }
</script>
