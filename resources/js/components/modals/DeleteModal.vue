<script setup>

</script>

<template>
    <div class="modal" tabindex="-1" role="dialog" style="background-color: rgba(56,54,54,0.6); display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-end">
                    <button type="button" @click="closeModal" class="close btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> Are you shore you want delete task</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="deleteTask">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">No</button>
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
            toast: useToast(),
        };
    },

    props: [
        'task'
    ],
    methods: {
        closeModal() {
            this.$parent.closeDeleteModal();
        },

        deleteTask() {

            console.log(this.task.id)
            axios.post('/api/tasks/' + this.task.id, {
                _method: 'DELETE',
            })
                .then(response => {
                    this.toast.success(response.data.message)
                    this.$parent.closeDeleteModal();
                })
        },
    }
};
</script>

