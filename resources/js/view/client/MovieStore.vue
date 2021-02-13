<template>
  <v-app>
    <v-container fluid>
      <v-row dense>
        <div v-if="this.cards.length === 0" class="red--text h1">
          No contamos con películas disponibles.
        </div>
        <v-col v-for="card in cards" :key="card.id" cols="3">
          <v-card>
            <v-img
              :src="card.img_url"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="250"
            >
              <v-card-title v-text="card.movie_name"></v-card-title>
            </v-img>

            <v-card-text>
              <div class="h6">Comprar por ${{ card.sale_price }}</div>
              <div class="h6">Alquilar por ${{ card.rent_price }}</div>

              <div v-if="card.quantity_stock > 10">
                Cantidad disponible: {{ card.quantity_stock }}
              </div>

              <div v-else class="red--text">
                Cantidad disponible: {{ card.quantity_stock }}
              </div>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="cyan darken-3"
                text
                @click="compra(card, 0)"
                :disabled="loading"
              >
                Alquilar
              </v-btn>
              <v-btn
                color="indigo darken-4"
                text
                @click="compra(card, 1)"
                :disabled="loading"
              >
                Comprar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
      <v-snackbar
        v-model="snackbar.active"
        :color="snackbar.color"
        timeout="3500"
        left
      >
        {{ snackbar.message }}
        <template v-slot:action="{ attrs }">
          <v-btn text v-bind="attrs" @click="snackbar.active = false">
            Cerrar
          </v-btn>
        </template>
      </v-snackbar>
    </v-container>
  </v-app>
</template>

<script>
export default {
  props: ["user_id"],
  name: "MovieStore",

  data: () => ({
    snackbar: { active: false, message: "", color: "indigo" },
    loading: false,
    cards: [],
  }),

  created() {
    this.fetchMovieCatalogue();
  },

  computed: {},

  methods: {
    fetchMovieCatalogue() {
      axios
        .get("/api/pelicula/catalogo")
        .then((response) => {
          console.log(response.data.data);
          this.cards = response.data.data;
        })
        .catch((error) => {
          console.log(error);
          this.snackbar = {
            active: true,
            message: "Error",
            color: "red",
          };
        });
    },

    compra({ id }, option) {
      this.loading = true;
      const user_id = this.user_id;
      axios
        .post("/api/pelicula/compra", { user_id, option, movie_id: id })
        .then((response) => {
          console.log(response);
          this.snackbar = {
            active: true,
            message: response.data.mensaje,
            color: "indigo",
          };
          this.fetchMovieCatalogue();
          this.loading = false;
        })
        .catch((error) => {
          console.log(error);
          this.snackbar = {
            active: true,
            message: "Error",
            color: "red",
          };
          this.loading = false;
        });
    },
  },
};
</script>