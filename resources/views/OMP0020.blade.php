
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>OMP0020 : สร้างใบเตรียมการขาย ส่งเสริม ยสท. /บุหรี่ทดลอง/บุหรี่ตัวอย่าง</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/datepicker3.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">


</head>

<body>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="logo w-60"><img src="{{ asset('img/logo.png') }}" alt=""></div>
                    <h4 class="site-name">Tobacco Authority Of Thailand</h4>
                    
                </li>
                <li>
                    <a href="#"><i class="fa fa-diamond"></i> <span class="nav-label">ระบบขาย กระบวนการสร้างลูกค้า</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="#">Customer Search และการส่งขออนุมัติการสร้างลูกค้า ระบบ E-Commerce สำหรับขายต่างประเทศ</a></li>
                        <li><a href="#">โปรแกรมส่งขออนุมัติการสร้างลูกค้าสำหรับขายต่างประเทศ</a></li>
                        <li><a href="#">Customer Search ระบบ Web-ขาย สำหรับลูกค้าขายต่างประเทศ</a></li>
                        <li><a href="#">Customer Search ระบบ Web-ขาย สำหรับลูกค้าขายในประเทศ</a></li>
                        <li><a href="#">ข้อมูลลูกค้า สำหรับขายต่างประเทศ</a></li>
                        <li><a href="#">ข้อมูลลูกค้า สำหรับขายในประเทศ</a></li>
                        <li><a href="#">กำหนดรหัสนายหน้า สำหรับขายในประเทศ</a></li>
                        <li><a href="#">ระบบสร้างข้อมูลลูกค้าใหม่ในระบบ Oracle ให้อัตโนมัติ</a></li>
                        <li><a href="#">ระบบทำการ update Customer Number ตามระบบ Oracle ให้กับระบบ E-Commerce และทำการ Update Status ลูกค้าใหม่ในระบบ E-Commerce เป็น “Active”</a></li> 
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-diamond"></i> <span class="nav-label">ระบบขาย กระบวนการขายต่างประเทศ</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-diamond"></i> <span class="nav-label">ระบบขาย กระบวนการขายในประเทศ</span></a>
                </li>                 
            </ul>

        </div><!--sidebar-collapse-->
    </nav><!--navbar-default-->

    <div class="navbar-minimalize page-blocker"></div>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div><!--navbar-header-->

                <ul class="nav navbar-top-links navbar-right">
             
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a class="dropdown-item float-left" href="profile.html">
                                        <img alt="image" class="rounded-circle" src="{{ asset('img/a7.jpg') }}">
                                    </a>
                                    <div class="media-body">
                                        <small class="float-right">46h ago</small>
                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a class="dropdown-item float-left" href="profile.html">
                                        <img alt="image" class="rounded-circle" src="{{ asset('img/a4.jpg') }}">
                                    </a>
                                    <div class="media-body ">
                                        <small class="float-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a class="dropdown-item float-left" href="profile.html">
                                        <img alt="image" class="rounded-circle" src="{{ asset('img/profile.jpg') }}">
                                    </a>
                                    <div class="media-body ">
                                        <small class="float-right">23h ago</small>
                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="mailbox.html" class="dropdown-item">
                                        <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html" class="dropdown-item">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="float-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a href="profile.html" class="dropdown-item">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="float-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a href="grid_options.html" class="dropdown-item">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="float-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html" class="dropdown-item">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle" src="{{ asset('img/profile_small.jpg') }}"/>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block font-bold">David Williams</span>
                                <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                                <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                                <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="login.html">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

            </nav><!--navbar-static-top-->
        </div><!--row-->

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Customer Search</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">หน้าหลัก</a>
                    </li> 
                    <li class="breadcrumb-item active">
                        <strong>ข้อมูลลูกค้า สำหรับขายต่างประเทศ</strong>
                    </li>
                </ol>
            </div>
        </div><!--page-heading-->

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>ใบเตรียมการขาย ส่งเสริม ยสท. /บุหรี่ทดลอง/บุหรี่ตัวอย่าง</h3>
                </div>
                <div class="ibox-content"> 
                    <div class="row space-50 justify-content-md-center mt-md-4">
                        <div class="col-12">
                            <div class="form-header-buttons">
                                <div class="buttons multiple">
                                    <button class="btn btn-md btn-success" type="button"><i class="fa fa-plus"></i> สร้าง</button>
                                    <button class="btn btn-md btn-info" type="button"><i class="fa fa-copy"></i> คัดลอก</button>
                                    <button class="btn btn-md btn-white" type="button"><i class="fa fa-search"></i> ค้นหา</button>
                                    <button class="btn btn-md btn-success" data-toggle="modal" data-target="#attachmentModal" type="button"><span class="fa fa-upload"> ไฟล์แนบ</span></button>
                                    <div class="dropdown">
                                        <button class="btn btn-md btn-white m-0" data-toggle="dropdown" type="button">ปุ่มคำสั่ง <i class="fa fa-caret-down"></i></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">บันทึก</a></li>
                                            <li><a href="#">ยืนยัน</a></li>
                                            <li><a href="#">ยกเลิก</a></li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-md btn-info" type="button"><i class="fa fa-print"></i> พิมพ์ใบเตรียมการขาย</button>
                                    <button class="btn btn-md btn-primary" type="button"><i class="fa fa-check"></i> ส่งข้อมูลอนุมัติ</button>
                                </div>
                            </div><!--form-header-buttons-->

                            <div class="hr-line-dashed"></div>
                        </div><!--col-12-->
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">เลขที่ใบเตรียมขาย</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" disabled  name="" placeholder="" value="630100127">
                                            <i class="fa fa-search"></i> 
                                        </div>
                                    </div>
                                </div><!--col--> 

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">Order Status</label>
                                        <div class="row space-5 align-items-center">
                                            <div class="col-md-6">
                                                
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" disabled name="" placeholder="" value="Draft">
                                                    <i class="fa fa-search"></i> 
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-2 mt-md-0">
                                                <div class="i-checks f13"><label><input type="checkbox" value="option_d1" name="a" disabled><span class="nowrap">ยอดส่งได้รับการอนุมัติ</span></label></div>
                                            </div>
                                        </div><!--row-->
                                    </div>
                                </div><!--col-->

                                <div class="col-12"></div>

                                <!--//-->

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">รหัสลูกค้า</label>
                                        <div class="row space-5 align-items-center">
                                            <div class="col-md-4">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control"  name="" placeholder="" value="2101022">
                                                    <i class="fa fa-search"></i> 
                                                </div>
                                            </div>
                                            <div class="col-md-8 mt-2 mt-md-0">
                                                <input type="text" class="form-control" disabled name="" placeholder="" value="การยาสูบแห่งประเทศไทย 5">
                                            </div>
                                        </div><!--row-->
                                    </div>
                                </div><!--col-->

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">ที่อยู่</label>
                                       <input type="text" class="form-control"  name="" placeholder="" value="กรุงเทพมหานคร">
                                    </div>
                                </div><!--col-->

                                <!--//-->

                                <div class="col-12"></div>

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">สั่งทาง</label>
                                        <select class="custom-select">
                                            <option>E-Commerce</option>
                                            <option>EDI</option> 
                                            <option>Email</option> 
                                            <option>Fax</option> 
                                            <option>Line</option> 
                                            <option>Other</option>    
                                        </select>
                                    </div>
                                </div><!--col-->

                                <!--//-->

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">หมายเหตุสั่งซื้อ</label>
                                       <input type="text" class="form-control"  name="" placeholder="" value="">
                                    </div>
                                </div><!--col-->

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">ผู้ร้องขอ</label>
                                        <div class="row space-5 align-items-center">
                                            <div class="col-md-4">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control"  name="" placeholder="" value="2">
                                                    <i class="fa fa-search"></i> 
                                                </div>
                                            </div>
                                            <div class="col-md-8 mt-2 mt-md-0">
                                                <input type="text" class="form-control" disabled  name="" placeholder="" value="กองวางแผนกลยุทธ์การขาย">
                                            </div>
                                        </div><!--row-->
                                    </div>
                                </div><!--col-->

                                <!--//-->

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">ส่งโดย</label>
                                        <select class="custom-select">
                                            <option>ขนเอง</option>
                                            <option>บริษัทขนส่ง</option>
                                            <option>อื่นๆ</option>    
                                        </select>
                                    </div>
                                </div><!--col-->

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">วันที่สั่ง</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control date"  name="" placeholder="" value="">
                                            <i class="fa fa-calendar"></i> 
                                        </div>
                                    </div>
                                </div><!--col-->

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">วันที่ส่ง</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control date"  name="" placeholder="" value="">
                                            <i class="fa fa-calendar"></i> 
                                        </div>
                                    </div>
                                </div><!--col-->

                                <!--//-->

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">Order Type</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control"  name="" placeholder="" value="ส่งเสริม-ยสท 5">
                                            <i class="fa fa-search"></i> 
                                        </div>
                                    </div>
                                </div><!--col-->

                                <div class="col-xl-4 col-md-6"> 
                                    <div class="form-group">
                                        <label class="d-block">ราคาขาย</label>
                                        <select class="custom-select">
                                            <option>ราคาโรงงาน</option>    
                                        </select>
                                    </div>
                                </div><!--col-->

                                 <!--//-->

                                <div class="col-md-8"> 
                                    <div class="form-group">
                                        <label class="d-block">หมายเหตุรายการ</label>
                                        <input type="text" class="form-control"  name="" placeholder="" value="ออกบุหรี่ตามอนุมัติผู้ว่าการ"> 
                                    </div>
                                </div><!--col-->

                            </div><!--row-->                             
                        </div><!--col-xl-6-->

                        <div class="col-xl-12">
                            <hr class="lg">

                            <div class="form-header-buttons">
                                <div class="buttons multiple">
                                    <button class="btn btn-md btn-success" type="button"><i class="fa fa-plus"></i> สร้าง</button> 
                                    <button class="btn btn-md btn-primary" type="button"><i class="fa fa-save"></i> บันทึก</button>
                                </div>
                            </div><!--form-header-buttons-->

                            <div class="hr-line-dashed"></div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-hover min-1200 f13"> 
                                    <thead>
                                        <tr class="align-middle">
                                            <th rowspan="2" class="w-90">รายการที่</th>
                                            <th rowspan="2" class="w-160">รหัสสินค้า</th>
                                            <th rowspan="2" class="min-150">ชื่อผลิตภัณฑ์</th>
                                            <th colspan="3">จำนวนที่สั่ง</th>
                                            <th rowspan="2">ราคาขาย/<br>พันมวน</th>
                                            <th rowspan="2">จำนวนเงิน</th>
                                            <th rowspan="2">คงคลังทั้งหมด<br>(พันมวน)</th>
                                            <th rowspan="2" style="width: 55px">ลบ</th>
                                        </tr>
                                        <tr class="align-middle">
                                            <!--จำนวนที่สั่ง-->
                                            <th class="w-90"><small>หีบ</small></th>
                                            <th class="w-90"><small>ห่อ</small></th>
                                            <th class="w-90"><small>คิดเป็น<br>พันมวน</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="align-middle">
                                            <td>1.1</td>  
                                            <td>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="" value="2301">
                                                    <i class="fa fa-search"></i>
                                                </div>
                                            </td>
                                            <td class="text-left">กรองทิพย์ 90</td>

                                            <td><input type="text" class="form-control md text-center" value="1" name=""></td>
                                            <td><input type="text" class="form-control md text-center" value="41" name=""></td>
                                            <td>18.20</td>

                                            <td class="text-right">4,337.50</td>
                                            <td class="text-right">78,942.50</td>
                                            <td class="text-right">300.00</td> 

                                            <td><a class="fa fa-times red" href="#"></a></td>
                                        </tr> 

                                        <tr>
                                            <td class="text-right" colspan="7">
                                                <strong class="black">รวมเงิน</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong class="black">78,942.50</strong>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!--table-responsive--> 
                            
                        </div><!--col-xl-12-->

                        <div class="col-xl-12 mt-5">
                            <div class="paper-row title mb-3 has-bg" data-toggle="collapse" data-target="#collapse_01" aria-expanded="true">
                                <span class="icon-collapse blue"><span class="icon"></span></span> <strong>บันทึกรายละเอียดสินค้า</strong>
                            </div>

                            <div id="collapse_01" class="collapse in show">
                                <div class="table-responsive-lg">
                                <table class="table table-bordered text-center  f13"> 
                                    <thead>
                                        <tr class="align-middle">
                                            <th class="w-160">รหัสสินค้า(INV)</th>
                                            <th class="w-160">ชื่อผลิตภัณฑ์(INV)</th>
                                            <th class="w-160">Org</th>
                                            <th class="w-160">Org Name</th>
                                            <th class="w-160">Lot</th>
                                            <th class="w-160">Onhand</th>
                                            <th class="w-160">จำนวนหน่วย</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="align-middle">
                                            <td><input type="text" class="form-control md text-center" disabled="" name="" value="2301"></td>
                                            <td><input type="text" class="form-control md" disabled="" name="" value="กรองทิพย์ 90"></td>
                                            <td>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control text-center"  name="" placeholder="" value="A01">
                                                    <i class="fa fa-search"></i> 
                                                </div>
                                            </td> 
                                            <td><input type="text" class="form-control md" disabled="" name="" value="สินค้าสำเร็จรูป"></td>
                                            <td>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control text-center"  name="" placeholder="" value="AAAA">
                                                    <i class="fa fa-search"></i> 
                                                </div>
                                            </td>
                                            <td><input type="text" class="form-control md text-center" disabled="" name="" value="100.00"></td> 
                                            <td>18.2</td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div><!--collapse-->
                        </div><!--col-xl-12-->
                         
                    </div><!--row-->

                </div><!--ibox-content-->
            </div><!--ibox-->

             
        </div><!--wrapper-content-->

        <div class="footer fixed">
            <div class="float-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2018
            </div>
        </div><!--footer-->

    </div><!--page-wrapper-->
</div><!--wrapper-->

<div class="modal modal-600 fade" id="attachmentModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 

            <div class="modal-header">
                <h3>Upload File</h3>
            </div>
            <div class="modal-body pt-4 pb-4">
                <div class="attachment-box">
                    <div class="form-group d-flex"> 
                        <div class="custom-file">
                            <input id="logo" type="file" class="custom-file-input">
                            <label for="logo" class="custom-file-label">Choose file...</label>
                        </div>
                        <div class="button">
                            <button class="btn btn-success">Submit</button>
                            <button class="btn btn-warning">Clear</button>
                        </div>
                    </div>  

                    <ul class="nav files">
                        <li>
                            <code><a href="#"><i class="fa fa-file-pdf-o"></i>  เอกสาร1.pdf</code></a>
                            <button class="btn btn-remove"><i class="fa fa-times"></i></button>
                        </li>
                        <li>
                            <code><a href="#"><i class="fa fa-file-pdf-o"></i>  เอกสาร2.pdf</code></a>
                            <button class="btn btn-remove"><i class="fa fa-times"></i></button>
                        </li>
                    </ul>
                </div>
            </div><!--modal-body-->  

            <div class="modal-footer center mt-4">
                <button class="btn btn-gray btn-lg" type="button" data-dismiss="modal">
                    ปิด
                </button>
                <button class="btn btn-primary btn-lg" type="button" data-dismiss="modal">
                    ยืนยัน
                </button>
            </div>

        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal-->

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>

<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

<!-- Custom and plugin javascript -->  
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<script>
    $(document).ready(function(){ 
        $('.date').datepicker();
    });
</script>
 

</body>

</html>
