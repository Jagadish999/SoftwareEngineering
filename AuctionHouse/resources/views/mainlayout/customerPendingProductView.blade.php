<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Pending Product</title>

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pendingProduct.css">

    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    @include('partials.navigation')
    <div class = "main-page-contains">

        <h1>Pending Products</h1>

        @if (count($allPendingProduct) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Category</th>
                    <th>Bid Amount</th>
                    <th>Status</th>
                    <th>Action</th> <!-- Add a new column for the delete button -->
                </tr>
            </thead>
            <tbody>
                @foreach ($allPendingProduct as $pendingProduct)
                    <tr>
                        <td><img src="{{ asset('/product/images/' . $pendingProduct['image']) }}" alt="{{ $pendingProduct['category_name'] }}"></td>
                        <td>{{ $pendingProduct['category_name'] }}</td>
                        <td>GBP {{ number_format($pendingProduct['userBidAmt'], 2) }}</td>
                        <td>{{ $pendingProduct['status'] }}</td>
                        <td>
                            <a href="#" id="{{ $pendingProduct['id'] }}" class="delete-button">
                                <i class="fas fa-trash"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @else
            <p>No pending products found.</p>
        @endif

        </div>


    </div>



    <script src = "/js/script.js"></script>

    <script>
        const data = @json($allPendingProduct);
        console.log(data);

        function deleteRequest(){
            const allDeleteBtns = document.getElementsByClassName('delete-button');

            for(let i = 0; i < allDeleteBtns.length; i++){
                allDeleteBtns[i].addEventListener('click', ()=>{

                    const customerBidId = allDeleteBtns[i].getAttribute('id');

                    callPostMethod({customerBidId: customerBidId}, "/deleteBid", "POST")
                    .then(() => {
                        window.location.reload();
                    });
                });
            }
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

        document.addEventListener('DOMContentLoaded', deleteRequest);
    </script>
</body>
</html>