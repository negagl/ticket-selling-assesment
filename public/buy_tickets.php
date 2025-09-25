<?php

require_once "header.php";
require_once "../src/OrderService.php";

global $pdo;

$event = "";
$ticket_types = [];
$order_code = 0;
$message = "";

// Bring tickets only for this event
if (!empty($_POST["event"])) {
    $event = $_POST["event"];

    $stmt = $pdo->prepare("SELECT t.id, t.type, t.price, t.remaining_tickets FROM tickets t JOIN events e ON t.event_id = e.id WHERE e.name = ?");
    $stmt->execute([$event]);
    $ticket_types = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["email"]) && !empty($_POST["ticket_type"]) && !empty($_POST["quantity"])) {
        try{
            // Look for user's id
            $stmt = $pdo->prepare("SELECT u.id FROM users u WHERE u.email = ?");
            $stmt->execute([$_POST["email"]]);
            $user_id = $stmt->fetchColumn();

            $ticket_id = $_POST["ticket_type"];
            $quantity = $_POST["quantity"];

            $order = OrderService::createOrder($user_id, $ticket_id, $quantity);
            $order_code = $order[0];
            $message = $order[1];
        } catch (Exception $e) {
            $message = "There was an error, please try again later.";
        }
    }
}
?>

<main>
    <form method="post" class="flex flex-col bg-[#34cafc] w-[30%] items-center justify-center mx-auto mt-[10rem] py-20 gap-12">
        <label>
            <input type="hidden" name="event" value="<?= $event ?>">
        </label>

        <label>
            <span>Email:</span>
            <input type="email" name="email" placeholder="john@email.com" class="bg-white" required>
        </label>

        <label>
            <span>Ticket:</span>
            <select name="ticket_type" class="bg-white" required>
                <?php
                foreach ($ticket_types as $type) { ?>
                    <option value="<?= $type["id"] ?>"><?= "{$type['type']} - \${$type['price']}"  ?></option>
                <?php } ?>
            </select>
        </label>

        <label>
            <span>Quantity:</span>
            <input type="number" name="quantity" min="1" class="bg-white" value="1">
        </label>

        <div>
            <a class="bg-gray-200 font-bold px-12 py-2 rounded-lg cursor-pointer" href="index.php">Back</a>
            <button type="submit" class="bg-[#1d5971] text-white font-bold px-12 py-2 rounded-lg cursor-pointer">Buy</button>
        </div>

        <span class=<?= ($order_code == 0) ? "text-green-500" : "text-red-500" ?>><?= $message ?></span>
    </form>
</main>

<?php require_once "footer.php"; ?>
