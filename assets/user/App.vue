<template>
  <div class="container bg-white">
    <header class="row pt-4">
      <div class="col-sm-2">
        <img src="/img/logo.png" alt="kartcentrum" class="w-100">
      </div>
      <div class="col-sm-10 d-flex">
        <h1 class="mt-auto">Kartcentrum <span class="text-danger">MAX</span></h1>
      </div>
    </header>
    <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item href="/">Home</b-nav-item>
          <b-nav-item href="#" active>Mijn activiteiten</b-nav-item>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-item href="/user/profile">{{ username }}'s profiel</b-nav-item>
          <b-nav-item href="/logout">uitloggen</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <img class="w-100 mb-3" src="/img/kart-wide.jpg"/>
    <ActivityTable/>
    <hr>
    <footer class="d-flex">
      <p class="text-muted text-center flex-grow-1">&copy;afdeling applicatieontwikkelaar Tinwerf 10, 2544 ED Den Haag.
        Telefoon:088
        666 3600</p>
      <div>
        <img class="img-thumbnail" width="40" style="margin-top: -10px;margin-bottom: 10px" src="/img/linkedin.jpg"/>
        <img class="img-thumbnail" width="40" style="margin-top: -10px;margin-bottom: 10px" src="/img/tweet.jpg"/>
        <img class="img-thumbnail" width="40" style="margin-top: -10px;margin-bottom: 10px" src="/img/pinterest.png"/>
      </div>
    </footer>
  </div>
</template>

<script>
import ActivityTable from './ActivityTable';
export default {
  name: 'App.vue',
  components: { ActivityTable },
  computed: {
    username() {
      return window.user;
    }
  }
};
</script>

<style scoped>
.router-link-exact-active {
  color: black!important;
}
</style>
