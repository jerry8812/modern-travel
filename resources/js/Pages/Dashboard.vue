<template>
    <Head>
        <title>Dashboard | Modern Travel</title>
    </Head>
    <PagePanel>
        <TotalSalesGraph />
    </PagePanel>
</template>

<script setup>
import TotalSalesGraph from '@/Components/Dashboard/TotalSalesGraph.vue'
import PagePanel from '@/Components/Common/PagePanel.vue'
import { Head } from '@inertiajs/vue3';
</script>
