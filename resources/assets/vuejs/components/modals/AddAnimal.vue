<template>
    <div class="add-animal-modal modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить животное</h5>
                    <button
                        type="button"
                        class="btn btn-close"
                        @click="closeModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <form>
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
                                @focus="inputError = false"
                            />
                        </div>
                        <div
                            class="alert alert-danger mt-1"
                            role="alert"
                            v-if="inputError"
                        >
                            Имя не должно быть пустым
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="closeModal"
                    >
                        Закрыть
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="addAnimal"
                    >
                        Создать
                    </button>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
import { TOGGLE_ADD_FORM, USER_ANIMALS, INIT_GROWTH } from "../../store/types";

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
        addAnimal() {
            const animalId = this.$props.animalKind.id;

            if (!this.name) {
                this.inputError = true;
                return;
            }

            this.inputError = false;

            const data = {
                animalId,
                userId: 1,
                name: this.name,
            };

            this.$axios
                .post("/api/animals/add", data)
                .then((response) => {
                    const body = response.data;

                    if (!body.data) {
                        alert(body.error);
                        return;
                    }

                    this.$store.commit(USER_ANIMALS, body.data);

                    // const interval =
                    //     (this.$store.state.config.lifecycle * 60 * 1000) /
                    //     body.data.max_age;

                    // let timer = setInterval(() => {
                    //     this.$store
                    //         .dispatch(INIT_GROWTH, {
                    //             axios: this.$axios,
                    //             animalId: body.data.id,
                    //         })
                    //         .then((data) => {
                    //             if (
                    //                 data.age <= data.max_age &&
                    //                 data.size <= data.max_size
                    //             ) {
                    //                 let imageElement = document.querySelector(
                    //                     `[data-my-animal="${data.id}"] > img`
                    //                 );
                    //                 imageElement.style.width = `${data.size}%`;
                    //             } else {
                    //                 clearInterval(timer);
                    //             }
                    //         })
                    //         .catch((error) => {
                    //             alert("Произошла ошибка. Попробуйте позже");
                    //             return console.error(error);
                    //         });
                    // }, interval);

                    this.closeModal();
                    return;
                })
                .catch((error) => {
                    alert("Произошла ошибка. Попробуйте позже");
                    return console.log(error);
                });
        },
        closeModal() {
            this.$store.commit(TOGGLE_ADD_FORM, false);
        },
    },
};
</script>