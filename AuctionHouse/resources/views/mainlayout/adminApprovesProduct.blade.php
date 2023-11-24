<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/adminApprovesProduct.css">

    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

    @include('partials.adminnavigation')

    <div class = "main-page-contains">

        <h1>All Product Request To Apprope</h1>

        @if (count($highestBids) > 0)

            <table class="table">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Highest Bid</th>
                        <th>Customer Details</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($highestBids as $customerBid)
                        <tr>
                            <td>
                                <img src="{{ asset('/product/images/' . $customerBid->productImage) }}" alt="Product Image">
                            </td>
                            <td>GBP {{ number_format($customerBid->userBidAmt, 2) }}</td>
                            <td>
                                <ul>
                                    <li>Email: {{ $customerBid->userEmail }}</li>
                                    <li>Message: {{ $customerBid->userMessage }}</li>
                                    <li>Phone: {{ $customerBid->userPhone }}</li>
                                </ul>
                            </td>
                            <td>{{ $customerBid->status }}</td>
                            <td>
                                <button class="btn-approve" id="{{ $customerBid->id }}">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button class="btn-reject" id="{{ $customerBid->id }}">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <p>No customer bids available.</p>
        @endif

    </div>

    <script src = "/js/script.js"></script>

    <script>
        const data = @json($highestBids);
        console.log(data);

        //_______________________________________________
        function buttonEvents(){
            const approveBtn = document.getElementsByClassName('btn-approve');
            const rejectBtn = document.getElementsByClassName('btn-reject');


            for(let i = 0; i < approveBtn.length; i++){
                approveBtn[i].addEventListener('click', ()=>{

                    const categoryId = approveBtn[i].getAttribute('id');

                    callPostMethod({ categoryId: categoryId, status: "Approved" }, '/updateBiddingStatus', 'POST')
                    .then(() => {
                        window.location.reload();
                    });
                });
            }

            for(let i = 0; i < rejectBtn.length; i++){
                rejectBtn[i].addEventListener('click', ()=>{

                    const categoryId = approveBtn[i].getAttribute('id');

                    callPostMethod({ categoryId: categoryId, status: "Rejected" }, '/updateBiddingStatus', 'POST')
                    .then(() => {
                        window.location.reload();
                    });
                });   
            }
        }
        //_______________________________________________

        document.addEventListener('DOMContentLoaded', buttonEvents);

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
    </script>
</body>
</html>