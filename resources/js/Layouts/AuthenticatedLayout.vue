<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';


import Toast from '@/Components/Toast.vue';
import Navbar from './Partials/Navbar.vue';

// Toast
const message = computed(() => usePage().props.flash.message);

</script>

<template>
    <Toast
      v-if="message"
      :text="message?.text"
      :type="message?.type"
    />
    
    <div>
        <div class="min-h-screen bg-gray-100">
            <Navbar />

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
