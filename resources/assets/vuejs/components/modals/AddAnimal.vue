<template>
    <div class="add-animal-modal modal fade show" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить животное</h5>
                    <button
                        type="button"
                        class="btn btn-close"
                        @click="close"
                    ></button>
                </div>
                <form @submit="addAnimal">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <input
                                class="form-control"
                                type="text"
                                :placeholder="`Выбранный тип: ${animalKind.kind_ru}`"
                                readonly
                            />
                        </div>

                        <div class="form-group">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Введите имя животного"
                                v-model="name"
                            />
                        </div>
                        <div class="alert alert-danger mt-1" v-if="inputError">
                            Имя не должно быть пустым
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="close"
                        >
                            Закрыть
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            @click="addAnimal"
                        >
                            Создать
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-backdrop fade show" @click="close"></div>
    </div>
</template>

<script>
import {
    ALERT,
    INIT_GROWTH,
    TOGGLE_ADD_FORM,
    USER_ANIMALS,
} from "../../store/types";

export default {
    props: {
        animalKind: Object,
    },
    data() {
        return {
            name: "",
            inputError: false,
        };
    },
    methods: {
        addAnimal(e) {
            e.preventDefault();

            const kindId = this.$props.animalKind.id;

            if (!this.name) {
                this.inputError = true;
                return;
            }

            const data = {
                kindId,
                userId: 1,
                name: this.name,
            };

            this.$axios
                .post("/api/animals/add", data)
                .then((response) => {
                    const body = response.data;

                    if (!body.data) {
                        return this.$store.commit(ALERT, {
                            show: true,
                            message: body.error,
                        });
                    }

                    const animal = body.data;

                    this.$store.commit(USER_ANIMALS, body.data);
                    this.$store.dispatch(INIT_GROWTH, {
                        axios: this.$axios,
                        animal,
                    });

                    this.close();
                    return;
                })
                .catch((error) => {
                    return this.$store.commit(ALERT, {
                        show: true,
                        message: error,
                    });
                });
        },
        close() {
            this.$store.commit(TOGGLE_ADD_FORM, false);
        },
        onInput() {
            if (this.inputError) {
                this.inputError = false;
            }
        },
    },
};
</script>