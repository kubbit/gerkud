<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $esleipena->getId() ?></td>
    </tr>
    <tr>
      <th>Gertakaria:</th>
      <td><?php echo $esleipena->getGertakariaId() ?></td>
    </tr>
    <tr>
      <th>Langilea:</th>
      <td><?php echo $esleipena->getLangileaId() ?></td>
    </tr>
    <tr>
      <th>Testua:</th>
      <td><?php echo $esleipena->getTestua() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $esleipena->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $esleipena->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('esleipena/edit?id='.$esleipena->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('esleipena/index') ?>">List</a>
