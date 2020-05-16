$(document).ready(() => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
})

const amount = document.querySelector('#amount');
const amountError = document.querySelector('#amount-error');
const purpose = document.querySelector('#purpose');
const purposeError = document.querySelector('#purpose-error');
const inlinePayButton = document.querySelector('#pay-inline');

let compareLesserCheck = (value, length) => {
    let response;
    value < length ? response = true : response = false;
    return response;
};

let checkValue = (value, min, field, boolean) => {
    let lesserValue = compareLesserCheck(value, min);
    if (lesserValue && boolean == 1) {
        field.innerHTML = `Value must start from ${min}`;
        return false;
    }
    else if (lesserValue && boolean == 0) {
        return false;
    }
    else {
        field.innerHTML = '';
        return true;
    }
};

let checkLength = (value, length, field, boolean) => {
    let lesserValue = compareLesserCheck(value.length, length);
    if (lesserValue && boolean == 1) {
        field.innerHTML = `Length must be above ${length - 1}`;
        return false;
    }
    else if (lesserValue && boolean == 0) {
        return false;
    }
    else {
        field.innerHTML = '';
        return true;
    }
};

let validationListener = () => {
    inlinePayButton.setAttribute('disabled', 'true');
    amount.addEventListener('input', () => {
        checkValue(amount.value, 100, amountError, 1)
    });
    purpose.addEventListener('input', () => {
        checkLength(purpose.value, 5, purposeError, 1)
    });
    document.addEventListener('input', checkValidation)
};

let checkValidation = () => {
    let amountValidation = checkValue(amount.value, 100, amountError, 0);
    let purposeValidation = checkLength(purpose.value, 5, purposeError, 0);
    if (amountValidation && purposeValidation) {
        inlinePayButton.removeAttribute('disabled');
    }
    else {
        inlinePayButton.setAttribute('disabled', 'true');
    }
}

validationListener();

let payWithPaystack = () => {
    inlinePayButton.setAttribute('disabled', 'true');
	let formData = {
        email:	email,
		amount: amount.value * 100
	};

	var handler = PaystackPop.setup({
		key: key,
		email: formData.email,
		amount: formData.amount,
		currency: "NGN",
		//ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
		metadata: {
			custom_fields: [
				{
					display_name: "Mobile Number",
					variable_name: "mobile_number",
					value: 12345
				}
			]
		},
		callback: function(response){
            console.log('yes', response);
            inlinePayButton.innerHTML = "Processing...";
			if (response.status == 'success' & response.message == 'Approved') {
				formData.reference = response.reference;
				formData.trans = response.trans;
				$.post(payUrl, formData, (data, status) => {
                    console.log(data);
                    window.location.reload();
				}).catch(err => {
					console.log(err);
				});
			}
		},
		onClose: function(){
			alert('window closed');
		}
	});
	handler.openIframe();
}
