<template>
  <div>
    <h4>Er zijn 6 soorten activiteiten</h4>
    <div class="accordion" role="tablist" v-if="activities">
      <b-card no-body class="mb-1" v-for="(activity, key) in activities" :key="key">
        <b-card-header header-tag="header" class="p-1" role="tab">
          <b-button block v-b-toggle="'accordion-' + activity.id" variant="light">{{ activity.name }}</b-button>
        </b-card-header>
        <b-collapse :id="'accordion-' + activity.id" :visible="key === 0" accordion="my-accordion" role="tabpanel">
          <b-card-body>
            <b-card-text>
              <div>Beschrijving: {{ activity.description === null ? '-' : activity.description }}</div>
              <div>Prijs: &euro;{{ activity.price }}</div>
              <div>Tijdsduur: {{ activity.duration }} minuten</div>
              <div>Minimum leeftijd: {{ activity.minAge }} jaar</div>
            </b-card-text>
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>
    <p>Let op, voor het karten zijn dichte schoenen verplicht. Karten met een korte broek is niet toegestaan. Wij hebben overalls ter beschikking, maar probeer indien mogelijk een lange broek aan te doen of mee te nemen.</p>
    <div class="d-flex">
      <img class="w-25 mx-auto" src="img/kart.jpg" alt="kart"/>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'theActivities',
  data: () => ({
    activities: null,
    text: 'test text'
  }),
  beforeMount() {
    axios.get('/api/activities').then(response => this.activities = response.data);
  }
};
</script>
