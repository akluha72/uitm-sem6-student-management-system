<?php
/**
 * Shared student form, used by add_student.php and edit_student.php.
 * Expects:
 *   $student      array of current/old values (keys = columns), or [] for empty
 *   $submit_label string for the submit button
 */
$v = function (string $k) use ($student) {
    return e($student[$k] ?? '');
};
$selected = function (string $k, string $val) use ($student) {
    return (($student[$k] ?? '') === $val) ? 'selected' : '';
};
$autogen_id = $autogen_id ?? false;

// Standard Malaysian options.
$races     = ['Malay', 'Chinese', 'Indian', 'Bumiputera Sabah', 'Bumiputera Sarawak', 'Orang Asli', 'Others'];
$religions = ['Islam', 'Buddhism', 'Christianity', 'Hinduism', 'Sikhism', 'Taoism', 'Others'];
?>
<form method="post" enctype="multipart/form-data">
    <?php if (!empty($student['id'])): ?>
        <input type="hidden" name="id" value="<?= (int)$student['id'] ?>">
    <?php endif; ?>
    <div class="form-grid">
        <div class="form-group">
            <label>Student ID <?= $autogen_id ? '<small class="muted">(auto-generated)</small>' : '' ?></label>
            <input type="text" name="student_id" value="<?= $v('student_id') ?>"
                   <?= $autogen_id ? 'readonly' : 'required' ?>>
        </div>
        <div class="form-group">
            <label>Student Name</label>
            <input type="text" name="name" value="<?= $v('name') ?>" required>
        </div>
        <div class="form-group">
            <label>Address 1</label>
            <input type="text" name="address1" value="<?= $v('address1') ?>" required>
        </div>
        <div class="form-group">
            <label>Address 2</label>
            <input type="text" name="address2" value="<?= $v('address2') ?>">
        </div>
        <div class="form-group">
            <label>Postcode</label>
            <input type="text" name="postcode" value="<?= $v('postcode') ?>" required>
        </div>
        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" value="<?= $v('city') ?>" required>
        </div>
        <div class="form-group">
            <label>Gender</label>
            <select name="gender" required>
                <option value="">-- Select --</option>
                <option value="Male"   <?= $selected('gender', 'Male') ?>>Male</option>
                <option value="Female" <?= $selected('gender', 'Female') ?>>Female</option>
            </select>
        </div>
        <div class="form-group">
            <label>Race</label>
            <select name="race" required>
                <option value="">-- Select --</option>
                <?php foreach ($races as $r): ?>
                    <option value="<?= e($r) ?>" <?= $selected('race', $r) ?>><?= e($r) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Religion</label>
            <select name="religion" required>
                <option value="">-- Select --</option>
                <?php foreach ($religions as $r): ?>
                    <option value="<?= e($r) ?>" <?= $selected('religion', $r) ?>><?= e($r) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="contact" value="<?= $v('contact') ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= $v('email') ?>" required>
        </div>
        <div class="form-group">
            <label>Student Photo</label>
            <input type="file" name="photo" accept="image/*">
            <?php if (!empty($student['photo'])): ?>
                <small class="muted" style="margin-top:.4rem;">
                    Current: <?= e($student['photo']) ?> (leave empty to keep)
                </small>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn"><?= e($submit_label) ?></button>
        <a href="view_student.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>
