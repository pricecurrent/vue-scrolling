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
                <button>
                    <svg class="stroke-current text-indigo-600 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </button>
            </div>
        </div>

        <!-- Comments -->
        <div class="mt-6">
            <div>
                <div class="relative">
                    <div class="absolute flex flex-col justify-center right-0 h-full px-4">
                        <button><svg class="w-4 stroke-current text-indigo-500 hover:text-indigo-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></button>
                    </div>
                    <input class="border border-indigo-200  hover:bg-indigo-100 focus:bg-indigo-100 outline-none pr-12 px-3 py-2 rounded text-sm w-full"
                           v-model="body"
                           placeholder="What do you think of this cat?"
                           @keyup.enter="postComment"
                    >
                </div>
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
