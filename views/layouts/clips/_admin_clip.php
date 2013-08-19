<?php $this->beginClip('adminMenuClip'); ?>

<?php
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'list',
    'items' => $this->adminMenu
));
?>

<?php $this->endClip(); ?>