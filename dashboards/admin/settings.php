<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
?>

<main class="main-content">
    <h1>Shop Settings</h1>
    <p>Manage general shop settings here.</p>

    <form action="#" method="POST" class="shop-settings-form">
        <div class="form-group">
            <label for="shop_name">Shop Name</label>
            <input type="text" id="shop_name" name="shop_name" value="Sakuragi Tailoring Shop" required>
        </div>

        <div class="form-group">
            <label for="shop_email">Contact Email</label>
            <input type="email" id="shop_email" name="shop_email" value="contact@sakuragi.ph" required>
        </div>

        <div class="form-group">
            <label for="contact_number">Contact Number</label>
            <input type="text" id="contact_number" name="contact_number" value="0917 123 4567" required>
        </div>

        <div class="form-group">
            <label for="address">Main Branch Address</label>
            <textarea id="address" name="address" rows="3">123 JP Laurel Ave, Davao City</textarea>
        </div>

        <div class="form-group">
            <label for="default_branch">Default Branch</label>
            <select id="default_branch" name="default_branch">
                <option value="main">Main Branch - JP Laurel</option>
                <option value="sm-lanang">SM Lanang</option>
                <option value="abreeza">Abreeza Ayala</option>
            </select>
        </div>

        <div class="form-group">
            <label for="business_hours">Business Hours</label>
            <div style="display: flex; gap: 10px;">
                <input type="time" name="open_time" value="09:00" required>
                <span>to</span>
                <input type="time" name="close_time" value="18:00" required>
            </div>
        </div>

        <div class="form-group">
            <label for="notifications">
                <input type="checkbox" id="notifications" name="notifications" checked>
                Enable Email Notifications
            </label>
        </div>

        <div class="form-group">
            <label for="facebook_link">Facebook Page</label>
            <input type="url" id="facebook_link" name="facebook_link" value="https://facebook.com/sakuragi.shop">
        </div>

        <div class="form-group">
            <label for="instagram_link">Instagram Handle</label>
            <input type="url" id="instagram_link" name="instagram_link" value="https://instagram.com/sakuragi.shop">
        </div>

        <button type="submit" class="btn-save">Save Settings</button>
    </form>
    
</main>

<?php require_once '../../includes/footer.php'; ?>


<style>
    /* ========== SHOP SETTINGS FORM ========== */
.shop-settings-form {
    width: 100%;
    max-width: 720px;
    margin: 2rem auto;
    background-color: #ffffff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.shop-settings-form .form-group {
    margin-bottom: 1.5rem;
}

.shop-settings-form label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.shop-settings-form input[type="text"],
.shop-settings-form input[type="email"],
.shop-settings-form input[type="url"],
.shop-settings-form input[type="time"],
.shop-settings-form select,
.shop-settings-form textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    background-color: #fdfdfd;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.shop-settings-form input:focus,
.shop-settings-form textarea:focus,
.shop-settings-form select:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
}

.shop-settings-form textarea {
    resize: vertical;
}

/* Grouped input layout for time range */
.shop-settings-form .form-group input[type="time"] {
    width: auto;
    flex: 1;
}

/* Inline checkbox style */
.shop-settings-form input[type="checkbox"] {
    margin-right: 8px;
    transform: scale(1.1);
}

/* Save button */
.shop-settings-form .btn-save {
    background-color: #3498db;
    color: #fff;
    padding: 12px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: inline-block;
    margin-top: 1rem;
}

.shop-settings-form .btn-save:hover {
    background-color: #2980b9;
}

    
</style>