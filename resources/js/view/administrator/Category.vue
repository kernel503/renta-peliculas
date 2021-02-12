<template>
  <v-app>
    <v-container>
      <v-data-table
        :headers="headers"
        :items="categories"
        sort-by="calories"
        class="elevation-1"
        :search="search"
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>CRUD Categoria</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Buscar"
              single-line
              hide-details
            ></v-text-field>
            <v-spacer></v-spacer>

            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="primary"
                  dark
                  class="mb-2"
                  v-bind="attrs"
                  v-on="on"
                >
                  Agregar Categoria
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="category_name"
                          label="Nombre de Categoria"
                          @keypress.enter="save"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">
                    Cancelar
                  </v-btn>
                  <v-btn color="blue darken-1" text @click="save">
                    Guardar
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
        </template>
        <template v-slot:no-data>
          <v-btn color="primary" @click="fetchCategory"> Solicitar </v-btn>
        </template>
      </v-data-table>
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
  data: () => ({
    search: "",
    dialog: false,
    headers: [
      {
        text: "Nobre de categoria",
        align: "start",
        sortable: true,
        value: "category_name",
      },
      { text: "Acciones", value: "actions", align: "end", sortable: false },
    ],
    categories: [],
    category_name: "",
    editedIndex: -1,
    currentItem: {},
    snackbar: { active: false, message: "", color: "indigo" },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nueva Categoria" : "Editar Categoria";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.fetchCategory();
  },

  methods: {
    fetchCategory() {
      axios
        .get("/api/categoria")
        .then((response) => {
          console.log(response);
          this.categories = response.data;
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

    editItem(item) {
      this.editedIndex = this.categories.indexOf(item);
      this.currentItem = { ...item };
      this.category_name = this.currentItem.category_name;
      this.dialog = true;
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.currentItem = {};
        this.category_name = this.currentItem.category_name;
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex === -1) {
        axios
          .post("/api/categoria", {
            category_name: this.category_name,
          })
          .then((response) => {
            console.log(response);
            this.fetchCategory();
            this.snackbar = {
              active: true,
              message: "Elemento agregado." + this.category_name,
              color: "indigo",
            };
            this.category_name = "";
          })
          .catch((error) => {
            console.log(error);
            this.snackbar = {
              active: true,
              message: "Error",
              color: "red",
            };
          });
      } else {
        const { id } = this.categories[this.editedIndex];
        if (!this.category_name) {
          this.snackbar = {
            active: true,
            message: "Debe llenar el campo",
            color: "red",
          };
          return;
        }
        axios
          .put("/api/categoria", {
            id,
            category_name: this.category_name,
          })
          .then((response) => {
            console.log(response);
            this.fetchCategory();
            this.snackbar = {
              active: true,
              message: "Elemento actualizado",
              color: "indigo",
            };
            this.category_name = "";
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
      this.close();
    },
  },
};
</script>
