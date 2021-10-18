import {loadStripe} from '@stripe/stripe-js';

(async function() {
    'use strict';


    const stripe = await loadStripe(process.env.MIX_STRIPE_KEY);

    Array.prototype.forEach.call(
        document.querySelectorAll(
            "[data-checkout]"
        ),
        function (input) {
            input.addEventListener("click", function (event) {
                event.preventDefault();
                axios.post(input.getAttribute('data-checkout'))
                    .then(response => stripe.redirectToCheckout({ sessionId: response.data.id }))
                    .catch(function (error) {
                        console.error(error);
                    })
                    .then(result => {
                        if (result.error) {
                            alert(result.error.message);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    );

})();
