<?php $__env->startSection("title"); ?>
    <title>TestCreate</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <h2 class="display-4" style="text-align:center; margin-bottom:30px;"><?php echo e(($msg_id != "") ? "Update" : "Create"); ?> Msg</h2>

    
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-md-center">
                <form class="form1 col col-md-8" name="form1" method="post" action="<?php echo e(($msg_id != '') ? action('WelcomeController@update', ['msg_id'=>$msg_id]) : 'new_a_msg'); ?>">
                    <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
                    <input name="_method" type="hidden" value="put">
                    <div class="form-group">
                        <label for="Title"><span style="color:red;">*</span>Title</label>
                        <input type="text" class="form-control" name="Title" placeholder="請輸入標題" value="<?php echo e(isset($title) ? $title : old('Title')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Msg"><span style="color:red;">*</span>Msg</label>
                        <textarea type="text" class="form-control" name="Msg" style="height:100px;" placeholder="請輸入留言" required><?php echo e(isset($msg) ? $msg : old("Msg")); ?></textarea>
                    </div>
                    <div class="form-group d-flex justify-content-md-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("welcome_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>