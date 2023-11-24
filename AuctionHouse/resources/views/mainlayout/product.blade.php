<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>All Products</title>

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/productView.css">

    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>

    @include('partials.adminnavigation')

    <div class = "main-page-contains">
    
        <h1>All Product List Here</h1>
        
        <div>
            @if(count($result) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($result as $productName)
                        <tr>
                            <td>
                                <img src="/product/images/{{$productName['image_Name']}}" alt="image Here">
                            </td>
                            <td>
                                <h2>{{$productName['category_name']}}</h2>
                            </td>
                            <td>
                                <button class="status-toggle" id="{{$productName['id']}}">
                                    @if ($productName['status'] === 'Hide')
                                        <i class="fas fa-eye"></i> <!-- Eye icon for "Show" -->
                                        Show
                                    @else
                                        <i class="fas fa-archive"></i> <!-- Archive icon for "Archive" -->
                                        Archive
                                    @endif
                                </button>

                                <button class="delete-button" id="{{ $productName['id'] }}">
                                    <i class="fas fa-trash"></i> <!-- Trash icon for "Delete" -->
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            @else
                <h2>No Product data available</h2>
            @endif
        </div>
    </div>

    <script src = "/js/script.js"></script>
    <script>
        const data = @json($result);
        console.log(data);

        function hideProductAction(){
            const hideBtn = document.getElementsByClassName('status-toggle');
            const deleteBtn = document.getElementsByClassName('delete-button');

            for(let i = 0; i < hideBtn.length; i++){
                hideBtn[i].addEventListener('click', ()=>{
                    const productId = hideBtn[i].getAttribute('id');
                    callPostMethod({ id: productId }, '/updateProductStatus', 'POST')
                    .then(() => {
                        window.location.reload();
                    });
                });
            }

            for(let i = 0; i < deleteBtn.length; i++){
                deleteBtn[i].addEventListener('click', ()=>{
                    const productId = deleteBtn[i].getAttribute('id');
                    callPostMethod({ id: productId }, '/deleteProduct', 'POST')
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

        document.addEventListener('DOMContentLoaded', hideProductAction);
    </script>
    
</body>
</html>