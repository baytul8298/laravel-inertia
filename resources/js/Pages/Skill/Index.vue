<script setup>
import { ref, reactive, computed, watch, onMounted, nextTick } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    skills: Array,
});

const showModal = ref(false);
const isEditing = ref(false);
const editingSkill = ref(null);
const imagePreview = ref(null);
const quillEditor = ref(null);

const editorOptions = {
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            //['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            //[{ 'script': 'sub'}, { 'script': 'super' }],
            //[{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': [] }],
            ['clean'],
            ['link', 'image']
        ]
    },
    placeholder: 'Enter skill description...',
    theme: 'snow'
};

// Initialize form
const form = useForm({
    name: '',
    title: '',
    description: '',
    image: null,
    is_active: 1,
    skill_items: [
        { name: '', percentage: '' }
    ]
});

// Open Create Modal
function openCreateModal() {
    resetForm();
    isEditing.value = false;
    editingSkill.value = null;
    imagePreview.value = null;
    showModal.value = true;
}

// Open Edit Modal
function openEditModal(skill) {
    resetForm();
    isEditing.value = true;
    editingSkill.value = skill;
    imagePreview.value = null;

    // Set form values
    form.name = skill.name;
    form.title = skill.title;
    form.description = skill.description || '';
    form.is_active = skill.is_active ? 1 : 0;

    if (skill.skill_items && skill.skill_items.length > 0) {
        form.skill_items = skill.skill_items.map(item => ({
            id: item.id,
            name: item.name,
            percentage: item.percentage
        }));
    } else {
        form.skill_items = [{ name: '', percentage: '' }];
    }

    showModal.value = true;
}

// Reset form
function resetForm() {
    form.reset();
    form.is_active = 1;
    form.skill_items = [{ name: '', percentage: '' }];
}

// Close modal
function closeModal() {
    showModal.value = false;
    resetForm();
    editingSkill.value = null;
    imagePreview.value = null;
}

// Handle image upload
function handleImageUpload(event) {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Add skill item
function addSkillItem() {
    form.skill_items.push({ name: '', percentage: '' });
}

function removeSkillItem(index) {
    if (form.skill_items.length > 1) {
        form.skill_items.splice(index, 1);
    }
}

// Submit form
function submitForm() {
    if (isEditing.value) {
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('name', form.name);
        formData.append('title', form.title);
        formData.append('description', form.description);
        formData.append('is_active', form.is_active);

        // Append skill items
        form.skill_items.forEach((item, index) => {
            if (item.id) {
                formData.append(`skill_items[${index}][id]`, item.id);
            }
            formData.append(`skill_items[${index}][name]`, item.name);
            formData.append(`skill_items[${index}][percentage]`, item.percentage);
        });

        // Append image if new one selected
        if (form.image instanceof File) {
            formData.append('image', form.image);
        }

        router.post(route('skill.update', editingSkill.value.id), formData, {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
            },
            onError: (errors) => {
                console.log('Update errors:', errors);
            }
        });
    } else {
        form.post(route('skill.store'), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
            },
            onError: (errors) => {
                console.log('Create errors:', errors);
            }
        });
    }
}

function deleteSkill(id) {
    if (confirm('Are you sure you want to delete this skill?')) {
        router.delete(route('skill.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                // Success message
            }
        });
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Skills" />

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Skills Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Skills List</h1>
                        <button
                            @click="openCreateModal"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            + Create Skill
                        </button>
                    </div>

                    <!-- Skills Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">ID</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Name</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Title</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Image</th>
<!--                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Description</th>-->
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Skills</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Status</th>
                                <th class="p-3 border border-gray-300 text-left text-sm font-medium text-gray-700">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr v-for="skill in skills" :key="skill.id" class="hover:bg-gray-50">
                                <td class="p-3 border border-gray-300">{{ skill.id }}</td>
                                <td class="p-3 border border-gray-300">{{ skill.name }}</td>
                                <td class="p-3 border border-gray-300">{{ skill.title }}</td>
                                <td class="p-3 border border-gray-300">
                                    <div class="flex justify-center">
                                        <img
                                            v-if="skill.image"
                                            :src="'/storage/' + skill.image"
                                            class="h-12 w-12 object-cover rounded"
                                            alt="Skill Image"
                                        />
                                        <span v-else class="text-gray-400 text-sm">No Image</span>
                                    </div>
                                </td>
<!--                                <td class="p-3 border border-gray-300 max-w-xs">-->
<!--                                    <div class="line-clamp-3" v-html="skill.description || '-'"></div>-->
<!--                                </td>-->
                                <td class="p-3 border border-gray-300">
                                    <div class="space-y-1">
                                        <div v-for="item in skill.skill_items" :key="item.id" class="text-sm">
                                            {{ item.name }}: {{ item.percentage }}%
                                        </div>
                                    </div>
                                </td>
                                <td class="p-3 border border-gray-300">
                                        <span
                                            :class="[
                                                'px-2 py-1 text-xs font-semibold rounded-full',
                                                skill.is_active
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800'
                                            ]"
                                        >
                                            {{ skill.is_active ? "Active" : "Inactive" }}
                                        </span>
                                </td>
                                <td class="p-3 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <button
                                            @click="openEditModal(skill)"
                                            class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded hover:bg-blue-200"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            @click="deleteSkill(skill.id)"
                                            class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded hover:bg-red-200"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Create/Edit Modal -->
                    <div v-if="showModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-start justify-center z-50 p-4 overflow-y-auto">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl my-8">
                            <div class="p-6">
                                <!-- Modal Header -->
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ isEditing ? 'Edit Skill' : 'Create New Skill' }}
                                    </h3>
                                    <button @click="closeModal" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Form -->
                                <form @submit.prevent="submitForm">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Left Column -->
                                        <div class="space-y-4">
                                            <!-- Name -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                                <input
                                                    v-model="form.name"
                                                    type="text"
                                                    required
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                />
                                                <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">
                                                    {{ form.errors.name }}
                                                </div>
                                            </div>

                                            <!-- Title -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                                                <input
                                                    v-model="form.title"
                                                    type="text"
                                                    required
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                />
                                                <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">
                                                    {{ form.errors.title }}
                                                </div>
                                            </div>

                                            <!-- Image -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    {{ editingSkill?.image ? 'Change Image' : 'Upload Image' }}
                                                </label>
                                                <input
                                                    type="file"
                                                    @change="handleImageUpload"
                                                    accept="image/*"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"
                                                />
                                                <div v-if="form.errors.image" class="text-red-500 text-xs mt-1">
                                                    {{ form.errors.image }}
                                                </div>
                                                <!-- Image Preview -->
                                                <div v-if="imagePreview || editingSkill?.image" class="mt-2">
                                                    <img
                                                        :src="imagePreview || (editingSkill?.image ? '/storage/' + editingSkill.image : '')"
                                                        class="h-32 w-32 object-cover rounded border"
                                                        alt="Preview"
                                                    />
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ editingSkill?.image ? 'Current image' : 'New image preview' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Status -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                                <select
                                                    v-model="form.is_active"
                                                    required
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                >
                                                    <option :value="1">Active</option>
                                                    <option :value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Right Column - Description with Quill Editor -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                            <div class="border border-gray-300 rounded-md overflow-hidden">
                                                <QuillEditor
                                                    ref="quillEditor"
                                                    v-model:content="form.description"
                                                    contentType="html"
                                                    theme="snow"
                                                    :options="editorOptions"
                                                    class="h-64"
                                                />
                                            </div>
                                            <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">
                                                {{ form.errors.description }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Skill Items Section -->
                                    <div class="mt-6">
                                        <div class="flex justify-between items-center mb-4">
                                            <h4 class="text-md font-medium text-gray-900">Skill Items</h4>
                                            <button
                                                type="button"
                                                @click="addSkillItem"
                                                class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded hover:bg-green-200"
                                            >
                                                + Add More
                                            </button>
                                        </div>

                                        <div class="space-y-3">
                                            <div v-for="(item, index) in form.skill_items" :key="index" class="flex items-center space-x-3 p-3 border border-gray-200 rounded">
                                                <!-- Item Name -->
                                                <div class="flex-1">
                                                    <input
                                                        v-model="item.name"
                                                        type="text"
                                                        placeholder="Skill Name"
                                                        required
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                    />
                                                    <div v-if="form.errors[`skill_items.${index}.name`]" class="text-red-500 text-xs mt-1">
                                                        {{ form.errors[`skill_items.${index}.name`] }}
                                                    </div>
                                                </div>

                                                <!-- Percentage -->
                                                <div class="w-32">
                                                    <div class="relative">
                                                        <input
                                                            v-model="item.percentage"
                                                            type="number"
                                                            min="0"
                                                            max="100"
                                                            placeholder="0-100"
                                                            required
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 pr-10"
                                                        />
                                                        <span class="absolute right-3 top-2 text-gray-500">%</span>
                                                    </div>
                                                    <div v-if="form.errors[`skill_items.${index}.percentage`]" class="text-red-500 text-xs mt-1">
                                                        {{ form.errors[`skill_items.${index}.percentage`] }}
                                                    </div>
                                                </div>

                                                <!-- Remove Button -->
                                                <button
                                                    type="button"
                                                    @click="removeSkillItem(index)"
                                                    class="px-3 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 transition-colors"
                                                    :disabled="form.skill_items.length === 1"
                                                    :class="{ 'opacity-50 cursor-not-allowed': form.skill_items.length === 1 }"
                                                >
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Add individual skills with their proficiency percentage (0-100%)</p>
                                    </div>

                                    <!-- Form Buttons -->
                                    <div class="flex justify-end space-x-3 mt-6">
                                        <button
                                            type="button"
                                            @click="closeModal"
                                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="submit"
                                            :disabled="form.processing"
                                            class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-colors"
                                        >
                                            <span v-if="form.processing">
                                                {{ isEditing ? 'Updating...' : 'Saving...' }}
                                            </span>
                                            <span v-else>
                                                {{ isEditing ? 'Update Skill' : 'Save Skill' }}
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Custom styles for Quill Editor */
.ql-editor {
    min-height: 200px;
    font-size: 14px;
}

.ql-container {
    font-family: inherit;
}

.ql-toolbar {
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
    border-bottom: 1px solid #e5e7eb;
}

.ql-container {
    border-bottom-left-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
