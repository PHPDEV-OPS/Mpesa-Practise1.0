<?php
require_once('../src/config.php');
require_once('../src/mpesa.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $plan = $_POST['plan'] ?? '';
    
    try {
        $mpesa = new MpesaIntegration();
        $response = $mpesa->initiateSTKPush($phone, $amount, $plan);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'STK push sent successfully']);
        exit;
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Development Services - Pricing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/payment.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-center mb-12">Our Web Development Services</h1>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Basic Plan -->
            <div class="pricing-card">
                <h2 class="text-2xl font-semibold text-center mb-4">Basic</h2>
                <p class="text-4xl font-bold text-center mb-6">KSH 100</p>
                <ul class="mb-8 space-y-4">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                        </svg>
                        Basic Website Development
                    </li>
                </ul>
                <div class="space-y-4">
                    <input type="tel" class="phone-input w-full px-4 py-2 border rounded" placeholder="254XXXXXXXXX" data-plan="basic" data-amount="100">
                    <button class="buy-btn w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600" data-plan="basic">
                        Buy Now
                    </button>
                </div>
            </div>

            <!-- Standard Plan -->
            <div class="pricing-card transform scale-105 border-2 border-blue-500">
                <h2 class="text-2xl font-semibold text-center mb-4">Standard</h2>
                <p class="text-4xl font-bold text-center mb-6">KSH 200</p>
                <ul class="mb-8 space-y-4">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                        </svg>
                        Advanced Website Features
                    </li>
                </ul>
                <div class="space-y-4">
                    <input type="tel" class="phone-input w-full px-4 py-2 border rounded" placeholder="254XXXXXXXXX" data-plan="standard" data-amount="200">
                    <button class="buy-btn w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600" data-plan="standard">
                        Buy Now
                    </button>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="pricing-card">
                <h2 class="text-2xl font-semibold text-center mb-4">Premium</h2>
                <p class="text-4xl font-bold text-center mb-6">KSH 300</p>
                <ul class="mb-8 space-y-4">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                        </svg>
                        Premium Website Solutions
                    </li>
                </ul>
                <div class="space-y-4">
                    <input type="tel" class="phone-input w-full px-4 py-2 border rounded" placeholder="254XXXXXXXXX" data-plan="premium" data-amount="300">
                    <button class="buy-btn w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600" data-plan="premium">
                        Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.buy-btn').click(function() {
                const plan = $(this).data('plan');
                const amount = $(this).parent().find('.phone-input').data('amount');
                const phone = $(this).parent().find('.phone-input').val();

                if (!phone.match(/^254[0-9]{9}$/)) {
                    alert('Please enter a valid phone number starting with 254');
                    return;
                }

                $.ajax({
                    url: 'index.php',
                    method: 'POST',
                    data: {
                        phone: phone,
                        amount: amount,
                        plan: plan
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Payment request sent! Please check your phone to complete the payment.');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>