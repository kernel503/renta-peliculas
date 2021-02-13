<template>
  <v-app>
    <v-container>
      <v-data-table
        :headers="headers"
        :items="users"
        item-key="id"
        class="elevation-1"
        :search="search"
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Administrar Rol Usuario</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Buscar"
              single-line
              hide-details
            ></v-text-field>
            <v-spacer></v-spacer>
          </v-toolbar>
        </template>

        <template v-slot:item.is_admin="{ item }">
          <v-switch
            v-model="item.is_admin"
            @change="changeState(item)"
          ></v-switch>
        </template>
      </v-data-table>
    </v-container>
    <v-snackbar
      v-model="snackbar.state"
      :timeout="3000"
      :color="snackbar.color"
      left
    >
      {{ snackbar.message }}
      <template v-slot:action="{ attrs }">
        <v-btn text v-bind="attrs" @click="snackbar.state = false">
          Cerrar
        </v-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>

<script>
export default {
  name: "User",
  data() {
    return {
      search: "",
      users: [],

      headers: [
        {
          text: "NickName",
          value: "name",
          align: "start",
        },
        {
          text: "Correo",
          value: "email",
          align: "start",
          sortable: false,
        },
        {
          text: "Fecha Registro",
          value: "created_at",
          align: "start",
          sortable: false,
        },
        {
          text: "Administrador",
          value: "is_admin",
          align: "start",
          sortable: false,
        },
      ],

      snackbar: {
        state: false,
        message: "",
        color: "",
      },

      attrs: {},
    };
  },

  created() {
    this.fetchUsers();
  },

  methods: {
    fetchUsers() {
      axios.get("/api/usuarios").then((response) => {
        this.users = response.data;
      });
    },

    changeState(value) {
      console.log(value);
      axios
        .put("/api/usuarios", value)
        .then((response) => {
          console.log(response);
          this.showSnackbar(response.data.mensaje);
        })
        .catch((error) => {
          console.log(error);
          this.showSnackbar("Error", "error");
        });
      // this.showSnackbar("Permiso Actualizado", "success");
    },

    showSnackbar(message, color = "indigo") {
      this.snackbar.message = message;
      this.snackbar.color = color;
      this.snackbar.state = true;
    },
  },
};
</script>
