<template>
    <app-layout>
        <template #header>
            {{course.title}}
        </template>
        <div class="flex-wrap justify-center py-4 mx-8" style="display:flex; ">
            <div class="text-2xl">{{this.courseShow.episodes[this.currentKey].title}}</div>
            <iframe class="w-full h-screen" :src="this.courseShow.episodes[this.currentKey].video_url" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <div style="font-size:small;">{{this.courseShow.episodes[this.currentKey].description}}</div>

            <!--Progress Bar-->
            <div class="py-6 w-full">
                <progress-bar :watched-episodes="watched" :episodes="course.episodes" />
            </div>
            <!--Progress Bar-->

            <!--Progress Button-->
            <div class="mt-6">
                <ul v-for="(episode,index) in this.courseShow.episodes" v-bind:key="episode.id">
                    <li class="mt-3 flex justify-between items-center"> 
                        <div>
                            Episode n°{{index+1}} - {{episode.title}}
                            <button class="text-gray-500 focus:text-indigo-500 focus:outline-none" @click="switchEpisode(index)" >Voir l'épisode</button>
                        </div>
                        <progress-button :episode-id="episode.id" :watched-episodes="watched" />
                    </li>
                </ul>
            </div>
            <!--End Progress Button-->
        </div>
    </app-layout>
</template>

<script>
import AppLayout from './../../Layouts/AppLayout';
import ProgressButton from './ProgressButton';
import ProgressBar from './ProgressBar';

export default {
    components:{
        AppLayout,
        ProgressButton,
        ProgressBar
    },

    props: ['course','watched'],

    data(){
        return{
            courseShow: this.course,
            currentKey:0
        }
    },

    methods: {
        switchEpisode(index){
            this.currentKey= index;
            window.scrollTo({
                top:0,
                left:0,
                behavior:'smooth'
            });
        }
    },

    mounted(){
        // console.log(this.courses)
    }
    
}
</script>