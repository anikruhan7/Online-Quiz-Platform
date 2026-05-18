<h2>Admin Profile</h2>
<?php $user = $user ?? []; ?>
<form method="POST" action="index.php?url=admin/update-profile" enctype="multipart/form-data">
    <div class="input-group">
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
    </div>
    <div class="input-group">
        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
    </div>
    <div class="input-group">
        <label>Profile Picture</label>
        <input type="file" name="profile_pic">
        <?php if (!empty($user['profile_pic']) && $user['profile_pic'] != 'default.png'): ?>
            <img src="<?= $user['profile_pic'] ?>" width="50" style="display:block; margin-top:5px;">
        <?php endif; ?>
    </div>
    <button type="submit" class="btn">Update Profile</button>
</form>