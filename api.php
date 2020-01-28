<?php

$app->on('cockpit.rest.init', function ($routes) {
  $routes['checkout'] = 'TwoCheckout\\Controller\\TwoCheckoutApi';
});