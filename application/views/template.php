<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ARDY LAND INVENTORY</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=base_url("assets")?>/enlink/images/logo/favicon.png">

    <!-- page css -->

    <!-- Core css -->
    <link href="<?=base_url("assets")?>/enlink/css/app.min.css" rel="stylesheet">
    <style>
        .loading-wrap {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 99999;
            background: #FFF;
        }
        .loading-wrap .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            font-size: 10rem;
        }
    </style>
</head>

<body>
    <div class="app">
        <?php if(!empty($loading)&&$loading==true) { ?>
        <div class="loading-wrap">
            <div class="loading">
                <i class="anticon anticon-loading"></i>
            </div>
        </div>
        <?php } ?>
        <div class="layout">
            <!-- Header START -->
            <div class="header">
                <div class="logo logo-dark">
                    <a href="<?=base_url("assets")?>/">
                        <img src="<?=base_url("assets")?>/enlink/images/logo/logo.png" alt="Logo">
                        <img class="logo-fold" src="<?=base_url("assets")?>/enlink/images/logo/logo-fold.png" alt="Logo">
                    </a>
                </div>
                <div class="logo logo-white">
                    <a href="<?=base_url("assets")?>/">
                        <img src="<?=base_url("assets")?>/enlink/images/logo/logo-white.png" alt="Logo">
                        <img class="logo-fold" src="<?=base_url("assets")?>/enlink/images/logo/logo-fold-white.png" alt="Logo">
                    </a>
                </div>
                <div class="nav-wrap">
                    <ul class="nav-left">
                        <li class="desktop-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                        <li class="mobile-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <li class="dropdown dropdown-animated scale-left">
                            <a href="javascript:void(0);" data-toggle="dropdown">
                                <i class="anticon anticon-bell notification-badge"></i>
                            </a>
                            <div class="dropdown-menu pop-notification">
                                <div class="p-v-15 p-h-25 border-bottom d-flex justify-content-between align-items-center">
                                    <p class="text-dark font-weight-semibold m-b-0">
                                        <i class="anticon anticon-bell"></i>
                                        <span class="m-l-10">Notification</span>
                                    </p>
                                    <a class="btn-sm btn-default btn" href="javascript:void(0);">
                                        <small>View All</small>
                                    </a>
                                </div>
                                <div class="relative">
                                    <div class="overflow-y-auto relative scrollable" style="max-height: 300px">
                                        <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                            <div class="d-flex">
                                                <div class="avatar avatar-blue avatar-icon">
                                                    <i class="anticon anticon-mail"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">You received a new message</p>
                                                    <p class="m-b-0"><small>8 min ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                            <div class="d-flex">
                                                <div class="avatar avatar-cyan avatar-icon">
                                                    <i class="anticon anticon-user-add"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">New user registered</p>
                                                    <p class="m-b-0"><small>7 hours ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                            <div class="d-flex">
                                                <div class="avatar avatar-red avatar-icon">
                                                    <i class="anticon anticon-user-add"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">System Alert</p>
                                                    <p class="m-b-0"><small>8 hours ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item d-block p-15 ">
                                            <div class="d-flex">
                                                <div class="avatar avatar-gold avatar-icon">
                                                    <i class="anticon anticon-user-add"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">You have a new update</p>
                                                    <p class="m-b-0"><small>2 days ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown dropdown-animated scale-left">
                            <div class="pointer" data-toggle="dropdown">
                                <div class="avatar avatar-image  m-h-10 m-r-15">
                                    <img src="<?=base_url("assets")?>/enlink/images/avatars/thumb-3.jpg"  alt="">
                                </div>
                            </div>
                            <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                    <div class="d-flex m-r-50">
                                        <div class="avatar avatar-lg avatar-image">
                                            <img src="<?=base_url()?>assets/foto_profil/<?=$this->session->userdata('images')?>" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <p class="m-b-0 text-dark font-weight-semibold"><?=$this->session->userdata('full_name')?></p>
                                            <p class="m-b-0 opacity-07">UI/UX Desinger</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?=base_url('user/profile')?>" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                            <span class="m-l-10">Edit Profile</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                                <a href="<?=base_url('auth/logout')?>" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                            <span class="m-l-10">Logout</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#quick-view">
                                <i class="anticon anticon-appstore"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>    
            <!-- Header END -->
			
			<!-- Core Vendors JS -->
			<script src="<?=base_url("assets")?>/enlink/js/vendors.min.js"></script>
			
			<!-- Core JS -->
			<script src="<?=base_url("assets")?>/enlink/js/app.min.js"></script>
			
            <?php $this->load->view('template/sidebar'); ?>

            <!-- Page Container START -->
            <div class="page-container">
                

                <!-- Content Wrapper START -->
                <div class="main-content">
					<?=$contents?>
				</div>
                <!-- Content Wrapper END -->

                <!-- Footer START -->
                <footer class="footer">
                    <div class="footer-content">
                        <p class="m-b-0">Copyright © Holding Land Inventory. All rights reserved.</p>
                        <span>
                            <a href="" class="text-gray m-r-15">Term &amp; Conditions</a>
                            <a href="" class="text-gray">Privacy &amp; Policy</a>
                        </span>
                    </div>
                </footer>
                <!-- Footer END -->

            </div>
            <!-- Page Container END -->
        </div>
    </div>

	<script>
        $(function() {
            $.get("<?=base_url('user_history/log')?>",function(data){
                $row = "";
                $.each(data.data,function(i,v){
                    $row += '<li> \
                        <a href="<?=base_url("land/update/")?>'+v[0]+'"> \
                            <i class="fa fa-users text-aqua"></i>'+v[1]+'\
                            <i class="'+v[2]+'" style="float:right"></i>\
                        </a> \
                    </li>';
                });
                $(".notif-lbl").text(data.count);
                $(".notif-lg").append('<li class="header">You have '+data.count+' notifications</li> \
                    <li> \
                        <ul class="menu"> \
                        '+$row+' \
                        </ul> \
                    </li> \
                    <li class="footer"><a href="<?=site_url("user_history/loging")?>">View all</a></li> \
                ');
            },"JSON");

            /*setInterval(function(){
                $.post("<?=base_url('user_history/log')?>",function(data){
                    //console.log(data.count>$(".notif-lbl").text());
                    if(data.count>$(".notif-lbl").text()){
                        $div = data.count-$(".notif-lbl").text();
                        $.each(data.data.slice(data.count-$div,$div+1),function(i,v){
                            $(".notif-lg .menu").prepend('<li> \
                                <a href="<?=base_url("land/update/")?>'+v[0]+'"> \
                                    <i class="fa fa-users text-aqua"></i>'+v[1]+'\
                                    <i class="'+v[2]+'" style="float:right"></i>\
                                </a> \
                            </li>');
                        });
                        $(".notif-lbl").text(data.count);
                        $(".notif-lg .header").text('You have '+data.count+' notifications');
                    }
                }, "JSON");
            },5000);*/
		});
	</script>
</body>

</html>