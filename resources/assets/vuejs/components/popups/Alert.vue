<template>
    <div
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
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            fill="currentColor"
            class="bi bi-exclamation-triangle-fill"
            viewBox="0 0 16 16"
        >
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
            />
        </svg>
        <div class="ms-2">{{ message }}</div>
    </div>
</template>

<script>
export default {
    computed: {
        message() {
            return this.$store.state.alert.message;
        },
    },
};
</script>