<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
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
                                Titre de la formation
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="title" type="text" v-model="form.title">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="description">
                                Description de la formation
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="description" type="text" v-model="form.description"></textarea>
                        </div>
                        <div class="mb-4">
                            <h2 class="text-2xl mb-2">Episodes de la formation</h2>
                            <div class="mb-5" v-for="(episode,index) in form.episodes" v-bind:key="index">
                                <label :for="'title-'+index" class="block text-gray-700 text-sm gont-bold nb-2">
                                    Titre de l'épisode n°{{index+1}}
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" :id="'title-'+index" type="text" v-model="form.episodes[index].title">

                                <label :for="'description-'+index" class="block text-gray-700 text-sm gont-bold nb-2">
                                    Description de l'épisode n°{{index+1}}
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" :id="'description-'+index" type="text" v-model="form.episodes[index].description">

                                <label :for="'video_url-'+index" class="block text-gray-700 text-sm gont-bold nb-2">
                                    URL de la video de l'épisode n°{{index+1}} <br>
                                    <em class="text-red-600">(Doit être un lien youtube de type embed, si vous voulez accéder aux durées. ex: https://www.youtube.com/embed/D3oivlcoEvw)</em>
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" :id="'video_url-'+index" type="text" v-model="form.episodes[index].video_url">
                            </div>
                        </div>
                        <button class='my-2 py-2 px-4 bg-green-600 text-white max-w-min rounded block'  @click.prevent="add" v-if="form.episodes.length<15">+</button>
                        <button class='my-2 py-2 px-4 bg-red-600 text-white max-w-min rounded block'  @click.prevent="remove" v-if="form.episodes.length>1">🗑️</button>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                            Créer ma formation
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },
        data(){
            return {
                form: {
                    title:null,
                    description:null,
                    episodes:[
                        {title:null,description:null,video_url:null}
                    ]
                }
            }
        },
        methods: {
            submit() {
                this.$inertia.post('/courses', this.form)
            },
            add(){
                this.form.episodes.push({title:null,description:null,video_url:null});
            },
            remove(){
                this.form.episodes.pop();
            },
        }
    }
</script>
