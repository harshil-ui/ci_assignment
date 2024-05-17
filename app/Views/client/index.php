<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <title>CI_assignment</title>

    <style>
        .pagination a {
            margin-right: 5px;
        }

        .search-container {
            margin: 5px 0;
            float: right;
            width: 30%;
        }
    </style>
</head>

<body>
    <?php if (session()->get('isLoggedIn')) { ?>
        <a href="<?= site_url('logout') ?>">Logout</a>
    <?php } else { ?>
        <a href="<?= site_url('login') ?>">Login</a>
        <a href="<?= site_url('register') ?>">Register</a>
    <?php } ?>

    <div class="search-container">
        <form class="form-inline">
            <input class="form-control mr-sm-2" name="query" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Sr no.</th>
                <th scope="col">First name</th>
                <th scope="col">Last name</th>
                <th scope="col">Email</th>
                <th scope="col">City</th>
                <th scope="col">State</th>
                <th scope="col">Zipcode</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $srNo = ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1;
            foreach ($users as $user) : ?>
                <tr>
                    <th scope="row"><?= $srNo++; ?></th>
                    <td><?= esc($user['first_name']) ?></td>
                    <td><?= esc($user['last_name']) ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td><?= esc($user['city']) ?></td>
                    <td><?= esc($user['state']) ?></td>
                    <td><?= esc($user['zip_code']) ?></td>
                    <td>
                        <a href="<?= site_url('edit-user/' . $user['id']); ?>">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>

    </table>

    <?php if (empty($users)) { ?>
        <h3>No record found..!</h3>
    <?php } ?>

    <?= $pager->links() ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>