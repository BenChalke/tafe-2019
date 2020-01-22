$(document).ready(function(){
    $('.home-slider').bxSlider({
        mode: 'horizontal',
        auto: true,
        autoControls: false,
        stopAutoOnClick: false,
        pager: false,
        controls: false,
        pause: 6000,
        speed: 3000,
    });
});

function activateMobileMenu() {
    var mobileMenu = document.getElementById("mobile-menu-nav");

    if (mobileMenu.style.display === "block") {
        mobileMenu.style.display = "none";
    } else {
        mobileMenu.style.display = "block";
    }
}

function confirmDelete() {
    let confirmed = false;
    if (confirmed) {
        return true;
    }
    else {
        // element.attachEvent('onsubmit', function(e){
        //     e.preventDefault();
        // });

        return false;
    }
}

const removeCategoryForms = document.querySelectorAll('.remove-category-form');

for (let removeCategoryForm of removeCategoryForms) {
    removeCategoryForm.addEventListener('submit', (e)=>{
        if (!confirm('DELETE???')) {
            e.preventDefault();
        }
    });
}

const checkoutForm = document.querySelector('#checkoutForm');

if(checkoutForm) {

    checkoutForm.addEventListener("submit", function(e) { 
        console.log("this form has been submitted"); 
        
        const firstName = document.querySelector('#first-name').value;
        const lastName = document.querySelector('#last-name').value;
        const email = document.querySelector('#email').value;
        const phone = document.querySelector('#phone').value;
        const streetName = document.querySelector('#street-name').value;
        const suburb = document.querySelector('#suburb').value;
        const state = document.querySelector('#state').value;
        const postcode = document.querySelector('#postcode').value;
        const cardName = document.querySelector('#card-name').value;
        const cardNumber = document.querySelector('#card-number').value;
        const cardExpiry = document.querySelector('#card-expiry').value;

        console.log('firstname', firstName);
        console.log('lastname', lastName);
        console.log('email', email);
        console.log('phone', phone);
        console.log('streetName', streetName);
        console.log('suburb', suburb);
        console.log('state', state);
        console.log('postcode', postcode);
        console.log('cardName', cardName);
        console.log('cardNumber', cardNumber);
        console.log('cardExpiry', cardExpiry);

        const hasNumber = /\d/;

        if(firstName === '' || hasNumber.test(firstName)) {
            document.querySelector('#error-message').innerHTML="Your first name is invalid";
            e.preventDefault();
            return;
        }
        if(lastName === '' || hasNumber.test(lastName)) {
            document.querySelector('#error-message').innerHTML="Your last name is invalid";
            e.preventDefault();
            return;
        }

        const emailValid = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if(email === '' || !email.match(emailValid)) {
            document.querySelector('#error-message').innerHTML="Your email is invalid";
            e.preventDefault();
            return;
        }

        const phoneValid = /04[\d]{8}/g;

        if(phone === '' || !phone.match(phoneValid)) {
            document.querySelector('#error-message').innerHTML="Your phone number is invalid";
            e.preventDefault();
            return;
        }

        if(streetName === '') {
            document.querySelector('#error-message').innerHTML="Please enter your street name";
            e.preventDefault();
            return;
        }

        if(suburb === '') {
            document.querySelector('#error-message').innerHTML="Please enter your suburb";
            e.preventDefault();
            return;
        }

        if(state === '') {
            document.querySelector('#error-message').innerHTML="Please enter your state";
            e.preventDefault();
            return;
        }

        if(postcode === '') {
            document.querySelector('#error-message').innerHTML="Please enter your postcode";
            e.preventDefault();
            return;
        }

        if(cardName === '') {
            document.querySelector('#error-message').innerHTML="Please enter your card name";
            e.preventDefault();
            return;
        }

        if(cardNumber === '') {
            document.querySelector('#error-message').innerHTML="Please enter your card number";
            e.preventDefault();
            return;
        }

        if(cardExpiry === '') {
            document.querySelector('#error-message').innerHTML="Please enter your card expiry";
            e.preventDefault();
            return;
        }
    });
}
