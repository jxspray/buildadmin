<template>
</template>

<script setup lang="ts">
import elField from "./elField_bak";
import {onMounted, ref, watch} from "vue/dist/vue";
import {useTemplateRefsList} from "@vueuse/core";
const designWindowRef = ref()
const props = defineProps(['modelValue', 'labelWidth', 'labelPosition', 'variable', 'ifset', 'repeat'])
const emit = defineEmits(['update:modelValue'])
const state = new elField([])
const tabsRefs = useTemplateRefsList<HTMLElement>()



onMounted(() => {
    state.createSortable(designWindowRef.value)
    tabsRefs.value.forEach((item, index) => {
        state.createTabsRef(item, index)
    })
})
watch(
    state.list,
    (newVal) => {
        emit('update:modelValue', newVal)
    }
);
</script>
