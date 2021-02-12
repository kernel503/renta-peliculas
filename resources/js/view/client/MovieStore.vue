<template>
  <v-app>
    <v-container>
      <v-form
        class="mb-8"
        ref="form"
        v-model="valid"
        lazy-validation
        @submit.prevent="storeMovie"
      >
        <v-row>
          <v-tabs
            fixed-tabs
            background-color="indigo"
            dark
            class="ma-5"
            v-model="indexTab"
          >
            <v-tab>
              {{ `${isUpdate ? "Editar Película" : "Agregar Película"}` }}
            </v-tab>
            <v-tab> Catálogo de Peliculas </v-tab>
          </v-tabs>

          <template v-if="indexTab === 0">
            <v-col cols="8" sm="8" md="8">
              <v-text-field
                v-model="formData.movie_name"
                :rules="requiredField"
                label="Nombre de película"
                required
                outlined
              ></v-text-field>
              <v-text-field
                v-model="formData.release_date"
                :rules="yearField"
                label="Año de lanzamiento"
                counter="4"
                required
                outlined
              ></v-text-field>
              <v-select
                v-model="formData.category_id"
                :rules="requiredField"
                :items="items"
                label="Seleccionar Categoria"
                item-value="id"
                item-text="category_name"
                outlined
              ></v-select>
              <v-text-field
                v-model="formData.img_url"
                :rules="urlField"
                label="Ruta de la imagen"
                required
                outlined
              ></v-text-field>
              <v-text-field
                v-model="formData.quantity_stock"
                :rules="integerField"
                label="Cantidad disponible"
                required
                outlined
              ></v-text-field>
              <v-text-field
                v-model="formData.sale_price"
                :rules="doubleField"
                label="Precio de venta"
                required
                outlined
              ></v-text-field>
              <v-text-field
                cols="4"
                sm="4"
                md="4"
                v-model="formData.rent_price"
                :rules="doubleField"
                label="Precio de alquiler"
                required
                outlined
              ></v-text-field>
              <v-checkbox
                v-model="formData.available"
                label="Disponible"
                color="red"
                hide-details
              ></v-checkbox>
            </v-col>

            <v-col cols="4" sm="4" md="4">
              <v-card>
                <v-img
                  :src="formData.img_url"
                  class="white--text align-end"
                  gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                  height="450px"
                >
                </v-img>
              </v-card>
            </v-col>
            <v-btn class="mr-4" @click="reset"> Limpiar Formulario </v-btn>
            <v-btn color="indigo" dark class="mr-4" @click="storeMovie">
              {{ `${isUpdate ? "Editar Película" : "Agregar Película"}` }}
            </v-btn>
            <v-btn
              color="red"
              dark
              class="mr-4"
              @click="cancelUpdate"
              v-if="isUpdate"
            >
              Cancelar Edición
            </v-btn>
          </template>
        </v-row>
      </v-form>

      <template v-if="indexTab === 1">
        {{ fetchMovies }}
        <v-data-table
          :headers="headers"
          :items="filterMovieList"
          sort-by="calories"
          class="elevation-1"
          :search="search"
        >
          <template v-slot:top>
            <v-toolbar flat>
              <v-toolbar-title>CRUD Pelicula</v-toolbar-title>
              <v-divider class="mx-4" inset vertical></v-divider>
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Buscar"
                single-line
                hide-details
              ></v-text-field>
              <v-spacer></v-spacer>
              <v-checkbox
                v-model="listAll"
                label="Mostrar ocultos"
                color="indigo"
                hide-details
              ></v-checkbox>
            </v-toolbar>
          </template>
          <template v-slot:item.movie_name="{ item }">
            <template v-if="item.available">
              {{ item.movie_name }}
            </template>
            <template v-else>
              <v-chip color="red" dark>
                {{ item.movie_name }}
              </v-chip>
            </template>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-icon class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
          </template>
        </v-data-table>
      </template>

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
const defaultFormField = {
  movie_name: "",
  release_date: "",
  category_id: "",
  img_url: "",
  quantity_stock: "",
  sale_price: "",
  rent_price: "",
  available: true,
};

export default {
  props: ["id"],

  data: () => ({
    valid: true,
    indexTab: 0,
    listAll: true,
    search: "",
    isUpdate: false,

    items: [],
    // formData: {
    //   movie_name: "Gran Torino",
    //   release_date: "2012",
    //   category_id: "1",
    //   img_url:
    //     "https://upload.wikimedia.org/wikipedia/en/c/c6/Gran_Torino_poster.jpg",
    //   quantity_stock: "10",
    //   sale_price: "5",
    //   rent_price: "2",
    //   available: true,
    // },
    formData: {
      movie_name: "",
      release_date: "",
      category_id: "",
      img_url: "",
      quantity_stock: "",
      sale_price: "",
      rent_price: "",
      available: true,
    },

    headers: [
      {
        text: "Nombre de película",
        align: "start",
        sortable: true,
        value: "movie_name",
      },
      {
        text: "Lanzamiento",
        value: "release_date",
        align: "center",
        sortable: true,
      },
      {
        text: "Cantidad disponible",
        value: "quantity_stock",
        align: "center",
        sortable: true,
      },
      {
        text: "Venta $",
        align: "center",
        sortable: true,
        value: "sale_price",
      },
      {
        text: "Alquiler $",
        align: "center",
        sortable: true,
        value: "rent_price",
      },
      { text: "Acciones", value: "actions", align: "end", sortable: false },
    ],

    movieList: [],

    requiredField: [(v) => !!v || "Este campo es requerido"],
    yearField: [
      (v) => !!v || "Este campo es requerido",
      (v) => (v && v.length === 4) || "Año debe contener 4 digitos",
      (v) => (+v && +v >= 1895) || "Debe ser número, >= 1895",
    ],

    nameRules: [
      (v) => !!v || "Name is required",
      (v) => (v && v.length <= 10) || "Name must be less than 10 characters",
    ],

    urlField: [
      (v) => !!v || "E-mail is required",
      (v) =>
        /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(
          v
        ) || "Debe ser una URL valida",
    ],

    doubleField: [
      (v) => !!v || "Este campo es requerido",
      (v) => (+v && +v > 0) || "Debe ser número mayor que 0",
    ],

    integerField: [
      (v) => !!v || "Este campo es requerido",
      (v) =>
        (+v && Number.isInteger(+v) && +v > 0) ||
        "Debe ser número mayor que 0 y un valor entero",
    ],

    snackbar: { active: false, message: "", color: "indigo" },
  }),

  created() {
    this.fetchCategory();
  },

  computed: {
    fetchMovies() {
      if (this.indexTab === 1) {
        axios
          .get("/api/pelicula")
          .then((response) => {
            console.log(response);
            this.movieList = response.data;
          })
          .catch((error) => {
            console.log(error);
            this.snackbar = {
              active: true,
              message: "Error",
              color: "red",
            };
          });
      }
    },

    filterMovieList() {
      if (this.listAll) {
        return this.movieList;
      } else {
        return this.movieList.filter((element) => {
          if (element.available) {
            return element;
          }
        });
      }
    },
  },

  methods: {
    fetchCategory() {
      axios
        .get("/api/categoria")
        .then((response) => {
          console.log(response);
          this.items = response.data;
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

    reset() {
      this.$refs.form.resetValidation();
      this.formData = { ...defaultFormField };
    },

    storeMovie() {
      if (this.$refs.form.validate()) {
        axios
          .post("/api/pelicula", this.formData)
          .then((response) => {
            console.log(response);
            this.snackbar = {
              active: true,
              message: `${
                this.isUpdate
                  ? "Película actualizada"
                  : "Nueva película disponible"
              }`,
              color: "indigo",
            };
            this.cancelUpdate();
          })
          .catch((error) => {
            console.log(error);
            this.snackbar = {
              active: true,
              message: "Error",
              color: "red",
            };
          });
      }
    },

    editItem(item) {
      this.isUpdate = true;
      this.formData = { ...item };
      this.indexTab = 0;
    },

    cancelUpdate() {
      this.isUpdate = false;
      this.reset();
    },
  },
};
</script>