<!-- resources/js/Pages/UserManagement.vue -->
<template>
    <app-layout>
        <v-container>
            <h1 class="mb-4">User Management</h1>

            <!-- User List -->
            <v-data-table
                :headers="headers"
                :items="users"
                :items-per-page="10"
                class="elevation-1"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn class="mr-2" color="primary" small @click="editUser(item)">Edit</v-btn>
                    <v-btn class="mr-2" color="error" small @click="deleteUser(item)">Delete</v-btn>
                    <v-btn color="info" small @click="viewReports(item)">View Reports</v-btn>
                </template>
            </v-data-table>

            <!-- Add User Button -->
            <v-btn class="mt-4" color="success" @click="openAddUserDialog">
                Add User
            </v-btn>

            <!-- Add/Edit User Dialog -->
            <v-dialog v-model="showAddUserDialog" max-width="500px">
                <v-card>
                    <v-card-title>
                        <span>{{ editedIndex === -1 ? 'Add User' : 'Edit User' }}</span>
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="saveUser">
                            <v-text-field v-model="form.name" :error-messages="form.errors.name"
                                          label="Name"></v-text-field>
                            <v-text-field v-model="form.email" :error-messages="form.errors.email"
                                          label="Email"></v-text-field>
                            <v-text-field
                                v-model="form.password"
                                :error-messages="form.errors.password"
                                :hint="editedIndex === -1 ? '' : 'Leave blank to keep current password'"
                                label="Password"
                                type="password"
                            ></v-text-field>
                            <v-checkbox v-model="form.is_admin" label="Is Admin"></v-checkbox>
                            <v-btn :loading="form.processing" class="mt-4" color="primary" type="submit">Save</v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-dialog>

            <!-- View Reports Dialog -->
            <v-dialog v-model="showReportsDialog" max-width="800px">
                <v-card>
                    <v-card-title>
                        <span>Reports for {{ selectedUser ? selectedUser.name : '' }}</span>
                    </v-card-title>
                    <v-card-text>
                        <v-list v-if="userReports.length">
                            <v-list-item v-for="report in userReports" :key="report.id">
                                <v-list-item-content>
                                    <v-list-item-title>{{ report.field }} Evaluation</v-list-item-title>
                                    <v-list-item-subtitle>Date: {{
                                            new Date(report.created_at).toLocaleString()
                                        }}
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-btn :href="route('report.show', report.id)" class="mt-3" color="primary" small>
                                        View Report
                                    </v-btn>
                                </v-list-item-action>
                            </v-list-item>
                        </v-list>
                        <p v-else>No reports available for this user.</p>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-container>
    </app-layout>
</template>

<script setup>
import {onMounted, ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const users = ref([]);
const headers = [
    {text: 'Name', value: 'name'},
    {text: 'Email', value: 'email'},
    {text: 'Admin', value: 'is_admin'},
    {text: 'Actions', value: 'actions', sortable: false},
];

const showAddUserDialog = ref(false);
const showReportsDialog = ref(false);
const editedIndex = ref(-1);
const selectedUser = ref(null);
const userReports = ref([]);

const form = useForm({
    name: '',
    email: '',
    password: '',
    is_admin: false,
});

onMounted(() => {
    fetchUsers();
});

const fetchUsers = () => {
    axios.get(route('users.index'), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            users.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching users:', error);
        });
};

const editUser = (user) => {
    editedIndex.value = users.value.indexOf(user);
    resetForm();
    form.name = user.name;
    form.email = user.email;
    form.is_admin = user.is_admin;
    showAddUserDialog.value = true;
};

const deleteUser = (user) => {
    if (confirm('Are you sure you want to delete this user?')) {
        axios.delete(route('users.destroy', user.id))
            .then(() => {
                users.value = users.value.filter(u => u.id !== user.id);
            })
            .catch(error => {
                console.error('Error deleting user:', error);
            });
    }
};

const viewReports = (user) => {
    selectedUser.value = user;
    axios.get(route('users.reports', user.id))
        .then(response => {
            userReports.value = response.data;
            showReportsDialog.value = true;
        })
        .catch(error => {
            console.error('Error fetching user reports:', error);
        });
};
const resetForm = () => {
    form.reset();
    form.clearErrors();
};
const openAddUserDialog = () => {
    editedIndex.value = -1;
    resetForm();
    showAddUserDialog.value = true;
};
const saveUser = () => {
    if (editedIndex.value > -1) {
        // Update existing user
        form.put(route('users.update', users.value[editedIndex.value].id), {
            preserveScroll: true,
            onSuccess: () => {
                Object.assign(users.value[editedIndex.value], form);
                showAddUserDialog.value = false;
            },
        });
    } else {
        // Add new user
        form.post(route('users.store'), {
            preserveScroll: true,
            onSuccess: (response) => {
                users.value.push(response.data);
                showAddUserDialog.value = false;
            },
        });
    }
};
</script>
