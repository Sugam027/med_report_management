<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading titleHead">
        <p class="headingName">Notifications</p>
    </div>
    <div class="container">
        <?php foreach ($data['notifications'] as $notification): ?>
        <div class="notifications">
            <p class="<?= $notification['is_read'] ? 'read' : 'unread'; ?>">
                <?= $notification['message']; ?>
            </p>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<style>
    .notifications{
        background-color: #fff;
        display: flex;
        gap: 0.9rem;
        margin-bottom: 1rem;
        padding: 0.5rem;
        border-left: var(--aside-bg) 5px solid;
        border-radius: 3px;
        box-shadow: 0px 1px 5px 0px;
        cursor: pointer;
    }
    .notifications:hover{
        opacity: 0.8;
    }
</style>



<?php require_once '../app/views/templates/footer.php'; ?>