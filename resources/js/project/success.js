// Stripe.js instance
const stripe = Stripe(publishable_key);

checkStatus();

// Fetches the payment intent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );

    if (!clientSecret) { return; }

    const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

    setPaymentDetails(paymentIntent);
}

function setPaymentDetails(intent) {
    var status = '';
    if (intent.status == "succeeded") {
        status = 'succeeded';
    } else if (intent.status == "processing") {
        status = 'processing';
    } else if (intent.status == "requires_payment_method") {
        status = 'requires_payment_method';
    }

    checkoutStatus(status, intent);
}

function setupUI(data){
    if (data.payment_status == 'succeeded'){
        $('#greeting').html('Thank You! 😇');
        $('#message').html('Your payment has beed placed! We will work on this shortly.');
    } else if(data.payment_status == 'processing'){
        $('#payment_status').html('Thank You! 😇');
        $('#message').html('Your payment in process! We will check and update soon.');
    } else if(data.payment_status == 'requires_payment_method'){
        $('#payment_status').html('Thank You! 😇');
        $('#message').html('Your payment will retured to you soon, You need to update your payment method in cashapp.');
        $('#mainDiv').hide();
    }

    $('#name').html(data.name);
    $('#phone').html(data.phone);
    $('#email').html(data.email);
    $('#platform').html(data.platform);
    $('#username').html(data.username);
    $('#amount').html(`$${data.amount}.00`);
    $('#payment_id').html(data.payment_id);
    $('#client_secret').html(data.client_secret);
    $('#updated_at').html(data.updated_at);
    $('#payment_status').html(data.payment_status);
}

async function checkoutStatus(status, intent) {
    const data  = await fetch(checkout_status_url, {
        method: "POST",
        headers: { "X-CSRF-Token": csrf_token, "Content-Type": "application/json" },
        body: JSON.stringify({ status: status, payment_id: intent.id, client_secret: intent.client_secret, payment_method_types: intent.payment_method_types[0] }),
    }).then((r) => r.json());

    setupUI(data);
}