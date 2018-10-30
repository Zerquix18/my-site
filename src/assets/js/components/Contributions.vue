<template>
  <div>
    <div v-if="contributions === null">
      Loading contributions...
    </div>
    <div  v-else-if="contributions.length === 0">
      No contributions found.
    </div>
    <div v-else>
      <div v-for="contribution in contributions" v-bind:key="contribution.url">
        <div class="card">
          <div class="card-content">
            <div class="media">
              <div class="media-left">
                <figure class="image is-48x48">
                  <img :src="contribution.avatar" alt="Placeholder image">
                </figure>
              </div>
              <div class="media-content">
                <p class="title is-4 has-text-black"></p>
                <p class="subtitle is-6 has-text-black">
                  <a :href="contribution.url" class="has-text-primary">
                    {{ contribution.title }}
                  </a>
                  <br>
                  <span class="tag is-info">
                    {{ contribution.type }}
                  </span>
                  <span class="tag is-warning">
                    {{ contribution.state }}                    
                  </span>
                </p>
              </div>
            </div>

            <div class="content">
              <p class="has-text-right">
                <time datetime="2016-1-1">{{ contribution.date }}</time>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      contributions: null,
    };
  },

  mounted: function () {
    this.loadContributions();
  },

  methods: {
    loadContributions: function () {
      fetch('contributions.php')
      .then((response) => {
        if (! response.ok) {
          console.log('omg this shouldnt happen');
          return;
        }
        return response.json();
      }).then((result) => {
        this.contributions = result;
      });
      console.log('Contributions loaded.');
    }
  }
}
</script>