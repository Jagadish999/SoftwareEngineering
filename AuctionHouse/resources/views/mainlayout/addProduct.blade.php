<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/addProduct.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

    @include('partials.adminnavigation')

    <div class = "main-page-contains">
        <h1>Choose Category To Add product</h1>

        <div>
            @if(count($allCategoryNames) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Add Product</th>
                            <th>Delete Category</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($allCategoryNames as $categoryId => $categoryName)
                        <tr>
                            <td>
                                <span class="category-button">{{ $categoryName }}</span>
                            </td>
                            <td>
                                <a href="/addProduct/{{ $categoryName }}" class="add-product-button">
                                    <i class="fas fa-plus"></i> Add Product
                                </a>
                            </td>
                            <td>
                                <a href="#" class="delete-button"  id="{{ $categoryId }}">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @else
                <h2>No category data available</h2>
            @endif
        </div>
    </div>

    <script src = "/js/script.js"></script>

    <script>
        const data = @json($allCategoryNames);
        console.log(data);

        function deleteFunctionLoader(){
            const deleteBtn = document.getElementsByClassName('delete-button');

            for(let i = 0; i < deleteBtn.length; i++){
                deleteBtn[i].addEventListener('click', ()=>{
                    const categoryId = deleteBtn[i].getAttribute('id');
                    console.log('Category ID:', categoryId);

                    callPostMethod({categoryId: categoryId}, '/deleteCategory', "POST")                    
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

        document.addEventListener('DOMContentLoaded', deleteFunctionLoader);
    </script>
</body>
</html>