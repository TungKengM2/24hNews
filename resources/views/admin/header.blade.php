<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Navbar</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand px-4 py-3 justify-content-center">
        <form action="#" class="d-none d-sm-inline-block me-auto">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="search">
                <button class="btn btn-primary" id="search" type="button">
                    <i class="">search</i>
                </button>
            </div>
        </form>

        <li class="nav-item dropdown ms-auto d-flex">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmL71aTMDWIHF3HD3VfThy3iT7vnbMt2w2jA&s"
                    width="50" height="50" alt="User Image" class="rounded-circle me-2">
            </a>
            <span class="d-block d-md-inline">
                Vu Luan<br>
                <span class="badge bg-success mt">Admin</span>
            </span>
            <ul class="dropdown-menu dropdown-menu-end text-center p-1" aria-labelledby="userDropdown">
                <li class="dropdown-item">
                    <a class="dropdown-item" href="#"><i class="lni lni-user"></i> Profile</a>
                </li>
                <li><a class="dropdown-item" href="#"><i class="lni lni-cog"></i> Setting</a></li>
            </ul>
        </li>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
