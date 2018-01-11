<head>
	<link rel="stylesheet" type="text/css" href="./css/flash.css">
</head>
<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['flash'])): ?>
    <?php foreach($_SESSION['flash'] as $type => $message): ?>

        <div id="hideMe" class="alert alert-<?= $type; ?>">
            <?= $message; ?>
        </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>