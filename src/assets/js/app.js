/**
 * Heeey
 */

import '../scss/app.sass';
import Vue from 'vue';
import Contributions from './components/Contributions.vue';

new Vue({
  el: "#contributions",
  render: h => h(Contributions)
});


document.addEventListener('DOMContentLoaded', () => {
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
  if ($navbarBurgers.length > 0) {
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {
        const target = el.dataset.target;
        const $target = document.getElementById(target);
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');
      });
    });
  }
});
