<h2>Admin Profile</h2>

<?php $user = $user ?? []; ?>
<form method="POST" action="index.php?url=admin/update-profile" enctype="multipart/form-data">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
    <br><br>
    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
    <br><br>
    <label>Profile Picture</label>
    <input type="file" name="profile_pic">
    <?php if (!empty($user['profile_pic']) && $user['profile_pic'] != 'default.png'): ?>
        <br><img src="<?php echo $user['profile_pic']; ?>" width="80">
    <?php endif; ?>
    <br><br>
    <button type="submit">Update Profile</button>
</form>