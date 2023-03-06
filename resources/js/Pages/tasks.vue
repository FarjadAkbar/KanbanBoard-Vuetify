<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dragable Board</h2>
        </template>

        <div class="flex justify-center">
            <div class="min-h-screen flex overflow-x-scroll py-12">
                <div v-for="column in columns" :key="column.title"
                    class="bg-gray-100 rounded-lg px-3 py-3 column-width rounded mr-4">
                    <p class="text-gray-700 font-semibold font-sans tracking-wide text-sm mb-2">{{ column.title }}</p>



                    <draggable v-model="column.tasks" item-key="id" v-bind="taskDragOptions" @end="handleTaskMoved">
                        <template #item="{ element }">
                            <div class="bg-white shadow rounded px-3 pt-3 pb-5 border border-white mb-2">
                                <div>
                                    <p class="text-gray-700 font-semibold font-sans tracking-wide text-sm mb-1">{{
                                        element.title
                                    }}</p>
                                    <p class="text-gray-400 font-sans tracking-wide text-xs">{{ element.description
                                    }}</p>
                                </div>
                                <div class="flex mt-4 justify-between items-center">
                                    <span class="text-sm text-gray-600">{{ element.date }}</span>
                                </div>
                            </div>
                        </template>
                        <template #footer>
                            <JetButton class="mt-4">
                                Add
                            </JetButton>
                        </template>
                    </draggable>



                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from './../Layouts/AppLayout'
import draggable from 'vuedraggable'
import JetButton from '../Jetstream/Button.vue';
import axios from 'axios';

export default {
    components: {
        AppLayout,
        draggable,
        JetButton
    },
    props: ['columns', 'errors'],
    computed: {
    taskDragOptions() {
      return {
        animation: 200,
        group: "task-list",
        dragClass: "status-drag"
      };
    }
  },
    data() {
        return {
            drag: false,
        };
    },
    methods: {
            handleTaskMoved(){
                // axios.put("/tasks.update", {columns: this.statuses}).catch(err => {
                //     console.log(err.response);
                // });
                console.log(this.statuses)
            }
    }
}
</script>


<style scoped>
.column-width {
    min-width: 320px;
    width: 320px;
}

/* Unfortunately @apply cannot be setup in codesandbox, 
but you'd use "@apply border opacity-50 border-blue-500 bg-gray-200" here */
.ghost-card {
    opacity: 0.5;
    background: #F7FAFC;
    border: 1px solid #4299e1;
}
</style>
