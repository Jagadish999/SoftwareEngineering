<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/customerProduct.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <title>Buy Product</title>
    <script src = "/js/customerProductView.js"></script>
</head>
<body>
    @include('partials.navigation')

    <div class = "main-page-contains">
        <div class="search-area">
            <!-- Search Form with Select -->
            <form method="GET" action="{{ route('search.results') }}">
                @csrf
                <div class="search-input">
                    <input type="text" name="search" placeholder="Search...">
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="filter-select">
                    <label for="filter">Select Category: </label>
                    <select name="filter" id="filter">
                        <option value="all">All</option>
                        @foreach ($allCategory as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>



        <div class="product-list">
            @if (count($result) > 0)
                <!-- Product Cards -->
                @foreach ($result as $product)
                    <div class="product-card">
                        <img src="{{ asset('/product/images/' . $product['image_Name']) }}" alt="{{ $product['category_name'] }}">
                        <h3>Category: {{ $product['category_name'] }}</h3>
                        <div class="buttons">
                            <button class="buy-button" id="{{ $product['id'] }}">
                                <i class="fas fa-shopping-cart"></i> Place Bid
                            </button>
                            <button class="info-button" id="{{ $product['id'] }}">
                                <i class="fas fa-info-circle"></i> View Details
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>No products available.</h2>
            @endif
        </div>
    </div>

    <!-- Custom Alert Dialog for color selection -->
    <div class="product-Infos">
        <div class="product-details-container">
            <div class="cross-holder">
                <span class="btn-cross">&times;</span>
            </div>
            <div class="Product-details-table">
                <table>

                </table>
            </div>
        </div>
    </div>

    <div class="place-bid">
        
        <!-- Bid and Contact Form -->
        <form id="bidContactForm" action="" method="post">
            
        
            <!-- Cross Sign -->
            <div class="cross-holder">
                <span class="btn-cross">&times;</span>
            </div>

            <!-- Customer Bid Form -->
            <div class="bid-form">
                <h2>Place Your Bid</h2>
                <input type="number" id="bidAmount" name="bidAmount" placeholder="Enter your bid amount" required>
            </div>

            <!-- Contact Details Form -->
            <div class="contact-form">
                <h2>Contact Details</h2>
                <input type="text" id="name" name="name" placeholder="Your Name" required>
                <input type="email" id="email" name="email" placeholder="Your Email" required>
                <input type="tel" id="phone" name="phone" placeholder="Your Phone Number" required>
                <textarea id="message" name="message" placeholder="Your Message" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit">Submit</button>
        </form>
    </div>


    <script src = "/js/script.js"></script>

    <script>
        const data = @json($result);
        const productData = @json($productDetails);
        const catData = @json($allCategory);

        console.log(data);
        console.log(productData);
        console.log(catData);
    </script>
</body>
</html>