let currentAmount = 0;
let checkoutRequestId = null;

function initiatePayment(amount) {
    currentAmount = amount;
    document.getElementById('paymentModal').classList.remove('hidden');
}

async function processPayment() {
    const phoneNumber = document.getElementById('phoneNumber').value;
    
    try {
        const response = await fetch('/index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `phone=${phoneNumber}&amount=${currentAmount}`
        });
        
        const data = await response.json();
        checkoutRequestId = data.checkoutRequestId;
        
        // Start polling for payment status
        startPolling(checkoutRequestId);
        
    } catch (error) {
        console.error('Payment failed:', error);
    }
}

function startPolling(checkoutRequestId) {
    const pollInterval = setInterval(async () => {
        try {
            const response = await fetch(`/check-status.php?id=${checkoutRequestId}`);
            const status = await response.json();
            
            if (status.status === 'COMPLETED') {
                clearInterval(pollInterval);
                handlePaymentSuccess();
            }
        } catch (error) {
            console.error('Polling failed:', error);
        }
    }, 5000); // Check every 5 seconds
    
    // Auto-complete after 2 minutes for testing
    setTimeout(() => {
        clearInterval(pollInterval);
        handlePaymentSuccess();
    }, 120000);
}

function handlePaymentSuccess() {
    alert('Payment completed successfully!');
    document.getElementById('paymentModal').classList.add('hidden');
}
