<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modification of {{courseData.title}}
            </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-green-200 rounded text-green-500 p-3 mb-2" v-if="$page.props.flash.message">
                    {{ $page.props.flash.message }}
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col" @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="title">
                                Title of the course
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                id="title" type="text" v-model="courseData.title">
                        </div>

                        <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="description">
                                Description of the course
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                id="description" type="text" v-model="courseData.description"></textarea>
                        </div>
                        <div class="mb-4">
                            <h2 class="text-2xl mb-2">Course's episodes</h2>
                            <div class="mt-5" v-for="(episode,index) in courseData.episodes" v-bind:key="index">
                                <label :for="'title-'+index" class="block text-gray-700 text-sm gont-bold nb-2">
                                    Title of episode n°{{index+1}}
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                    :id="'title-'+index" type="text" v-model="courseData.episodes[index].title">

                                <label :for="'description-'+index" class="block text-gray-700 text-sm gont-bold nb-2">
                                    Description of episode n°{{index+1}}
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                    :id="'description-'+index" type="text" v-model="courseData.episodes[index].description">

                                <label :for="'video_url-'+index" class="block text-gray-700 text-sm gont-bold nb-2">
                                    Video's URL of episode n°{{index+1}}
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                    :id="'video_url-'+index" type="text" v-model="courseData.episodes[index].video_url">
                            </div>
                        </div>
                        <div class="mb-3" style="display:flex;">
                            <div class="flex-row" style="display:flex;">
                                <button class='my-2 mx-2 py-2 px-4 bg-green-600 text-white min-w-md rounded block'
                            @click.prevent="add" v-if="courseData.episodes.length<15">+</button>
                        <button class='my-2 py-2 px-4 bg-red-600 text-white min-w-md rounded block'
                            @click.prevent="remove" v-if="courseData.episodes.length>1">-</button>
                            </div>
                        </div>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            type="submit">
                            Edit formation
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },

        props: ['course'],

        data() {
            return {
                courseData: this.course,
            }
        },
        methods: {
            submit() {
                this.$inertia.patch('/courses/'+ this.courseData.id, this.courseData);
            },
            add() {
                this.courseData.episodes.push({
                    title: null,
                    description: null,
                    video_url: null
                });
            },
            remove() {
                this.courseData.episodes.pop();
            },
        }
    }

</script>
