<?php $this->view("header"); ?>

<h2>data</h2>

<p>Click <a href="/collectible/backup">here</a> to download a SQL file that loads the data.</p>

<?php foreach ($tables as $table): ?>
<div class="dataSection">
 <h3><?=$table?></h3>
 <?php
 $fields = $this->db->field_data($table);
 $data = $this->db->get($table)->result_array();
 $this->load->view('collectible/_all', array('collectible' => $table, 'fields' => $fields, 'data' => $data));
 ?>
</div>
<?php endforeach; ?>

<?php $this->view("footer"); ?>

