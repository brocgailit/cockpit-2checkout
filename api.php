<?php

$app->on('cockpit.rest.init', function ($routes) {
  $routes['2checkout'] = 'TwoCheckout\\Controller\\TwoCheckoutApi';
});