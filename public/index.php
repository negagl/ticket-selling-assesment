<?php

require_once "header.php";

global $pdo;

// Get all events
$stmt = $pdo->prepare("SELECT e.name FROM events e");
$stmt->execute();
$events_array = $stmt->fetchAll();
?>

<form method="post" action="buy_tickets.php" class="flex flex-col bg-[#34cafc] w-[30%] items-center justify-center mx-auto mt-[10rem] py-20 gap-12">
    <label>
        <span>Event:</span>
        <select name="event" class="bg-white">
            <?php foreach ($events_array as $event) { ?>
                <option value="<?=$event["name"]?>"><?=$event["name"]?></option>
            <?php } ?>
        </select>
    </label>
    <button type="submit" class="bg-[#1d5971] text-white font-bold px-12 py-2 rounded-lg cursor-pointer">Next</button>
</form>

<?php require_once "footer.php"; ?>
