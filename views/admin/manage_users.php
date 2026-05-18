<h2>Manage Users</h2>

<form method="GET" action="index.php?url=admin/manage-users">
    <input type="text" name="search" placeholder="Search by name or email" value="<?php echo htmlspecialchars($search ?? ''); ?>">
    <button type="submit">Search</button>
</form>

<?php $users = $users ?? []; ?>
<?php if (empty($users)): ?>
    <p>No users found.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <form method="POST" action="index.php?url=admin/update-user">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <select name="role">
                                <option <?php echo $user['role'] == 'student' ? 'selected' : ''; ?>>student</option>
                                <option <?php echo $user['role'] == 'instructor' ? 'selected' : ''; ?>>instructor</option>
                                <option <?php echo $user['role'] == 'ta' ? 'selected' : ''; ?>>ta</option>
                                <option <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>admin</option>
                            </select>
                        </td>
                        <td><input type="checkbox" name="is_active" <?php echo $user['is_active'] ? 'checked' : ''; ?>></td>
                        <td><button type="submit">Update</button></td>
                    </tr>
                </form>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>