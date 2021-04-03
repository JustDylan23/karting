<template>
  <div>
    Dit zijn alle beschikbare activiteiten
    <table class="table" style="table-layout: fixed" v-if="available">
      <thead>
      <tr>
        <th>datum</th>
        <th>soort activiteit</th>
        <th>prijs</th>
        <th>beschikbare plaatsen</th>
        <th>schrijf in</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="activity in available">
        <td>{{ activity.displayDate }}</td>
        <td>{{ activity.name }}</td>
        <td>&euro;{{ activity.price }}</td>
        <td>{{ activity.totalRegistrations }} van de {{ activity.maxRegistrations }}</td>
        <td class="text-success display-4" @click="register(activity.id)">+</td>
      </tr>
      <tr v-if="available.length === 0">
        <td colspan="5">Op dit moment zijn er geen nieuwe activiteiten beschikbaar.</td>
      </tr>
      </tbody>
    </table>

    Dit zijn de door jou ingeschreven activiteiten
    <table class="table" style="table-layout: fixed" v-if="registered">
      <thead>
      <tr>
        <th>datum</th>
        <th>soort activiteit</th>
        <th>prijs</th>
        <th>beschikbare plaatsen</th>
        <th>schrijf uit</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="activity in registered">
        <td>{{ activity.displayDate }}</td>
        <td>{{ activity.name }}</td>
        <td>&euro;{{ activity.price }}</td>
        <td>{{ activity.totalRegistrations }} van de {{ activity.maxRegistrations }}</td>
        <td class="text-danger display-4" @click="unsubscribe(activity.id)">-</td>
      </tr>
      <tr v-if="registered.length === 0">
        <td colspan="5">Op dit moment sta je nergens voor ingeschreven.</td>
      </tr>
      <tr v-else>
        <td colspan="2">
          Totaal prijs:
        </td>
        <td colspan="3">
          €{{ totalPrice }}
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
import { format } from 'date-fns';

export default {
  name: 'ActivityTable',
  data: () => ({
    available: null,
    registered: null,
  }),
  computed: {
    totalPrice() {
      let price = 0;
      for (const el of this.registered) {
        price += parseFloat(el.price);
      }

      return price.toFixed(2);
    },
  },
  beforeMount() {
    axios.get('/api/user/activities').then((response) => {
      this.available = this.mapArray(response.data.available);
      this.registered = this.mapArray(response.data.registered);
      this.sortArray(this.available);
      this.sortArray(this.registered);
    });
  },
  methods: {
    mapArray(data) {
      return data.map((el) => {
        el.datetime = new Date(el.datetime);
        el.displayDate = format(el.datetime, "dd-MM-yyyy HH:mm:ss");
        return el;
      });
    },
    register(id) {
      const tmp = this.available.splice(this.available.findIndex((activity) => activity.id === id), 1)[0];
      this.$set(tmp, 'totalRegistrations', tmp.totalRegistrations + 1);
      this.registered.push(tmp);
      this.sortArray(this.registered);
      axios.post('/api/user/registrations/' + id);
    },
    unsubscribe(id) {
      const tmp = this.registered.splice(this.registered.findIndex((activity) => activity.id === id), 1)[0];
      this.$set(tmp, 'totalRegistrations', tmp.totalRegistrations - 1);
      this.available.push(tmp);
      this.sortArray(this.available);
      axios.delete('/api/user/registrations/' + id);
    },
    sortArray(array) {
      array.sort((a, b) => a.datetime - b.datetime);
    },
  },
};
</script>

<style scoped>

</style>
