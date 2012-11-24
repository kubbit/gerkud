<h1>Iruzkinen zerrenda</h1>

<table width=80%>
  <thead>
    <tr>
      <th>Id</th>
      <th>Gertakaria</th>
      <th>Langilea</th>
      <th>Testua</th>
      <th>Created at</th>
<!--      <th></th>-->
    </tr>
  </thead>
  <tbody>
    <?php foreach ($iruzkinas as $iruzkina): ?>
    <tr>
<!--      <td><a href="<?php //echo url_for('iruzkina/show?id='.$iruzkina->getId()) ?>"><?php //echo $iruzkina->getId() ?></a></td> -->
      <td><?php echo $iruzkina->getId() ?></td>
      <td><?php echo $iruzkina->getGertakariaId() ?></td>
      <td><?php echo $iruzkina->getLangilea() ?></td>
      <td><?php echo $iruzkina->getTestua() ?></td>
      <td><?php echo $iruzkina->getCreatedAt() ?></td>
<!--
      <td>
<?php //echo link_to('Ezabatu', 'iruzkina/delete?id='.$iruzkina->getId(), array('method' => 'delete', 'confirm' => 'Ziur zaude?')) ?>
      </td>
-->    
   </tr>
    <?php endforeach; ?>

<!--
<tr><td colspan=6 align=right><br><a href="<?php //echo url_for('iruzkina/new') ?>">Iruzkina gehitu</a></td></tr>
-->
  </tbody>
</table>

