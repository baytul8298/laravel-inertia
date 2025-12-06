<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from "vue";
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
});

const createForm = useForm({
    name: "",
    type: "",
    description: "",
    image: null,
    is_active: 1,
});

const editForm = useForm({
    id: null,
    name: "",
    type: "",
    description: "",
    image: null,
    is_active: 1,
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const editingCategory = ref(null);

function openEdit(category) {
    editingCategory.value = category;

    editForm.id = category.id;
    editForm.name = category.name;
    editForm.type = category.type || "";
    editForm.description = category.description || "";
    editForm.is_active = category.is_active ? 1 : 0;
    editForm.image = null;

    showEditModal.value = true;
}

function submitCreate() {
    createForm.post(route('category.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showCreateModal.value = false;
            createForm.reset();
            createForm.image = null;
        },
        onError: (errors) => {
            console.log('Create errors:', errors);
        }
    });
}

function submitEdit() {
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('name', editForm.name);
    formData.append('type', editForm.type);
    formData.append('description', editForm.description);
    formData.append('is_active', editForm.is_active);

    if (editForm.image instanceof File) {
        formData.append('image', editForm.image);
    }

    router.post(route('category.update', editForm.id), formData, {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
            editForm.reset();
            editForm.image = null;
            editingCategory.value = null;
        },
        onError: (errors) => {
            console.log('Update errors:', errors);
        }
    });
}

// Delete category
function deleteCategory(id) {
    if (confirm("Are you sure you want to delete this category?")) {
        useForm({}).delete(route("category.destroy", id), {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Show success message
            }
        });
    }
}

function onEditImageChange(event) {
    editForm.image = event.target.files[0];
}

function onCreateImageChange(event) {
    createForm.image = event.target.files[0];
}

function closeCreateModal() {
    showCreateModal.value = false;
    createForm.reset();
    createForm.image = null;
}

function closeEditModal() {
    showEditModal.value = false;
    editForm.reset();
    editForm.image = null;
    editingCategory.value = null;
}
</script>

<template>
    <Head title="Categories" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Category Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Category List</h1>

                        <!-- Create Button -->
                        <button
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click="showCreateModal = true"
                        >
                            + Create Category
                        </button>
                    </div>

                    <!-- Categories Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">ID</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Name</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Type</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Image</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Status</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr v-for="cat in categories" :key="cat.id" class="hover:bg-gray-50">
                                <td class="p-3 border border-gray-300">{{ cat.id }}</td>
                                <td class="p-3 border border-gray-300">{{ cat.name }}</td>
                                <td class="p-3 border border-gray-300">{{ cat.type || '-' }}</td>
                                <td class="p-3 border border-gray-300">
                                    <div class="flex justify-center">
                                        <img
                                            v-if="cat.image"
                                            :src="'/storage/' + cat.image"
                                            class="h-12 w-12 object-cover rounded"
                                            alt="Category Image"
                                        />
                                        <span v-else class="text-gray-400 text-sm">No Image</span>
                                    </div>
                                </td>
                                <td class="p-3 border border-gray-300">
                                        <span
                                            :class="[
                                                'px-2 py-1 text-xs font-semibold rounded-full',
                                                cat.is_active
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800'
                                            ]"
                                        >
                                            {{ cat.is_active ? "Active" : "Inactive" }}
                                        </span>
                                </td>
                                <td class="p-3 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <button
                                            class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded hover:bg-blue-200"
                                            @click="openEdit(cat)"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded hover:bg-red-200"
                                            @click="deleteCategory(cat.id)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Create Modal -->
                    <div v-if="showCreateModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Create New Category</h3>
                                    <button @click="closeCreateModal" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                        <input
                                            v-model="createForm.name"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Category name"
                                            required
                                        />
                                        <div v-if="createForm.errors.name" class="text-red-500 text-xs mt-1">
                                            {{ createForm.errors.name }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                        <input
                                            v-model="createForm.type"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Category type"
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                        <textarea
                                            v-model="createForm.description"
                                            rows="3"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Category description"
                                        ></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                                        <input
                                            type="file"
                                            @change="onCreateImageChange"
                                            accept="image/*"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"
                                        />
                                        <div v-if="createForm.errors.image" class="text-red-500 text-xs mt-1">
                                            {{ createForm.errors.image }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select
                                            v-model="createForm.is_active"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        >
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 mt-6">
                                    <button
                                        type="button"
                                        @click="closeCreateModal"
                                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="button"
                                        @click="submitCreate"
                                        :disabled="createForm.processing"
                                        class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                                    >
                                        <span v-if="createForm.processing">Saving...</span>
                                        <span v-else>Save Category</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div v-if="showEditModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Edit Category</h3>
                                    <button @click="closeEditModal" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Current Image Preview -->
                                <div v-if="editingCategory?.image" class="mb-4">
                                    <p class="text-sm font-medium text-gray-700 mb-1">Current Image:</p>
                                    <img
                                        :src="'/storage/' + editingCategory.image"
                                        class="h-24 w-24 object-cover rounded-md border"
                                        alt="Current image"
                                    />
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                        <input
                                            v-model="editForm.name"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                            required
                                        />
                                        <div v-if="editForm.errors.name" class="text-red-500 text-xs mt-1">
                                            {{ editForm.errors.name }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                        <input
                                            v-model="editForm.type"
                                            type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                        <textarea
                                            v-model="editForm.description"
                                            rows="3"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        ></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            {{ editingCategory?.image ? 'Change Image' : 'Upload Image' }}
                                        </label>
                                        <input
                                            type="file"
                                            @change="onEditImageChange"
                                            accept="image/*"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"
                                        />
                                        <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                                        <div v-if="editForm.errors.image" class="text-red-500 text-xs mt-1">
                                            {{ editForm.errors.image }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select
                                            v-model="editForm.is_active"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        >
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 mt-6">
                                    <button
                                        type="button"
                                        @click="closeEditModal"
                                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="button"
                                        @click="submitEdit"
                                        :disabled="editForm.processing"
                                        class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                                    >
                                        <span v-if="editForm.processing">Updating...</span>
                                        <span v-else>Update Category</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.modal-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, 0.5);
    z-index: 50;
}

.modal-box {
    background: white;
    padding: 20px;
    width: 400px;
    border-radius: 8px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.input {
    width: 100%;
    margin-bottom: 12px;
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 14px;
}

.input:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.btn {
    padding: 8px 16px;
    background: #4f46e5;
    color: white;
    border-radius: 4px;
    font-weight: 500;
    border: none;
    cursor: pointer;
}

.btn:hover {
    background: #4338ca;
}

.btn-cancel {
    padding: 8px 16px;
    background: #f3f4f6;
    color: #374151;
    border-radius: 4px;
    font-weight: 500;
    border: 1px solid #d1d5db;
    cursor: pointer;
}

.btn-cancel:hover {
    background: #e5e7eb;
}
</style>
