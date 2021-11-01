import Vue from 'vue';
import Vuex from 'vuex';
import * as types from './types';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        config: {
            lifecycle: 0.5, // Minutes
        },
        animals: [],
        addFormShow: false,
        animalToAdd: null,
        userAnimals: []
    },
    mutations: {
        [types.ANIMALS_AVAILABLE](state, data) {
            state.animals = data;
        },
        [types.TOGGLE_ADD_FORM](state, data) {
            state.addFormShow = data;
        },
        [types.USER_ANIMALS](state, data) {
            if (Array.isArray(data)) {
                state.userAnimals = data;
            } else {
                state.userAnimals.push(data);
            }
        },
        [types.KIND_TO_ADD](state, data) {
            state.userAnimals = data;
        },
    },
    actions: {
        [types.INIT_GROWTH](context, payload) {
            return new Promise((resolve, reject) => {
                const data = {
                    animalId: payload.animalId,
                };

                payload.axios
                    .post("/api/animals/age", data)
                    .then((response) => {
                        const body = response.data;

                        if (!body.data) {
                            return reject(body.error);
                        }

                        return resolve(body.data);
                    })
                    .catch((error) => {
                        return reject(error);
                    });
            });
        }
    },
    getters: {
        getAnimalKind: state => id => {
            return state.animals.find(animal => animal.id == id);
        },
        growingAnimals: state => {
            return state.userAnimals.filter(animal => animal.age !== animal.max_age);
        },
    }
})

export default store;