<template>
    <app-layout>
        <template #header>
            List of courses
        </template>

        <div class="bg-green-200 rounded text-green-500 p-3 mb-2" v-if="$page.props.flash.message">
            {{ $page.props.flash.message }}
        </div>

        <div class="flex-wrap justify-center flex" >
            <div class="m-3 p-3 flex-col justify-center flex items-center"
                style=" width:25%; border: 1px solid black; "
                v-for="course in this.courseList.data" v-bind:key="course.id">
                    <div class="flex-col flex items-center">
                        <div class="text-sm text-gray-500">Put online by {{course.user.name}} - <span
                                class=" text-gray-500">{{course.participants}} participant<span
                                    v-if="parseInt(course.participants) > 1">s</span>
                            </span></div>
                        <div class="flex flex-col justify-between  items-center">
                            <div class="text-xl px-3 text-center">{{course.title}}</div>
                            <span class="font-semibold text-gray-500">Duration: {{convert(course.total_duration)}}</span>
                            <div class="text-sm text-pink-400 py-3 text-center">{{course.episodes_count}} episodes</div>
                        </div>
                    </div>
                <div style="font-size:small;">{{course.description}}</div>
                
                <div class="m-2">
                    <a :href="'course/' + course.id"
                    class="bg-indigo-500 text-white my-1 px-2 py-1 text-sm rounded hover:bg-indigo-700">See course</a>
                    <a :href="'courses/edit/' + course.id" v-if="course.update"
                    class="bg-gray-500 text-white my-1 px-2 py-1 text-sm rounded hover:bg-gray-700">Modify
                    course</a>
                </div>
            </div>
        </div>
        <div class="flex place-content-center">
            <inertia-link :href="link.url" v-html="link.label" class="text-indigo-700 border-gray-500 p-3" v-for="link in this.courseList.links" v-bind:key="link.label"></inertia-link>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout';
    export default {
        components: {
            AppLayout
        },

        data() {
            return {
                courseList: this.courses
            }
        },
        props: ['courses'],

        methods: {
            /**
             * Convert the time in seconds from database in hours/minutes/seconds time format.
             */
            convert(timestamps){
                let hours = Math.floor(timestamps / 3600);
                let minutes = Math.floor(timestamps / 60)-(hours*60);
                let seconds = timestamps % 60;

                return hours.toString().padStart(2,0) + ':' + minutes.toString().padStart(2,0) + ':' + seconds.toString().padStart(2,0);
            }
        }


    }

</script>
