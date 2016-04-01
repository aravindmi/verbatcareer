<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Verbat | Careers</title>


    <!-- Bootstrap Core CSS -->
    <link href="/assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/assets/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->

    <!-- jQuery -->
    <script src="/assets/bower_components/jquery/dist/jquery.min.js"></script>

    <style>

        [data-sort] {

            cursor: pointer;
        }

    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url('admin/dashboard'); ?>">Career Engine</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">

            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-comment fa-fw"></i> New Comment
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                <span class="pull-right text-muted small">12 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> Message Sent
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-tasks fa-fw"></i> New Task
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-alerts -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">

                    <li><a href="<?php echo site_url();?>"><i class="fa fa-gear fa-fw"></i> Visit Site</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?php echo site_url('auth/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/dashboard'); ?>"jobs
                           class="<?php echo isset($menu) && $menu == 'dashboard' ? 'active' : ''; ?>"><i
                                class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/jobs'); ?>"
                           class="<?php echo isset($menu) && $menu == 'jobs' ? 'active' : ''; ?>"><i
                                class="fa fa-university fa-fw"></i> Opportunities</a>
                    </li>
                    <!--<li>
                        <a href="<?php echo site_url('admin/applicants'); ?>"
                           class="<?php echo isset($menu) && $menu == 'applicants' ? 'active' : ''; ?>"><i
                                class="fa fa-users fa-fw"></i> Applicants</a>
                    </li>-->
                    <li>
                        <a href="<?php //echo site_url('admin/reports'); ?>#"
                           class="<?php echo isset($menu) && $menu == 'reports' ? 'active' : ''; ?>"><i
                                class="fa fa-bar-chart-o fa-fw"></i> Reports</a>
                    </li>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                        <div id="ajax-panel">
                            <div id="overlay">
                                <img id="loading" src="http://bit.ly/pMtW1K">
                            </div>
                        </div>

                        <?php echo $this->ci_alerts->display('error'); ?><?php echo $this->ci_alerts->display('success'); ?>
                        <?php if(isset($upload_error)){echo $upload_error;}?>
                    </div>
                    <?php
                    if (isset($page)) {
                        $this->load->view($page);
                    } else {
                        echo $this->config->item('SITE_NAME');
                    }
                    ?>


                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->




<!-- Bootstrap Core JavaScript -->
<script src="/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="/assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="/assets/dist/js/sb-admin-2.js"></script>
<!-- Custom Theme JavaScript -->
<script src="/assets/js/stupidtable.min.js"></script>
<script src="//cdn.ckeditor.com/4.5.7/basic/ckeditor.js"></script>

<?php echo isset($menu) && $menu == 'jobs' ? "<script>CKEDITOR.replace( 'job_description' );</script>" : ''; ?>

<script>
    $(function(){
        var table = $("table").stupidtable();
        table.bind('aftertablesort', function (event, data) {
            // data.column - the index of the column sorted after a click
            // data.direction - the sorting direction (either asc or desc)
            // $(this) - this table object
            var th = $(this).find("th");
            th.find(".srt").remove();
            var dir = $.fn.stupidtable.dir;
            var arrow = data.direction === dir.ASC ? "&uarr;" : "&darr;";
            th.eq(data.column).append('<span class="srt label label-info">' + arrow +'</span>');
            //console.log("The sorting direction: " + data.direction);
            //console.log("The column index: " + data.column);
        });
    });
</script>

<?php if(isset($date) && $date == TRUE){ ?>
<!-- date Piker -->
<script src="/assets/dist/js/bootstrap-datepicker.min.js"></script>
<link href="/assets/dist/css/bootstrap-datepicker3.css" rel="stylesheet">
<script>
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    })
</script>
<?php } ?>

<script>
    $(document).ready(function()
    {
        $('#search_text').keyup(function()
        {
            searchTable($(this).val());
        });

        $('#overlay').hide();

    });

    function searchTable(inputVal)
    {
        var table = $('#list_table');
        table.find('tr').each(function(index, row)
        {
            var allCells = $(row).find('td');
            if(allCells.length > 0)
            {
                var found = false;
                allCells.each(function(index, td)
                {
                    var regExp = new RegExp(inputVal, 'i');
                    if(regExp.test($(td).text()))
                    {
                        found = true;
                        return false;
                    }
                });
                if(found == true)$(row).show();else $(row).hide();
            }
        });
    }

    var refresh = function(){
        $('#search_text').val('');
        searchTable('');

    }

    var update_award = function (can_id){

        var sid = 'award_'+can_id;
        var award = $('#'+sid).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url();?>admin/candidates/update_award',
            data: { candidate_id: can_id, candidate_award: award },
            beforeSend:function(){
                // this is where we append a loading image
                $('#ajax-panel').empty();

                $('#ajax-panel').html('<div id="overlay">' +
                    '<img id="loading" src="http://bit.ly/pMtW1K">' +
                    '</div>');
            },
            success:function(data){
                // successful request; do something with the data
                $('#ajax-panel').empty();

                if(data == 'success'){

                    //do nothing
                }else{

                    alert('Update failed!! Please try again');
                }


            },
            error:function(){
                // failed request; give feedback to user
                $('#ajax-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
            }
        });

    }

</script>


</body>

</html>
