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
                    @click="selectAnimal(animal.id)"
                    :key="animal.id"
                    :disabled="isAnimalAvailable(animal.id)"
                >
                    <img
                        class="h-50"
                        :src="animal.default_image"
                        :alt="animal.kind_ru"
                    />
                </button>

                <add-animal-modal
                    v-if="showAddForm"
                    :animalKind="selectedKind"
                ></add-animal-modal>
            </div>
        </div>
    </div>
</template>

<script>
// Components
import AddAnimalModal from "./modals/AddAnimal";

import { ALERT, AVAILABLE_ANIMALS, TOGGLE_ADD_FORM } from "../store/types";

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
                return this.$store.commit(AVAILABLE_ANIMALS, response.data);
            })
            .catch((error) => {
                return this.$store.commit(ALERT, {
                    show: true,
                    message: error,
                });
            });
    },
    computed: {
        showAddForm() {
            return this.$store.state.showAddForm;
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
            return this.userAnimals.find(
                (animal) => animal.animal_kind_id == animalId
            );
        },
        selectAnimal(animalId) {
            this.selectedKind = this.$store.getters.getAnimalKind(animalId); // props
            this.$store.commit(TOGGLE_ADD_FORM, true);
        },
    },
};
</script>