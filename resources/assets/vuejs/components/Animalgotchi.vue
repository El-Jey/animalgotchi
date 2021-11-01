<template>
    <div class="simulator container-fluid h-100 p-4">
        <animals-selector></animals-selector>
        <animals-playground></animals-playground>
    </div>
</template>

<script>
import AnimalsSelector from "./AnimalsSelector";
import AnimalsPlayground from "./AnimalsPlayground";
import { USER_ANIMALS, INIT_GROWTH } from "../store/types";

export default {
    components: { AnimalsSelector, AnimalsPlayground },
    beforeCreate() {
        const userId = 1;

        this.$axios
            .get(`/api/animals/${userId}`)
            .then((response) => {
                this.$store.commit(USER_ANIMALS, response.data);
            })
            .catch((error) => {
                return console.log(error);
            });
    },
    watch: {
        userAnimals: function () {
            const growingAnimals = this.$store.getters.growingAnimals;

            if (growingAnimals.length) {
                growingAnimals.forEach((animal) => {
                    const interval =
                        (this.$store.state.config.lifecycle * 60 * 1000) /
                        animal.max_age;

                    let timer = setInterval(() => {
                        this.$store
                            .dispatch(INIT_GROWTH, {
                                axios: this.$axios,
                                animalId: animal.id,
                            })
                            .then((data) => {
                                if (
                                    data.age < data.max_age ||
                                    data.size < data.max_size
                                ) {
                                    let imageElement = document.querySelector(
                                        `[data-my-animal="${animal.id}"] > img`
                                    );

                                    imageElement.style.width = `${data.size}%`;
                                } else {
                                    console.log('clear111111');
                                    clearInterval(timer);
                                }
                            })
                            .catch((error) => {
                                alert("Произошла ошибка. Попробуйте позже");
                                return console.error(error);
                            });
                    }, interval);
                });
            }
        },
    },
    computed: {
        userAnimals() {
            return this.$store.state.userAnimals;
        },
    },
};
</script>
