<template>
  <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

        <v-form @submit.prevent="handleEditTask">
          <v-card min-width="400">
            <v-card-title>
              <span class="text-h5">Edit Task</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field label="Title*" required placeholder="Enter a title"
                      v-model.trim="editTask.title"></v-text-field>
                    <div v-show="errorMessage.title">
                      <span class="text-xs text-red-500">
                        {{ errorMessage.title }}
                      </span>
                    </div>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field label="Description" placeholder="Add a description (optional)"
                      v-model.trim="editTask.description"></v-text-field>
                    <div v-show="errorMessage.description">
                      <span class="text-xs text-red-500">
                        {{ errorMessage.description }}
                      </span>
                    </div>
                  </v-col>

                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue-darken-1" variant="text" @click="$emit('task-canceled')">
                Close
              </v-btn>
              <v-btn color="bg-indigo-600" variant="text" type="submit">
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </div>
    </div>
  </div>
</template>
  
<script>
import JetButton from '../../Jetstream/Button.vue';
export default {
  props: {
    task: Array,
  },
  components: {
    JetButton
  },
  data() {
    return {
      editTask: {},
      errorMessage: {
        title: "",
        description: ""
      }
    };
  },
  mounted() {
    this.editTask = this.task
  },
  methods: {
    handleEditTask() {
      // Basic validation so we don't send an empty task to the server
      if (!this.editTask.title) {
        this.errorMessage.title = "The title field is required";
        return;
      }

      if (!this.editTask.description) {
        this.errorMessage.description = "The description field is required";
        return;
      }

      // Send new task to server
      axios
        .post("/tasks", this.editTask)
        .then(res => {
          // Tell the parent component we've added a new task and include it
          this.$emit("task-edited", res.data);
        })
        .catch(err => {
          // Handle the error returned from our request
          this.handleErrors(err);
        });
    },
    handleErrors(err) {
      if (err.response && err.response.status === 422) {
        // We have a validation error
        const errorBag = err.response.data.errors;
        if (errorBag.title) {
          this.errorMessage = errorBag.title[0];
        } else if (errorBag.description) {
          this.errorMessage = errorBag.description[0];
        } else {
          this.errorMessage = err.response.message;
        }
      } else {
        // We have bigger problems
        console.log(err.response);
      }
    }
  }
};
</script>