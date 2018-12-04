
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});

$('#purchase-form').each(function () {
    let $this = $(this);
    let $stripeScript = $('<script>');

    $stripeScript.attr('class', 'stripe-button');
    $stripeScript.attr('src', 'https://checkout.stripe.com/checkout.js');
    $stripeScript.attr('data-key', $this.data('stripeKey'));
    $stripeScript.attr('data-amount', $this.data('stripeAmount'));
    // todo: support for multiple currencies
    $stripeScript.attr('data-currency', 'usd');
    $stripeScript.attr('data-name', $this.data('stripeName'));
    $stripeScript.attr('data-description', $this.data('stripeDescription'));
    // todo: Support for custom stripe image
    $stripeScript.attr('data-image', 'https://stripe.com/img/documentation/checkout/marketplace.png');
    $stripeScript.attr('data-locale', 'auto');

    $this.append($stripeScript);
});


$('[title]').tooltip();