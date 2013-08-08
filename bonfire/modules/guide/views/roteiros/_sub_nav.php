<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/roteiros/guide') ?>" id="list"><?php echo lang('guide_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Guide.Roteiros.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/roteiros/guide/create') ?>" id="create_new"><?php echo lang('guide_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>