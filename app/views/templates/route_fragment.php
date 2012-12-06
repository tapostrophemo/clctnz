<?php foreach ($operations as $op): $name = str_replace(' ', '_', $op->name); ?>
$route['<?=$name?>'] = 'application/<?=$name?>';
<?php endforeach; ?>

