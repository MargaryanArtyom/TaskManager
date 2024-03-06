<template>
    <div v-if="createModal">
        <crate-modal @close="closeCreateModal"></crate-modal>
    </div>
    <div v-if="editModal">
        <edit-modal :task="taskForEdit" @close="closeEditModal"></edit-modal>
    </div>
    <div v-if="deleteModal">
        <delete-modal :task="taskForDelete" @close="closeDeleteModal"></delete-modal>
    </div>

    <div class="container h-100">
        <div class="row justify-content-center">

            <div class="d-flex px-0">
                <button @click="openCreateModal" class="btn-primary btn">Create Task</button>
            </div>
            <div class="d-flex align-items-center p-3 my-3  rounded shadow-sm" style="background-color: #8B3DFB" >
                    <div class="col-md-4  d-flex justify-content-center">
                        <h5 class="font-weight-bold text-white">To Do</h5>
                    </div>
                    <div class="col-md-4  d-flex justify-content-center">
                        <h5 class="font-weight-bold text-white">in Progress</h5>
                    </div>
                    <div class="col-md-4  d-flex justify-content-center">
                        <h5 class="font-weight-bold text-white">Done</h5>
                    </div>
            </div>

            <div class="px-0 col-12 mt-4 d-flex justify-content-center">
                <div class="col-md-4 h-100  d-flex justify-content-center pt-1 p-3 rounded border shadow" style="background-color: #57C3B3" @dragover.prevent @drop="onDrop(1, $event)">
                    <div>
                        <div v-for="task in toDoTasks" class="card mt-2" draggable="true" style="min-width: 320px" @dragstart="onDragStart($event, task.id)">
                            <div class="d-flex justify-content-between px-2 pt-1">
                                <div class="font-weight-bold">{{task.title}}</div>
                                <div class="d-flex">
                                    <div @click="openEditModal(task)" class="mx-3">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div @click="openDeleteModal(task)">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>{{task.description}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 h-100  d-flex justify-content-center pt-1 p-3 rounded border shadow" style="background-color: #0fea98" @dragover.prevent @drop="onDrop(2, $event)">
                    <div>
                        <div v-for="task in inProgressTasks" class="card mt-2" style="min-width: 320px" draggable="true" @dragstart="onDragStart($event, task.id)">
                            <div class="d-flex justify-content-between px-2 pt-1">
                                <div class="font-weight-bold">{{task.title}}</div>
                                <div class="d-flex">
                                    <div @click="openEditModal(task)" class="mx-3">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div @click="openDeleteModal(task)">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>{{task.description}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 h-100  d-flex justify-content-center pt-1 p-3 rounded border shadow" style="background-color: #3bacbe" @dragover.prevent @drop="onDrop(3, $event)">
                    <div>
                        <div v-for="task in doneTasks" class="card mt-2" style="min-width: 320px" draggable="true" @dragstart="onDragStart($event, task.id)">
                            <div class="d-flex justify-content-between px-2 pt-1">
                                <div class="font-weight-bold">{{task.title}}</div>
                                <div class="d-flex">
                                    <div @click="openEditModal(task)" class="mx-3">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div @click="openDeleteModal(task)">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>{{task.description}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import CrateModal from "./modals/CrateModal.vue";
import DeleteModal from "./modals/DeleteModal.vue";
import EditModal from "./modals/EditModal.vue";
import Login from "./Login.vue";

export default {
    components: { CrateModal, EditModal, DeleteModal },
    name: "dashboard",
    data() {
        return {
            user: this.$store.state.auth.user,
            createModal: false,
            editModal: false,
            deleteModal: false,
            tasks: [],
            taskForEdit: [],
            taskForDelete: [],
        };
    },

    mounted() {
      axios.get('/api/tasks')
          .then(response => {
              this.tasks = response.data;
          })
    },
    computed: {
        toDoTasks() {
            return this.tasks.filter(task => task.order_id === 1);
        },
        inProgressTasks() {
            return this.tasks.filter(task => task.order_id === 2);
        },
        doneTasks() {
            return this.tasks.filter(task => task.order_id === 3);
        }
    },

    methods: {
        openCreateModal() {
            this.createModal = true;
        },
        closeCreateModal() {
            this.createModal = false;
        },
        openEditModal(task) {
            this.taskForEdit = task;
            this.editModal = true;
        },
        closeEditModal() {
            axios.get('/api/tasks')
                .then(response => {
                    this.tasks = response.data;
                })
            this.editModal = false;
        },
        openDeleteModal(task) {
            this.taskForDelete = task;
            this.deleteModal = true;
        },
        closeDeleteModal() {
            axios.get('/api/tasks')
                .then(response => {
                    this.tasks = response.data;
                })
            this.deleteModal = false;
        },

        onDragStart(event, taskId) {
            event.dataTransfer.setData('text/plain', taskId.toString());
            event.dataTransfer.effectAllowed = 'move';
        },

        onDrop(column, event) {

            event.preventDefault();
            const taskId = event.dataTransfer.getData('text/plain');
            const task = this.tasks.find(task => task.id === parseInt(taskId));

            if (!task) {
                console.error(`Task with ID '${taskId}' not found.`);
                return;
            }

            axios.post('/api/tasks/change-order', {
                order_id: column,
                task_id: task.id
            })
                .then(response => {

                })

            task.order_id = column;
            this.tasks = this.tasks.filter(t => t.id !== task.id);
            this.tasks.push(task);
        },

    }
};
</script>
