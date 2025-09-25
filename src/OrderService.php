<?php

class OrderService {
    public static function createOrder($user_id, $ticket_id, $quantity): array
    {
        global $pdo;

        // Check if event is still active
        $stmt = $pdo->prepare("SELECT e.status FROM tickets t JOIN events e ON t.event_id = e.id WHERE t.id = ?");
        $stmt->execute([$ticket_id]);
        $status = $stmt->fetchColumn();
        if ($status != 1) return [1, "Closed Event, can't sell more tickets."];

        // Validates that user exists
        if (empty($user_id)) {
            return [1, "User is not registered."];
        }

        // Check if there's enough tickets
        $stmt = $pdo->prepare("SELECT t.remaining_tickets, t.price FROM tickets t WHERE t.id = ?");
        $stmt->execute([$ticket_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $available_quantity = $row["remaining_tickets"];
        $ticket_price = $row["price"];
        if ($available_quantity < $quantity) return [1, "Not enough tickets to sell."];

        // Buy tickets
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("UPDATE tickets SET remaining_tickets = remaining_tickets - ? WHERE id = ?");
            $stmt->execute([$quantity, $ticket_id]);

            $total_price = $ticket_price * $quantity;
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, ticket_id, quantity, total_price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $ticket_id, $quantity, $total_price]);

            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            return [1, "Error creating order, try again."];
        }

        return [0, "Order Created."];
    }
}