<?php
include('connect.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Delayed Loader</title>
    <style>
        /* Loader styling */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #f4f6f5; /* Semi-transparent background */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        /* Hidden content initially */
        .content {
            display: none;
            text-align: center;
            margin-top: 20%;
            font-family: Arial, sans-serif;
        }

        /* Styling for content after loading */
        body.loaded #loader {
            display: none;
        }

        .visible {
            display: block;
        }

        h1 {
            font-size: 2.5rem;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div id="loader">
        <img src="images/loader.gif" alt="Loading..." style="width: 500px; height: 500px;">
    </div>

    <!-- Main Content -->
    

    <script>
        // Simulate a delay in page load
        window.addEventListener("load", () => {
            setTimeout(() => {
                document.body.classList.add("loaded");
                document.querySelector(".content").classList.add("visible");
            }, 2200); // 3000ms = 3 seconds
        });
    </script>
</body>
</html>
