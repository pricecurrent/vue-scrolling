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
                <button @click.prevent="showCommentsForm = ! showCommentsForm">
                    <svg class="stroke-current text-indigo-600 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </button>
            </div>
        </div>

        <!-- Comments -->
        <div v-show="showCommentsForm" class="mt-6">
            <div>
                <div class="relative">
                    <div class="absolute flex flex-col justify-center right-0 h-full px-4">
                        <button @click.prevent="postComment"><svg class="w-4 stroke-current text-indigo-500 hover:text-indigo-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></button>
                    </div>
                    <input class="border border-indigo-200  hover:bg-indigo-100 focus:bg-indigo-100 outline-none pr-12 px-3 py-2 rounded text-sm w-full"
                           v-model="body"
                           placeholder="What do you think of this cat?"
                           @keyup.enter="postComment"
                    >
                </div>
                <!-- replying to -->
                <div v-show="replyingTo.id" class="flex items-center mt-2">
                    <div class="text-xs flex text-gray-600 uppercase mb-1">
                        <div class="flex items-center flex-none">
                            <button @click.prevent="unsetReplyingTo" class="mr-2"><svg class="stroke-current text-indigo-500 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></button>
                            <span class="px-2 py-1 bg-gray-200">replying to: </span>
                        </div>
                        <div class="w-2/3 ml-4 pl-2 py-1 border-l-2 border-indigo-200 text-gray-600">
                            {{ replyingTo.body }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- thread -->
            <div v-for="comment in comments" class="text-gray-700 py-4 pb-0 mt-4 rounded">
                <!-- parent comment -->
                <div class="-mx-4 px-4 bg-gray-100">
                    <span class="text-gray-500 uppercase text-xs">{{ comment.created_at }}</span>
                    <p>{{ comment.body }}</p>
                    <div>
                        <button @click.prevent="setReplyingTo(comment)"><svg class="stroke-current text-gray-500 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></button>
                    </div>
                </div>
                <!-- replies -->
                <div v-for="reply in comment.replies" class="px-4">
                    <div class="text-gray-700 rounded">
                        <span class="text-gray-500 uppercase text-xs">{{ reply.created_at }}</span>
                        <p>{{ reply.body }}</p>
                        <div>
                            <button @click.prevent="setReplyingTo(comment)"><svg class="stroke-current text-gray-500 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></button>
                        </div>
                    </div>
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
                comments: [],
                showCommentsForm: false,
                replyingTo: {},
            }
        },
        methods: {
            postComment() {
                axios.post(`cats/${this.cat.id}/comments`, {
                    parent_id: this.replyingTo.id ? this.replyingTo.id : null,
                    body: this.body,
                }).
                    then(response => {
                        this.body = ''

                        if (! this.replyingTo.id) {
                            this.comments.push(response.data)
                        } else {
                            this.replyingTo.replies.push(response.data)
                        }

                        this.unsetReplyingTo()
                    })
            },
            fetchComments() {
                axios.get(`cats/${this.cat.id}/comments`)
                    .then(response => {
                        this.comments = response.data
                    })
            },
            setReplyingTo(comment) {
                this.replyingTo = comment
            },
            unsetReplyingTo() {
                this.replyingTo = {}
            }
        },

        created() {
            this.fetchComments()
        }
    }
</script>
