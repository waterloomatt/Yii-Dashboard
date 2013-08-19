<?php $this->beginContent('/layouts/main'); ?>
<div class="row">
    <div class="span2" id="sidebar">
        <?php
        if (isset($this->clips['adminMenuClip']))
            echo $this->clips['adminMenuClip'];
        ?>
    </div>
    <div class="span10" id="main-content">
        <?php echo $content; ?>
    </div>
</div>
<?php $this->endContent(); ?>