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
            <p class="created_date"><?= $notification['created_at']; ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<style>
    .notifications{
        background-color: #fff;
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
    .notifications .created_date{
        margin-top: 0.5rem;
        color: var(--light-black);
    }
</style>



<?php require_once '../app/views/templates/footer.php'; ?>