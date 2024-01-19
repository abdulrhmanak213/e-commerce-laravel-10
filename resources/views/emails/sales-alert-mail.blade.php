<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azalea Store</title>
    <style>
        /* Reset some default email styles */
        body, p {
            margin: 0;
            padding: 0;
        }

        /* Styles for the entire email container */
        .email-container {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8f8f8;
            text-align: center;
            padding: 20px;
        }

        /* Heading style */
        .heading {
            font-size: 28px;
            font-weight: bold;
            color: #000000; /* Beige color */
            margin: 20px 0;
        }

        /* Sale banner */
        .sale-banner {
            background-image: url('https://example.com/sale-banner.jpg');
            background-size: cover;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Sale banner text */
        .sale-banner-text {
            color: #e4b078;
            font-size: 24px;
            padding: 20px;
        }

        .categories {
            color: #000000;
            font-size: 18px;
            padding: 20px;
        }

        /* Call to action button */
        .cta-button {
            background-color: #e4b078; /* Beige color */
            color: #000; /* Black color */
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
            display: inline-block;
        }

        /* Footer */
        .footer {
            background-color: #000; /* Black color */
            color: #fff;
            padding: 10px 0;
        }

        /* Center content on small screens */
        @media (max-width: 600px) {
            .email-container {
                text-align: center !important;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <h1 class="heading">New Sales On Our Store!</h1>
    <div class="sale-banner">
        <p class="sale-banner-text">Discover amazing deals at our store. Up to {{$sale_value}}% off on these
            categories:</p>
        <ul>
            @foreach ($categories as $category)
                <p class="categories"> {{ $category->title }}</p>
            @endforeach
        </ul>
    </div>
    <a href="https://example.com/sale" class="cta-button">Shop Now</a>
    <p class="footer">Copyright © {{$year}} Azalea. All rights reserved.</p>
</div>
</body>
</html>
