<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temu App - Admin Dashboard</title>
    <style>
    
        body {
            font-family: "Inter", sans-serif;
            background-color: #f3f4f6; /* Light gray background */
            color: #333; /* Dark text color */
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%; 
            box-sizing: border-box; 
        }

      
        .header {
            background-color: #dc2626; /* Red-600 */
            color: #fff;
            padding: 1rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap; 
        }

        .header-title {
            font-size: 2.25rem; 
            font-weight: 700;
            margin-bottom: 0;
        }

        .main-content {
            flex-grow: 1; 
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .section-title {
            font-size: 2.5rem; 
            font-weight: 800; 
            color: #1f2937; 
            margin-bottom: 2rem;
            text-align: center;
        }

        .section-description {
            font-size: 1.125rem; 
            color: #4b5563; 
            margin-bottom: 3rem;
            text-align: center;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .card {
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.5rem; 
            font-weight: 600; 
            color: #374151; 
            margin-bottom: 1rem;
        }

        .card-description {
            color: #4b5563; 
            margin-bottom: 1.5rem;
            flex-grow: 1; 
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem; 
            font-weight: 600; 
            text-align: center;
            text-decoration: none; 
            transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
            border: none; 
            cursor: pointer;
        }

        .btn-primary {
            background-color: #ef4444; 
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #dc2626; 
            transform: translateY(-1px);
        }
       
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            .header-title {
                margin-bottom: 1rem;
            }
            .nav-list {
                flex-direction: column;
                gap: 0.5rem;
            }
            .nav-link {
                width: 100%;
                text-align: center;
            }
            .section-title {
                font-size: 2rem;
            }
            .section-description {
                font-size: 1rem;
            }
            .card-grid {
                grid-template-columns: 1fr; 
            }
        }
    </style>
</head>
<body>
    
    <header class="header">
        <div class="container header-content">
            <h1 class="header-title">Temu App Dashboard</h1>
        </div>
    </header>
    
    <main class="main-content container">
        <h2 class="section-title">Manage Your E-commerce Data</h2>
        <p class="section-description">
            Welcome to the Temu App Admin Dashboard. Use the navigation above or the cards below to manage users, products, orders, reviews, and phone numbers.
        </p>

        <div class="card-grid">
            <div class="card">
                <h3 class="card-title">Users</h3>
                <p class="card-description">Manage user accounts, view details, and update information.</p>
                <a href="./user/read.php" class="btn btn-primary">Go to Users</a>
            </div>
            <div class="card">
                <h3 class="card-title">Products</h3>
                <p class="card-description">Add, edit, or remove products from your inventory.</p>
                <a href="./product/read.php" class="btn btn-primary">Go to Products</a>
            </div>
            <div class="card">
                <h3 class="card-title">Orders</h3>
                <p class="card-description">View and manage customer orders, update order status.</p>
                <a href="./order/read.php" class="btn btn-primary">Go to Orders</a>
            </div>

         
            <div class="card">
                <h3 class="card-title">Order Items</h3>
                <p class="card-description">Manage individual items within customer orders.</p>
                <a href="./orderitem/read.php" class="btn btn-primary">Go to Order Items</a>
            </div>

            <div class="card">
                <h3 class="card-title">Reviews</h3>
                <p class="card-description">Monitor and moderate product reviews from users.</p>
                <a href="./review/read.php" class="btn btn-primary">Go to Reviews</a>
            </div>

            <div class="card">
                <h3 class="card-title">Phones</h3>
                <p class="card-description">Manage phone numbers associated with user accounts.</p>
                <a href="./phone/read.php" class="btn btn-primary">Go to Phones</a>
            </div>
        </div>
    </main>

</body>
</html>
