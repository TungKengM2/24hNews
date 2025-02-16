<!doctype html>
<html lang="en">

<head>
    <title>@yield('tieudetrang')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="client.css">
    <style>
        /* Reset styles */
        *, *::before, *::after {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }
    
        /* Body */
        body {
          font-family: Arial, sans-serif;
          line-height: 1.6;
          background-color: #f4f4f4;
          color: #333;
        }
    
        /* Container */
        .container {
          width: 90%;
          max-width: 1200px;
          margin: 0 auto;
          padding: 20px;
        }
    
        /* Header */
        .header {
          background-color: #333;
          color: #fff;
          padding: 20px 0;
        }
        .header .logo {
          text-align: center;
          font-size: 2rem;
          margin-bottom: 10px;
        }
        .nav ul {
          display: flex;
          flex-wrap: wrap;
          justify-content: center;
          gap: 15px;
        }
        .nav a {
          color: #fff;
          font-weight: bold;
          text-transform: uppercase;
          transition: color 0.3s ease;
        }
        .nav a:hover {
          color: #ff6347;
        }
    
        /* Main Content */
        .main-content {
          margin: 20px 0;
          display: flex;
          flex-wrap: wrap;
          gap: 20px;
        }
        /* Featured Article */
        .featured-article {
          flex: 1 1 100%;
          background-color: #fff;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .featured-article img {
          width: 100%;
          border-radius: 10px;
          margin-bottom: 15px;
        }
        .featured-article .article-title {
          font-size: 1.8rem;
          margin-bottom: 10px;
        }
        .featured-article .article-summary {
          font-size: 1rem;
          margin-bottom: 15px;
        }
        .featured-article .read-more {
          display: inline-block;
          background-color: #333;
          color: #fff;
          padding: 10px 20px;
          border-radius: 5px;
          text-decoration: none;
          transition: background-color 0.3s ease;
        }
        .featured-article .read-more:hover {
          background-color: #ff6347;
        }
    
        /* Sidebar (Danh mục tin tức) */
        .sidebar {
          flex: 1 1 300px;
        }
        .category {
          background-color: #fff;
          padding: 20px;
          border-radius: 10px;
          margin-bottom: 20px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          text-align: center;
        }
        .category .category-title {
          font-size: 1.4rem;
          margin-bottom: 10px;
        }
        .category .category-summary {
          font-size: 1rem;
        }
    
        /* Latest Articles */
        .latest-articles {
          flex: 2 1 600px;
        }
        .latest-articles .articles-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
          gap: 20px;
        }
        .latest-articles .article {
          background-color: #fff;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .latest-articles .article img {
          width: 100%;
          border-radius: 10px;
          margin-bottom: 15px;
        }
        .latest-articles .article-title {
          font-size: 1.2rem;
          margin-bottom: 10px;
        }
        .latest-articles .article-summary {
          font-size: 0.9rem;
          margin-bottom: 15px;
        }
        .latest-articles .read-more {
          display: inline-block;
          background-color: #333;
          color: #fff;
          padding: 8px 15px;
          border-radius: 5px;
          text-decoration: none;
          transition: background-color 0.3s ease;
        }
        .latest-articles .read-more:hover {
          background-color: #ff6347;
        }
    
        /* Footer */
        .footer {
          background-color: #333;
          color: #fff;
          text-align: center;
          padding: 20px 0;
          margin-top: 40px;
        }
    
        /* Responsive adjustments */
        @media (max-width: 768px) {
          .main-content {
            flex-direction: column;
          }
        }
      </style>
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        @include('client.layouts.header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('client.layouts.footer')
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>