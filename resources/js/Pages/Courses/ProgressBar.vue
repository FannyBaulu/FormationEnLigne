<template>
    <div>
        <div class="bg-gray-200 h-full rounded">
            <div class="bg-green-500 text-white rounded-l text-center transition-width duration-500" :style="'width:'+percentage+'%'">{{ percentage }}%</div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['watchedEpisodes','episodes'],

    data(){
        return {
            watchedEpisodesData :this.watchedEpisodes
        }
    },

    computed: {
        /**
         * Calculate the percentage of the course completed by comparing
         * the number of episodes watched and the number of episodes in the course.
         */
        percentage(){
            let filteredEp = this.episodes.filter(courseEp =>{
                return this.watchedEpisodesData.find(watchedEp => {
                    return watchedEp.id === courseEp.id;
                });
            });

            return Math.ceil((filteredEp.length / this.episodes.length)*100);
        }
    },

    mounted(){
        eventBus.$on('toggleProgress', data => this.watchedEpisodesData = data);
    }
}
</script>