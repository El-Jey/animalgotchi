<template>
    <div class="row mb-5">
        <div class="animals-select col position-relative d-flex">
            <button class="add-button btn p-0 border-0">
                <img
                    class="h-100"
                    src="assets/images/icons/add.svg"
                    alt="Add animal"
                />
            </button>
            <div
                v-if="animals.length"
                class="
                    animals-substrate
                    flex-center
                    position-absolute
                    h-100
                    p-1
                    ps-5
                    pe-3
                "
            >
                <button
                    v-for="animal in animals"
                    class="animals-ellipse btn p-0 flex-center mx-1"
                    @click="selectAnimal"
                    :key="animal.id"
                    :data-id="animal.id"
                    :disabled="isAnimalAvailable(animal.id)"
                >
                    <img
                        class="h-50"
                        :src="animal.default_image"
                        :alt="animal.kind_ru"
                    />
                </button>

                <add-animal-modal
                    v-if="addFormShow"
                    :animalKind="selectedKind"
                ></add-animal-modal>
            </div>
        </div>
    </div>
</template>

<script>
// Components
import AddAnimalModal from "./modals/AddAnimal";

import { ANIMALS_AVAILABLE, TOGGLE_ADD_FORM } from "../store/types";

export default {
    components: { AddAnimalModal },
    data() {
        return {
            selectedKind: "",
        };
    },
    created() {
        this.$axios
            .get("/api/animals")
            .then((response) => {
                return this.$store.commit(ANIMALS_AVAILABLE, response.data);
            })
            .catch((error) => {
                return console.log(error);
            });
    },
    computed: {
        addFormShow() {
            return this.$store.state.addFormShow;
        },
        animals() {
            return this.$store.state.animals;
        },
        userAnimals() {
            return this.$store.state.userAnimals;
        },
    },
    methods: {
        isAnimalAvailable(animalId) {
            return this.userAnimals.find((animal) => animal.animal_kind_id == animalId);
        },
        selectAnimal(e) {
            const animalId = parseInt(
                e.target.closest(".animals-ellipse").getAttribute("data-id")
            );

            this.selectedKind = this.$store.getters.getAnimalKind(animalId);
            this.$store.commit(TOGGLE_ADD_FORM, true);
        },
    },
};
</script>