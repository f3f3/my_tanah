<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ARDY LAND INVENTORY</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=base_url("assets/enlink/")?>images/logo/favicon.png">
    <!-- page css -->

    <!-- Core css -->
    <link href="<?=base_url("assets/enlink/")?>css/app.min.css" rel="stylesheet">
</head>

<body>
    <div class="app">
        <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('<?=base_url("assets/enlink/")?>images/others/login-3.png')">
            <div class="d-flex flex-column justify-content-between w-100">
                <div class="container d-flex h-100">
                    <div class="row align-items-center w-100">
                        <div class="col-md-7 col-lg-5 m-h-auto">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between m-b-30">
                                        <img class="img-fluid" alt="" src="<?=base_url("assets/enlink/")?>images/logo/logo.png">
                                        <h2 class="m-b-0">Sign In</h2>
                                    </div>
                                    <?php
                                        $status_login = $this->session->userdata('status_login');
                                        if (!empty($status_login)) { ?>
                                        <div class="alert alert-danger">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <span class="alert-icon">
                                                    <i class="anticon anticon-close-o"></i>
                                                </span>
                                                <span><?=$status_login?></span>
                                            </div>
                                        </div>
                                    <?php    } ?>
                                    <?php echo form_open('auth/cheklogin'); ?>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="Username">Username:</label>
                                            <div class="input-affix">
                                                <i class="prefix-icon anticon anticon-mail"></i>
                                                <input type="email" class="form-control" id="Username" placeholder="Email" name="ids">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="Password">Password:</label>
                                            <div class="input-affix m-b-10">
                                                <i class="prefix-icon anticon anticon-lock"></i>
                                                <input type="Password" class="form-control" id="Password" placeholder="Password" name="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-size-13 text-muted"></span>
                                                <button class="btn btn-primary">Sign In</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Core Vendors JS -->
    <script src="<?=base_url("assets/enlink/")?>js/vendors.min.js"></script>
    <!-- page js -->
    <!-- Core JS -->
    <script src="<?=base_url("assets/enlink/")?>js/app.min.js"></script>
</body>

</html>