<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $erabiltzailea->getId() ?></td>
    </tr>
    <tr>
      <th>First name:</th>
      <td><?php echo $erabiltzailea->getFirstName() ?></td>
    </tr>
    <tr>
      <th>Last name:</th>
      <td><?php echo $erabiltzailea->getLastName() ?></td>
    </tr>
    <tr>
      <th>Email address:</th>
      <td><?php echo $erabiltzailea->getEmailAddress() ?></td>
    </tr>
    <tr>
      <th>Username:</th>
      <td><?php echo $erabiltzailea->getUsername() ?></td>
    </tr>
    <tr>
      <th>Algorithm:</th>
      <td><?php echo $erabiltzailea->getAlgorithm() ?></td>
    </tr>
    <tr>
      <th>Salt:</th>
      <td><?php echo $erabiltzailea->getSalt() ?></td>
    </tr>
    <tr>
      <th>Password:</th>
      <td><?php echo $erabiltzailea->getPassword() ?></td>
    </tr>
    <tr>
      <th>Is active:</th>
      <td><?php echo $erabiltzailea->getIsActive() ?></td>
    </tr>
    <tr>
      <th>Is super admin:</th>
      <td><?php echo $erabiltzailea->getIsSuperAdmin() ?></td>
    </tr>
    <tr>
      <th>Last login:</th>
      <td><?php echo $erabiltzailea->getLastLogin() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $erabiltzailea->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $erabiltzailea->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('erabiltzaileak/edit?id='.$erabiltzailea->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('erabiltzaileak/index') ?>">List</a>
