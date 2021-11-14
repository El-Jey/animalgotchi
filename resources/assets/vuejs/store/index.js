import Vue from 'vue';
import Vuex from 'vuex';
import * as types from './types';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        alert: {
            show: null,
            message: null,
            timeout: null
        },
        animals: [],
        addFormShow: false,
        animalToAdd: null,
        config: {
            lifecycle: 0.5, // Minutes
        },
        userAnimals: []
    },
    mutations: {
        [types.ALERT](state, data) {
            state.alert = data;

            const timeout = data.timeout || 3000;
            setTimeout(() => {
                for (const key in state.alert) {
                    state.alert[key] = null;
                }
            }, timeout);
        },
        [types.ANIMALS_AVAILABLE](state, data) {
            state.animals = data;
        },
        [types.KIND_TO_ADD](state, data) {
            state.userAnimals = data;
        },
        [types.LETS_GROW](state, growingAnimal) {
            const index = state.userAnimals.findIndex(animal => animal.id == growingAnimal.id);
            state.userAnimals.splice(index, 1, growingAnimal);
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
    },
    actions: {
        [types.INIT_GROWTH](context, { axios, animal }) {
            const interval = (context.state.config.lifecycle * 60 * 1000) / animal.max_age;

            let timer = setInterval(() => {
                const data = {
                    animalId: animal.id
                };

                axios.post("/api/animals/age", data)
                    .then((response) => {
                        const body = response.data;

                        if (!body.data) {
                            return console.error(body.error);
                        }

                        if (
                            body.data.age < body.data.max_age ||
                            body.data.size < body.data.max_size
                        ) {
                            context.commit(types.LETS_GROW, body.data);
                        } else {
                            clearInterval(timer);
                        }
                    })
                    .catch((error) => {
                        return console.error(error);
                    });
            }, interval);
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