<template>
    <app-layout>
        <AddTask v-if="showAddModal" :statusId="newTaskForStatus" @task-canceled="closeAddTaskForm"
            @task-added="handleTaskAdded"></AddTask>


        <EditTask v-if="showEditModal" :task="editTaskData" @task-canceled="closeEditTaskForm"
            @task-edited="handleTaskEdited"></EditTask>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dragable Board</h2>
        </template>
        <v-container>
            <v-row>
                <template v-for="status in statuses" :key="n">
                    <v-col class="mt-2" cols="4">
                        <p class="mb-3">{{ status.title }}</p>

                        <draggable v-model="status.tasks" item-key="id" v-bind="taskDragOptions" @end="handleTaskMoved">
                            <template #item="{ element }">
                                <v-card :title="element.title" :subtitle="element.created_at" :text="element.description" class="mt-5">
                                    <v-card-actions>
                                        <v-btn variant="plain" color="blue-grey" @click="handleEdit(element)">Edit</v-btn>
                                        <v-btn variant="plain" color="error" @click="handleDelete(element.id, status.id)">Delete</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </template>

                            <template #footer>
                                <jet-button @click="openAddTaskForm(status.id)" class="mt-4">
                                    Add
                                </jet-button>

                            </template>
                        </draggable>
                    </v-col>
                </template>

            </v-row>
        </v-container>
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'
import draggable from 'vuedraggable'
import JetButton from '../../Jetstream/Button.vue';
import axios from 'axios';
import AddTask from "./AddTask";
import EditTask from "./EditTask";
import DataSlot from '../DataSlot.vue';

export default {
    components: {
        AppLayout,
        draggable,
        DataSlot,
        AddTask,
        EditTask,
        JetButton,
    },
    props: ['statuses', 'errors'],
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
            showAddModal: false,
            showEditModal: false,
            newTaskForStatus: "",
            editTaskData: [],
        };
    },
    methods: {
        closeAddTaskForm() {
            this.newTaskForStatus = 0;
            this.showAddModal = false;
        },
        closeEditTaskForm() {
            this.newTaskForStatus = 0;
            this.showEditModal = false;
        },
        openAddTaskForm(statusId) {
            this.showAddModal = true;
            this.newTaskForStatus = statusId;
        },
        handleEdit(element) {
            this.showEditModal = true;
            this.editTaskData = element
        },
        handleDelete(id, statusid) {
            if (confirm("Do you really want to delete?")) {
                axios.delete('tasks/' + id)
                    .then(resp => {
                        const statusIndex = this.statuses.findIndex(
                            status => status.id === statusid
                        );

                        // Find the index of the status where we should add the task
                        const taskIndex = this.statuses[statusIndex].tasks.findIndex(
                            task => task.id === id
                        );
                        this.statuses[statusIndex].tasks.splice(taskIndex, 1);

                        console.log(resp)
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },
        handleTaskEdited() {
            // // Find the index of the status where we should add the task
            // const statusIndex = this.statuses.findIndex(
            //     status => status.id === newTask.status_id
            // );

            // // Add newly created task to our column
            // this.statuses[statusIndex].tasks.push(editTask);

            // // Reset and close the AddTaskForm
            this.showEditModal = false;
        },
        // add a task to the correct column in our list
        handleTaskAdded(newTask) {
            // Find the index of the status where we should add the task
            const statusIndex = this.statuses.findIndex(
                status => status.id === newTask.status_id
            );

            // Add newly created task to our column
            this.statuses[statusIndex].tasks.push(newTask);

            // Reset and close the AddTaskForm
            this.showAddModal = false;
        },
        handleTaskMoved() {
            console.log(this.statuses)
            axios.put("tasks/update", { statuses: this.statuses }).catch(err => {
                console.log(err.response);
            });
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
