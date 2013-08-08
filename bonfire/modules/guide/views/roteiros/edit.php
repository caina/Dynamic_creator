
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>


<div class="admin-box">
    <h3>Guide</h3>
    <fieldset>
        <?php echo $form ?>
    </fieldset>


</div>

<div class="fileupload fileupload-new" data-provides="fileupload">
  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" /></div>
  <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
  <div>
    <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" /></span>
    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
  </div>
</div>

