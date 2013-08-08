
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
