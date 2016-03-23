<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h2 class="page-header">Upload
   
</h2>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
           Upload Excel
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if($school_data->candidates_count > 0){?>
                    <div class="alert alert-danger">
                       <p>Selected School have <span class="label label-warning"><b><?php echo $school_data->candidates_count;?></b></span> candidates in total. Make sure that <b>you are not re-uploading the same student list</b>.
                           If you want to update some candidates make sure that you are using latest system generated excel,
                           if not please click <a href="<?php echo site_url('admin/candidates/gen_excel/'.$school_data->school_id);?>"><span class="label label-success"><b>HERE</b></span></a>  to download, then make the changes and upload again.

                        </p>
                    </div>
                    <?php } ?>
                    <form method="post" class="form-horizontal"  enctype="multipart/form-data">
						<div class="form-group">
                            <label class="col-sm-2 control-label form-label">School Name</label>
                            <div class="col-sm-8">

                                   <input class="form-control" type="text" value="<?php echo $school_data->school_name.'(ID: '.$school_data->school_id.')-'.$school_data->place;?>" readonly>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label form-label">Candidate Excel</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="userfile">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-success"  onclick="return confirm('Are you sure ?');" type="submit">Upload</button>
                                <a class="btn btn-danger" href="<?php echo site_url('admin/candidates');?>">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>