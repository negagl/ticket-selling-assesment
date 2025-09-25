<?php

require_once "header.php";

global $pdo;

// Sold tickets by type and event
$stmt = $pdo->query("SELECT
    e.name AS event_name,
    t.type AS ticket_type,
    t.total_tickets - t.remaining_tickets AS tickets_sold,
    (t.total_tickets - t.remaining_tickets) * t.price AS total_revenue
FROM tickets t
JOIN events e ON t.event_id = e.id
ORDER BY e.name, t.type;
");
$by_type_event = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sold tickets by event
$stmt = $pdo->query("SELECT
    e.name AS event_name,
    SUM(t.total_tickets - t.remaining_tickets) AS tickets_sold,
    SUM((t.total_tickets - t.remaining_tickets) * price) AS total_revenue
FROM tickets t
JOIN events e ON t.event_id = e.id
GROUP BY e.id;
");
$by_event = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="mx-20 mt-20 flex justify-around">
    <div>
        <h1 class="font-bold text-xl">Events report by ticket type:</h1>
        <table class="table-auto mt-12">
            <thead>
                <th class="border px-2">Event</th>
                <th class="border px-2">Ticket Type</th>
                <th class="border px-2">Sold Tickets</th>
                <th class="border px-2">Sold $</th>
            </thead>
            <tbody>
                <?php foreach ($by_type_event as $row) { ?>
                    <tr>
                        <td class="border px-2"><?= $row["event_name"] ?></td>
                        <td class="border px-2"><?= $row["ticket_type"] ?></td>
                        <td class="border px-2"><?= $row["tickets_sold"] ?></td>
                        <td class="border px-2"><?= "$" . number_format($row["total_revenue"], 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div>
        <h1 class="font-bold text-xl">Events report by event:</h1>
        <table class="table-auto mt-12">
            <thead>
            <th class="border px-2">Event</th>
            <th class="border px-2">Sold Tickets</th>
            <th class="border px-2">Sold $</th>
            </thead>
            <tbody>
            <?php foreach ($by_event as $row) { ?>
                <tr>
                    <td class="border px-2"><?= $row["event_name"] ?></td>
                    <td class="border px-2"><?= $row["tickets_sold"] ?></td>
                    <td class="border px-2"><?= "$" . number_format($row["total_revenue"], 2) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</main>
<?php require_once "footer.php" ?>
