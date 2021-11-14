<template>
    <div class="flex-center pt-5 row h-75">
        <div
            v-for="animal in userAnimals"
            :key="animal.id"
            class="col-3 flex-shrink-0 flex-grow-1 flex-wrap"
        >
            <img
                class="animal-image h-50"
                :src="animal.image"
                :alt="animal.name"
                :style="{ width: `${animal.size}%` }"
            />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    },
    computed: {
        userAnimals() {
            return this.$store.state.userAnimals;
        },
    },
    methods: {},
};
</script>