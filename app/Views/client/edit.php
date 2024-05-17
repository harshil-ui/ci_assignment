<?= $this->extend('Auth/layout') ?>

<?= $this->section('title') ?>
Edit user
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">

            <div class="card my-5">

                <h5 class="card-header">Edit user</h5>

                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" id="update_user">

                        <input type="hidden" name="id" value="<?= isset($user['id']) ? esc($user['id']) : '' ?>">

                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Enter your first name" value="<?= isset($user['first_name']) ? esc($user['first_name']) : '' ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Enter your last name" value="<?= isset($user['last_name']) ? esc($user['last_name']) : '' ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" value="<?= isset($user['email']) ? esc($user['email']) : '' ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" value="<?= isset($user['city']) ? esc($user['city']) : '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter your state" value="<?= isset($user['state']) ? esc($user['state']) : '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="zip_code" class="form-label">Zip code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Enter your zip code" value="<?= isset($user['zip_code']) ? esc($user['zip_code']) : '' ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#update_user').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= site_url('update-user'); ?>',
                data: $(this).serialize(),
                dataType: 'JSON',
                complete(xhr) {
                    let jsonResponse = JSON.parse(xhr.responseText);
                    if (jsonResponse.success) {
                        alert(jsonResponse.message);
                        window.location.href = '/';
                    } else {
                        alert(JSON.stringify(jsonResponse.errors));
                    }
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>