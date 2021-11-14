<template>
    <div
        v-if="alert.type === 'error'"
        class="
            popup-alert
            alert alert-danger
            d-flex
            align-items-center
            justify-content-center
            position-absolute
            top-100
            start-50
            translate-middle
        "
    >
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div class="ms-2">{{ alert.message }}</div>
    </div>

    <div
        v-else-if="alert.type === 'success'"
        class="
            popup-alert
            alert alert-success
            d-flex
            align-items-center
            justify-content-center
            position-absolute
            top-100
            start-50
            translate-middle
        "
    >
        <i class="bi bi-check-circle-fill"></i>
        <div class="ms-2">{{ alert.message }}</div>
    </div>
</template>

<script>
export default {
    computed: {
        alert() {
            return this.$store.state.alert;
        },
    },
};
</script>