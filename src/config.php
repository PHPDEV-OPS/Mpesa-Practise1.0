<?php
// src/config.php

// M-Pesa API Configuration
define('MPESA_CONSUMER_KEY', 'VWFAehd4yqXSB4xOhet1RhYtKT9ojWUXzHa4iUPlqeyydoo3');  // Replace with your sandbox consumer key
define('MPESA_CONSUMER_SECRET', 'X1ii2dNFAJthDAXoEQ6eg4VuRtd62Tz3qAPDqlmABKbqr76CzYsPVk0rbj6jSTIu');  // Replace with your sandbox consumer secret
define('MPESA_PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919');  // Sandbox passkey
define('MPESA_SHORTCODE', '174379');  // Sandbox shortcode
define('MPESA_ENV', 'sandbox');  // Environment: sandbox or production
define('MPESA_BASE_URL', 'https://sandbox.safaricom.co.ke');  // Sandbox base URL


// Local testing configuration
define('LOCAL_TEST_MODE', true);
define('AUTO_COMPLETE_TIMEOUT', 120); // seconds
