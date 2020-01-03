<?php $__env->startSection("title"); ?>
    <title>TestCreate</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <h2 class="display-4" style="text-align:center; margin-bottom:30px;"><?php echo e(($msg_id != "") ? "Update" : "Create"); ?> Msg</h2>

    
    <form class="form1" name="form1" method="post" action="<?php echo e(($msg_id != '') ? action('WelcomeController@update', ['msg_id'=>$msg_id]) : 'new_a_msg'); ?>">
        <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
        <input name="_method" type="hidden" value="put">
        <div class="form-group row">
            <label for="Title" class="col-sm-2 col-form-label"><span style="color:red;">*</span>Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="Title" placeholder="請輸入標題" value="<?php echo e(($msg_id != "") ?  isset($title) ? $title : '' : old('Title')); ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="Msg" class="col-sm-2 col-form-label"><span style="color:red;">*</span>Msg</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" name="Msg" style="height:100px;" placeholder="請輸入留言" ><?php echo e(($msg_id != "") ? isset($msg) ? $msg : "" : old("Msg")); ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>     
<?php $__env->stopSection(); ?>

<?php echo $__env->make("welcome_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>