<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $langilea->getId() ?></td>
    </tr>
    <tr>
      <th>First name:</th>
      <td><?php echo $langilea->getFirstName() ?></td>
    </tr>
    <tr>
      <th>Last name:</th>
      <td><?php echo $langilea->getLastName() ?></td>
    </tr>
    <tr>
      <th>Email address:</th>
      <td><?php echo $langilea->getEmailAddress() ?></td>
    </tr>
    <tr>
      <th>Username:</th>
      <td><?php echo $langilea->getUsername() ?></td>
    </tr>
    <tr>
      <th>Algorithm:</th>
      <td><?php echo $langilea->getAlgorithm() ?></td>
    </tr>
    <tr>
      <th>Salt:</th>
      <td><?php echo $langilea->getSalt() ?></td>
    </tr>
    <tr>
      <th>Password:</th>
      <td><?php echo $langilea->getPassword() ?></td>
    </tr>
    <tr>
      <th>Is active:</th>
      <td><?php echo $langilea->getIsActive() ?></td>
    </tr>
    <tr>
      <th>Is super admin:</th>
      <td><?php echo $langilea->getIsSuperAdmin() ?></td>
    </tr>
    <tr>
      <th>Last login:</th>
      <td><?php echo $langilea->getLastLogin() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $langilea->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $langilea->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('langilea/edit?id='.$langilea->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('langilea/index') ?>">List</a>
