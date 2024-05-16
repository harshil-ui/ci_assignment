<?= $this->extend('Auth/layout') ?>

<?= $this->section('title') ?>
Edit user
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <!-- Card -->
            <div class="card my-5">
                <h5 class="card-header">Edit user</h5>
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" id="update_user">
                        <!-- First Name -->
                        <input type="hidden" name="id" value="<?= esc($user['id']); ?>">

                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Enter your first name" value="<?= $user['first_name'] ?>" disabled>
                        </div>
                        <!-- Last Name -->
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Enter your last name" value="<?= $user['last_name'] ?>" disabled>
                        </div>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" value="<?= $user['email'] ?>" disabled>
                        </div>

                        <!-- <div id="dealer_details"> -->
                        <!-- City -->
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" value="<?= $user['city'] ?>" required>
                        </div>
                        <!-- State -->
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter your state" value="<?= $user['state'] ?>" required>
                        </div>
                        <!-- Zip code -->
                        <div class="mb-3">
                            <label for="zip_code" class="form-label">Zip code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Enter your zip code" value="<?= $user['zip_code'] ?>" required>
                        </div>
                        <!-- </div> -->
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>