<h1>Fitxategien zerrenda</h1>

<table width=80%>
  <thead>
    <tr>
      <th>Id</th>
      <th>Gertakaria</th>
      <th>Fitxategia</th>
      <th>Deskribapena</th>
      <th>Created at</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($fitxategias as $fitxategia): ?>
    <tr>
<!--      <td><a href="<?php //echo url_for('fitxategia/show?id='.$fitxategia->getId()) ?>"><?php //echo $fitxategia->getId() ?></a></td>-->
      <td><?php echo $fitxategia->getId() ?></td>
      <td><?php echo $fitxategia->getGertakariaId() ?></td>
      <td><?php echo $fitxategia->getFitxategia() ?></td>
      <td><?php echo $fitxategia->getDeskribapena() ?></td>
      <td><?php echo $fitxategia->getCreatedAt() ?></td>
<!--
      <td>     
<?php //echo link_to('Ezabatu', 'fitxategia/delete?id='.$fitxategia->getId(), array('method' => 'delete', 'confirm' => 'Ziur zaude?')) ?>
</td>
-->
    </tr>
    <?php endforeach; ?>
<!--
    <tr><td colspan=6 align=right><a href="<?php //echo url_for('fitxategia/new') ?>">Berria</a>    </tr></th>
-->
  </tbody>
</table>

