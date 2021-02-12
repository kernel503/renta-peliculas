<template>
  <v-app id="main">
    <v-row align="center" justify="space-around">
      <v-btn depressed> Normal </v-btn>
      <v-btn depressed color="primary"> Primary </v-btn>
      <v-btn depressed color="error"> Error </v-btn>
      <v-btn depressed disabled> Disabled </v-btn>
    </v-row>
  </v-app>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
    // window.location.href = "/master";
    // axios
    //   .get("/user?ID=12345")
    //   .then(function (response) {
    //     // handle success
    //     console.log(response);
    //   })
    //   .catch(function (error) {
    //     // handle error
    //     console.log(error);
    //   })
    //   .then(function () {
    //     // always executed
    //   });
  },
};
</script>
