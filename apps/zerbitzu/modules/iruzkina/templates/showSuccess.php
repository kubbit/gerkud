<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $iruzkina->getId() ?></td>
    </tr>
    <tr>
      <th>Gertakaria:</th>
      <td><?php echo $iruzkina->getGertakariaId() ?></td>
    </tr>
    <tr>
      <th>Langilea:</th>
      <td><?php echo $iruzkina->getLangileaId() ?></td>
    </tr>
    <tr>
      <th>Ekintza:</th>
      <td><?php echo $iruzkina->getEkintzaId() ?></td>
    </tr>
    <tr>
      <th>Testua:</th>
      <td><?php echo $iruzkina->getTestua() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $iruzkina->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $iruzkina->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('iruzkina/edit?id='.$iruzkina->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('iruzkina/index') ?>">List</a>
