function eventLoader(){
    showDetails();
    showBidBox();
    // handleSearchRequest();
}

// function handleSearchRequest() {
//     const form = document.getElementById('searchForm');

//     form.addEventListener('submit', function (event) {
//         event.preventDefault(); // Prevent the default form submission behavior

//         const formData = new FormData(form); // Create a FormData object from the form
//         const formDataObject = {};

//         // Convert the FormData object into a JavaScript object
//         formData.forEach(function (value, key) {
//             formDataObject[key] = value;
//         });

//         // Log the JavaScript object to the console
//         console.log(formDataObject);

//         if(formDataObject.search != ""){
//             callPostMethod(formDataObject, "/searchFiltered", "POST")
//             .then(() => {
//                 window.location.reload();
//             });
//         }
//     });
// }


function showDetails() {

    const viewDetailBtns = document.querySelectorAll('.info-button');
    const productDetailHolder = document.getElementsByClassName('product-Infos')[0];
    const productDetailsTable = document.querySelector('.Product-details-table table');
    const mainContainer = document.getElementsByClassName('main-page-contains')[0];
    const cross = document.getElementsByClassName('btn-cross')[0];

    viewDetailBtns.forEach((btn) => {
        btn.addEventListener('click', () => {

            const productId = btn.getAttribute('id');
            const product = productData.find((item) => item.product_id === parseInt(productId));

            if (product) {

                productDetailsTable.innerHTML = '';

                product.details.forEach((detail) => {
                    const row = createTableRow(detail);
                    productDetailsTable.appendChild(row);
                });

                const productDetailsContainer = document.querySelector('.product-Infos');
                productDetailsContainer.style.display = 'block';
            }
            mainContainer.className += " blure";
        });
    });

    cross.addEventListener('click', () => {
        productDetailHolder.style.display = 'none';
        mainContainer.className = "main-page-contains";
    });
}

function showBidBox() {
    const placeBidBtn = document.getElementsByClassName('buy-button');
    const bidHolder = document.getElementsByClassName('place-bid')[0];
    const cross = document.getElementsByClassName('btn-cross')[1];
    const mainContainer = document.getElementsByClassName('main-page-contains')[0];

    for (let i = 0; i < placeBidBtn.length; i++) {
        placeBidBtn[i].addEventListener('click', () => {
            // Receiving Id
            const productId = placeBidBtn[i].getAttribute('id');

            // Show form
            bidHolder.style.display = 'block';
            mainContainer.className += ' blure';

            // Store productId in a hidden input field within the form
            const productIdInput = document.createElement('input');
            productIdInput.type = 'hidden';
            productIdInput.name = 'productId';
            productIdInput.value = productId;
            bidContactForm.appendChild(productIdInput);
        });
    }

    cross.addEventListener('click', () => {
        bidHolder.style.display = 'none';
        mainContainer.className = 'main-page-contains';
    });

    // Form submission event listener
    const bidContactForm = document.getElementById('bidContactForm');
    bidContactForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevent form submission from reloading the page

        // Get form data
        const formData = new FormData(bidContactForm);

        // Convert form data to an object
        const formObject = {};
        formData.forEach((value, key) => {
            formObject[key] = value;
        });
        try {
            // Make the POST request
            await callPostMethod(formObject, "/insertCustomerBid", "POST");
            
            // Redirect after the POST request is successful
            window.location.href = "/pendingProduct";
        } catch (error) {
            console.error('Error:', error);
        }
    });
}


async function callPostMethod(requiredData, redirectURL, method){

    try {
    const response = await fetch(redirectURL, {
        
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(requiredData)
    });

    } 
    catch (error) {
        console.error('Error:', error);
    }
}

function createTableRow(detail) {
    const row = document.createElement('tr');
    const headingCell = document.createElement('td');
    const descriptionCell = document.createElement('td');

    headingCell.textContent = detail.heading;
    descriptionCell.textContent = detail.description;

    row.appendChild(headingCell);
    row.appendChild(descriptionCell);

    return row;
}


document.addEventListener('DOMContentLoaded', eventLoader);