<template>
    <div class="simulator container-fluid h-100 p-4">
        <animals-selector></animals-selector>
        <animals-playground></animals-playground>
        <alert-popup v-if="alert.show"></alert-popup>
    </div>
</template>

<script>
import AnimalsSelector from "./AnimalsSelector";
import AnimalsPlayground from "./AnimalsPlayground";
import AlertPopup from "./popups/Alert.vue";
import { ALERT, INIT_GROWTH, USER_ANIMALS } from "../store/types";

export default {
    components: { AlertPopup, AnimalsPlayground, AnimalsSelector },
    beforeCreate() {
        const userId = 1;

        this.$axios
            .get(`/api/animals/${userId}`)
            .then((response) => {
                this.$store.commit(USER_ANIMALS, response.data);

                const growingAnimals = this.$store.getters.growingAnimals;
                if (growingAnimals.length) {
                    growingAnimals.forEach((animal) => {
                        this.$store.dispatch(INIT_GROWTH, {
                            axios: this.$axios,
                            animal,
                        });
                    });
                }
            })
            .catch((error) => {
                return this.$store.commit(ALERT, {
                    show: true,
                    message: error,
                });
            });
    },
    computed: {
        alert() {
            return this.$store.state.alert;
        },
    },
};
</script>
