<?php echo '<?php $this->view("header"); ?>'; ?>

<h2>menu</h2>

<ul>
<?php foreach ($operations as $operation): $name = str_replace(' ', '_', $operation->name) ?>
 <li><a href="/application/<?=$name?>"><?=$operation->name?></a></li>
<?php endforeach; ?>
</ul>

<?php echo '<?php $this->view("footer"); ?>'; ?>
