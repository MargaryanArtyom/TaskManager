<script setup>

</script>

<template>
    <div class="modal" tabindex="-1" role="dialog" style="background-color: rgba(56,54,54,0.6); display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Task</h5>
                    <button type="button" @click="closeModal" class="close btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Title</label>
                            <input v-model="title" type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Description</label>
                            <textarea v-model="description" class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="saveTask">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {useToast} from "@brackets/vue-toastification";
export default {

    data() {
    return {
        title: '',
        description: '',
        toast: useToast(),
    };
},
    methods: {
        saveTask() {
            axios.post('/api/tasks', {
                title: this.title,
                description: this.description
            })
                .then(response => {
                    this.toast.success(response.data.message)
                    this.$parent.toDoTasks.push(response.data.data);
                    this.$parent.closeCreateModal();
                })
                .catch(error => {
                    this.toast.error(error.response.data.message)
                })
        },

        closeModal() {
            this.$parent.closeCreateModal();
        }
    }
};
</script>

