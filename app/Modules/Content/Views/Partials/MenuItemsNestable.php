<?php use App\Modules\Content\Models\Post; ?>

<ol class="dd-list">
    <?php foreach ($items as $item) { ?>
    <?php $instance = $item->instance(); ?>
    <?php $title = ($instance instanceof Post) ? $instance->title : $instance->name; ?>
    <li class="dd-item dd3-item" data-id="<?= $item->id; ?>">
        <div class="dd-handle dd3-handle"> </div>
        <div class="dd3-content">
            <?php $type = $item->menu_item_object; ?>
            <?php $name = Config::get("content::labels.{$type}.name", __d('content', 'Unknown: {0}', $type)); ?>
            <div class="pull-left" style="margin-top: 5px;"><?= $name; ?> : <?= $title; ?></div>
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#modal-delete-dialog" data-id="<?= $item->id; ?>" title="<?= __d('content', 'Delete this Menu Item'); ?>" role="button"><i class="fa fa-remove"></i></a>
                <a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#modal-edit-dialog" data-id="<?= $item->id; ?>" data-name="<?= $title; ?>" title="<?= __d('content', 'Edit this Menu Item'); ?>" role="button"><i class="fa fa-pencil"></i></a>
            </div>
        </div>

        <?php $children = $item->children()->get(); ?>

        <?php if (! $children->isEmpty()) { ?>
        <?= View::fetch('Partials/MenuItemsNestable', array('menu' => $menu, 'items' => $children), 'Content'); ?>
        <?php } ?>
    </li>
    <?php } ?>
</ol>
