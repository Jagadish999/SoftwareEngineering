<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Approved Product</title>

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pendingProduct.css">


    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    @include('partials.navigation')
    <div class = "main-page-contains">

        <h1>Approved Products</h1>

        @if (count($allPendingProduct) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Category</th>
                    <th>Bid Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allPendingProduct as $pendingProduct)
                    <tr>
                        <td><img src="{{ asset('/product/images/' . $pendingProduct['image']) }}" alt="{{ $pendingProduct['category_name'] }}"></td>
                        <td>{{ $pendingProduct['category_name'] }}</td>
                        <td>GBP {{ number_format($pendingProduct['userBidAmt'], 2) }}</td>
                        <td  style="color: green;">{{ $pendingProduct['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @else
            <p>No Approved products found.</p>
        @endif

        </div>

    </div>

    <script src = "/js/script.js"></script>

    <script>
        const data = @json($allPendingProduct);
        console.log(data);
    </script>
</body>
</html>