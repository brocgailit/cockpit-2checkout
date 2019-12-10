<?php

$app->on('cockpit.rest.init', function ($routes) {
  $routes['checkout'] = 'Checkout\\Controller\\CheckoutApi';
});