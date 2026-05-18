<h2>My Profile</h2>
<form method="POST" action="index.php?url=student/profile/update" enctype="multipart/form-data">
    <label>Name:</label> <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required><br>
    <label>Phone:</label> <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>"><br>
    <label>Program:</label> <input type="text" name="program" value="<?= htmlspecialchars($user['program'] ?? '') ?>"><br>
    <label>Profile Picture:</label> <input type="file" name="profile_pic"><br>
    <?php if (!empty($user['profile_pic']) && $user['profile_pic'] != 'default.png'): ?>
        <img src="<?= $user['profile_pic'] ?>" width="80"><br>
    <?php endif; ?>
    <button type="submit">Update Profile</button>
</form>
<h3>Change Password</h3>
<form method="POST" action="index.php?url=student/change-password">
    <input type="password" name="old_password" placeholder="Old Password" required><br>
    <input type="password" name="new_password" placeholder="New Password" required><br>
    <button type="submit">Change Password</button>
</form>