<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/addProduct.css">
    <link rel="stylesheet" href="/css/addProductDetails.css">
    
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>


    @include('partials.adminnavigation')

    <div class = "main-page-contains">
        <h1>Add Product For {{$productCategory}}</h1>


        <form action="{{ route('submitProduct') }}" method="POST" id="productForm">
            @csrf
            <input type="hidden" name="productCategory" value="{{ $productCategory }}">
            
            @foreach($propertyDetails as $property)
                <div class="form-group">
                    <label for="{{ $property['name'] }}">{{ $property['name'] }}:</label>
                    @if ($property['datatype'] === 'number')
                        <input type="number" name="{{ $property['name'] }}" id="{{ $property['name'] }}" class="form-control" required>
                    @elseif ($property['datatype'] === 'text')
                        <input type="text" name="{{ $property['name'] }}" id="{{ $property['name'] }}" class="form-control" required>
                    @elseif ($property['datatype'] === 'largeText')
                        <textarea name="{{ $property['name'] }}" id="{{ $property['name'] }}" class="form-control" rows="4" required></textarea>
                    @endif
                </div>
            @endforeach

            <!-- Permanent "Add Image" input field -->
            <div class="form-group">
                <label for="image">Add Image:</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>

            <button type="submit" class="submit-button">Submit</button>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                var form = document.getElementById('productForm');

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    var formData = new FormData(form);
                    var csrfToken = form.querySelector('input[name="_token"]').value;

                    fetch("/submit-product", {
                        method: "POST",
                        body: formData, 
                        headers: {

                            "X-CSRF-TOKEN": csrfToken
                        }
                    })
                    .then(response => {
                        if (response.ok) {

                            window.location.href = "{{ route('addproductView') }}";
                        } else {
                        
                            console.error("Error submitting data:", response.status);
                        }
                    })
                    .catch(error => {

                        console.error("Network error:", error);
                    });
                });
            });
        </script>

    </div>

    <script src = "/js/script.js"></script>
</body>
</html>