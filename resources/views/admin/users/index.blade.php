<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        ::after,
        ::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
            overflow: hidden;
            transition: all 0.35s ease-in-out;
            background-color: #fff;
            min-width: 0;
        }


        .toggle-btn {
            background-color: transparent;
            cursor: pointer;
            border: 0;
            padding: 1rem 1.5rem;
        }

        .toggle-btn i {
            font-size: 1.5rem;
            color: #FFF;
        }



        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .sidebar-logo {
            margin: auto 0;
            padding: 20px 50px;
        }

        .sidebar-logo a {
            color: #FFF;
            font-size: 1.15rem;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 2rem 0;
            flex: 1 1 auto;
        }

        a.sidebar-link {
            padding: .625rem 1.625rem;
            color: #FFF;
            display: block;
            font-size: 0.9rem;
            white-space: nowrap;
            border-left: 3px solid transparent;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            margin-right: .75rem;
        }

        a.sidebar-link:hover {
            background-color: rgba(255, 255, 255, .075);
            border-left: 3px solid #3b7ddd;
        }

        .sidebar-item:hover .sidebar-dropdown {
            display: block;
            background-color: #0e2238;
            padding-left: 1.625rem;
        }

        .sidebar-footer {
            margin: 1rem 1.625rem;
        }

        .navbar {
            background-color: #f5f5f5;
            box-shadow: 0 0 2rem 0 rgba(33, 37, 41, .1);
        }

        .navbar-expand .navbar-collapse {
            min-width: 200px;
        }

        .avatar {
            height: 40px;
            width: 40px;
        }

        a {
            text-decoration: none;
            /* Ensure no underline on links */
        }

        @media (min-width: 768px) {}
    </style>
</head>

<body>
    <div class="main">
        @include('admin.layouts.partials.header')
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">

                    <div class="row">
                        <div class="col-12 col-md-4 ">
                            <div class="card border-0">
                                <div class="card-body py-4">
                                    <h5 class="mb-2 fw-bold">
                                        Memebers Progress
                                    </h5>
                                    <p class="mb-2 fw-bold">
                                        $72,540
                                    </p>
                                    <div class="mb-0">
                                        <span class="badge text-success me-2">
                                            +9.0%
                                        </span>
                                        <span class=" fw-bold">
                                            Since Last Month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 ">
                            <div class="card  border-0">
                                <div class="card-body py-4">
                                    <h5 class="mb-2 fw-bold">
                                        Memebers Progress
                                    </h5>
                                    <p class="mb-2 fw-bold">
                                        $72,540
                                    </p>
                                    <div class="mb-0">
                                        <span class="badge text-success me-2">
                                            +9.0%
                                        </span>
                                        <span class="fw-bold">
                                            Since Last Month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 ">
                            <div class="card border-0">
                                <div class="card-body py-4">
                                    <h5 class="mb-2 fw-bold">
                                        Memebers Progress
                                    </h5>
                                    <p class="mb-2 fw-bold">
                                        $72,540
                                    </p>
                                    <div class="mb-0">
                                        <span class="badge text-success me-2">
                                            +9.0%
                                        </span>
                                        <span class="fw-bold">
                                            Since Last Month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="fw-bold fs-4 my-3">Avg. Agent Earnings
                    </h3>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h1>Thêm mới bài viết</h1>
                            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
                                <i class="lni lni-arrow-left"></i> Back to Dashboard
                            </a>
                            <a class="btn btn-primary" href="{{ route('articles.create') }}">
                                <i class="lni lni-plus"></i>
                            </a>

                        </div>
                        <div class="col-12">
                        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th>Email</th>
                    <th>Role ID</th>
                    <th>Is Promoted</th>
                    <th>Violation Count</th>
                    <th>Banned Until</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>user1</td>
                    <td>0123456789</td>
                    <td><img src="image1.jpg" alt="User 1" style="width: 50px; height: 50px; border-radius: 50%;"></td>
                    <td>user1@example.com</td>
                    <td>2</td>
                    <td>Yes</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>2023-01-01 12:00:00</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Edit</button>
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>user2</td>
                    <td>0987654321</td>
                    <td><img src="image2.jpg" alt="User 2" style="width: 50px; height: 50px; border-radius: 50%;"></td>
                    <td>user2@example.com</td>
                    <td>1</td>
                    <td>No</td>
                    <td>1</td>
                    <td>2023-12-31</td>
                    <td>2023-01-05 14:30:00</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Edit</button>
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>user3</td>
                    <td>0912345678</td>
                    <td><img src="image3.jpg" alt="User 3" style="width: 50px; height: 50px; border-radius: 50%;"></td>
                    <td>user3@example.com</td>
                    <td>3</td>
                    <td>Yes</td>
                    <td>2</td>
                    <td>N/A</td>
                    <td>2023-01-10 09:15:00</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Edit</button>
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>
