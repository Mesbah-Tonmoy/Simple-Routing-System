<style>
    .profile-card {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 3rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .profile-header {
        text-align: center;
        padding-bottom: 2rem;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .profile-header h1 {
        color: #667eea;
        margin-bottom: 0.5rem;
    }
    
    .user-info {
        margin-top: 2rem;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #4a5568;
    }
    
    .info-value {
        color: #2d3748;
    }
</style>

<div class="profile-card">
    <div class="profile-header">
        <h1><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
        <p style="color: #718096;">Viewing user #<?= htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8') ?></p>
    </div>
    
    <div class="user-info">
        <div class="info-row">
            <span class="info-label">User ID:</span>
            <span class="info-value"><?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value"><?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value"><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Member Since:</span>
            <span class="info-value"><?= htmlspecialchars($user['joined'], ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    </div>
</div>