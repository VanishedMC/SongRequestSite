window._ = require('lodash');
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) { }

window.User = JSON.parse(document.querySelector('meta[name=user]').content);

window.axios = require('axios');
