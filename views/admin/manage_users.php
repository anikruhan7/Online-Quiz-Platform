<h2>Manage Users</h2>
<?php $users = $users ?? []; ?>
<table border="1" cellpadding="8" style="width:100%; border-collapse:collapse;">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $u): ?>
        <form method="POST" action="index.php?url=admin/update-user">
            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <select name="role">
                        <option <?= $u['role'] == 'student' ? 'selected' : '' ?>>student</option>
                        <option <?= $u['role'] == 'instructor' ? 'selected' : '' ?>>instructor</option>
                        <option <?= $u['role'] == 'ta' ? 'selected' : '' ?>>ta</option>
                        <option <?= $u['role'] == 'admin' ? 'selected' : '' ?>>admin</option>
                    </select>
                </td>
                <td><input type="checkbox" name="is_active" <?= $u['is_active'] ? 'checked' : '' ?>></td>
                <td><button type="submit">Update</button></td>
            </tr>
        </form>
    <?php endforeach; ?>
</table>