require("./bootstrap");

import Vue from "vue";
import Vuetify from "vuetify";
import App from "./components/App.vue";
import Category from "./view/administrator/Category";
import Movie from "./view/administrator/Movie.vue";
import MovieStore from "./view/client/MovieStore.vue";

Vue.use(Vuetify);

const app = new Vue({
    el: "#app",
    components: { App, Category, Movie, MovieStore },
    vuetify: new Vuetify()
});
